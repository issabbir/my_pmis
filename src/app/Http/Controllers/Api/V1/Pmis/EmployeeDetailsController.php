<?php

namespace App\Http\Controllers\Api\V1\Pmis;

use App\Entities\Pmis\Employee\EmpEducationTemp;
use App\Entities\Pmis\Employee\EmpExperienceTemp;
use App\Entities\Pmis\Employee\EmpHouseAllotmentTemp;
use App\Entities\Pmis\Employee\EmployeeTemp;
use App\Entities\Pmis\Employee\EmpAddressTemp;
use App\Entities\Pmis\Employee\EmpFamilyTemp;
use App\Entities\Pmis\Employee\EmpNomineeTemp;
use App\Entities\Pmis\Employee\EmpProfCertificateTemp;
use App\Entities\Pmis\Employee\EmpTourTemp;
use App\Entities\Pmis\Employee\EmpTrainingTemp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeDetailsController extends Controller
{
    private $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request,$id)
    {
        $employee = new EmployeeTemp();
        $empFamily = new EmpFamilyTemp();
        $empAddress = new EmpAddressTemp();
        $empNominee = new EmpNomineeTemp();
        $empTraining = new EmpTrainingTemp();
        $empTour = new EmpTourTemp();
        $empProfetionalCertificate = new EmpProfCertificateTemp();
        $empAcademic = new EmpEducationTemp();
        $empExperience = new EmpExperienceTemp();
        $empAccommodation = new EmpHouseAllotmentTemp();
        $basic_info = $employee->find($id);
        $family = $empFamily->where('emp_id', $id)->get();
        $address = $empAddress->where('emp_id', $id)->get();
        $nominee = $empNominee->where('emp_id', $id)->get();
        $training = $empTraining->where('emp_id', $id)->get();
        $tour = $empTour->where('emp_id', $id)->get();
        $expCertificate = $empProfetionalCertificate->where('emp_id', $id)->get();
        $academic = $empAcademic->where('emp_id', $id)->get();
        $experience = $empExperience->where('emp_id', $id)->get();
        $accommodation = $empAccommodation->where('emp_id', $id)->get();
        return [
            "basic_info" => $basic_info,
            "family" => $family,
            "address" => $address,
            "nominee" => $nominee,
            "training" => $training,
            "tour" => $tour,
            "expCertificate" => $expCertificate,
            "academic" => $academic,
            "experience" => $experience,
            "accommodation" => $accommodation
        ];
    }
}
