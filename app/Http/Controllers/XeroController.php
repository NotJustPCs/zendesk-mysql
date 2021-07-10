<?php

namespace App\Http\Controllers;

use App\Xero\Xero;
use App\Xero\Storage;
use App\Xero\Api\SaleInvoice;
use XeroAPI\XeroPHP\ApiException;
use Illuminate\Support\Facades\DB;
use App\Helpers\Xero as XeroHelper;
use XeroAPI\XeroPHP\Api\AccountingApi;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

class XeroController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return view('xero.index');
    }

    public function authorization()
    {
        (new XeroHelper())->authenticate();
    }

    /**
     * @throws ApiException
     */
    public function callback()
    {
        $xero = new XeroHelper();
        $storage = new Storage();
        $provider = $xero->getXeroOauth2Provider();
        $accessToken = $xero->getAccessToken($provider);
        // Get Array of Tenant Ids
        $identityInstance = $xero->getIdentityInstance($accessToken);
        $result = $identityInstance->getConnections();
        $xero->saveTokenExpiryAndTenantIdInStorage($storage, $accessToken, $result);
        return view('xero.load-data');
    }
    public function storeData()
    {
        try {
            $xero = new XeroHelper();
            $storage = new Storage();
            $xeroTenantId = (string) request()->session()->get('oauth2.tenant_id');
            (new Xero())->storeData($storage, $xero, $xeroTenantId);
            dd('done');
        } catch (IdentityProviderException $e) {
            echo "Failed!!!";
            // Failed to get the access token or user details.
            exit($e->getMessage());
        }
    }
    public function storeInvoice($id)
    {
        try {
            $xero = new XeroHelper();
            $storage = new Storage();
            $xeroTenantId = (string) request()->session()->get('oauth2.tenant_id');
            $invoice = DB::table('xero_invoices')->where('invoice_id', $id)->first();
            (new Xero())->storeInvoice($storage, $xero, $xeroTenantId, $invoice);
            dd('invoice data has been stored');
        } catch (IdentityProviderException $e) {
            echo "Failed!!!";
            // Failed to get the access token or user details.
            exit($e->getMessage());
        }
    }
    public function storeOnlineInvoice($id)
    {
        try {
            $xero = new XeroHelper();
            $storage = new Storage();
            $xeroTenantId = (string) request()->session()->get('oauth2.tenant_id');
            $invoice = DB::table('xero_invoices')->where('invoice_id', $id)->first();
            (new Xero())->storeOnlineInvoice($storage, $xero, $xeroTenantId, $invoice);
            dd('online invoice data has been stored');
        } catch (IdentityProviderException $e) {
            echo "Failed!!!";
            // Failed to get the access token or user details.
            exit($e->getMessage());
        }
    }

    public function repeatingInvoiceHistory($id)
    {
        try {
            $xero = new XeroHelper();
            $storage = new Storage();
            $xeroTenantId = (string) request()->session()->get('oauth2.tenant_id');
            $invoice = DB::table('xero_invoices')->where('invoice_id', $id)->first();
            (new Xero())->storeRepeatingInvoiceHistory($storage, $xero, $xeroTenantId, $invoice);
            dd('repeating invoice data has been stored');
        } catch (IdentityProviderException $e) {
            echo "Failed!!!";
            // Failed to get the access token or user details.
            exit($e->getMessage());
        }
    }
}


// Repeating Invoices
// Users

// I'd also like the history for:
// Repeating Invoices
// Items
// Contacts
// Invoices
// Quotes
