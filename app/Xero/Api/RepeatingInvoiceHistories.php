<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class RepeatingInvoiceHistories
{
    private $xeroTenantId;
    private $accountingApi;
    private $invoice;
    private $repeating_invoice_id;
    public function __construct($xeroTenantId, $accountingApi, $invoice, $repeating_invoice_id)
    {
        $this->xeroTenantId = $xeroTenantId;
        $this->accountingApi = $accountingApi;
        $this->invoice = $invoice;
        $this->repeating_invoice_id = $repeating_invoice_id;
        $this->init();
    }

    public function init()
    {
        $this->getRepeatingInvoicesHistories($this->xeroTenantId, $this->accountingApi);
    }

    public function getRepeatingInvoicesHistories($xeroTenantId, $accountingApi)
    {
        if ($this->invoice == null) {
            (new RepeatingInvoices($xeroTenantId, $accountingApi, $this->repeating_invoice_id));
            $this->invoice = DB::table('xero_repeating_invoices')->where('id',  $this->repeating_invoice_id)->first();
        }
        $repeatingInvoiceHistories = ($accountingApi->getRepeatingInvoiceHistory($xeroTenantId, $this->invoice->id))->getHistoryRecords();
        foreach ($repeatingInvoiceHistories as  $historyObject) {
            $invoiceHistory = Xero::deserialize($historyObject);
            //store repeating invoice History
            $this->storeRepeatingInvoiceHistory($invoiceHistory, $this->invoice);
        }
    }

    public function storeRepeatingInvoiceHistory($invoiceHistory, $invoice)
    {
        $invoiceHistory['invoice_id'] = $invoice->id;
        DB::table('xero_repeating_invoice_histories')->insert($invoiceHistory);
    }
}
