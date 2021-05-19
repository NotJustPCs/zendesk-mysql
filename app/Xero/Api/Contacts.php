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
            $contactId = $contact['contact_id'];
            //store contact groups
            $contact_groups = $contact['contact_groups'];
            unset($contact['contact_groups']);
            $this->storeContactGroups($contact_groups, $contactId);
            //store contact_persons
            $contact_persons = $contact['contact_persons'];
            unset($contact['contact_persons']);
            $this->storeContactPersons($contact_persons, $contactId);
            //store addresses
            $addresses = $contact['addresses'];
            unset($contact['addresses']);
            $this->storeAddress($addresses, $contactId);
            // store phones
            $phones = $contact['phones'];
            unset($contact['phones']);
            $this->storePhones($phones, $contactId);
            // store default_currency
            $default_currency = $contact['default_currency'];
            unset($contact['default_currency']);
            $this->storeDefaultCurrency($default_currency, $contactId);
            //store sales_tracking_categories
            $sales_tracking_categories = $contact['sales_tracking_categories'];
            unset($contact['sales_tracking_categories']);
            $this->storeSalesTrackingCategories($sales_tracking_categories, $contactId);
            // store purchases_tracking_categories
            $purchases_tracking_categories = $contact['purchases_tracking_categories'];
            unset($contact['purchases_tracking_categories']);
            $this->storePurchasesTrackingCategories($purchases_tracking_categories, $contactId);
            // store payment_terms
            $payment_terms = $contact['payment_terms'];
            unset($contact['payment_terms']);
            $this->storePaymentTerms($payment_terms, $contactId);
            // store branding_theme
            $branding_theme = $contact['branding_theme'];
            unset($contact['branding_theme']);
            $this->storeBrandingTheme($branding_theme, $contactId);
            // store batch_payments
            $batch_payments = $contact['batch_payments'];
            unset($contact['batch_payments']);
            $this->storeBatchPayments($batch_payments, $contactId);
            // store balances
            $balances = $contact['balances'];
            unset($contact['balances']);
            $this->storeBalances($balances, $contactId);
            // store attachments
            $attachments = $contact['attachments'];
            unset($contact['attachments']);
            $this->storeAttachments($attachments, $contactId);
            // store validation_errors
            $validation_errors = $contact['validation_errors'];
            unset($contact['validation_errors']);
            $this->storeValidationErrors($validation_errors, $contactId);
            // store contact
            $this->storeContact($contact);
        }
    }


    public function storeContact($contact)
    {
        DB::table('xero_contacts')->insert($contact);
    }


    private function storeContactGroups($contact_groups, $contactId)
    {
        if (isset($contact_groups)) {
            foreach ($contact_groups as $contact_group) {
                $contact_group = Xero::deserialize($contact_group);
                //Note:store addresses
                $contacts = $contact_group['contacts'];
                unset($contact_group['contacts']);
                // $this->storeAddress($contacts, $contactId);
                //
                $contact_group['contact_id'] = $contactId;
                DB::table('xero_contact_groups')->insert($contact_group);
            }
        }
    }

    private function storeContactPersons($contact_persons, $contactId)
    {
        if (isset($contact_persons)) {
            foreach ($contact_persons as $contact_person) {
                $contact_person = Xero::deserialize($contact_person);
                $contact_person['contact_id'] = $contactId;
                DB::table('xero_contact_persons')->insert($contact_person);
            }
        }
    }

    private function storeAddress($addresses, $contactId)
    {
        if (isset($addresses)) {
            foreach ($addresses as $address) {
                $address = Xero::deserialize($address);
                $address['contact_id'] = $contactId;
                DB::table('xero_contact_addresses')->insert($address);
            }
        }
    }

    private function storePhones($phones, $contactId)
    {
        if (isset($phones)) {
            foreach ($phones as $phone) {
                $phone = Xero::deserialize($phone);
                $phone['contact_id'] = $contactId;
                DB::table('xero_contact_phones')->insert($phone);
            }
        }
    }

    private function storeDefaultCurrency($default_currencies, $contactId)
    {
        //Note:Reference not found
        // if (isset($default_currencies)) {
        //     foreach ($default_currencies as $currency) {
        //         $currency = Xero::deserialize($currency);
        //         $currency['contact_id'] = $contactId;
        //         DB::table('xero_contact_default_currencies')->insert($currency);
        //     }
        // }
    }

    private function storeSalesTrackingCategories($sales_tracking_categories, $contactId)
    {
        if (isset($sales_tracking_categories)) {
            foreach ($sales_tracking_categories as $sales_tracking_category) {
                $sales_tracking_category = Xero::deserialize($sales_tracking_category);
                $sales_tracking_category['contact_id'] = $contactId;
                DB::table('xero_contact_sales_tracking_categories')->insert($sales_tracking_category);
            }
        }
    }

    private function storePurchasesTrackingCategories($purchases_tracking_categories, $contactId)
    {
        if (isset($purchases_tracking_categories)) {
            foreach ($purchases_tracking_categories as $purchases_tracking_category) {
                $purchases_tracking_category = Xero::deserialize($purchases_tracking_category);
                $purchases_tracking_category['contact_id'] = $contactId;
                DB::table('xero_contact_purchases_tracking_categories')->insert($purchases_tracking_category);
            }
        }
    }

    private function storeValidationErrors($validation_errors, $contactId)
    {
        if (isset($validation_errors)) {
            foreach ($validation_errors as $validation_error) {
                $validation_error = Xero::deserialize($validation_error);
                $validation_error['contact_id'] = $contactId;
                DB::table('xero_contact_validation_errors')->insert($validation_error);
            }
        }
    }

    private function storeAttachments($attachments, $contactId)
    {
        if (isset($attachments)) {
            foreach ($attachments as $attachment) {
                $attachment = Xero::deserialize($attachment);
                $attachment['contact_id'] = $contactId;
                DB::table('xero_contact_purchases_attachments')->insert($attachment);
            }
        }
    }

    private function storeBalances($balances, $contactId)
    {
        //Note: No Reference
        // if (isset($balances)) {
        //     foreach ($balances as $balance) {
        //         $balance = Xero::deserialize($balance);
        //         $balance['contact_id'] = $contactId;
        //         DB::table('xero_contact_balances')->insert($balance);
        //     }
        // }
    }

    private function storePaymentTerms($payment_terms, $contactId)
    {
        if (isset($payment_terms)) {
            foreach ($payment_terms as $payment_term) {
                $payment_term = Xero::deserialize($payment_term);
                $payment_term['contact_id'] = $contactId;
                DB::table('xero_contact_payment_terms')->insert($payment_term);
            }
        }
    }

    private function storeBrandingTheme($branding_theme, $contactId)
    {
        if (isset($branding_theme)) {
            foreach ($branding_theme as $theme) {
                $theme = Xero::deserialize($theme);
                $theme['contact_id'] = $contactId;
                DB::table('xero_contact_branding_themes')->insert($theme);
            }
        }
    }

    private function storeBatchPayments($batch_payments, $contactId)
    {
        if (isset($batch_payments)) {
            foreach ($batch_payments as $batch_payment) {
                $batch_payment = Xero::deserialize($batch_payment);
                $batch_payment['contact_id'] = $contactId;
                DB::table('xero_contact_batch_payments')->insert($batch_payment);
            }
        }
    }
}
