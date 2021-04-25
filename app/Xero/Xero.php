<?php

namespace App\Xero;

use GuzzleHttp\Client;
use App\Xero\Api\Items;
use App\Xero\Api\Quotes;
use App\Xero\Api\Contacts;
use App\Xero\Api\Employee;
use App\Xero\Api\TimeSheet;
use App\Xero\Api\SaleInvoices;
use App\Xero\Api\EmployeeLeave;
use XeroAPI\XeroPHP\Configuration;
use App\Helpers\Xero as XeroHelper;
use App\Xero\Api\User;
use XeroAPI\XeroPHP\Api\PayrollUkApi;
use XeroAPI\XeroPHP\Api\AccountingApi;

class Xero
{
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
        (new User($xeroTenantId, $accountingApi));
        //:::::Payroll Uk
        //Store employees
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new Employee($xeroTenantId,  $payrollUkApi));
        //Store employee leaves
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new EmployeeLeave($xeroTenantId,  $payrollUkApi));
        //store Timesheets
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new TimeSheet($xeroTenantId,  $payrollUkApi));

        dd('done');
    }
    public function accountingApiInstance($config)
    {
        return new AccountingApi(
            new Client(),
            $config
        );
    }

    public function payrollUkApiInstance($config)
    {
        return $payrollUkApi = new PayrollUkApi(
            new Client(),
            $config
        );
    }
}
