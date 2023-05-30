<?php


namespace App\Http\Controllers\Api\V1\HouseAllotment;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class HouseAllotmentController extends Controller
{
    public function selfAllotmentInformation()
    {
        $emp_id = Auth::user()->emp_id;
//        $sql = "SELECT EMP.EMP_CODE,
//         EMP.EMP_NAME,
//         DES.DESIGNATION,
//         DEP.DEPARTMENT_NAME,
//         SEC.DPT_SECTION,
//         HA.ALLOT_ID,
//         ha.TAKE_OVER_DATE,
//         TKOVR.SANITARY_FITTINGS,
//         TKOVR.HOUSE_DETAILS,
//         HL.FLOOR_NUMBER,
//         HL.HOUSE_CODE,
//         HL.HOUSE_NAME,
//         HL.HOUSE_SIZE,
//         HL.WATER_TAP
//    FROM PMIS.EMPLOYEE EMP
//         LEFT JOIN PMIS.L_DESIGNATION DES
//            ON EMP.DESIGNATION_ID = DES.DESIGNATION_ID
//         LEFT JOIN PMIS.L_DEPARTMENT DEP
//            ON EMP.DPT_DEPARTMENT_ID = DEP.DEPARTMENT_ID
//         LEFT JOIN PMIS.L_DPT_SECTION SEC
//            ON EMP.SECTION_ID = SEC.DPT_SECTION_ID
//         INNER JOIN HAS.HOUSE_ALLOTTMENT HA ON EMP.EMP_ID = HA.EMP_ID
//         LEFT JOIN HAS.TAKE_OVER TKOVR ON HA.TAKE_OVER_ID = TKOVR.TAKE_OVER_ID
//         INNER JOIN HAS.HOUSE_LIST HL ON HA.HOUSE_ID = HL.HOUSE_ID
//   WHERE     EMP.EMP_ID = :EMP_ID
//         AND HA.ALLOT_YN = 'Y'
//         AND HA.CANCEL_YN = 'N'
//         AND ha.TAKE_OVER_DATE < :OLD_TAKE_OVER_DATE
//         AND ROWNUM <= 1
//ORDER BY EMP.EMP_CODE";
        $sql = "SELECT EMP.EMP_CODE,
         EMP.EMP_NAME,
         DES.DESIGNATION,
         DEP.DEPARTMENT_NAME,
         SEC.DPT_SECTION,
         HA.ALLOT_ID,
         ha.TAKE_OVER_DATE,
         TKOVR.SANITARY_FITTINGS,
         TKOVR.HOUSE_DETAILS,
         HL.FLOOR_NUMBER,
         HL.HOUSE_CODE,
         HL.HOUSE_NAME,
         HL.HOUSE_SIZE,
         HL.WATER_TAP
    FROM PMIS.EMPLOYEE EMP
         LEFT JOIN PMIS.L_DESIGNATION DES
            ON EMP.DESIGNATION_ID = DES.DESIGNATION_ID
         LEFT JOIN PMIS.L_DEPARTMENT DEP
            ON EMP.DPT_DEPARTMENT_ID = DEP.DEPARTMENT_ID
         LEFT JOIN PMIS.L_DPT_SECTION SEC
            ON EMP.SECTION_ID = SEC.DPT_SECTION_ID
         INNER JOIN HAS.HOUSE_ALLOTTMENT HA ON EMP.EMP_ID = HA.EMP_ID
         LEFT  JOIN HAS.TAKE_OVER TKOVR ON HA.TAKE_OVER_ID = TKOVR.TAKE_OVER_ID
         INNER JOIN HAS.HOUSE_LIST HL ON HA.HOUSE_ID = HL.HOUSE_ID
   WHERE     EMP.EMP_ID = :EMP_ID
         AND HA.ALLOT_YN = 'Y'
         AND HA.CANCEL_YN = 'N'
         AND ha.TAKE_OVER_DATE < :OLD_TAKE_OVER_DATE
         AND ROWNUM <= 1
ORDER BY EMP.EMP_CODE";

        $oldTakeoverDate = new \DateTime();
        $oldTakeoverDate->sub(new \DateInterval('P3Y'));
        //dd($oldTakeoverDate);
        return DB::select($sql, ['EMP_ID' => $emp_id, 'OLD_TAKE_OVER_DATE' => $oldTakeoverDate]);
    }


    public function EmployeesFromHouseAllotment($searchParam)
    {
        $sql = "SELECT EMP.EMP_CODE, U.USER_ID,
         EMP.EMP_CODE || ' - ' || EMP.EMP_NAME AS OPTION_NAME,
         EMP.EMP_NAME,
         DES.DESIGNATION,
         DEP.DEPARTMENT_NAME,
         SEC.DPT_SECTION,
         HA.ALLOT_ID,
         ha.TAKE_OVER_DATE,
         TKOVR.SANITARY_FITTINGS,
         TKOVR.HOUSE_DETAILS,
         HL.FLOOR_NUMBER,
         HL.HOUSE_CODE,
         HL.HOUSE_NAME,
         HL.HOUSE_SIZE,
         HL.WATER_TAP
    FROM PMIS.EMPLOYEE EMP
         LEFT JOIN PMIS.L_DESIGNATION DES
            ON EMP.DESIGNATION_ID = DES.DESIGNATION_ID
         LEFT JOIN PMIS.L_DEPARTMENT DEP
            ON EMP.DPT_DEPARTMENT_ID = DEP.DEPARTMENT_ID
         LEFT JOIN PMIS.L_DPT_SECTION SEC
            ON EMP.SECTION_ID = SEC.DPT_SECTION_ID
         INNER JOIN HAS.HOUSE_ALLOTTMENT HA ON EMP.EMP_ID = HA.EMP_ID
         LEFT JOIN HAS.TAKE_OVER TKOVR ON HA.TAKE_OVER_ID = TKOVR.TAKE_OVER_ID
         INNER JOIN HAS.HOUSE_LIST HL ON HA.HOUSE_ID = HL.HOUSE_ID
         LEFT JOIN CPA_SECURITY.SEC_USERS U on U.EMP_ID = EMP.EMP_ID
   WHERE UPPER (EMP.emp_code || EMP.emp_name) LIKE '%' || UPPER (:EMP_CODE) || '%'
         AND EMP.EMP_ID != :EMP_ID
         AND HA.ALLOT_YN = 'Y'
         AND HA.CANCEL_YN = 'N'
         AND ha.TAKE_OVER_DATE < :OLD_TAKE_OVER_DATE
         AND ROWNUM <= 10
ORDER BY EMP.EMP_CODE";


        $oldTakeoverDate = new \DateTime();
        $oldTakeoverDate->sub(new \DateInterval('P3Y'));
        return DB::select($sql, ['EMP_CODE' => $searchParam, 'OLD_TAKE_OVER_DATE' => $oldTakeoverDate, 'EMP_ID' => Auth::user()->emp_id]);
    }

    public function create(Request $request){
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $int_request_id = $request->get('int_request_id') ? : '';
            $int_request_date =  date("Y-m-d");
            $params = [
                'int_request_id' => [
                    'value' => &$int_request_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "int_request_date" => $int_request_date,
                "req_from_allot_id" => $request->get('req_from_allot_id'),
                "req_to_allot_id" => $request->get('req_to_allot_id'),
                "remarks" => $request->get('remarks'),
                'req_doc_file' => [
                    'value' => $request->post('req_doc_file'),
                    'type' => SQLT_CLOB,
                ],
                'req_doc_name' => $request->get('req_doc_name'),
                'req_doc_type' => $request->get('req_doc_type'),
                'accept_yn' => $request->get('accept_yn'),
                'accept_by' => null,
                'accept_date' => null,
                "insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("has.int_request_entry ", $params);

            if($request->get('int_request_id') == "" && $params["o_status_code"] == 1){
                $notification = [
                    "p_notification_to" => $request->get('user_id'),
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'You have a request for house interchange.',
                    "p_priority" => null,
                    "p_module_id" => 1,
                    "p_target_url" => "my-account#/application/house-interchange"
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $notification);
            } else if($request->get('int_request_id') && $params["o_status_code"] == 1 && $params["accept_yn"] == 'Y'){
                $notification = [
                    "p_notification_to" => $request->get('insert_by'),
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'Your house interchange request has been accepted.',
                    "p_priority" => null,
                    "p_module_id" => 1,
                    "p_target_url" => "my-account#/application/house-interchange"
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $notification);
            } else if($request->get('int_request_id') && $params["o_status_code"] == 1 && $params["accept_yn"] == 'D'){
                $notification = [
                    "p_notification_to" => $request->get('insert_by'),
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'Your house interchange request has been denied.',
                    "p_priority" => null,
                    "p_module_id" => 1,
                    "p_target_url" => "my-account#/application/house-interchange"
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $notification);
            }

        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }




    public function request_list(){
        $sql = "SELECT IR.*,
       TOHA.EMP_ID AS REQUEST_TO,
       E.EMP_NAME AS REQUEST_RECEIVER,
       EM.EMP_NAME AS REQUEST_SENDER,
       CASE
          WHEN FRHA.EMP_ID = :EMP_ID THEN 'REQUEST SENT'
          ELSE 'REQUEST RECEIVED'
       END
          AS SENT_RECEIVED
  FROM HAS.INTERCHANGE_REQUEST IR
       JOIN HAS.HOUSE_ALLOTTMENT FRHA ON FRHA.ALLOT_ID = IR.REQ_FROM_ALLOT_ID
       JOIN PMIS.EMPLOYEE EM ON EM.EMP_ID = FRHA.EMP_ID
       JOIN HAS.HOUSE_ALLOTTMENT TOHA ON TOHA.ALLOT_ID = IR.REQ_TO_ALLOT_ID
       JOIN PMIS.EMPLOYEE E ON E.EMP_ID = TOHA.EMP_ID
       WHERE FRHA.EMP_ID = :EMP_ID or TOHA.EMP_ID = :EMP_ID";
        return DB::select($sql, [ 'EMP_ID' => Auth::user()->emp_id]);
    }
}
