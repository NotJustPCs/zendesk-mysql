<?php


namespace App\Helpers;


class Xero
{

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




}