<?php

namespace App\Providers;



use App\Contracts\MessageContract;
use App\Contracts\Overtime\OvertimeContract;
use App\Contracts\Payroll\DepuEmpPayrollContract;
use App\Contracts\Pmis\Employee\DepuEmpBasicInfoContract;
use App\Managers\MessageManager;
use App\Managers\Overtime\OvertimeManager;
use App\Managers\Payroll\DepuEmpPayrollManager;
use App\Managers\Pmis\Employee\DepuEmpBasicInfoManager;
use Illuminate\Support\ServiceProvider;

use App\Contracts\Pmis\Employee\BasicInfoContract;
use App\Managers\Pmis\Employee\BasicInfoManager;

use App\Contracts\Pmis\Employee\ExperienceContract;
use App\Managers\Pmis\Employee\ExperienceManager;

use App\Contracts\Pmis\Employee\IdentificationContract;
use App\Managers\Pmis\Employee\IdentificationManager;

use App\Contracts\Pmis\Employee\PmisCommonContract;
use App\Managers\Pmis\Employee\PmisCommonManager;

use App\Contracts\Pmis\Employee\ServiceContract;
use App\Managers\Pmis\Employee\ServiceManager;

use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Managers\Pmis\Employee\EmployeeManager;

use App\Contracts\Payroll\PayrollContract;
use App\Managers\Payroll\PayrollManager;


class PmisContractProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(BasicInfoContract::class, BasicInfoManager::class);
        $this->app->bind(ExperienceContract::class, ExperienceManager::class);
        $this->app->bind(IdentificationContract::class, IdentificationManager::class);
        $this->app->bind(PmisCommonContract::class, PmisCommonManager::class);
        $this->app->bind(BasicInfoContract::class, BasicInfoManager::class);
        $this->app->bind(ServiceContract::class, ServiceManager::class);
        $this->app->bind(AdminContract::class, AdminManager::class);
        $this->app->bind(EmployeeContract::class, EmployeeManager::class);
        $this->app->bind(PayrollContract::class, PayrollManager::class);
        $this->app->bind(OvertimeContract::class, OvertimeManager::class);
        $this->app->bind(DepuEmpBasicInfoContract::class,DepuEmpBasicInfoManager::class);
        $this->app->bind(DepuEmpPayrollContract::class,DepuEmpPayrollManager::class);
        $this->app->bind(MessageContract::class,MessageManager::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
