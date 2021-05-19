<?php


namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Quotes
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
        $this->getQuotes($this->xeroTenantId, $this->accountingApi);
    }

    public function getQuotes($xeroTenantId, $accountingApi)
    {
        $quotes = ($accountingApi->getQuotes($xeroTenantId))->getQuotes();
        foreach ($quotes as  $quoteObject) {
            $quote = Xero::deserialize($quoteObject);
            $quoteId = $quote['quote_id'];
            //store line items
            $line_items = $quote['line_items'];
            unset($quote['line_items']);
            $this->storeLineItems($line_items, $quoteId);
            //store quotes
            $this->storeQuote($quote);
        }
    }

    private function storeLineItems($line_items, $quoteId)
    {
        foreach ($line_items as  $line_item) {
            if (isset($line_item)) {
                $line_item = Xero::deserialize($line_item);
                $line_item['quote_id'] = $quoteId;
                //Note: null
                $tracking = $line_item['tracking'];
                unset($line_item['tracking']);
                DB::table('xero_quote_line_items')->insert($line_item);
            }
        }
    }

    private function storeQuote($quote)
    {
        $contact = $quote['contact'];
        unset($quote['contact']);
        unset($quote['validation_errors']);
        $quote['contact_id'] = $contact->getContactId();
        DB::table('xero_quotes')->insert($quote);
    }
}
