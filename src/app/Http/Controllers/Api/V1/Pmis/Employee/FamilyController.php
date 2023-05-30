<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LAuthDocType;
use App\Entities\Admin\LGeoDistrict;
use App\Entities\Admin\LGeoThana;
use App\Entities\Pmis\Employee\EmpAddressTemp;
use App\Entities\Pmis\Employee\EmpFamily;
use App\Entities\Pmis\Employee\EmpFamilyTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmpNomineeTemp;
use App\Entities\Security\Role;
use App\Entities\Security\User;
use App\Entities\Security\UserRole;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class FamilyController extends Controller
{
    private $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getData();
    }

    public function getFamilyFiles($id){
        $family = EmpFamilyTemp::where('emp_family_id', $id)->first();
        return response()->json($family);
    }

    public function holdFamily($id, $holdYN){

        try {
            $family = new EmpFamilyTemp();
            $family->exists = true;
            $family->emp_family_id = $id;
            $family->hold_yn = $holdYN;
            $family->save();
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'o_status_message' => $e->getMessage()];
        }
        return [
            'status' => true,
            'o_status_message' => 'Nominee status changes successfully',
            'nominee' => $family
        ];
    }

    public function approveFamily(Request $request){
        try {
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');
            $params = [
                'p_emp_id' => $request->get('emp_id'),
                'p_insert_by' => Auth::id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];
            dd($params);

            DB::executeProcedure('emp_nominee_approve', $params);

        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }
    public function unapprovedFamily(Request $request) {

        $empId = $request->get('emp_id');
        $sql = "select * from emp_family_temp where EMP_ID = nvl(:empId, EMP_ID) AND APPROVED_YN='N'";
        return $list = DB::select($sql, ['empId' => $empId]);
    }

    public function specific(Request $request, $id)
    {
        $family = new EmpFamilyTemp();
        $address=new EmpAddressTemp();
        $thana=new LGeoThana();
        $adminManager = $this->adminManager;
        $families = $family
            ->where('emp_id', $id)
           /* ->where('approved_yn', 'Y')*/
            ->orderBy('emp_family_id', 'desc')->with('nominee_info')->get();

        $empAddress=$address->where('emp_id',$id)->where('address_type_id','2')->first();

        $selectedThanaByDefult = [];

        if ($empAddress){
            $selectedThanaByDefult=$thana->where('geo_district_id',$empAddress->district_id)->get();
        }


        return [
            "relations" => $adminManager->findRelationType(),
            "auth_type_ids" => $adminManager->findAuthDocTypes(),
            "gender" => $adminManager->findGenders(),
            'family_status' => $adminManager->findFamilyMemberStatus(),
            'district_ids' => $adminManager->findGeoDistrict(),
            "data" => $families->makeHidden(['photo','auth_attachment']),
            "empAddress" => $empAddress,
            "selectedThanaByDefult" => $selectedThanaByDefult,
        ];
    }

    public function myFamily(Request $request)
    {
        $family = new EmpFamilyTemp();
        $address=new EmpAddressTemp();
        $thana=new LGeoThana();
        $adminManager = $this->adminManager;
        $families = $family->where('emp_id', \auth()->user()->emp_id)
            ->orderBy('emp_family_id', 'desc')->with('nominee_info')->get();

        $empAddress=$address->where('emp_id',\auth()->user()->emp_id)->where('address_type_id','2')->first();

        if ($empAddress)
            $selectedThanaByDefult=$thana->where('geo_district_id',$empAddress->district_id)->get();
        else
            $selectedThanaByDefult = [];

        return [
            "relations" => $adminManager->findRelationType(),
            "auth_type_ids" => $adminManager->findAuthDocTypes(),
            "gender" => $adminManager->findGenders(),
            'family_status' => $adminManager->findFamilyMemberStatus(),
            'district_ids' => $adminManager->findGeoDistrict(),
            "data" => $families->makeHidden(['photo','auth_attachment']),
            "empAddress" => $empAddress,
            "selectedThanaByDefult" => $selectedThanaByDefult,
        ];
    }

    public function getData()
    {
        $adminManager = $this->adminManager;

        return [
            "relations" => $adminManager->findRelationType(),
            "auth_ids" => $adminManager->findAuthDocTypes(),
            "gender" => $adminManager->findGenders(),
            'family_status' => $adminManager->findFamilyMemberStatus()
        ];
    }

    public function view($id, Request $request)
    {
        $empFamily = new EmpFamilyTemp();
        $district=new LGeoDistrict();
        $thana=new LGeoThana();
        $authType=new LAuthDocType();
        $employeeFamily=$empFamily->find($id);
        $selectedFamilyMemberDistrict=$district->find($employeeFamily->district_id);
        $selectedFamilyMemberThana=$thana->find($employeeFamily->thana_id);
        $employeeFamily->selectedFamilyMemberDistrict=$selectedFamilyMemberDistrict;
        $employeeFamily->selectedFamilyMemberThana=$selectedFamilyMemberThana;
        $employeeFamily->selectedAuthType=$authType->find($employeeFamily->auth_doc_type_id);
        return $employeeFamily;
    }

    public function uniqueFamilyAuthId(Request $request)
    {
        $familyId = (int)$request->get('emp_family_id');
        $authDocTypeId = (int)$request->get('auth_doc_type_id');
        $authId = (int)$request->get('auth_id');
        $employeeId = (int)$request->get('emp_id');

        $where[] = ['emp_id', '=', $employeeId];
        $where[] = ['auth_doc_type_id', '=', $authDocTypeId];
        $where[] = ['auth_id', '=', $authId];

        if ($familyId) {
            $where[] = ['emp_family_id', '!=', $familyId];
        }

        try {
            $totalAuthenticationId = DB::table('emp_family_temp')->select(Db::raw('count(auth_id) as total'))->where($where)->first();

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

    public function myFamilyUniqueFamilyAuthId(Request $request)
    {
        $familyId = (int)$request->get('emp_family_id');
        $authDocTypeId = (int)$request->get('auth_doc_type_id');
        $authId = (int)$request->get('auth_id');
        $employeeId = \auth()->user()->emp_id;

        $where[] = ['emp_id', '=', $employeeId];
        $where[] = ['auth_doc_type_id', '=', $authDocTypeId];
        $where[] = ['auth_id', '=', $authId];

        if ($familyId) {
            $where[] = ['emp_family_id', '!=', $familyId];
        }

        try {
            $totalAuthenticationId = DB::table('emp_family_temp')->select(Db::raw('count(auth_id) as total'))->where($where)->first();

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

    public function store(Request $request)
    {
        try {
            return $this->employees_create_new_family($request);
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }

    public function myFamilyStore(Request $request)
    {
        try {
            return $this->create_new_family($request);
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }

    public function update(Request $request)
    {
        //TODO: Default template for action.
    }

    public function remove($id, Request $request)
    {
        return $this->employees_delete_new_family($id);
    }
    public function familyAuthDoc(Request $request, $id)
    {
        $familyTemp = EmpFamilyTemp::find($id);
        //dd($familyTemp);
        if($familyTemp) {
            if($familyTemp->auth_attachment && $familyTemp->auth_attach_file_type && $familyTemp->auth_attach_file_name) {
                $content = $familyTemp->auth_attachment;
                $contentType = $this->getContentType($familyTemp->auth_attach_file_type);
                $filename = $familyTemp->auth_attach_file_name;

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);

                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'inline; filename="'.$filename.'"'
                ]);
            }
        }
    }
    private $fileTypes = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'png' => 'image/png',
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpeg',
    ];

    private function getContentType($fileType)
    {
        $contentType = $this->fileTypes[$fileType];

        if($contentType) {
            return $contentType;
        }

        return '';
    }
    public function employees_create_new_family(Request $request)
    {
        try {
            $emp_family_id = $request->get("emp_family_id");
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "emp_family_id" => [
                    "value" => &$emp_family_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'emp_id' => $request->get('emp_id'),
                'emp_member_name' => $request->get('emp_member_name'),
                'emp_member_name_bng' => $request->get('emp_member_name_bng'),
                'relation_type_id' => $request->get('relation_type_id'),
                'address_line_1' => $request->get('address_line_1'),
                'address_line_2' => $request->get('address_line_2'),
                'emp_member_dob' => date("Y-m-d", strtotime($request->get('emp_member_dob'))),
                'emp_member_mobile' => $request->get('emp_member_mobile'),
                'auth_doc_type_id' => $request->get('auth_doc_type_id'),
                'emp_member_medical_id' => $request->get('emp_member_medical_id'),
                'gender_id' => $request->get('gender_id'),
                'family_member_status_id' => $request->get('family_member_status_id'),
                'emp_member_allowance_yn' => $request->get('emp_member_allowance_yn'),
                'auth_id' => $request->get('auth_id'),
                'district_id' => $request->get('district_id'),
                'thana_id' => $request->get('thana_id'),
                'post_code' => $request->get('post_code'),
                'is_nominee_yn'=>$request->get('is_nominee_yn')?$request->get('is_nominee_yn'):'N',
                'percentage' => $request->get('percentage'),
                'nominee_for_id' => $request->get('nominee_for_id'),
                'nominee_marital_status_id' => $request->get('nominee_marital_status_id'),
                'nominee_email' => $request->get('nominee_email'),
                'nominee_photo' => [
                    'value' => $request->post('photo'),
                    'type' => SQLT_CLOB,
                ],
                'nominee_auth_id_photo' => [
                    'value' => $request->post('nominee_auth_id_photo'),
                    'type' => SQLT_CLOB,
                ],
                'nominee_acc_no' => $request->get('nominee_acc_no'),
                'bank_id' => $request->get('bank_id'),
                'branch_id' => $request->get('branch_id'),
                'nominee_photo_name' => $request->get('nominee_photo_name'),
                'nominee_photo_type' => $request->get('nominee_photo_type'),
                'nominee_auth_id_photo_name' => $request->get('nominee_auth_id_photo_name'),
                'nominee_auth_id_photo_type' => $request->get('nominee_auth_id_photo_type'),
                'autistic_yn' => $request->get('autistic_yn'),
                'approved_yn' => $request->get('approved_yn'),
                'p_marital_status_id' => $request->get('marital_status_id'),
                'auth_attachment' => [
                    'value' => $request->post('auth_attachment'),
                    'type' => SQLT_CLOB,
                ],
                'auth_attach_file_type' => $request->get('auth_attach_file_type'),
                'auth_attach_file_name' => $request->get('auth_attach_file_name'),
                'insert_by' => Auth::id(),
                'update_by' => Auth::id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];
            DB::executeProcedure("EMPLOYEES.CREATE_NEW_FAMILY", $params);

            if($request->get("emp_id") != null ){
                $user_id = User::where('emp_id', $request->get("emp_id"))->value('user_id');
                $user_notification = [
                    "p_notification_to" => $user_id,
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'Your new family member has been sent for approval.',
                    "p_priority" => null,
                    "p_module_id" => 1,
                    "p_target_url" => "my-account#/family"
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
            }

            $role_id = Role::where('role_key', 'PMIS APPROVAL')->value('role_id');
            $user_roles = UserRole::where('role_id', $role_id)->get();
            $emp_name = Employee::where('emp_id', $request->get("emp_id"))->value('emp_name');
            foreach ($user_roles as $user_role){
                $operator_notification = [
                    "p_notification_to" => $user_role->user_id,
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'New family member enlisted for '.$emp_name.'. Your approval require.',
                    "p_priority" => null,
                    "p_module_id" => 1,
                    "p_target_url" => "pmis#/family-approval"
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
            }
            //dd($params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function create_new_family(Request $request)
    {
        try {
            $emp_family_id = $request->get("emp_family_id");
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "emp_family_id" => [
                    "value" => &$emp_family_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'emp_id' => \auth()->user()->emp_id,
                'emp_member_name' => $request->get('emp_member_name'),
                'emp_member_name_bng' => $request->get('emp_member_name_bng'),
                'relation_type_id' => $request->get('relation_type_id'),
                'address_line_1' => $request->get('address_line_1'),
                'address_line_2' => $request->get('address_line_2'),
                'emp_member_dob' => date("Y-m-d", strtotime($request->get('emp_member_dob'))),
                'emp_member_mobile' => $request->get('emp_member_mobile'),
                'auth_doc_type_id' => $request->get('auth_doc_type_id'),
                'emp_member_medical_id' => $request->get('emp_member_medical_id'),
                'gender_id' => $request->get('gender_id'),
                'family_member_status_id' => $request->get('family_member_status_id'),
                'emp_member_allowance_yn' => $request->get('emp_member_allowance_yn'),
                'auth_id' => $request->get('auth_id'),
                'district_id' => $request->get('district_id'),
                'thana_id' => $request->get('thana_id'),
                'post_code' => $request->get('post_code'),
                'is_nominee_yn'=>$request->get('is_nominee_yn')?$request->get('is_nominee_yn'):'N',
                'percentage' => $request->get('percentage'),
                'nominee_for_id' => $request->get('nominee_for_id'),
                'nominee_marital_status_id' => $request->get('nominee_marital_status_id'),
                'nominee_email' => $request->get('nominee_email'),
                'nominee_photo' => [
                    'value' => $request->post('photo'),
                    'type' => SQLT_CLOB,
                ],
                'nominee_auth_id_photo' => [
                    'value' => $request->post('nominee_auth_id_photo'),
                    'type' => SQLT_CLOB,
                ],
                'nominee_acc_no' => $request->get('nominee_acc_no'),
                'bank_id' => $request->get('bank_id'),
                'branch_id' => $request->get('branch_id'),
                'nominee_photo_name' => $request->get('nominee_photo_name'),
                'nominee_photo_type' => $request->get('nominee_photo_type'),
                'nominee_auth_id_photo_name' => $request->get('nominee_auth_id_photo_name'),
                'nominee_auth_id_photo_type' => $request->get('nominee_auth_id_photo_type'),
                'autistic_yn' => $request->get('autistic_yn'),
                'approved_yn' => $request->get('approved_yn'),
                'p_marital_status_id' => $request->get('marital_status_id'),
                'auth_attachment' => [
                    'value' => $request->post('auth_attachment'),
                    'type' => SQLT_CLOB,
                ],
                'auth_attach_file_type' => $request->get('auth_attach_file_type'),
                'auth_attach_file_name' => $request->get('auth_attach_file_name'),
                'insert_by' => Auth::id(),
                'update_by' => Auth::id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message,
            ];
            DB::executeProcedure("EMPLOYEES.CREATE_NEW_FAMILY", $params);

            $role_id = Role::where('role_key', 'PMIS APPROVAL')->value('role_id');
            $user_roles = UserRole::where('role_id', $role_id)->get();
            $emp_name = Employee::where('emp_id',  \auth()->user()->emp_id)->value('emp_name');
            foreach ($user_roles as $user_role){
                $operator_notification = [
                    "p_notification_to" => $user_role->user_id,
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'New family member enlisted for '.$emp_name.'. Your approval is needed.',
                    "p_priority" => null,
                    "p_module_id" => 1,
                    "p_target_url" => "pmis#/family-approval"
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
            }

            return $params;
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function employees_delete_new_family($id)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "emp_family_id" => $id,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("EMPLOYEES.DELETE_NEW_FAMILY", $params);
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function nominee_for_list(){
        $sql = "SELECT NOMINEE_FOR_ID, NOMINEE_FOR_NAME FROM L_NOMINEE_FOR ORDER BY NOMINEE_FOR_NAME";
        return DB::select($sql);
    }
}


