<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class RepeatingInvoiceHistories
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
        $this->getRepeatingInvoicesHistories($this->xeroTenantId, $this->accountingApi);
    }

    public function getRepeatingInvoicesHistories($xeroTenantId, $accountingApi)
    {
        $invoices = DB::table('xero_repeating_invoices')->select('id')->get();
        foreach ($invoices as  $invoice) {
            $repeatingInvoiceHistories = ($accountingApi->getRepeatingInvoiceHistory($xeroTenantId, $invoice->id))->getHistoryRecords();
            foreach ($repeatingInvoiceHistories as  $historyObject) {
                $invoiceHistory = Xero::deserialize($historyObject);
                //store repeating invoice History
                $this->storeRepeatingInvoiceHistory($invoiceHistory, $invoice);
            }
        }
    }

    public function storeRepeatingInvoiceHistory($invoiceHistory, $invoice)
    {
        $invoiceHistory['invoice_id'] = $invoice->id;
        DB::table('xero_repeating_invoice_histories')->insert($invoiceHistory);
    }
}
