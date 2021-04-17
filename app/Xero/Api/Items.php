<?php


namespace App\Xero\Api;


use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class Items
{
    private $xeroTenantId;
    private $accountingApi;
    public function __construct($xeroTenantId, $accountingApi)
    {
        $this->xeroTenantId = $xeroTenantId;
        $this->accountingApi = $accountingApi;
        $this->init();
    }

    public function init()
    {
        $this->getItems($this->xeroTenantId, $this->accountingApi);
    }

    public function getItems($xeroTenantId, $accountingApi)
    {
        $items = ($accountingApi->getItems($xeroTenantId))->getItems();
        foreach ($items as  $itemObject) {
            $item = Xero::deserialize($itemObject);
            $itemId = $item['item_id'];
            //store item purchase details
            $purchase_details = $item['purchase_details'];
            unset($item['purchase_details']);
            $this->storePurchaseDetails($purchase_details, $itemId);
            //store sale details
            $sales_details = $item['sales_details'];
            unset($item['sales_details']);
            $this->storeSaleDetails($sales_details, $itemId);
            //store quotes
            $this->storeItem($item);
        }
    }

    private function storePurchaseDetails($purchase_detail, $itemId)
    {

        if (isset($purchase_detail)) {
            $purchase_detail = Xero::deserialize($purchase_detail);
            $purchase_detail['item_id'] = $itemId;
            DB::table('xero_item_purchase_details')->insert($purchase_detail);
        }
    }

    private function storeSaleDetails($sales_detail, $itemId)
    {

        if (isset($sales_detail)) {
            $sales_detail = Xero::deserialize($sales_detail);
            $sales_detail['item_id'] = $itemId;
            DB::table('xero_item_sale_details')->insert($sales_detail);
        }
    }

    private function storeItem($quote)
    {
        unset($quote['validation_errors']);
        DB::table('xero_items')->insert($quote);
    }
}
