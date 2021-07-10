<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class InvoiceHistories
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
        $this->getInvoiceHistories($this->xeroTenantId, $this->accountingApi);
    }

    public function getInvoiceHistories($xeroTenantId, $accountingApi)
    {
        $invoiceHistories = ($accountingApi->getInvoiceHistory($xeroTenantId, $this->invoice->invoice_id))->getHistoryRecords();
        foreach ($invoiceHistories as  $historyObject) {
            $invoiceHistory = Xero::deserialize($historyObject);
            //store repeating item History
            $this->storeInvoiceHistory($invoiceHistory, $this->invoice);
        }
    }

    public function storeInvoiceHistory($invoiceHistory, $invoice)
    {
        $invoiceHistory['invoice_id'] = $invoice->invoice_id;
        DB::table('xero_invoice_histories')->insert($invoiceHistory);
    }
}
