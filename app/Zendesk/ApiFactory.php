<?php


namespace App\Zendesk;

use App\Zendesk\Client;
use App\Zendesk\Api\User;
use App\Zendesk\Api\Ticket;
use App\Zendesk\Api\Organization;


class ApiFactory
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function userApi(): User
    {
        return new User($this->client);
    }
    public function organizationApi(): Organization
    {
        return new Organization($this->client);
    }
    public function ticketApi(): Ticket
    {
        return new Ticket($this->client);
    }
}
