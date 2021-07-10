<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class ContactHistories
{
    private $xeroTenantId;
    private $accountingApi;
    private $contact;
    public function __construct($xeroTenantId, $accountingApi, $contact)
    {
        $this->xeroTenantId = $xeroTenantId;
        $this->accountingApi = $accountingApi;
        $this->contact = $contact;
        $this->init();
    }

    public function init()
    {
        $this->getContactHistories($this->xeroTenantId, $this->accountingApi);
    }

    public function getContactHistories($xeroTenantId, $accountingApi)
    {
        $contactHistories = ($accountingApi->getContactHistory($xeroTenantId, $this->contact->contact_id))->getHistoryRecords();
        foreach ($contactHistories as  $historyObject) {
            $contactHistory = Xero::deserialize($historyObject);
            //store contact History
            $this->storeContactHistory($contactHistory, $this->contact);
        }
    }

    public function storeContactHistory($contactHistory, $contact)
    {
        $contactHistory['contact_id'] = $contact->contact_id;
        DB::table('xero_contact_histories')->insert($contactHistory);
    }
}
