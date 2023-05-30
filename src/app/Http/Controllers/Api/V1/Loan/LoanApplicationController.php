<?php


namespace App\Http\Controllers\Api\V1\Loan;

use App\Entities\Admin\LRelationType;
use App\Entities\Loan\LoanApplication;
use App\Entities\Loan\LoanDocuments;
use App\Entities\Loan\LoanGuarantor;
use App\Entities\Loan\LoanGuarantorInfo;
use App\Entities\Loan\LoanTransaction;
use App\Entities\Loan\LoanType;
use App\Entities\Pmis\Employee\Employee;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoanApplicationController extends Controller
{
    public function getLoanSearch(Request $request)
    {
        $loan_no = $request->get("loan_no");
        $emp_code = $request->get("emp_code");
        $loan_type_id = $request->get("loan_type_id");

        $sql = "select loan.emp_loan_search(:p1,:p2,:p3) from dual";
        return $list = DB::select($sql, ['p1' => $loan_no, 'p2' => $emp_code, 'p3' => $loan_type_id]);
    }
    public function searchEmployees($searchParam){
       // if(Auth::user()->hasPermission('CAN_APPLY_LOAN_APPLICATION_FOR_ALL')){
            $sql = "select loan.emp_search(:param) from dual";
       // }
         return DB::select($sql, ['param' => $searchParam]);
    }
    public function searchExistingEmployees($loan_type_id,$searchParam){
          $sql = "select loan.emp_existing_loan_search(:param,:loan_type_id) from dual";
         return DB::select($sql, ['param' => $searchParam,'loan_type_id' => $loan_type_id]);
    }
    public function searchEmployeesByLoanType($loan_type_id,$searchParam=null){
        $sql = "SELECT la.emp_code,
ev.emp_name AS employee_name,
ev.designation AS designation,
ev.department_name AS department,
ev.dpt_section AS section,
TO_CHAR (ev.emp_join_date, 'YYYY') join_year,
TO_CHAR (ev.emp_join_date, 'MM') join_month,
ev.gpf_id,
la.loan_id as application_id,
la.sanction_id,
la.emp_id,
la.emp_code || '-' || ev.emp_name AS option_name,
la.open_date as application_date,
la.loan_no,
la.loan_type_id,
la.description,
la.reason,
NVL (la.paid_installment_no, 0) + 1 AS paid_installment_no,
la.rate_of_interest,
la.loan_amount AS loan_amount,
la.remaining_principal AS remaining_principle_amount,
la.remaining_interest AS remaining_interest_amount,
la.installment_no AS number_of_installment
FROM loans la, employee_info_vu ev
WHERE la.emp_id = ev.emp_id
AND UPPER (la.loan_no || ev.emp_name || la.emp_code) LIKE
'%' || UPPER ( :p_loan_no_name) || '%'
AND la.loan_type_id = :p_loan_type_id
AND la.approval_status = 'Y'";
        return DB::select($sql, ['p_loan_no_name' => $searchParam,'p_loan_type_id' => $loan_type_id]);
    }
    public function getLoanGuarantorSearchByType($searchParam){
          $sql = "SELECT LGI.GUAR_NAME AS guar_name,
       LG.LOAN_GUARANTOR_ID as emp_id
FROM LOAN_GUARANTOR LG,LOAN_GUARANTOR_INFO LGI
WHERE  LG.LOAN_GUARANTOR_ID = LGI.GUAR_INFO_ID
  AND UPPER (LGI.GUAR_NAME) LIKE
       '%' || UPPER ( :param ) || '%'";
         return DB::select($sql, ['param' => $searchParam]);
    }
    public function getLoanData($searchParam){
         $sql = "select loan.loan_info_edit(:p_loan_id) from dual";
         $loan_info = DB::selectOne($sql, ['p_loan_id' => $searchParam]);

         //dd($list);
        $sql2 = "SELECT ev.emp_id,
               lg.loan_guarantor_id as loan_guarantor_id,
               lg.loan_emp_id,
               lg.attachment,
               lg.attachment_file_name,
               rt.relation_type,
               rt.RELATION_TYPE_ID relation_with_loan,
               lgf.CONTACT_NO contact
          FROM employee_info_vu ev
          left join loan_guarantor_info lgf on( ev.emp_id=lgf.guar_emp_id)
          left join loan_guarantor lg on (lg.guar_info_id = lgf.guar_info_id)
          left join l_relation_type rt on (rt.relation_type_id = lg.relation_with_loan)
          where lg.LOAN_EMP_ID = $loan_info->emp_id AND lg.LOAN_TYPE_ID = $loan_info->loan_type_id";

         $loan_application = DB::select($sql2);
         $guaranter_data = collect($loan_application)->map(function($x){ return (array) $x; })->toArray();

         $data=array();
           foreach ($guaranter_data as $key=>$val){
               $val['selectedGuarantor']=DB::table('employee')->select(["emp_code","emp_id","emp_name"])->where('emp_id',$val['emp_id'])->first();
               $data[]=$val;
           }
         $data = [
             'loanData' => $loan_info,
             'document' => LoanDocuments::where('loan_id',$searchParam)->get(['loan_doc_id','loan_doc_name','loan_doc','attachment_file_name']),
             'guarantor' => $data,
             'relations' => LRelationType::all(),
         ];
         return $data;
    }
    public function guarantorDelete($id){
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_loan_guarantor_id" => $id,
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("loan.loan_guarantor_delete", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
    public function attachmentDelete($id){
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_loan_doc_id" => $id,
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("loan.loan_documents_delete", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
    public function getLoanSummaryData(Request $request)
    {

        $loan_no = $request->get('loan_no');
        $emp_code = $request->get("emp_code");
        $loan_type_id = $request->get("loan_type_id");
        //$loan_no = $loan['loan_no'];
        $year_from = $request->get("year_from");
        $month_from = $request->get("month_from");
        $year_to = $request->get("year_to");
        $month_to = $request->get("month_to");
        //dd($request->all());
        $sql = "select loan.emp_loan_summary_data(:p1,:p2,:p3,:p4,:p5,:p6,:p7) from dual";
       // dd( DB::select($sql, ['p1' => $emp_code, 'p2' => $loan_type_id, 'p3' => $loan_no, 'p4' => $year_from, 'p5' => $month_from, 'p6' => $year_to, 'p7' => $month_to]));
         $list = DB::select($sql, ['p1' => $emp_code, 'p2' => $loan_type_id, 'p3' => $loan_no, 'p4' => $year_from, 'p5' => $month_from, 'p6' => $year_to, 'p7' => $month_to]);
        //dd($list);
        return [
             'summery' => $list,
             'guarantors' => $this->getApplicationGuarantor($loan_no),
             'disbursements' => $this->getDisbursementApprovals($loan_no),
             'payments' => $this->getPaymentApprovals($loan_no),
             'attachments' => $this->getAttachment(isset($list[0]->loan_id) ? $list[0]->loan_id : 0),
            //'instruction' => $this->getPayInstructionApprovals($loan_no),
        ];
    }
    private function getAttachment($loan_id)
    {
        $sql = "SELECT * from LOAN_DOCUMENTS WHERE LOAN_ID = $loan_id";

        return DB::select($sql);
    }
    private function getApplicationGuarantor($loan_no)
    {
        $sql = "SELECT lgi.guar_emp_id emp_id,
       lgi.guar_name emp_name,
       lgi.guar_emp_code,
       lgi.guar_designation designation,
       lgi.guar_department_name,
       lgi.guar_dob,
       lgi.contact_no,
       lgi.present_address,
       lgi.permanent_address,
       lg.relation_with_loan,
       lg.LOAN_GUARANTOR_ID,
       lg.ATTACHMENT,
       lg.ATTACHMENT_FILE_NAME
  FROM loan_guarantor lg
       JOIN loan_guarantor_info lgi ON lgi.guar_info_id = lg.guar_info_id
       JOIN employee e ON lgi.guar_emp_id = e.emp_id
       JOIN pmis.l_designation ld ON ld.designation_id = e.designation_id
 WHERE lg.loan_no = '$loan_no'";

        return DB::select($sql);
    }

    private function getDisbursementApprovals($loan_no)
    {
        $sql = "select loan.emp_loan_summ_tran_disbur_data(:p_loan_no,:p_transaction_type) from dual";
        return DB::select($sql,['p_loan_no' => $loan_no,'p_transaction_type' => 1]);
    }

    private function getPaymentApprovals($loan_no)
    {
        $sql = "select  loan.emp_loan_summ_tran_disbur_data(:p_loan_no,:p_transaction_type) from dual";
        return DB::select($sql,['p_loan_no' => $loan_no,'p_transaction_type' => 2]);
    }

    private function getPayInstructionApprovals($loan_no)
    {
        $sql = "SELECT
    E.EMP_ID,
    E.EMP_NAME,
    E.EMP_CODE,
    LD.DESIGNATION,
    DP.DEPARTMENT_NAME,
    LDS.DPT_SECTION,
    LT.LOAN_NAME,
    LA.LOAN_NO,
    LA.RATE_OF_INTEREST,
    LA.INSTALLMENT_NO,
    LA.LOAN_TYPE_ID,
    LP.APPROVAL_ID,
    LP.APPROVAL_STATUS,
    LP.APPROVAL_COMMENT,
    LA.APPLICATION_ID,
    LA.APPLICATION_AMT,
    LPI.INSTR_PRIENCIPAL_AMT,
    LPI.INSTR_INTEREST_AMT,
    TO_CHAR(LPI.INSTR_DATE, 'DD-MM-RRRR') as INSTR_DATE,
    LPI.INSTR_FOR_DATE,
    LPI.INSTR_ATTACHMENT
from LOAN_PAYMENT_INSTRUCTION  LPI
         JOIN LOAN_APPLICATION LA ON LPI.LOAN_NO = LA.LOAN_NO
         JOIN EMPLOYEE E on LPI.EMP_ID = E.EMP_ID
         JOIN PMIS.L_DESIGNATION LD on LD.DESIGNATION_ID = E.DESIGNATION_ID
         JOIN PMIS.L_DEPARTMENT DP on DP.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
         JOIN PMIS.L_DPT_SECTION LDS on LDS.DPT_SECTION_ID = E.SECTION_ID
         JOIN PMIS.LOAN_TYPE LT on LT.LOAN_TYPE_ID = LA.LOAN_TYPE_ID
         LEFT JOIN PMIS.LOAN_APPROVAL LP on LP.LOAN_NO = LA.LOAN_NO
          WHERE  LPI.APPROVAL_STATUS = 'N' AND ltr.LOAN_NO = $loan_no";
        return DB::select($sql);
    }

    public function  storeLoanDisbursement(Request $request){
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_loan_no" => $request->get("loan_no"),
                "p_loan_type_id" => $request->get("loan_type_id"),
                "p_transaction_amt" => $request->get("transaction_amt"),
                "p_description" => $request->get("description"),
                "p_attachment" => [
                    'value' => $request->get("attachment"),
                    'type' => SQLT_CLOB
                ],
                "p_attachment_file_name" => $request->get("attachment_file_name"),
                "p_attachment_doc_no" => $request->get("attachment_doc_no"),
                "p_doc_date" => $request->get("doc_date")? date("Y-m-d", strtotime($request->get('doc_date'))) : '',
                "p_cheque_status" => $request->get("cheque_status"),

                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("loan.loan_disbursed", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function getDisbursements()
    {
        $sql = "select loan.loan_disbursement_data_table from dual";
        return $list = DB::select($sql);
    }


    public function post(Request $request) {
        DB::beginTransaction();
        $guarantorMessage = ['status' => true];
        $attachmentMessage = ['status' => true];
        try {
            $loanId = $request->get('application_id');
            $application_id = sprintf("%4000s","");
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_application_id" => isset($loanId) ? $loanId : '',
                "o_application_id" => &$application_id,
                "p_emp_id" => $request->get("emp_id"),
                "p_cgpf_no" => $request->get("gpf_id"),
                "p_loan_type_id" => $request->get("loan_type_id"),
                "p_application_amt" => $request->get("application_amt"),
                "p_description" => $request->get("description"),
                "p_reason" => $request->get("reason"),
                "p_rate_of_interest" => $request->get("rate_of_interest"),
                "p_installment_no" => $request->get("installment_no"),
                "p_comment_status_1" => $request->get("comment_status_1"),
                "p_approval_status_1" => $request->get("approval_status_1"),
                "p_comment_status_2" => $request->get("comment_status_2"),
                "p_approval_status_2" => $request->get("approval_status_2"),
                "p_approx_installment_amount" => $request->get("approx_installment_amount"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("loan.loan_application_entry", $params);

          if ($params['o_status_code'] == 1){
             $guarantorMessage = $this->LoanGuarantors($request,$params['o_application_id']);
             $attachmentMessage = $this->LoanDocuments($request,$params['o_application_id']);
         }


        //dd($guarantorMessage);
        if (!$attachmentMessage['status']){
            DB::rollBack();
            return $attachmentMessage;
        }else if (!$guarantorMessage['status']){
            DB::rollBack();
            return $guarantorMessage;
        }else{
            DB::commit();
            return $params;
        }
        }catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }
    }
    public function existingLoanEdit(Request $request) {
        DB::beginTransaction();
        try {
            $loanId = $request->get('application_id');
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_loan_id" => isset($loanId) ? $loanId : '',
                "p_approx_installment_amount" => $request->get("approx_installment_amount"),
                "p_remaining_principal" => $request->get("remaining_principal"),
                "p_remaining_interest" => $request->get("remaining_interest"),
                "p_loan_amt" => $request->get("loan_amount"),
                "p_disbursement_amt" => $request->get("disbursement_amt"),
                "p_open_date" => $request->get("open_date")? date("Y-m-d", strtotime($request->get('open_date'))) : '',
                "p_first_disbursement_date" => $request->get("first_disbursement_date")? date("Y-m-d", strtotime($request->get('first_disbursement_date'))) : '',
                "p_installment_no" => $request->get("installment_no"),
                "p_paid_installment_no" => $request->get("paid_installment_no"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure("loan.existing_loan_data_update", $params);
            DB::commit();
            return $params;
        }catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }
    }

    public function get(Request $request, LoanApplication $loanApplication, LoanType $loanType) {
        return $this->formData($request, $loanApplication, $loanType);
    }

    public function put($id,Request $request) {
        return $this->PFPROCESS_LOAN_APPLICATION_ENTRY($request, $id);
    }

    public function PFPROCESS_LOAN_APPLICATION_ENTRY(Request $request, $id=null)
    {
        try {
            $application_id = sprintf("%4000s","");
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_application_id" => '',
                "o_application_id" => &$application_id,
                "p_emp_id" => $request->get("emp_id"),
                "p_cgpf_no" => $request->get("gpf_id"),
                "p_loan_type_id" => $request->get("loan_type_id"),
                "p_application_amt" => $request->get("application_amt"),
                "p_description" => $request->get("description"),
                "p_reason" => $request->get("reason"),
                "p_rate_of_interest" => $request->get("rate_of_interest"),
                "p_installment_no" => $request->get("installment_no"),
                "p_comment_status_1" => $request->get("comment_status_1"),
                "p_approval_status_1" => $request->get("approval_status_1"),
                "p_comment_status_2" => $request->get("comment_status_2"),
                "p_approval_status_2" => $request->get("approval_status_2"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("loan.loan_application_entry", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
    public function LoanDocuments(Request $request, $id=null)
    {
        DB::beginTransaction();
        $success = false;
        $status_message = '';
         try {
            foreach ($request->attachments as $attachment){
                $loan_doc_id = isset($attachment['loan_doc_id']) ? $attachment['loan_doc_id'] : null;
                $status_code = sprintf("%4000s","");
                $status_message = sprintf("%4000s","");
                $params = [
                    "p_loan_doc_id" => $loan_doc_id,
                    "p_loan_doc_name" => isset($attachment['loan_doc_name']) ? $attachment['loan_doc_name'] : '',
                    "p_loan_doc_name_bng" => '',
                    "p_loan_doc" => [
                        'value' => $attachment['loan_doc'],
                        'type' => SQLT_CLOB
                    ],
                    "p_loan_doc_type" => '',
                    "p_loan_id" => $id,
                    "p_doc_description" => '',
                    "p_when_store" => '',
                    "attachment_file_name" => $attachment['attachment_file_name'],
                    "p_insert_by" => auth()->id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("loan.LOAN_OPEN_DOCUMENTS_STORE", $params);
                //Log::info($params);
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
            DB::rollBack();
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

    }

    public function LoanGuarantors(Request $request,$id=null){

        try {
            if (count($request->guarantors) < 2){
                return ["exception" => false, 'o_status_code' => 0,  "status" => false, "o_status_message" => 'Need minimum 2 guarantors!'];
            }
            $i=1;
            $success = false;
            foreach ($request->guarantors as  $guarantor){
                $loan_guarantor_id = isset($guarantor['loan_guarantor_id']) ? $guarantor['loan_guarantor_id'] : null;
                $status_code = sprintf("%4000s","");
                $status_message = sprintf("%4000s","");
                if($guarantor['selectedGuarantor']['emp_name']){
                    $params = [
                        "p_loan_guarantor_id" => $loan_guarantor_id,
                        "p_guarantor_serial" => $i++,
                        "p_guar_emp_id" => isset($guarantor['selectedGuarantor']['emp_id']) ? $guarantor['selectedGuarantor']['emp_id'] : '',
                        "p_guar_emp_code" => isset($guarantor['selectedGuarantor']['emp_code']) ? $guarantor['selectedGuarantor']['emp_code'] : '',
                        "p_guar_contact_no" => isset($guarantor['contact']) ? $guarantor['contact'] : '',
                        "p_loan_type_id" => $request->get('loan_type_id'),
                        "p_loan_emp_id" => $request->get('emp_id'),
                        "p_loan_emp_code" => $request->get('emp_code'),
                        "p_relation_with_loan" => isset($guarantor['relation_with_loan']) ? $guarantor['relation_with_loan'] : '',
                        "p_loan_application_id" => $id,
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
                } else {
                    $status_message = 'You provide an invalid guarantor!';
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

//    public function LoanGuarantors(Request $request, $id=null)
//    {
//
//        DB::beginTransaction();
//        $success = false;
//        $status_message = '';
//        try {
//            $i=1;
//            foreach ($request->guarantors as  $guarantor){
//                $loan_guarantor_id = isset($guarantor['guar_info_id']) ? $guarantor['guar_info_id'] : null;
//                $status_code = sprintf("%4000s","");
//                $status_message = sprintf("%4000s","");
//                $params = [
//                    "p_loan_guarantor_id" => $loan_guarantor_id,
//                    "p_loan_application_id" => $id,
//                    "p_attachment" => [
//                        'value' => isset($guarantor['attachment']) ? $guarantor['attachment'] : '',
//                        'type' => SQLT_CLOB
//                    ],
//                    "p_attachment_file_name" => isset($guarantor['attachment_file_name']) ? $guarantor['attachment_file_name'] :  '',
//                    "p_insert_by" => auth()->id(),
//                    "o_status_code" => &$status_code,
//                    "o_status_message" => &$status_message,
//                ];
//                DB::executeProcedure("loan.loan_guarantor_aggrement_up", $params);
//                 //dd($params);
//                if ($params['o_status_code'] == 1){
//                    DB::commit();
//                    $success = true;
//                }else{
//                    DB::rollBack();
//                    $success = false;
//                }
//            }
//            if ($success){
//                return ["exception" => false, 'o_status_code' => 1,  "status" => true, "o_status_message" => 'Successfully Inserted'];
//            }else{
//                return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $status_message];
//            }
//
//        }
//        catch (\Exception $e) {
//            DB::rollBack();
//            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
//        }
//    }

    public function guarantorEmployee($id){
        $sql2 = "SELECT ev.emp_id,
               lg.loan_guarantor_id as guar_info_id,
               lg.loan_emp_id,
               lg.attachment,
               lg.attachment_file_name,
               rt.relation_type,
               ev.emp_name,
               ev.department_name,
               ev.designation
          FROM employee_info_vu ev
          left join loan_guarantor_info lgf on( ev.emp_id=lgf.guar_emp_id)
          left join loan_guarantor lg on (lg.guar_info_id = lgf.guar_info_id)
          left join l_relation_type rt on (rt.relation_type_id = lg.relation_with_loan)
          where lg.loan_emp_id = :p_emp_id";
        $gurantors = DB::select($sql2,['p_emp_id'=>$id]);
        return [
            'gurantors' => $gurantors,
        ];
    }
    private function getLoanTypes(LoanType $loanType) {
        return $loanType->get();
    }

    private function getApplicationLoans(Request $request, LoanApplication $loanApplication) {
        //Todo: filter can be applied based on request
        //1 = pf loan
        $loanType=$request->get("loanType");
        return DB::select('select loan.emp_loan_data(:loanType,:auth) from dual', ['loanType' => $loanType,'auth'=>auth()->id()]);
    }

    public function loanGuarantor($id){
        return LoanGuarantor::with('guar_info')->where('loan_id', $id)->get();
    }

    public function getDocuments($id){
        return LoanDocuments::where('loan_id', $id)->get();
    }

    private function formData(Request $request, LoanApplication $loanApplication, LoanType $loanType) {
       //dd($this->getApplicationLoans($request, $loanApplication));
        return [
            'guarantors' => LoanGuarantorInfo::get(['guar_info_id','guar_name']),
            'loanTypes' => $this->getLoanTypes($loanType),
            'pfLoans' => $this->getApplicationLoans($request, $loanApplication),
            'relations' => LRelationType::all(),
        ];
    }
    public function downloadGuarantorAttachment($id) {
             $data = LoanGuarantor::find($id);
        if($data) {
            if($data->attachment) {
                $fileArr = explode('.', $data->attachment_file_name);
                $content = $data->attachment;
                // echo $content; die();
                $contentType = $this->getContentType($fileArr[count($fileArr)-1]);
                $filename = $data->attachment_file_name;

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);
                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'attachment; filename="'.$filename.'"'
                ]);
            }
            die("No Attachment found!!");
        }
    }
    public function downloadAttachment($id) {
       $data = LoanDocuments::find($id);
        if($data) {
            if($data->loan_doc) {
                $fileArr = explode('.', $data->attachment_file_name);
                $content = $data->loan_doc;
                // echo $content; die();
                $contentType = $this->getContentType($fileArr[count($fileArr)-1]);
                $filename = $data->attachment_file_name;

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);
                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'attachment; filename="'.$filename.'"'
                ]);
            }
            die("No Attachment found!!");
        }
    }
    public function downloadDisbursementAttachment($id) {
       $data = LoanTransaction::find($id);
        if($data) {
            if($data->attachment) {
                $fileArr = explode('.', $data->attachment_file_name);
                $content = $data->attachment;
                // echo $content; die();
                $contentType = $this->getContentType($fileArr[count($fileArr)-1]);
                $filename = $data->attachment_file_name;

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);
                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'attachment; filename="'.$filename.'"'
                ]);
            }
            die("No Attachment found!!");
        }
    }
    private $fileTypes = [
        'pdf' => 'application/pdf',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'png' => 'image/png',
        'jpg' => 'image/jpg',
        'JPG' => 'image/JPG',
        'jpeg' => 'image/jpeg',
        'JPEG' => 'image/JPEG',
        'txt' => 'text/plain',
    ];

    private function getContentType($fileType)
    {
        $contentType = $this->fileTypes[$fileType];

        if($contentType) {
            return $contentType;
        }

        return '';
    }

    public function updateApprovalWorkflow($id,Request $request){

    }
}
