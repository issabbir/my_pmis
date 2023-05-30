<?php


namespace App\Http\Controllers\Api\V1\Loan;

use App\Entities\Admin\LRelationType;
use App\Entities\Loan\LoanApplication;
use App\Entities\Loan\LoanDocuments;
use App\Entities\Loan\LoanGuarantor;
use App\Entities\Loan\LoanGuarantorInfo;
use App\Entities\Loan\LoanType;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoanGuarantorController extends Controller
{
    public function getLoanGuarantorSearch(Request $request,LoanType $loanType)
    {
        $loan_no = $request->get("loan_no");
        $emp_code = $request->get("emp_code");
        $loan_type_id = $request->get("loan_type_id");
        $sql = "SELECT DISTINCT ev.emp_id,
                lg.loan_emp_id,
                ev.emp_name,
                ev.emp_code,
                ev.department_name,
                ev.designation
  FROM loan_guarantor lg, employee_info_vu ev
 WHERE lg.loan_emp_id = ev.emp_id";
        $data = DB::select($sql);

        $sql2 = "SELECT ev.emp_id,
       lg.loan_guarantor_id,
       lg.loan_emp_id,
       ev.emp_name,
       ev.department_name,
       ev.designation
  FROM loan_guarantor lg, loan_guarantor_info lgf, employee_info_vu ev
 WHERE     lg.guar_info_id = lgf.guar_info_id
       AND lgf.guar_emp_id = ev.emp_id";
        $gurantors = DB::select($sql2);
            //dd($data);
        return [
            'data' => $data,
            'relations' => LRelationType::all(),
            'loanTypes' => $this->getLoanTypes($loanType),
            'gurantors' => $gurantors,
        ];
    }
    private function getLoanTypes(LoanType $loanType) {
        return $loanType->get();
    }
    public function store(Request $request){
        try {
            if (count($request->guarantors) < 2){
                return ["exception" => false, 'o_status_code' => 0,  "status" => false, "o_status_message" => 'Need minimum 2 guarantors!'];
            }
            $i=1;
            foreach ($request->guarantors as  $guarantor){
                $loan_guarantor_id = isset($guarantor['loan_guarantor_id']) ? $guarantor['loan_guarantor_id'] : null;
                $status_code = sprintf("%4000s","");
                $status_message = sprintf("%4000s","");
                $params = [
                    "p_loan_guarantor_id" => $loan_guarantor_id,
                    "p_guarantor_serial" => $i++,
                    "p_guar_emp_id" => isset($guarantor['selectedGurantor']['emp_id']) ? $guarantor['selectedGurantor']['emp_id'] : '',
                    "p_guar_emp_code" => isset($guarantor['selectedGurantor']['emp_id']) ? $guarantor['selectedGurantor']['emp_id'] : '',
                    "p_guar_contact_no" => isset($guarantor['contact']) ? $guarantor['contact'] : '',
                    "p_loan_type_id" => $request->get('loan_type_id'),
                    "p_loan_emp_id" => $request->get('emp_id'),
                    "p_loan_emp_code" => $request->get('emp_code'),
                    "p_relation_with_loan" => isset($guarantor['relation_with_loan']) ? $guarantor['relation_with_loan'] : '',
                    "p_loan_application_id" => '',
                    "p_attachment" => [
                        'value' => isset($guarantor['attachment']) ? $guarantor['attachment'] : '',
                        'type' => SQLT_CLOB
                    ],
                    "p_attachment_file_name" => isset($guarantor['attachment_file_name']) ? $guarantor['attachment_file_name'] :  '',
                    "p_insert_by" => auth()->id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("loan.loan_guarantor_create", $params);
                if ($params['o_status_code'] == 1){
                    DB::commit();
                    $success = true;
                }else{
                    DB::rollBack();
                    $success = false;
                }
            }
            if ($success){
                return ["exception" => false, 'o_status_code' => 1,  "status" => true, "o_status_message" => 'Successfully Inserted'];
            }else{
                return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $status_message];
            }
        }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function getLoanGuarantor(){
        $sql = "select * from loan_guarantor";
        return DB::select($sql);
    }

}
