<?php


namespace App\Helpers;


class Core
{
    public static function zendeskRequestHeaders()
    {
        $apiToken = config('zendesk.api_token');
        $userName = config('zendesk.email');
        $token = $userName . "/token:" . $apiToken;
        $base64EncodeToken = base64_encode($token);

        return [
            'headers' => [
                'Authorization'     => "Basic " . $base64EncodeToken,
                'Content-Type' => 'application/json '
            ]
        ];
    }

    public static function zendeskUrl($uri = null)
    {
        $url = config('zendesk.url');
        return 'https://' . $url . '/api/v2/' . $uri;
    }
    public static function zendeskToken()
    {
        $apiToken = config('zendesk.api_token');
        $userName = config('zendesk.email');
        $token = $userName . "/token:" . $apiToken;
        return "Basic " . base64_encode($token);
    }
}
