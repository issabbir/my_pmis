<?php


namespace App\Http\Controllers\Api\V1\Admin\Biller;


use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Pmis\Employee\Employee;
use App\Http\Controllers\Controller;
use App\Entities\Admin\PrBillCodeMaster;
use App\Entities\Payroll\PrBillCodeMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillerCodeController extends Controller
{
    protected $adminManager;

    public function __construct(AdminContract $adminManager) {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request, $code = null)
    {
        $PrBillCodeMaster = new PrBillCodeMaster();
        $PrBllCodeMapping = new PrBillCodeMapping();



        $PrBillCodeMapping = $PrBllCodeMapping->orderBy('bill_mapping_id', 'DESC');
        if ($request->get('filter') != 'null') {
            $PrBillCodeMapping = $PrBillCodeMapping
                ->where('emp_bill_code','=', $request->get('filter'))
                ->orwhere('biller_bill_code','=', $request->get('filter'))
                ->orWhereHas('employee', function($q) use ($request) {
                    if ($request->get('filter')) {
                        $q->where('employee.emp_code','=',$request->get('filter'));
                    }
                });
        }
        $PrBillCodeMapping = $PrBillCodeMapping->paginate($request->get('size'));
        $where = [];
        $where[] = ['activation_flag','=','Y'];
        $PrBillCodeMaster = $PrBillCodeMaster->orderBy('bill_code', 'ASC')->where($where)->get();
        return [
            'billCodes' => $PrBillCodeMaster,
            'records' => $PrBillCodeMapping
        ];
    }

    public function indexx(Request $request, $code = null)
    {
        $PrBillCodeMaster = new PrBillCodeMaster();

        $PrBillCodeMapping = DB::select("SELECT BCM.*,
         E.EMP_CODE,
         E.EMP_NAME,
         D.DESIGNATION,
         DP.DEPARTMENT_NAME,
         DV.DPT_DIVISION_NAME,
         S.DPT_SECTION
    FROM PR_BILL_CODE_MAPPING BCM
         LEFT JOIN EMPLOYEE E ON E.EMP_ID = BCM.BILLER_EMP_ID
         LEFT JOIN L_DESIGNATION D ON D.DESIGNATION_ID = E.DESIGNATION_ID
         LEFT JOIN L_DEPARTMENT DP ON DP.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
         LEFT JOIN L_DPT_DIVISION DV ON DV.DPT_DIVISION_ID = E.DPT_DIVISION_ID
         LEFT JOIN L_DPT_SECTION S ON S.DPT_SECTION_ID = E.SECTION_ID
   WHERE UPPER (
               E.EMP_CODE
            || E.EMP_NAME
            || D.DESIGNATION
            || DP.DEPARTMENT_NAME
            || DV.DPT_DIVISION_NAME
            || S.DPT_SECTION
            || BCM.EMP_BILL_CODE
            || BCM.ACTIVATION_DATE
            || BCM.DEACTIVE_DATE) LIKE
            '%' || UPPER ( :FILTERS) || '%'
ORDER BY BCM.BILL_MAPPING_ID DESC", ['FILTERS' => $request->get('filter')]);
        /*if ($request->get('filter') != 'null') {
            $PrBillCodeMapping = $PrBillCodeMapping
                ->where('emp_bill_code', 'like', "%".$request->get('filter')."%");
        }*/
        $PrBillCodeMapping = $PrBillCodeMapping->paginate($request->get('size'));
        $where = [];
        $where[] = ['activation_flag','=','Y'];
        $PrBillCodeMaster = $PrBillCodeMaster->orderBy('bill_code', 'ASC')->where($where)->get();
        return [
            'billCodes' => $PrBillCodeMaster,
            'records' => $PrBillCodeMapping
        ];
    }


    public function billCodeMaster($code = null)
    {
        $PrBillCodeMaster = new PrBillCodeMaster();
        $where = [];
        $where[] = ['activation_flag','=','Y'];
        $PrBillCodeMaster = $PrBillCodeMaster->orderBy('bill_code', 'ASC')->where($where)->get();
        return [
            'billCodes' => $PrBillCodeMaster,
        ];
    }
    public function specific(Request $request, $id)
    {
        $PrBillCodeMapping = new PrBillCodeMapping();
        $PrBillCodeMapping = $PrBillCodeMapping->find($id);
        $PrBillCodeMapping->employee;
        $PrBillCodeMapping->employee->option2=$PrBillCodeMapping->employee->emp_code." ".$PrBillCodeMapping->employee->emp_name." | ".$PrBillCodeMapping->employee->bill_code;
        return [
            "data" => $PrBillCodeMapping,
            "billCodes" => $this->index($request, $PrBillCodeMapping->emp_bill_code)
        ];
    }

    public function employees(Request $request, $billerCode = null,$billCode)
    {
        $Employee = new Employee();
        $where = [];
//        if($billerCode > 0){
//            $where[] = ['biller_code','=',$billerCode];
//        }
        $where[] = ['bill_code','=',$billCode];
        //$where[] = ['employee.emp_status_id','=','1'];
        $Employee = $Employee->where($where)->whereIn('employee.emp_status_id', [1,13])->get();
        return [
            "data" => $Employee
        ];
    }

    public function save(Request $request){
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $bill_mapping_id = $request->get("bill_mapping_id");
            $params = [
                "p_bill_mapping_id" => $bill_mapping_id,
                "p_biller_emp_id" => $request->get("biller_emp_id"),
                "p_biller_bill_code" => $request->get("biller_bill_code"),
                "p_emp_bill_code" => $request->get("emp_bill_code"),
                "p_description" => $request->get("description"),
                "p_activation_date" => $request->get("activation_date"),
                "p_deactive_date" => $request->get("deactive_date"),
                "p_activation_flag" => $request->get("activation_flag"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("payroll.pr_biller_mapping", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function getBillerInfo(Request $request,$id, EmployeeContract $employeeManager){
        return[
            "empcodeList" => $employeeManager->BillerOption($id)
        ];
    }

}
