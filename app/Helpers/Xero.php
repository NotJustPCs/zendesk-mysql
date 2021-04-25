<?php


namespace App\Helpers;

use App\Xero\Storage;
use GuzzleHttp\Client;
use XeroAPI\XeroPHP\JWTClaims;
use XeroAPI\XeroPHP\Configuration;
use XeroAPI\XeroPHP\Api\IdentityApi;


class Xero
{
    public function authenticate()
    {
        $provider = $this->getXeroOauth2Provider();
        if (!isset($_GET['code'])) {

            $options = [
                'scope' => ['openid email profile offline_access assets projects accounting.settings accounting.transactions accounting.contacts accounting.journals.read accounting.reports.read accounting.attachments payroll.employees.read payroll.timesheets']
            ];

            // Fetch the authorization URL from the provider; this returns the urlAuthorize option and generates and applies any necessary parameters (e.g. state).
            $authorizationUrl = $provider->getAuthorizationUrl($options);
            // Get the state generated for you and store it to the session.

            // $_SESSION['oauth2state'] = $provider->getState();
            request()->session()->put('oauth2state', $provider->getState());
            // Redirect the user to the authorization URL.
            header('Location: ' . $authorizationUrl);
            exit();

            // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            exit('Unable to authenticate');
        }
    }

    public function getXeroOauth2Provider()
    {
        $clientId = config('xero.client_id');
        $clientSecret = config('xero.client_secret');
        $redirectUri = config('xero.redirect_uri');
        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => $clientId,
            'clientSecret'            => $clientSecret,
            'redirectUri'             => $redirectUri,
            'urlAuthorize'            => 'https://login.xero.com/identity/connect/authorize',
            'urlAccessToken'          => 'https://identity.xero.com/connect/token',
            'urlResourceOwnerDetails' => 'https://api.xero.com/api.xro/2.0/Organisation'
        ]);

        return $provider;
    }

    public function getAccessToken($provider)
    {
        return $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
    }

    public function getIdentityInstance($accessToken)
    {


        $jwt = new JWTClaims();
        $jwt->setTokenId($accessToken->getValues()["id_token"]);
        $jwt->decode();

        $config = Configuration::getDefaultConfiguration()->setAccessToken((string)$accessToken->getToken());
        return new IdentityApi(
            new Client(),
            $config
        );
    }

    public function checkTokenHasExpiredAndRefresh(Storage $storage, $xeroTenantId)
    {
        if ($storage->getHasExpired()) {
            $provider = (new Xero())->getXeroOauth2Provider();

            $newAccessToken = $provider->getAccessToken('refresh_token', [
                'refresh_token' => $storage->getRefreshToken()
            ]);
            // Save my token, expiration and refresh token
            $storage->setToken(
                $newAccessToken->getToken(),
                $newAccessToken->getExpires(),
                $xeroTenantId,
                $newAccessToken->getRefreshToken(),
                $newAccessToken->getValues()["id_token"]
            );
        }
    }
    /**
     * save my token, expiration and tenant_id
     **/
    public function saveTokenExpiryAndTenantIdInStorage(Storage $storage, $accessToken, $result)
    {
        $storage->setToken(
            $accessToken->getToken(),
            $accessToken->getExpires(),
            $result[0]->getTenantId(),
            $accessToken->getRefreshToken(),
            $accessToken->getValues()["id_token"]
        );
    }
    public static function deserialize($instance)
    {
        $data = [];
        foreach ($instance::openAPITypes() as $property => $type) {
            $propertyGetter = $instance::getters()[$property];

            if (!isset($propertyGetter) || !isset($instance::attributeMap()[$property])) {
                continue;
            }

            $propertyValue = $instance::attributeMap()[$property];
            if (isset($propertyValue)) {
                $data[$property] = $instance->$propertyGetter();
            }
        }
        return $data;
    }
}
