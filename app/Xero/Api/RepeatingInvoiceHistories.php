<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class RepeatingInvoiceHistories
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
        $this->getRepeatingInvoicesHistories($this->xeroTenantId, $this->accountingApi);
    }

    public function getRepeatingInvoicesHistories($xeroTenantId, $accountingApi)
    {
        $repeatingInvoiceHistories = ($accountingApi->getRepeatingInvoiceHistory($xeroTenantId, $this->invoice->invoice_id))->getHistoryRecords();
        foreach ($repeatingInvoiceHistories as  $historyObject) {
            $invoiceHistory = Xero::deserialize($historyObject);
            //store repeating invoice History
            $this->storeRepeatingInvoiceHistory($invoiceHistory, $this->invoice);
        }
    }

    public function storeRepeatingInvoiceHistory($invoiceHistory, $invoice)
    {
        $invoiceHistory['invoice_id'] = $invoice->invoice_id;
        DB::table('xero_repeating_invoice_histories')->insert($invoiceHistory);
    }
}
