<?php

namespace App\Http\Controllers;

use App\Helpers\Xero;
use App\Xero\Storage;
use GuzzleHttp\Client;
use App\Xero\ClientBuilder;
use Illuminate\Http\Request;
use XeroAPI\XeroPHP\JWTClaims;
use XeroAPI\XeroPHP\Configuration;
use App\Http\Controllers\Controller;
use XeroAPI\XeroPHP\Api\IdentityApi;
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
    
    public function authorization(Request $request)
    {
        $builder = new ClientBuilder();
        $builder->createClientV2($request);
    }

    public function callback()
    { 
        $storage = new Storage(); 
        $provider = (new Xero())->getXeroOauth2Provider();
        // If we don't have an authorization code then get one
        if (!isset($_GET['code'])) {
            echo "NO CODE";
            header("Location: index.php?error=true");
            exit();

        } elseif (empty($_GET['state'])) {
            echo "Invalid State";
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            try {
                // Try to get an access token using the authorization code grant.
                $accessToken = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
            
                $jwt = new JWTClaims();
                $jwt->setTokenId($accessToken->getValues()["id_token"]);
                $jwt->decode();
        
                $config = Configuration::getDefaultConfiguration()->setAccessToken( (string)$accessToken->getToken() );
                $identityInstance = new IdentityApi(
                    new Client(),
                    $config
                );
                
                // Get Array of Tenant Ids
                $result = $identityInstance->getConnections();

                // Save my token, expiration and tenant_id
                $storage->setToken(
                    $accessToken->getToken(),
                    $accessToken->getExpires(),
                    $result[0]->getTenantId(),  
                    $accessToken->getRefreshToken(),
                    $accessToken->getValues()["id_token"]
                );
    
                $this->storeData($storage);
        
            } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                echo "Failed!!!";
                // Failed to get the access token or user details.
                exit($e->getMessage());
            }
        }
    }

    public function storeData($storage)
    {
        $xeroTenantId = (string) request()->session()->get('oauth2.tenant_id');
        if ($storage->getHasExpired()) {
            $provider = (new Xero())->getXeroOauth2Provider();
    
            $newAccessToken = $provider->getAccessToken('refresh_token', [
                'refresh_token' => $storage->getRefreshToken()
            ]);
            // Save my token, expiration and refresh token
             // Save my token, expiration and refresh token
             $storage->setToken(
                $newAccessToken->getToken(),
                $newAccessToken->getExpires(), 
                $xeroTenantId,
                $newAccessToken->getRefreshToken(),
                $newAccessToken->getValues()["id_token"] );
        }

        $config = Configuration::getDefaultConfiguration()->setAccessToken( (string)$storage->getSession()['token'] );		  
        $accountingApi = new AccountingApi(
            new Client(),
            $config
        );

        $this->getContact($xeroTenantId,$accountingApi);
    }

    public function getContact($xeroTenantId,$accountingApi)
    {
        dd($accountingApi->getContacts($xeroTenantId));
    }
}
