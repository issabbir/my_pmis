<?php

namespace App\Http\Controllers\Api\V1\Workflow;

use App\Entities\Admin\LModule;
use App\Entities\Admin\LWorkFlowApproval;
use App\Entities\Admin\WorkFlowProcess;
use App\Entities\Admin\WorkFlowStep;
use App\Entities\Pf\GpfEmployee;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Menu;
use App\Entities\Security\Role;
use App\Entities\Security\User;
use App\Entities\Security\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function status($workflowId,$object_id) {
        $current_step = [];
        $previous_step = [];
        $workflowProcess = WorkFlowProcess::with('workflowStep')
            ->where('workflow_object_id',$object_id)
            ->orderBy('workflow_process_id', 'DESC')
            ->get();


        $option = [];
        if (!count($workflowProcess)){
            $next_step = WorkFlowStep::where('approval_workflow_id',$workflowId)->where('enabled_yn','Y')->orderBy('process_step', 'asc')->first();
         }else{
            //dd($workflowProcess);
            if ($workflowProcess) {
                $current_step = $workflowProcess[0]->workflowStep;
                $sql = 'select e.emp_code, e.emp_name, d.designation
                       from cpa_security.sec_users u
                         inner join pmis.employee e on (e.emp_id = u.emp_id)
                         left join pmis.L_DESIGNATION d  on (d.designation_id = e.designation_id)
                         where user_id=:userId';
                $user = db::selectOne($sql,['userId' => $workflowProcess[0]->insert_by]);
                $current_step->user = $user;
                $current_step->note = $workflowProcess[0]->note;
            }
            //dd($current_step);

            $next_step = WorkFlowStep::where('approval_workflow_id',$workflowId)->where('process_step','>', $current_step->process_step)->where('enabled_yn','Y')->orderBy('process_step', 'asc')->first();
            $previous_step = WorkFlowStep::where('approval_workflow_id',$workflowId)->where('process_step','<', $current_step->process_step)->where('enabled_yn','Y')->orderBy('process_step', 'asc')->get();
        }

        if (!empty($previous_step)){
            foreach ($previous_step as $previous) {
                $option[] = [
                    'text' => $previous->backward_title,
                    'value' => $previous->workflow_step_id,
                ];
            }
        }

         if (!empty($current_step)){
            $option[] = [
                'text' => str_replace('forward', 'Forwarded',($current_step)?$current_step->forward_title:''),
                'value' => $current_step->workflow_step_id,
                'disabled' => true
            ];
        }

         if (!empty($next_step)){
            $option[] = [
                'text' => ($next_step)?$next_step->forward_title:'',
                'value' => $next_step->workflow_step_id,
            ];
        }


         $process = [];
         foreach ($workflowProcess as $wp) {
            $sql = 'select e.emp_code, e.emp_name, d.designation
                       from cpa_security.sec_users u
                         inner join pmis.employee e on (e.emp_id = u.emp_id)
                         left join pmis.L_DESIGNATION d  on (d.designation_id = e.designation_id)
                         where user_id=:userId';
            $user = db::selectOne($sql,['userId' => $wp->insert_by]);
            $wp->user = $user;
            $process[] = $wp;
         }

        return  response(
            [
                'workflowProcess' => $process,
                'next_step' => $next_step,
                'previous_step' => $previous_step,
                'current_step' => $current_step,
                'options' => $option,
            ]
        );
     }

    public function store(Guard $auth, Request $request,$workflowId,$object_id) {

        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_workflow_process_id" => $request->get("workflow_process_id"),
                "p_workflow_object_id" => $object_id,
                "p_workflow_step_id" => $request->get("workflow_step_id"),
                "p_note" => $request->get("note"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("workflow_Process_entry", $params);

            $step = WorkFlowStep::where('workflow_step_id', $request->get("workflow_step_id"))->get();
            if($step[0]->role_yn == 'N'){

                $controller_user_notification = [
                    "p_notification_to" => $step[0]->user_id,
                    "p_insert_by" => Auth::id(),
                    "p_note" => $request->get("message"),
                    "p_priority" => null,
                    "p_module_id" => 4,
                    "p_target_url" => $request->get("target_url")
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $controller_user_notification);

            } else {
                $role_id = Role::where('role_key', $step[0]->user_role)->value('role_id');
                $user_roles = UserRole::where('role_id', $role_id)->get();
                foreach ($user_roles as $user_role){
                    $controller_user_notification = [
                        "p_notification_to" => $user_role->user_id,
                        "p_insert_by" => Auth::id(),
                        "p_note" => $request->get("message"),
                        "p_priority" => null,
                        "p_module_id" => 4,
                        "p_target_url" => $request->get("target_url")
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $controller_user_notification);
                }
            }




            if($params['o_status_code']=='1') {

                return $this->status($workflowId,$object_id);
            }
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code"=>99, "o_status_message" => $e->getMessage()];
        }
        DB::commit();
        return $params;
    }

    public function gpfFinalApprove($workflowId,$object_id,Guard $auth, Request $request) {

        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_gpf_id" =>$object_id,
                "p_gpf_status" => 'Y',
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pfprocess.gpf_application_approve", $params);

            $emp_id = GpfEmployee::where('gpf_id', $object_id)->value('emp_id');
            if($emp_id){
                $user_id = User::where('emp_id', $emp_id)->value('user_id');
                $user_notification = [
                    "p_notification_to" => $user_id,
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'Your GPF application has been approved.',
                    "p_priority" => null,
                    "p_module_id" => 4,
                    "p_target_url" => "pmis/provident-fund#/gpf-application"
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
            }
            $reporting_officer_id = Employee::where('emp_id', $emp_id)->value('reporting_officer_id');

            if($reporting_officer_id != null ){
                $controller_user_id = User::where('emp_id', $reporting_officer_id)->value('user_id');
                $emp_name = Employee::where('emp_id', $emp_id)->value('emp_name');
                $controller_user_notification = [
                    "p_notification_to" => $controller_user_id,
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'GPF application submitted by '.$emp_name.' has been approved.',
                    "p_priority" => null,
                    "p_module_id" => 4,
                    "p_target_url" => "pmis/provident-fund#/gpf-application"
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $controller_user_notification);
            }
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code"=>99, "o_status_message" => $e->getMessage()];
        }
        DB::commit();
        return $params;
    }




    public function gpfLoanFinalApprove($workflowId,$object_id,Guard $auth, Request $request) {
         DB::beginTransaction();
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_application_id" =>$object_id,
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("loan.loan_application_approval", $params);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "status" => false, "o_status_code"=>99, "o_status_message" => $e->getMessage()];
        }
        DB::commit();
        return $params;
    }

    public function gpfSettlementFinalApprove($workflowId,$object_id,Guard $auth, Request $request) {
        DB::beginTransaction();
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_settlement_id" =>$object_id,
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pfprocess.emp_settlement_approval", $params);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "status" => false, "o_status_code"=>99, "o_status_message" => $e->getMessage()];
        }
        DB::commit();
        return $params;
    }

    public function workflow_store(Request $request){
        $data = new LWorkFlowApproval();
        $data->work_flow_name = $request->work_flow_name;
        $data->module_id = $request->module_id;
        $data->department_id = $request->department_id;
        $data->save();
        return LWorkFlowApproval::all();
    }

    public function workflow_data(){

        return LWorkFlowApproval::with(['department', 'module'])
//            ->where('department_id',Auth::user()->employee->dpt_department_id)
            ->get();
    }

    public function workflow_data_for_all(){
        return LWorkFlowApproval::with(['department', 'module'])->get();
    }

    public function workflow_data_for_module($id){
        $department_id = Auth::user()->employee->current_department_id;
        return LWorkFlowApproval::with(['department', 'module'])->where('department_id',$department_id)->where('module_id',$id)->get();
    }

    public function getStepsById($id){
        return WorkFlowStep::where('approval_workflow_id', $id)->orderBy('process_step','asc')->get();
    }

    public function storeSteps(Request $request){
        $steps = $request->all();
        foreach($steps as $step){
            if(!$step['workflow_step_id']){
                $data = new WorkFlowStep;
                $data->insert_date =new \DateTime();
                $data->insert_by = Auth::user()->id;
            } else {
                $data = WorkFlowStep::find($step['workflow_step_id']);
                $data->update_date =new \DateTime();
                $data->update_by = Auth::user()->id;
            }
            $data->approval_workflow_id = $step['approval_workflow_id'];
            $data->role_yn = $step['role_yn'];
            $data->user_role = $step['user_role'];
            $data->user_id = $step['user_id'];
            $data->user_name = $step['user_name'];
            $data->forward_title =$step['forward_title'];
            $data->backward_title = $step['backward_title'];
            $data->notify_sms_yn = $step['notify_sms_yn'];
            $data->notify_email_yn = $step['notify_email_yn'];
            $data->process_step = $step['process_step'];
            $data->enabled_yn = $step['enabled_yn'];
            $result = $data->save();

        }

        return WorkFlowStep::where('approval_workflow_id', $steps[0]['approval_workflow_id'])->orderBy('process_step','asc')->get();
    }

    public function deleteStep($workflow_id, $step_id){
        WorkFlowStep::destroy($step_id);
        return WorkFlowStep::where('approval_workflow_id', $workflow_id)->orderBy('process_step','asc')->get();
    }

    public function delete_workflow($id){
        LWorkFlowApproval::destroy($id);
        return LWorkFlowApproval::all();
    }

    public function penesionRecontinueFinalApprove($workflowId,$object_id,Guard $auth, Request $request) {

        DB::beginTransaction();
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_recontinue_app_id" =>str_replace('PENRCON', '', $object_id),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pension.pension_recontinue_approve", $params);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "status" => false, "o_status_code"=>99, "o_status_message" => $e->getMessage()];
        }
        DB::commit();
        return $params;
    }

    public function pensionProcessFinalApprove($workflowId,$object_id,Guard $auth, Request $request) {

        DB::beginTransaction();
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_PENSION_PROCESS_APPROVAL_ID" =>str_replace('pen_prc_', '', $object_id),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pension.pension_process_approve", $params);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "status" => false, "o_status_code"=>99, "o_status_message" => $e->getMessage()];
        }
        DB::commit();
        return $params;
    }

    public function pensionProcessCalFinalApprove($workflowId,$object_id,Guard $auth, Request $request) {

        DB::beginTransaction();
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_pension_calculation_id" =>str_replace('PENSIONCAL', '', $object_id),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pension.emp_pension_cal_approve", $params);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "status" => false, "o_status_code"=>99, "o_status_message" => $e->getMessage()];
        }
        DB::commit();
        return $params;
    }

}
