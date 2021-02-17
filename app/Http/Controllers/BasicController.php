<?php

namespace App\Http\Controllers;

use App\Helpers\Core;
use App\Zendesk\ApiFactory;
use App\Zendesk\ClientBuilder;
use App\Http\Controllers\Controller;

class BasicController extends Controller
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
        $userApi = $apiFactory->userApi();
        $users = $userApi->users();
        //Fetch organizations
        $userApi = $apiFactory->organizationApi();
        $organizations = $userApi->organizations();

        dd($organizations);
    }
}
