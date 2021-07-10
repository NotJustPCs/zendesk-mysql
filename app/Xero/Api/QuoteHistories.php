<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class QuoteHistories
{
    private $xeroTenantId;
    private $accountingApi;
    private $quote;
    public function __construct($xeroTenantId, $accountingApi, $quote)
    {
        $this->xeroTenantId = $xeroTenantId;
        $this->accountingApi = $accountingApi;
        $this->quote = $quote;
        $this->init();
    }

    public function init()
    {
        $this->getQuoteHistories($this->xeroTenantId, $this->accountingApi);
    }

    public function getQuoteHistories($xeroTenantId, $accountingApi)
    {
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
