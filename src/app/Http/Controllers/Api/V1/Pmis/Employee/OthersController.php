<?php


namespace App\Http\Controllers\Api\V1\Pmis\Employee;


use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LAttributeType;
use App\Entities\Payroll\PrSalaryHeads;
use App\Entities\Admin\LEmpType;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmpOtherAttributesTemp;
use App\Entities\Admin\Llookups;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OthersController extends Controller
{
    /** @var AdminManager */
    private $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request,$id)
    {
        $LAttributeType = new LAttributeType();
        $PrSalaryHeads = new PrSalaryHeads();
        $clubs = $LAttributeType->where('active_yn','Y')->orderBy('attribute_name','asc')->get();
        $salaryHeads = $PrSalaryHeads->where('active_yn', 'Y')->orderBy('salary_head','asc')->get();
        $clubData=[];
        foreach ($clubs as $club) {
            $clubOtions = [];
            $clubOtions['text'] = $club->attribute_name;
            $clubOtions['value'] = $club;
            $clubData[] = $clubOtions;
        }
        $salaryHeadData = [];
        foreach ($salaryHeads as $salaryHead) {
            if (Auth::user()->hasRole('SUPER_ADMIN')){
                $salaryHeadOptions = [];
                $salaryHeadOptions['text'] = $salaryHead->salary_head;
                $salaryHeadOptions['value'] = $salaryHead;
                $salaryHeadData[] = $salaryHeadOptions;
            }else{
                if($salaryHead->salary_head_id != 44) {
                    $salaryHeadOptions = [];
                    $salaryHeadOptions['text'] = $salaryHead->salary_head;
                    $salaryHeadOptions['value'] = $salaryHead;
                    $salaryHeadData[] = $salaryHeadOptions;
                }
            }
        }

        if (Auth::user()->hasRole('SUPER_ADMIN')){
            $data=DB::table('emp_other_attributes_temp')
                ->where('emp_other_attributes_temp.emp_id','=',$id)
                ->join('l_emp_type', function ($join) {
                    $join->on('emp_other_attributes_temp.emp_type_id', '=', 'l_emp_type.emp_type_id');
                })
                ->join('employee', function ($join) {
                    $join->on('employee.emp_id', '=', 'emp_other_attributes_temp.emp_id');
                })
                ->get();
        }else{
            $data=DB::table('emp_other_attributes_temp')
                ->where('emp_other_attributes_temp.emp_id','=',$id)
                ->whereNotIn('emp_other_attributes_temp.SALARY_HEAD_ID',[44])
                ->join('l_emp_type', function ($join) {
                    $join->on('emp_other_attributes_temp.emp_type_id', '=', 'l_emp_type.emp_type_id');
                })
                ->join('employee', function ($join) {
                    $join->on('employee.emp_id', '=', 'emp_other_attributes_temp.emp_id');
                })
                ->get();
        }

        $Employee = new Employee();
        $employee = $Employee->with('empType')->where('employee.emp_id',$id)->first();
        return [
            'clubs' => $clubData,
            'salaryHeads' => $salaryHeadData,
            'data' => $data,
            'employee' => $employee
        ];
    }
    public function salaryHeads(Request $request)
    {
        $salaryHeads = PrSalaryHeads::where('active_yn', 'Y')->where('visible_scope_yn', 'Y')->orderBy('salary_head','asc')->get();
        $salaryHeadData = [];
        foreach ($salaryHeads as $salaryHead) {
            if (Auth::user()->hasRole('SUPER_ADMIN')){
                $salaryHeadOptions = [];
                $salaryHeadOptions['text'] = $salaryHead->salary_head;
                $salaryHeadOptions['value'] = $salaryHead;
                $salaryHeadData[] = $salaryHeadOptions;
            }else{
                if($salaryHead->salary_head_id != 44) {
                    $salaryHeadOptions = [];
                    $salaryHeadOptions['text'] = $salaryHead->salary_head;
                    $salaryHeadOptions['value'] = $salaryHead;
                    $salaryHeadData[] = $salaryHeadOptions;
                }
            }

        }
        return [
            'salaryHeads' => $salaryHeadData,
        ];
    }

    public function list(Request $request,$id)
    {
        $EmpOtherAttributesTemp = new EmpOtherAttributesTemp();
        $data = $EmpOtherAttributesTemp->with('emp_type')->with('clubs')->where('emp_id',$id)->get();
        return [
            'data' => $data
        ];
    }

    public function store(Request $request)
    {
        try{
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_attribute_id"        => $request->get("attribute_id"),
                "p_attribute_type"      => '',
                "p_emp_type_id"         => $request->get("emp_type_id"),
                "p_amount"              => $request->get("amount"),
                "p_emp_id"              => $request->get("emp_id"),
                "p_active_yn"           => $request->get("active_yn"),
                "p_insert_by"           => auth()->id(),
                "p_update_by"           => auth()->id(),
                "p_attribute_type_id"   => '',
                "p_percentage"          => $request->get("percentage"),
                "p_description"         => $request->get("description"),
                "p_salary_head_id"      => $request->get("salary_head_id"),
                "o_status_code"         => &$status_code,
                "o_status_message"      => &$status_message,
            ];
            DB::executeProcedure("employees.emp_other_att_entry", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
        return $params;
    }

}
