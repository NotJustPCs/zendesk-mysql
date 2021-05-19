<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class RepeatingInvoices
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
        $this->getRepeatingInvoices($this->xeroTenantId, $this->accountingApi);
    }

    public function getRepeatingInvoices($xeroTenantId, $accountingApi)
    {
        $repeatingInvoices = ($accountingApi->getRepeatingInvoices($xeroTenantId))->getRepeatingInvoices();
        foreach ($repeatingInvoices as  $invoiceObject) {
            $invoice = Xero::deserialize($invoiceObject);
            $invoiceId = $invoice['id'];
            //store line items
            $line_items = $invoice['line_items'];
            unset($invoice['line_items']);
            $this->storeLineItems($line_items, $invoiceId);
            //Store Schedule
            $schedule = $invoice['schedule'];
            unset($invoice['schedule']);
            $this->storeSchedule($schedule, $invoiceId);
            //store repeating invoices
            $this->storeRepeatingInvoices($invoice);
        }
    }

    public function storeLineItems($line_items, $invoiceId)
    {
        foreach ($line_items as  $line_item) {
            if (isset($line_item)) {
                $line_item = Xero::deserialize($line_item);
                $line_item['invoice_id'] = $invoiceId;
                //Note: null
                $tracking = $line_item['tracking'];
                unset($line_item['tracking']);
                DB::table('xero_repeating_invoice_line_items')->insert($line_item);
            }
        }
    }

    public function storeSchedule($schedule, $invoiceId)
    {
        if (isset($schedule)) {
            $schedule = Xero::deserialize($schedule);
            $schedule['invoice_id'] = $invoiceId;
            DB::table('xero_repeating_invoice_schedules')->insert($schedule);
        }
    }

    public function storeRepeatingInvoices($invoice)
    {
        unset($invoice['attachments']);
        $contact = $invoice['contact'];
        unset($invoice['contact']);

        $invoice['contact_id'] = $contact->getContactId();
        DB::table('xero_repeating_invoices')->insert($invoice);
    }
}
