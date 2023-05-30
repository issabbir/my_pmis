<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Entities\Admin\LAuthDocType;
use App\Entities\Admin\LBank;
use App\Entities\Admin\LBranch;
use App\Entities\Admin\LGeoThana;
use App\Entities\Admin\LNomineeFor;
use App\Entities\Admin\WorkFlowStep;
use App\Entities\Pmis\Employee\EmpFamilyTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmpNominee;
use App\Entities\Pmis\Employee\EmpNomineeTemp;
use App\Entities\Security\Role;
use App\Entities\Security\User;
use App\Entities\Security\UserRole;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class NomineeController extends Controller
{
    /** @var AdminManager */
    private $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getData();
    }

    public function updateNomineeWorkflow(Request $request, $id){
        DB::table('emp_nominee')
            ->where('nominee_id', $id)
            ->update(['approval_workflow_id' => $request->get('approval_workflow_id')]);

        $response=$this->systemAutoCompleteStep($request,$id);
        return ['data'=>$response];


    }

    public function nomineeFinalApprove($workflowId,$object_id,Guard $auth, Request $request) {
        $result = DB::table('emp_nominee')
            ->where('nominee_id', $object_id)
            ->update(['approved_yn' => 'Y']);
        if($result){
            $params = [
                "o_status_code" => 1,
                "o_status_message" => "SETTLEMENT APPROVE SUCCESSFULLY.",
            ];
        }
        return $params;
    }

    private function systemAutoCompleteStep($request=[],$id){
        $firstWorkflowStep=WorkFlowStep::where('approval_workflow_id',$request->get('approval_workflow_id'))
            ->orderBy('PROCESS_STEP')
            ->first();
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_workflow_process_id" => '',
                "p_workflow_object_id" => $request->get('nominee_id'),
                "p_workflow_step_id" => $firstWorkflowStep->workflow_step_id,
                "p_note" => 'System Assigned',
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("workflow_Process_entry", $params);
        }catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
        return $params;

    }

    public function holdNominee($id, $holdYN){

        try {
            $nominee = new EmpNomineeTemp();
            $nominee->exists = true;
            $nominee->nominee_id = $id;
            $nominee->hold_yn = $holdYN;
            $nominee->save();
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'o_status_message' => $e->getMessage()];
        }
        return [
                'status' => true,
                'o_status_message' => 'Nominee status changes successfully',
                'nominee' => $nominee
            ];
    }

    public function approveNominee(Request $request){
        DB::beginTransaction();
        try {
            foreach ($request->get('items') as $item) {
                $statusCode = sprintf('%20f', '');
                $statusMessage = sprintf('%4000s', '');
                $params = [
                    'p_nominee_id' => $item['nominee_id'],
                    'p_insert_by' => Auth::id(),
                    'o_status_code' => &$statusCode,
                    'o_status_message' => &$statusMessage
                ];

                DB::executeProcedure('employees.emp_nominee_apv', $params);


                if($item['emp_id'] != null ){
                    $user_id = User::where('emp_id', $item['emp_id'])->value('user_id');
                    $user_notification = [
                        "p_notification_to" => $user_id,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'Your new nominee has been approved.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "my-account#/nominee"
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
                }
                $insert_by = EmpNominee::where('nominee_id', $item['nominee_id'])->value('insert_by');
                if($user_id != $insert_by){
                    $emp_name = Employee::where('emp_id', $item['emp_id'])->value('emp_name');
                    $operator_notification = [
                        "p_notification_to" => $insert_by,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'New nominee approved for '.$emp_name.'.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "pmis#/employee/nominee/".$item['emp_id']
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                }

                if ($params['o_status_code'] == 1)
                    continue;
                else {
                    DB::rollBack();
                    return $params;
                }
            }

        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        DB::commit();
        return $params;
    }
    public function unapprovedNominee(Request $request) {

        $empId = $request->get('emp_id');
        $whereNominee = '';
         if ($nominee_id = $request->get('nominee_id')){
             $whereNominee = " AND n.nominee_id = NVL ( $nominee_id, N.nominee_id)";
         }
        $user_id = Auth::id();
        $sql = "
SELECT N.*,
       E.EMP_NAME,
       E.EMP_CODE,
       RT.RELATION_TYPE,
       G.GENDER_NAME,
       CASE WHEN AUTISTIC_YN = 'Y' THEN 'YES' ELSE 'NO' END AUTISTIC,
       B.BANK_NAME,
       BR.BRANCH_NAME,
       f.AUTH_ATTACHMENT,
       case
       when N.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=N.update_by)
       when N.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=N.insert_by)
       else '' end last_updated_by
  FROM EMP_NOMINEE N
       JOIN EMP_FAMILY f on f.emp_family_id = n.emp_family_id
       LEFT JOIN L_RELATION_TYPE RT ON RT.RELATION_TYPE_ID = N.RELATIONSHIP_ID
       LEFT JOIN L_GENDER G ON G.GENDER_ID = N.NOMINEE_GENDER_ID
       LEFT JOIN L_BANKS B ON B.BANK_ID = N.BANK_ID
       LEFT JOIN L_BRANCH BR ON BR.BRANCH_ID = N.BRANCH_ID
       JOIN EMPLOYEE E ON N.EMP_ID = E.EMP_ID
 WHERE     N.EMP_ID = NVL ( :EMPID, N.EMP_ID)
       AND N.APPROVED_YN = 'N'
       AND N.ACTIVE_YN != 'N'
        $whereNominee
       AND (   e.reporting_officer_id = (SELECT emp_id
                                           FROM cpa_security.sec_users
                                          WHERE user_id = :user_id)
            OR 'Nominee' || n.nominee_id IN
                  (SELECT wp.workflow_object_id
                     FROM workflow_process wp
                          INNER JOIN workflow_steps ws
                             ON (wp.workflow_step_id = ws.workflow_step_id)
                    WHERE (   (    ws.role_yn <> 'Y'
                               AND ws.user_name =
                                      (SELECT user_name
                                         FROM cpa_security.sec_users
                                        WHERE user_id = :user_id))
                           OR (    ws.user_role IN
                                      (SELECT r.role_key
                                         FROM cpa_security.sec_users su
                                              INNER JOIN
                                              cpa_security.sec_user_roles ur
                                                 ON (ur.user_id = su.user_id)
                                              INNER JOIN
                                              cpa_security.sec_role r
                                                 ON (r.role_id = ur.role_id)
                                        WHERE     su.user_id = :user_id
                                              AND r.role_key <>
                                                     'CONTROLING_OFFICER')
                               AND wp.workflow_object_id =
                                      'Nominee' || n.nominee_id))))";
        return $list = DB::select($sql, ['empId' => $empId, 'user_id'=>$user_id]);
    }

    public function currentEmployeeNominees(Request $request){
        return $this->specific($request, Auth::user()->employee->emp_id);
    }

    public function currentEmployee(Request $request){
        $sql = "select PFPROCESS.specific_employee_search(:emp_id) from dual";
        return DB::select($sql, ['emp_id' => Auth::user()->employee->emp_id]);
    }

    public function specific(Request $request, $id)
    {
        $nominee = new EmpNominee();
        $adminManager = $this->adminManager;


        $nominees = $nominee->where('emp_id',$id)
            ->with('nominee_for')
            ->orderBy('nominee_id', 'desc')
            ->get();
        return [
            'relationships' => $adminManager->findRelationType(),
            'maritalStatuses' => $adminManager->findMaritalStatus(),
            'authdocs' => $adminManager->findAuthDocTypes(),
            'banks' => $adminManager->findBanks(),
            'branches' => $adminManager->findBranches(),
            'genders' => $adminManager->findGenders(),
            'district_ids' => $adminManager->findGeoDistrict(),
            "data" => $nominees
        ];
    }

    public function specificGPF(Request $request, $id)
    {
        $nominee = new EmpNominee();
        $adminManager = $this->adminManager;


        $nominees = $nominee->where('emp_id',$id)
            ->with('nominee_for')
            ->with('emp_family')
            ->where('nominee_for_id','=','1')
            ->orderBy('nominee_id', 'desc')
            ->get();
        return [
            'relationships' => $adminManager->findRelationType(),
            'maritalStatuses' => $adminManager->findMaritalStatus(),
            'authdocs' => $adminManager->findAuthDocTypes(),
            'banks' => $adminManager->findBanks(),
            'branches' => $adminManager->findBranches(),
            'genders' => $adminManager->findGenders(),
            'district_ids' => $adminManager->findGeoDistrict(),
            "data" => $nominees
        ];
    }

    public function myNominee(Request $request)
    {
        $nominee = new EmpNomineeTemp();
        $adminManager = $this->adminManager;



        $nominees = $nominee->where('emp_id',\auth()->user()->emp_id)->with('nominee_for')->orderBy('nominee_id', 'desc')->get();

        return [
            'relationships' => $adminManager->findRelationType(),
            'maritalStatuses' => $adminManager->findMaritalStatus(),
            'authdocs' => $adminManager->findAuthDocTypes(),
            'banks' => $adminManager->findBanks(),
            'branches' => $adminManager->findBranches(),
            'genders' => $adminManager->findGenders(),
            'district_ids' => $adminManager->findGeoDistrict(),
            "data" => $nominees
        ];
    }

    public function getData()
    {
        $adminManager = $this->adminManager;

        return [
            'relationships' => $adminManager->findRelationType(),
            'maritalStatuses' => $adminManager->findMaritalStatus(),
            'authdocs' => $adminManager->findAuthDocTypes(),
            'banks' => $adminManager->findBanks(),
            'branches' => $adminManager->findBranches(),
            'genders' => $adminManager->findGenders(),
        ];
    }

    public function view(Request $request,$id)
    {
        $nominee = new EmpNomineeTemp();
        $thana=new LGeoThana();
        $authType=new LAuthDocType();
        $bank=new LBank();
        $branch=new LBranch();
        $nomineeFor = new LNomineeFor();
        $employeeNominee=$nominee->find($id);
        $employeeNominee->selectedFamilyMemberThana=$thana->find($employeeNominee->thana_id);
        $employeeNominee->selectedAuthType=$authType->find($employeeNominee->auth_type_id);
        $employeeNominee->selectedBank=$bank->find($employeeNominee->bank_id);
        $employeeNominee->selectedBranch=$branch->find($employeeNominee->branch_id);
        $employeeNominee->selectedNomineeFor=$nomineeFor->find($employeeNominee->nominee_for_id);
        return $employeeNominee;
    }

    public function uniqueNomineeAuthId(Request $request)
    {
        $nomineeId = (int)$request->get('nominee_id');
        $authTypeId = (int)$request->get('auth_type_id');
        $nomineeAuthId = (int)$request->get('nominee_auth_id');
        $employeeId = (int)$request->get('emp_id');

        $where[] = ['emp_id', '=', $employeeId];
        $where[] = ['auth_type_id', '=', $authTypeId];
        $where[] = ['nominee_auth_id', '=', $nomineeAuthId];

        if ($nomineeId) {
            $where[] = ['nominee_id', '!=', $nomineeId];
        }
        try {
            $totalAuthenticationId = DB::table('emp_nominee_temp')->select(Db::raw('count(nominee_auth_id) as total'))->where($where)->first();

            $total = (int)$totalAuthenticationId->total;
            $uniqueMessage = '';

            if ($total > 0) {
                $uniqueMessage = 'The given value already exists!';
            }
        } catch (Exception $exception) {
            $uniqueMessage = '';
        }


        return response()->json(['unique_message' => $uniqueMessage]);
    }

    public function store(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $array_data = $request->all();
            foreach ($array_data as $item){
                $result = $this->createNewNominee($item);
            }
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }

    public function update(Request $request, $id)
    {
        if ($id > 0) {

        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not updated!'];
        }
    }

    public function remove(Request $request, $id)
    {
        if ($id > 0) {
            return $this->removeNominee($request, $id);
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not deleted!'];
        }
    }

    private function createNewNominee($request)
    {

        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $nominee_id = ($request['nominee_id'])?$request['nominee_id']:'';
            $nominee_dob = $request['nominee_dob'] ? date("Y-m-d", strtotime($request['nominee_dob'])) : '';

            $alternate_nominee = isset($request['alternate_nominee']) ? $request['alternate_nominee']: "";

            $alternate_nominee_family_ids = isset($request['alternate_nominee']) ? implode(", ", array_column($alternate_nominee, 'emp_family_id')):"";
            $alternate_nominee_member_names = isset($request['alternate_nominee']) ? implode(", ", array_column($alternate_nominee, 'emp_member_name')):"";


            $params = [
                'nominee_id' => [
                    'value' => &$nominee_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'emp_id' => $request['emp_id'],
                'nominee_name' => $request['nominee_name'],
                'relationship_id' => $request['relationship_id'],
                'percentage' => $request['percentage'],
                'address_line_1' => $request['address_line_1'],
                'address_line_2' => $request['address_line_2'],
                'nominee_contact_no' => $request['nominee_contact_no'],
                'nominee_email' => $request['nominee_email'],
                'nominee_dob' => $nominee_dob,
                'nominee_marital_status_id' => $request['nominee_marital_status_id'],
                'nominee_photo' => [
                    'value' => $request['nominee_photo'],
                    'type' => SQLT_CLOB,
                ],
                'nominee_auth_id' => $request['nominee_auth_id'],
                'nominee_auth_id_photo' => [
                    'value' => $request['nominee_auth_id_photo'],
                    'type' => SQLT_CLOB,
                ],
                'nominee_acc_no' => $request['nominee_acc_no'],
                'bank_id' => $request['bank_id'],
                'branch_id' => $request['branch_id'],
                'nominee_gender_id' => $request['nominee_gender_id'],
                'insert_by' => auth()->id(),
                'update_by' => auth()->id(),
                'auth_type_id' => $request['auth_type_id'],
                'medical_id' => $request['medical_id'],
                'district_id' => $request['district_id'],
                'thana_id' => $request['thana_id'],
                'post_code' => $request['post_code'],
                'nominee_photo_name' => $request['nominee_photo_name'],
                'nominee_photo_type' => $request['nominee_photo_type'],
                'nominee_auth_id_photo_name' => $request['nominee_auth_id_photo_name'],
                'nominee_auth_id_photo_type' => $request['nominee_auth_id_photo_type'],
                'approved_yn' => $request['approved_yn'],
                'nominee_for_id' => $request['nominee_for_id'],
                'autistic_yn' => $request['autistic_yn'],
                'p_emp_family_id' => $request['emp_family_id'],
                'p_active_yn' => 'Y',
                'p_alternate_nominee_ids' =>  $request['alternate_nominee_ids'] ? $request['alternate_nominee_ids'] : $alternate_nominee_family_ids,
                'p_alternate_nominee_names' => $request['alternate_nominee_names'] ? $request['alternate_nominee_names'] :  $alternate_nominee_member_names,
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];
            DB::executeProcedure('employees.create_new_nominee', $params);

            $nominee_name = $request['nominee_name'];

            if($request['emp_id'] != null ){
                $user_id = User::where('emp_id', $request['emp_id'])->value('user_id');
                $user_notification = [
                    "p_notification_to" => $user_id,
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'Your new nominee ('. $nominee_name . ') has been sent for approval.',
                    "p_priority" => null,
                    "p_module_id" => 1,
                    "p_target_url" => "my-account#/nominee?nominee_id=".$params['nominee_id']['value']
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
            }

            $role_id = Role::where('role_key', 'PMIS APPROVAL')->value('role_id');
            $user_roles = UserRole::where('role_id', $role_id)->get();
            $emp_name = Employee::where('emp_id', $request['emp_id'])->value('emp_name');
            foreach ($user_roles as $user_role){
                $operator_notification = [
                    "p_notification_to" => $user_role->user_id,
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'New nominee enlisted for '.$emp_name.'. Your approval require.',
                    "p_priority" => null,
                    "p_module_id" => 1,
                    "p_target_url" => "pmis#/nominee-approval?nominee_id=".$params['nominee_id']['value']
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
            }
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }

    public function removeNominee(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $nominee_id = $id;

            $params = [
                'nominee_id' => [
                    'value' => &$nominee_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];

            DB::executeProcedure('employees.delete_new_nominee', $params);
            if ($params['o_status_code'] == 1){
                DB::commit();
            }else{
                DB::rollBack();
            }
            return $params;
        } catch (Exception $e) {
            DB::rollBack();
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }
}
