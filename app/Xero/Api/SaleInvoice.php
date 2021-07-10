<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleInvoice
{
    private $xeroTenantId;
    private $accountingApi;
    private $invoice;
    public function __construct($xeroTenantId, $accountingApi, $invoice)
    {
        $this->xeroTenantId = $xeroTenantId;
        $this->accountingApi = $accountingApi;
        $this->invoice = $invoice;
        $this->init();
    }

    public function init()
    {
        $this->getSaleInvoice($this->xeroTenantId, $this->accountingApi, $this->invoice);
    }

    public function getSaleInvoice($xeroTenantId, $accountingApi, $invoice)
    {

        $invoiceData = ($accountingApi->getInvoice($xeroTenantId, $invoice->invoice_id))->getInvoices();
        foreach ($invoiceData as  $invoiceObject) {
            $invoice = Xero::deserialize($invoiceObject);
            $invoiceId = $invoice['invoice_id'];
            //store line items
            $line_items = $invoice['line_items'];
            unset($invoice['line_items']);
            $this->storeLineItems($line_items, $invoiceId);
        }
    }


    private function storeLineItems($line_items, $invoiceId)
    {
        foreach ($line_items as  $line_item) {
            if (isset($line_item)) {
                $line_item = Xero::deserialize($line_item);
                $line_item['invoice_id'] = $invoiceId;
                $tracking = $line_item['tracking'];
                unset($line_item['tracking']);
                DB::table('xero_invoice_line_items')->insert($line_item);
            }
        }
    }
}
