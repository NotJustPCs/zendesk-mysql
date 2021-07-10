<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OnlineSaleInvoice
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
        $invoiceId = $invoice->invoice_id;
        $invoiceData = ($accountingApi->getOnlineInvoice($xeroTenantId, $invoiceId))->getOnlineInvoices();
        foreach ($invoiceData as  $invoiceObject) {
            $invoice = Xero::deserialize($invoiceObject);
            //store online Invoice
            $this->storeLineItems($invoice, $invoiceId);
        }
    }


    private function storeLineItems($invoice, $invoiceId)
    {
        $invoice['invoice_id'] = $invoiceId;
        DB::table('xero_online_invoices')->insert($invoice);
    }
}
