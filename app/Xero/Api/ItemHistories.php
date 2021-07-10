<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class ItemHistories
{
    private $xeroTenantId;
    private $accountingApi;
    private $item;
    public function __construct($xeroTenantId, $accountingApi, $item)
    {
        $this->xeroTenantId = $xeroTenantId;
        $this->accountingApi = $accountingApi;
        $this->item = $item;
        $this->init();
    }

    public function init()
    {
        $this->getItemHistories($this->xeroTenantId, $this->accountingApi);
    }

    public function getItemHistories($xeroTenantId, $accountingApi)
    {
        $itemHistories = ($accountingApi->getItemHistory($xeroTenantId, $this->item->item_id))->getHistoryRecords();
        foreach ($itemHistories as  $historyObject) {
            $itemHistory = Xero::deserialize($historyObject);
            //store repeating item History
            $this->storeItemHistory($itemHistory, $this->item);
        }
    }

    public function storeItemHistory($itemHistory, $item)
    {
        $itemHistory['item_id'] = $item->item_id;
        DB::table('xero_item_histories')->insert($itemHistory);
    }
}
