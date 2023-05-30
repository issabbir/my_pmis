<?php


namespace App\Http\Controllers\Api\V1\Pmis;


use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmployeeTemp;
use App\Entities\Pmis\Employee\EmpNominee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EmployeeApprovalController extends Controller
{
    public function updateEmployeeTemp($id, $holdYN){

            try {
                $statusCode = sprintf('%20f', '');
                $statusMessage = sprintf('%4000s', '');
                $params = [
                    'p_emp_id' => $id,
                    'p_emp_hold_yn' => $holdYN,
                    'p_insert_by' => Auth::id(),
                    'o_status_code' => &$statusCode,
                    'o_status_message' => &$statusMessage
                ];

                DB::executeProcedure('employees.employee_hold_entry', $params);

            }
            catch (Exception $e) {
                return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
            }
            return $params;
    }

    public function approveEmployee(Request $request){
        try {
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');
            $params = [
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];
            DB::executeProcedure('create_approve_hold_emp', $params);
            foreach ($request->get('items') as $item) {
                $insert_by = EmployeeTemp::where('emp_id', $item['emp_id'])->first()->insert_by;
                if($insert_by){
                    $emp_name = EmployeeTemp::where('emp_id', $item['emp_id'])->first()->emp_name;
                    $operator_notification = [
                        "p_notification_to" => $insert_by,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'New employee '.$emp_name.' has been approved.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "pmis#/employee/basic-info/".$item['emp_id']
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                }

            }
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }
    public function approveSingleEmployee(Request $request){
         // dd($request->all());
        try {
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');
            $params = [
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];
            DB::executeProcedure('create_approve_hold_emp', $params);
                $insert_by = EmployeeTemp::where('emp_id', $request->get('emp_id'))->first()->insert_by;
                if($insert_by){
                    $emp_name = EmployeeTemp::where('emp_id', $request->get('emp_id'))->first()->emp_name;
                    $operator_notification = [
                        "p_notification_to" => $insert_by,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'New employee '.$emp_name.' has been approved.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "pmis#/employee/basic-info/".$request->get('emp_id')
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                }
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }
}
