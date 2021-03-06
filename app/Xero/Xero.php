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
use App\Xero\Api\SaleInvoice;
use App\Xero\Api\SaleInvoices;
use App\Xero\Api\ItemHistories;
use App\Xero\Api\EmployeeLeaves;
use App\Xero\Api\QuoteHistories;
use App\Xero\Api\ContactHistories;
use App\Xero\Api\InvoiceHistories;
use XeroAPI\XeroPHP\Configuration;
use App\Helpers\Xero as XeroHelper;
use App\Xero\Api\OnlineSaleInvoice;
use App\Xero\Api\RepeatingInvoices;
use XeroAPI\XeroPHP\Api\PayrollUkApi;
use XeroAPI\XeroPHP\Api\AccountingApi;
use App\Xero\Api\RepeatingInvoiceHistories;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class Xero
{
    /**
     * @throws IdentityProviderException
     */
    public function storeData(Storage $storage, XeroHelper $xero, $xeroTenantId)
    {
        $config = $this->getConfig($storage, $xero, $xeroTenantId);
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
    }
    public function getConfig($storage, $xero, $xeroTenantId)
    {
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        return Configuration::getDefaultConfiguration()->setAccessToken((string)$storage->getSession()['token']);
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
    public function storeInvoice(Storage $storage, XeroHelper $xero, $xeroTenantId, $invoice)
    {

        $config = $this->getConfig($storage, $xero, $xeroTenantId);
        $accountingApi = $this->accountingApiInstance($config);
        //store invoice
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new SaleInvoiceLineItems($xeroTenantId,  $accountingApi, $invoice));
    }
    public function storeOnlineInvoice(Storage $storage, XeroHelper $xero, $xeroTenantId, $invoice)
    {
        $config = $this->getConfig($storage, $xero, $xeroTenantId);
        $accountingApi = $this->accountingApiInstance($config);
        //store invoice
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new OnlineSaleInvoice($xeroTenantId,  $accountingApi, $invoice));
    }
    public function storeRepeatingInvoiceHistory(Storage $storage, XeroHelper $xero, $xeroTenantId, $invoice, $id)
    {
        $config = $this->getConfig($storage, $xero, $xeroTenantId);
        $accountingApi = $this->accountingApiInstance($config);
        //store Repeating Invoices history
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new RepeatingInvoiceHistories($xeroTenantId,  $accountingApi, $invoice, $id));
    }
    public function storeItemHistory(Storage $storage, XeroHelper $xero, $xeroTenantId, $item)
    {
        $config = $this->getConfig($storage, $xero, $xeroTenantId);
        $accountingApi = $this->accountingApiInstance($config);
        //store item history
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new ItemHistories($xeroTenantId,  $accountingApi, $item));
    }
    public function storeContactHistory(Storage $storage, XeroHelper $xero, $xeroTenantId, $contact)
    {
        $config = $this->getConfig($storage, $xero, $xeroTenantId);
        $accountingApi = $this->accountingApiInstance($config);
        //store item history
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new ContactHistories($xeroTenantId,  $accountingApi, $contact));
    }
    public function storeInvoiceHistory(Storage $storage, XeroHelper $xero, $xeroTenantId, $contact)
    {
        $config = $this->getConfig($storage, $xero, $xeroTenantId);
        $accountingApi = $this->accountingApiInstance($config);
        //store Invoice history
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new InvoiceHistories($xeroTenantId,  $accountingApi, $contact));
    }
    public function storeQuoteHistory(Storage $storage, XeroHelper $xero, $xeroTenantId, $quote, $id)
    {
        $config = $this->getConfig($storage, $xero, $xeroTenantId);
        $accountingApi = $this->accountingApiInstance($config);
        //store Invoice history
        $xero->checkTokenHasExpiredAndRefresh($storage, $xeroTenantId);
        (new QuoteHistories($xeroTenantId,  $accountingApi, $quote, $id));
    }
}
