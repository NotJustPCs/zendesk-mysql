<?php

namespace App\Xero;

use App\Xero\Storage;
use GuzzleHttp\Client;
use App\Xero\Api\Items;
use App\Xero\Api\Users;
use App\Xero\Api\Quotes;
use App\Xero\Api\Contacts;
use App\Xero\Api\Employees;
use App\Xero\Api\TimeSheets;
use App\Xero\Api\SaleInvoices;
use App\Xero\Api\EmployeeLeaves;
use XeroAPI\XeroPHP\Configuration;
use App\Helpers\Xero as XeroHelper;
use App\Xero\Api\RepeatingInvoices;
use XeroAPI\XeroPHP\Api\PayrollUkApi;
use XeroAPI\XeroPHP\Api\AccountingApi;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class Xero
{
    /**
     * @throws IdentityProviderException
     */
    public function storeData(Storage $storage, XeroHelper $xero, $xeroTenantId)
    {
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        $config = Configuration::getDefaultConfiguration()->setAccessToken((string)$storage->getSession()['token']);
        $accountingApi = $this->accountingApiInstance($config);
        $payrollUkApi = $this->payrollUkApiInstance($config);
        //Store Contacts
        (new Contacts($xeroTenantId, $accountingApi));
        //Store Sale invoices
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new SaleInvoices($xeroTenantId, $accountingApi));
        //Store Quotes
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new Quotes($xeroTenantId, $accountingApi));
        //Store items
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new Items($xeroTenantId, $accountingApi));
        //Store users
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new Users($xeroTenantId, $accountingApi));
        //store Repeating Invoices
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new RepeatingInvoices($xeroTenantId,  $accountingApi));
        //:::::Payroll Uk
        //Store employees
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new Employees($xeroTenantId,  $payrollUkApi));
        //Store employee leaves
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new EmployeeLeaves($xeroTenantId,  $payrollUkApi));
        //store Timesheet
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new TimeSheets($xeroTenantId,  $payrollUkApi));

        dd('done');
    }
    public function accountingApiInstance($config): AccountingApi
    {
        return new AccountingApi(
            new Client(),
            $config
        );
    }

    public function payrollUkApiInstance($config): PayrollUkApi
    {
        return new PayrollUkApi(
            new Client(),
            $config
        );
    }
}
