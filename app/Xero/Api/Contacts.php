<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class Contacts
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
        $this->getContact($this->xeroTenantId, $this->accountingApi);
    }

    public function getContact($xeroTenantId, $accountingApi)
    {
        $contacts = ($accountingApi->getContacts($xeroTenantId))->getContacts();

        foreach ($contacts as  $ContactObject) {

            $contact = Xero::deserialize($ContactObject);
            //
            $contact_groups = $contact['contact_groups'];
            unset($contact['contact_groups']);
            //
            $contact_persons = $contact['contact_persons'];
            unset($contact['contact_persons']);
            //
            $addresses = $contact['addresses'];
            unset($contact['addresses']);
            //
            $phones = $contact['phones'];
            unset($contact['phones']);
            //
            $defaultCurrency = $contact['default_currency'];
            unset($contact['default_currency']);
            //
            $sales_tracking_categories = $contact['sales_tracking_categories'];
            unset($contact['sales_tracking_categories']);
            //
            $purchases_tracking_categories = $contact['purchases_tracking_categories'];
            unset($contact['purchases_tracking_categories']);
            //
            $payment_terms = $contact['payment_terms'];
            unset($contact['payment_terms']);
            //
            $branding_theme = $contact['branding_theme'];
            unset($contact['branding_theme']);
            //
            $batch_payments = $contact['batch_payments'];
            unset($contact['batch_payments']);
            //
            $balances = $contact['balances'];
            unset($contact['balances']);
            //
            $attachments = $contact['attachments'];
            unset($contact['attachments']);
            //
            $validation_errors = $contact['validation_errors'];
            unset($contact['validation_errors']);
            //
            $this->storeContact($contact);
            dd('done');
        }
    }


    public function storeContact($contact)
    {
        DB::table('xero_contacts')->insert($contact);
    }

    protected static $openAPITypes = [

        'contact_persons' => '\XeroAPI\XeroPHP\Models\Accounting\ContactPerson[]',
        'addresses' => '\XeroAPI\XeroPHP\Models\Accounting\Address[]',
        'phones' => '\XeroAPI\XeroPHP\Models\Accounting\Phone[]',

        'default_currency' => '\XeroAPI\XeroPHP\Models\Accounting\CurrencyCode',

        'sales_tracking_categories' => '\XeroAPI\XeroPHP\Models\Accounting\SalesTrackingCategory[]',
        'purchases_tracking_categories' => '\XeroAPI\XeroPHP\Models\Accounting\SalesTrackingCategory[]',

        'payment_terms' => '\XeroAPI\XeroPHP\Models\Accounting\PaymentTerm',

        'contact_groups' => '\XeroAPI\XeroPHP\Models\Accounting\ContactGroup[]',

        'branding_theme' => '\XeroAPI\XeroPHP\Models\Accounting\BrandingTheme',
        'batch_payments' => '\XeroAPI\XeroPHP\Models\Accounting\BatchPaymentDetails',

        'balances' => '\XeroAPI\XeroPHP\Models\Accounting\Balances',
        'attachments' => '\XeroAPI\XeroPHP\Models\Accounting\Attachment[]',

        'validation_errors' => '\XeroAPI\XeroPHP\Models\Accounting\ValidationError[]',

    ];
}
