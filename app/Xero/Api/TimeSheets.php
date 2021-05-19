<?php

namespace App\Xero\Api;

use App\Helpers\Xero;
use Illuminate\Support\Facades\DB;

class TimeSheets
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
        $this->getTimesheets($this->xeroTenantId, $this->payrollUkApi);
    }

    public function getTimesheets($xeroTenantId, $payrollUkApi)
    {
        $timesheets = ($payrollUkApi->getTimesheets($xeroTenantId))->getTimesheets();
        foreach ($timesheets as  $timesheetObject) {
            $timesheet = Xero::deserialize($timesheetObject);
            // //store timesheets
            $this->storeTimesheets($timesheet);
        }
    }
    private function storeTimesheets($timesheet)
    {
        DB::table('xero_timesheets')->insert($timesheet);
    }
}
