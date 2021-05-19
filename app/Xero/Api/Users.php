<?php


namespace App\Xero\Api;


use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class Users
{
    private $xeroTenantId;
    private $accountingApi;
    public function __construct($xeroTenantId, $accountingApi)
    {
        $this->xeroTenantId = $xeroTenantId;
        $this->accountingApi = $accountingApi;
        $this->init();
    }

    public function init()
    {
        $this->getUsers($this->xeroTenantId, $this->accountingApi);
    }

    public function getUsers($xeroTenantId, $accountingApi)
    {
        $users = ($accountingApi->getUsers($xeroTenantId))->getUsers();
        foreach ($users as  $userObject) {
            $user = Xero::deserialize($userObject);
            //store Item
            $this->storeUser($user);
        }
    }
    private function storeUser($user)
    {
        DB::table('xero_users')->insert($user);
    }
}
