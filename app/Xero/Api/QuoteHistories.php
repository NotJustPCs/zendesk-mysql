<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class QuoteHistories
{
    private $xeroTenantId;
    private $accountingApi;
    private $quote;
    private $quote_id;
    public function __construct($xeroTenantId, $accountingApi, $quote, $quote_id)
    {
        $this->xeroTenantId = $xeroTenantId;
        $this->accountingApi = $accountingApi;
        $this->quote = $quote;
        $this->quote_id =  $quote_id;
        $this->init();
    }

    public function init()
    {
        $this->getQuoteHistories($this->xeroTenantId, $this->accountingApi);
    }

    public function getQuoteHistories($xeroTenantId, $accountingApi)
    {
        if ($this->quote == null) {
            (new Quotes($xeroTenantId, $accountingApi, $this->quote_id));
            $this->quote = DB::table('xero_quotes')->where('quote_id',  $this->quote_id)->first();
        }
        $quoteHistories = ($accountingApi->getQuoteHistory($xeroTenantId, $this->quote->quote_id))->getHistoryRecords();
        foreach ($quoteHistories as  $historyObject) {
            $quoteHistory = Xero::deserialize($historyObject);
            //store repeating item History
            $this->storeQuoteHistory($quoteHistory, $this->quote);
        }
    }

    public function storeQuoteHistory($quoteHistory, $quote)
    {
        $quoteHistory['quote_id'] = $quote->quote_id;
        DB::table('xero_quote_histories')->insert($quoteHistory);
    }
}
