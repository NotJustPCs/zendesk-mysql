<?php

namespace App\Http\Controllers;

use App\Xero\Xero;
use App\Xero\Storage;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use XeroAPI\XeroPHP\ApiException;
use App\Helpers\Xero as XeroHelper;
use XeroAPI\XeroPHP\Api\AccountingApi;

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
        try {
            // Try to get an access token using the authorization code grant.
            $accessToken = $xero->getAccessToken($provider);
            // Get Array of Tenant Ids
            $identityInstance = $xero->getIdentityInstance($accessToken);
            $result = $identityInstance->getConnections();
            $xero->saveTokenExpiryAndTenantIdInStorage($storage, $accessToken, $result);
            $xeroTenantId = (string) request()->session()->get('oauth2.tenant_id');
            (new Xero())->storeData($storage, $xero, $xeroTenantId);
        } catch (IdentityProviderException $e) {
            echo "Failed!!!";
            // Failed to get the access token or user details.
            exit($e->getMessage());
        }
    }
}
