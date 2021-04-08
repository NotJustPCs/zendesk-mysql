<?php

namespace App\Xero;

use GuzzleHttp\Client;
use XeroAPI\XeroPHP\Configuration;
use App\Helpers\Xero as XeroHelper;
use App\Xero\Api\Contacts;
use XeroAPI\XeroPHP\Api\AccountingApi;

class Xero
{
    public function storeData(Storage $storage, XeroHelper $xero, $xeroTenantId)
    {
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        $config = Configuration::getDefaultConfiguration()->setAccessToken((string)$storage->getSession()['token']);
        $accountingApi = $this->accountingApiInstance($config);
        //Store Contacts
        (new Contacts($xeroTenantId, $accountingApi));
        // $this->getContact($xeroTenantId, $accountingApi);
    }
    public function accountingApiInstance($config)
    {
        return new AccountingApi(
            new Client(),
            $config
        );
    }
}
