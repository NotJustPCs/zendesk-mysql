<?php


namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;


class Employee
{
    private $xeroTenantId;
    private $payrollUkApi;
    public function __construct($xeroTenantId,  $payrollUkApi)
    {
        $this->xeroTenantId = $xeroTenantId;
        $this->payrollUkApi = $payrollUkApi;
        $this->init();
    }

    public function init()
    {
        $this->getEmployees($this->xeroTenantId, $this->payrollUkApi);
    }

    public function getEmployees($xeroTenantId, $payrollUkApi)
    {
        $employees = ($payrollUkApi->getEmployees($xeroTenantId))->getEmployees();
        foreach ($employees as  $employeeObject) {
            $employee = Xero::deserialize($employeeObject);
            $employeeId = $employee['employee_id'];
            //store employee address
            $address = $employee['address'];
            unset($employee['address']);
            $this->storeAddress($address, $employeeId);
            //store Employee
            $this->storeEmployee($employee);
        }
    }



    private function storeEmployee($employee)
    {
        DB::table('xero_employees')->insert($employee);
    }

    private function storeAddress($address, $employeeId)
    {
        if (isset($address)) {
            $address = Xero::deserialize($address);
            $address['employee_id'] = $employeeId;
            DB::table('xero_employee_addresses')->insert($address);
        }
    }
}
