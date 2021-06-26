<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleInvoices
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
        $this->getSaleInvoices($this->xeroTenantId, $this->accountingApi);
    }

    public function getSaleInvoices($xeroTenantId, $accountingApi)
    {
        $invoices = ($accountingApi->getInvoices($xeroTenantId))->getInvoices();
        foreach ($invoices as  $invoiceObject) {
            $invoice = Xero::deserialize($invoiceObject);
            $invoiceId = $invoice['invoice_id'];
            //store line items
            $line_items = $invoice['line_items'];
            unset($invoice['line_items']);
            $this->storeLineItems($line_items, $invoiceId);
            //store line_amount_types
            $line_amount_types = $invoice['line_amount_types'];
            unset($invoice['line_amount_types']);
            $this->storeLineAmountTypes($line_amount_types, $invoiceId);
            //store currency_code
            $currency_code = $invoice['currency_code'];
            unset($invoice['currency_code']);
            $this->storeCurrencyCode($currency_code, $invoiceId);
            //store payments
            $payments = $invoice['payments'];
            unset($invoice['payments']);
            $this->storePayments($payments, $invoiceId);
            //store prepayments
            $prepayments = $invoice['prepayments'];
            unset($invoice['prepayments']);
            $this->storePrepayments($prepayments, $invoiceId);
            //store overPayments
            $overPayments = $invoice['overpayments'];
            unset($invoice['overpayments']);
            $this->storeOverPayments($overPayments, $invoiceId);
            //store credit_notes
            $credit_notes = $invoice['credit_notes'];
            unset($invoice['credit_notes']);
            $this->storeCreditNotes($credit_notes, $invoiceId);
            //store attachments
            $attachments = $invoice['attachments'];
            unset($invoice['attachments']);
            $this->storeAttachments($attachments, $invoiceId);
            //store validation_errors
            $validation_errors = $invoice['validation_errors'];
            unset($invoice['validation_errors']);
            $this->storeValidationErrors($validation_errors, $invoiceId);
            //store warnings
            $warnings = $invoice['warnings'];
            unset($invoice['warnings']);
            $this->storeWarnings($warnings, $invoiceId);
            //store invoice
            $this->storeInvoice($invoice);
        }
    }

    private function storeInvoice($invoice)
    {
        $contact = $invoice['contact'];
        unset($invoice['contact']);
        $invoice['contact_id'] = $contact->getContactId();
        DB::table('xero_invoices')->insert($invoice);
    }

    private function storeLineItems($line_items, $invoiceId)
    {
        foreach ($line_items as  $line_item) {
            if (isset($line_item)) {
                $line_item = Xero::deserialize($line_item);
                $line_item['invoice_id'] = $invoiceId;
                //Note: null
                $tracking = $line_item['tracking'];
                unset($line_item['tracking']);
                Log::info(json_encode($tracking));
                DB::table('xero_invoice_line_items')->insert($line_item);
            }
        }
    }
    private function storeLineItemTracking($tracking, $line_item_id)
    {
        //Note::null
        $tracking['line_item_id'] = $line_item_id;
        DB::table('xero_invoice_line_item_trackings')->insert($tracking);
    }
    private function storeLineAmountTypes($line_amount_types, $invoiceId)
    {
        DB::table('xero_invoice_line_amount_types')->insert(['invoice_id' => $invoiceId, 'type' => $line_amount_types]);
    }

    private function storeCurrencyCode($currency_code, $invoiceId)
    {
        DB::table('xero_invoice_currency_codes')->insert(['invoice_id' => $invoiceId, 'code' => $currency_code]);
    }

    private function storePayments($payments, $invoiceId)
    {
        foreach ($payments as $key => $payment) {
            if (isset($payment)) {
                $payment = Xero::deserialize($payment);
                $payment['invoice_id'] = $invoiceId;
                unset($payment['invoice']);
                unset($payment['credit_note']);
                unset($payment['prepayment']);
                unset($payment['overpayment']);
                unset($payment['account']);
                unset($payment['validation_errors']);
                DB::table('xero_invoice_payments')->insert($payment);
            }
        }
    }

    private function storePrepayments($prepayments, $invoiceId)
    {
        foreach ($prepayments as $key => $prepayment) {
            if (isset($prepayment)) {
                $prepayment = Xero::deserialize($prepayment);
                $prepayment['invoice_id'] = $invoiceId;
                unset($prepayment['contact']);
                unset($prepayment['line_amount_types']);
                unset($prepayment['line_items']);
                unset($prepayment['currency_code']);
                unset($prepayment['allocations']);
                unset($prepayment['attachments']);

                DB::table('xero_invoice_pre_payments')->insert($prepayment);
            }
        }
    }

    private function storeOverPayments($overpayments, $invoiceId)
    {
        foreach ($overpayments as $key => $overpayment) {
            if (isset($overpayment)) {
                $overpayment = Xero::deserialize($overpayment);
                $overpayment['invoice_id'] = $invoiceId;
                unset($overpayment['contact']);
                unset($overpayment['line_amount_types']);
                unset($overpayment['line_items']);
                unset($overpayment['currency_code']);
                unset($overpayment['allocations']);
                unset($overpayment['payments']);
                unset($overpayment['attachments']);

                DB::table('xero_invoice_over_payments')->insert($overpayment);
            }
        }
    }

    private function storeCreditNotes($credit_notes, $invoiceId)
    {
        foreach ($credit_notes as  $credit_note) {
            if (isset($credit_note)) {
                $credit_note = Xero::deserialize($credit_note);
                $credit_note['invoice_id'] = $invoiceId;
                unset($credit_note['contact']);
                unset($credit_note['line_amount_types']);
                unset($credit_note['line_items']);
                unset($credit_note['currency_code']);
                unset($credit_note['allocations']);
                unset($credit_note['payments']);
                unset($credit_note['validation_errors']);
                DB::table('xero_invoice_credit_notes')->insert($credit_note);
            }
        }
    }

    private function storeAttachments($attachments, $invoiceId)
    {
        //Note::null
        // Log::info(json_encode($attachments));
    }

    private function storeValidationErrors($validation_errors, $invoiceId)
    {
        //Note::null
        // Log::info(json_encode($validation_errors));
    }

    private function storeWarnings($warnings, $invoiceId)
    {
        //Note::null
        //Log::info(json_encode($warnings));
    }
}
