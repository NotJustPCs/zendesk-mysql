<?php

namespace App\Http\Controllers;

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
        $client = new \Guzzle\Service\Client('http://api.github.com/users/');
        dd($client);
    }
}
