<?php

namespace App\Http\Controllers;

use App\Helpers\Core;
use App\Zendesk\ApiFactory;
use App\Zendesk\ClientBuilder;
use App\Http\Controllers\Controller;

class ZendeskController extends Controller
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

        $builder = new ClientBuilder();
        $client = $builder->createClientV2();
        $apiFactory = new ApiFactory($client);
        //Fetch Users
        $params=[];
        $params['include'] = 'identities';
        $userApi = $apiFactory->userApi();
        $users = $userApi->users($params);
        // Fetch organizations
        $organizationApi = $apiFactory->organizationApi();
        $organizations = $organizationApi->organizations();
        // Fetch Tickets
        $ticketApi = $apiFactory->ticketApi();
        $tickets = $ticketApi->tickets();

        return response()->json([
            'user_count' => count($users),
            'organization_count' => count($organizations),
            'ticket_count' => count($tickets),
        ]);
    }
}
