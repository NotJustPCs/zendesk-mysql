<?php


namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;


class EmployeeLeave
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
        $this->getEmployeeLeaves($this->xeroTenantId, $this->payrollUkApi);
    }

    public function getEmployeeLeaves($xeroTenantId, $payrollUkApi)
    {
        $employees = DB::table('xero_employees')->get();
        foreach ($employees as  $employee) {
            $employeeLeaves = ($payrollUkApi->getEmployeeLeaves($xeroTenantId, $employee->employee_id));
            foreach ($employeeLeaves->getLeave() as  $leaveObject) {
                $leave = Xero::deserialize($leaveObject);
                $leaveId = $leave['leave_id'];
                //store employee address
                $periods = $leave['periods'];
                unset($leave['periods']);
                $this->storeEmployeeLeavePeriods($periods, $leaveId);
                //store Employee
                $this->storeEmployeeLeave($leave);
            }
        }
    }



    private function storeEmployeeLeave($leave)
    {
        DB::table('xero_employee_leaves')->insert($leave);
    }

    private function storeEmployeeLeavePeriods($periods, $leaveId)
    {
        foreach ($periods as $period) {
            $period = Xero::deserialize($period);
            $period['leave_id'] = $leaveId;
            DB::table('xero_employee_leave_periods')->insert($period);
        }
    }
}
