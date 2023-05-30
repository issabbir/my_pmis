<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LAttachmentType;
use App\Entities\Admin\LBranch;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDptSection;
use App\Entities\Admin\LEmpGrade;
use App\Entities\Admin\LExam;
use App\Entities\Admin\LExamBody;
use App\Entities\Admin\LGeoDistrict;
use App\Entities\Admin\LGeoThana;
use App\Entities\Admin\LGradeSteps;
use App\Entities\Admin\LInstitute;
use App\Entities\Pmis\Employee\EmpAttachment;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmployeeOrs;
use App\Entities\Security\Menu;
use App\Entities\Security\Module;
use App\Entities\Security\Submenu;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /** @var AdminContract|AdminManager */
    protected $adminManager;

    /**
     * BasicInfoController constructor.
     * @param BasicInfoContract $basicInfoManager
     */
    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function getModules(){
        return Module::where('enabled', 'Y')->orderBy('module_name')->get();
    }

    public function findPayGradeById($id){
        //dd($id);
        $paygrade = $this->adminManager->findEmpGrads($id);

        $gradeStep = new LGradeSteps();
        $gradeStepList = $gradeStep->where('grade_id', $id)->get();
        $gradesteps[] = ["value" => null, 'text' => 'Select Grade steps'];
        foreach($gradeStepList as $item) {
            $gradesteps[] = ["text" =>"Grade Step ".$item->grade_steps_id." (".$item->basic_amt.")", 'value' => $item->grade_steps_id];
        }

        return response()->json([
            'paygrade' => $paygrade,
            'gradesteps' => $gradesteps,
        ]);
    }

    public function findPayGrade($id){
        //dd($id);
        $paygrade = $this->adminManager->findEmpGrads($id);
        $gradeStepList = LGradeSteps::all();
        $gradesteps[] = ["value" => null, 'text' => 'Select Grade steps'];
        foreach($gradeStepList as $item) {
            $gradesteps[] = ["text" =>"Grade Step ".$item->grade_steps_id." (".$item->basic_amt.")", 'value' => $item->grade_steps_id];
        }

        return response()->json([
            'paygrade' => $paygrade,
            'gradesteps' => $gradesteps,
        ]);
    }
    public function allGrades(){
        return LEmpGrade::all();
    }

    public function findDepartmentsById($id){
        $department = new LDepartment();
        $departmentList =  $department->where('dpt_division_id',$id)->get();
        $departments[] = ["value" => null, 'text' => 'Select Departments'];
         foreach ($departmentList as $item) {
            $departments[] = ["text" => $item->department_name, 'value' => $item->department_id];
        }
         return $departments;
    }
    public function newRecruit(){
        return EmployeeOrs::where('approved_yn','N')->get();
    }

    public function process(Request $request){
        try {
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');
            $params = [
                'application_id' => $request->get('application_id'),
                'job_user_id' => $request->get('job_user_id'),
                'emp_code' => $request->get('emp_code'),
                'emp_join_date' => $request->get('emp_join_date'),
                'emp_type_id' => $request->get('emp_type_id'),
                'bank_id' => $request->get('bank_id'),
                'branch_id' => $request->get('branch_id'),
                'emp_bank_acc_no' => $request->get('emp_bank_acc_no'),
                'update_by' => Auth::id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage,
            ];
            DB::executeProcedure('employee_ors_migration', $params);
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }
    public function attachmentTypes(){
        return LAttachmentType::all();
    }

    public function employee_code($id){
        return Employee::where('emp_id', $id)->value('emp_code');
    }

    public function attachments(Request $request){
        $result = '';
        if($request->input('attachment_id')){
            $result = $this->updateAttachment($request);
        } else {
            $result = $this->storeAttachment($request);
        }
        return $result;
    }

    public function deleteAttachment($id){
        EmpAttachment::destroy($id);
        return ['status_code' => '1'];
    }

    public function storeAttachment(Request $request){
        EmpAttachment::create([
            'attachment_type_id' => $request->input('attachment_type_id'),
            'filename' => $request->input('filename'),
            'file_content' => $request->input('file_content'),
            'filesystem_yn' => $request->input('filesystem_yn'),
            'file_path' => $request->input('file_path'),
            'active_yn' => $request->input('active_yn'),
            'filesize' => $request->input('filesize'),
            'emp_id' => $request->input('emp_id'),
            'title' => $request->input('title'),
            'title_bn' => $request->input('title_bn'),
            'file_extension' => $request->input('file_extension'),
            'emp_code' => $request->input('emp_code'),
            'insert_date' => new \DateTime(),
            'insert_by' => Auth::id(),
        ]);
        return ['status_code' => '1'];
    }
    public function updateAttachment(Request $request) {
        EmpAttachment::where('attachment_id',  $request->input('attachment_id'))
            ->update([
                'attachment_type_id' => $request->input('attachment_type_id'),
                'filename' => $request->input('filename'),
                'file_content' => $request->input('file_content'),
                'filesystem_yn' => $request->input('filesystem_yn'),
                'file_path' => $request->input('file_path'),
                'active_yn' => $request->input('active_yn'),
                'filesize' => $request->input('filesize'),
                'emp_id' => $request->input('emp_id'),
                'title' => $request->input('title'),
                'title_bn' => $request->input('title_bn'),
                'file_extension' => $request->input('file_extension'),
                'emp_code' => $request->input('emp_code'),
                'update_date' => new \DateTime(),
                'update_by' => Auth::id(),
            ]);
        return ['status_code' => '1'];
    }

    public function attachmentList(){
        return EmpAttachment::with('attachment_type')->get();
    }

    public function getEmployeeAttachment($id){
        return EmpAttachment::with('attachment_type')->where('emp_id', $id)->get();
    }



    public function findSectionsById($id){
        $section = new LDptSection();
        $sectionList = $section->where('department_id',$id)->get();
        $sections = [];
        $sections[] = ["value" => null, 'text' => 'Select Section'];
         foreach ($sectionList as $item) {
            $sections[] = ["text" => $item->dpt_section, 'value' => $item->dpt_section_id];
        }
         return $sections;
    }
    public function findBranchById($id){
        $branch = new LBranch();
        $branchList = $branch->where('bank_id',$id)->orderBy("branch_name", 'asc')->get();
        $branches = [];
        $branches[] = ["value" => null, 'text' => 'Select Branch'];
         foreach ($branchList as $item) {
            $branches[] = ["text" => $item->branch_name, 'value' => $item->branch_id];
        }
         return $branches;
    }

    public function modules(Request $request){
        return Module::orderBy('module_name')->get();
    }

    public function modulesDatatable(Request $request){
        $module = new Module();
        if ($request->get('filter') != 'null') {
            $module = $module
                ->where(DB::raw('lower(module_name)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(module_name_bng)'), 'like', "%".strtolower($request->get('filter'))."%");;
        }
        return $module->orderBy('module_name')->paginate($request->get('size'));

    }

    public function storeModule(Request $request){
        $module = new Module();
        $module->module_name = $request->get('module_name');
        $module->module_name_bng = $request->get('module_name_bng');
        $module->enabled = $request->get('enabled');
        $module->insert_by = Auth::id();
        $module->insert_date = new \DateTime();
        $result = $module->save();
        return response()->json($result);
    }

    public function updateModule(Request $request, $id){
        $module = Module::find($id);
        $module->module_name = $request->get('module_name');
        $module->module_name_bng = $request->get('module_name_bng');
        $module->enabled = $request->get('enabled');
        $module->update_by = Auth::id();
        $module->update_date = new \DateTime();
        $result = $module->save();
        return response()->json($result);
    }

    public function menus(Request $request){
        return Menu::orderBy('menu_name')->get();
    }

    public function menusDatatable(Request $request){
        $menu = new Menu();
        $menu = $menu->with(['module']);
        if ($request->get('filter') != 'null') {
            $menu = $menu
                ->where(DB::raw('lower(menu_name)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(menu_text_eng)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(menu_text_bng)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(menu_order_no)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(base_url)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(icon)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(bg_color)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(base_path)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhereHas('module', function($q) use ($request) {
                    if ($request->get('filter')) {
                        $q->where(DB::raw('lower(module_name)'), 'like', "%".strtolower($request->get('filter'))."%");
                    }
                });
        }
        return $menu->orderBy('menu_name')->paginate($request->get('size'));
    }

    public function storeMenu(Request $request){
        $menu = new Menu();
        $menu->menu_name = $request->get('menu_name');
        $menu->menu_text_eng = $request->get('menu_text_eng');
        $menu->menu_text_bng = $request->get('menu_text_bng');
        $menu->module_id = $request->get('module_id');
        $menu->menu_order_no = $request->get('menu_order_no');
        $menu->active_yn = $request->get('active_yn');
        $menu->base_url = $request->get('base_url');
        $menu->icon = $request->get('icon');
        $menu->bg_color = $request->get('bg_color');
        $menu->base_path = $request->get('base_path');
        $result = $menu->save();
        return response()->json($result);
    }

    public function updateMenu(Request $request, $id){
        $menu = Menu::find($id);
        $menu->menu_name = $request->get('menu_name');
        $menu->menu_text_eng = $request->get('menu_text_eng');
        $menu->menu_text_bng = $request->get('menu_text_bng');
        $menu->module_id = $request->get('module_id');
        $menu->menu_order_no = $request->get('menu_order_no');
        $menu->active_yn = $request->get('active_yn');
        $menu->base_url = $request->get('base_url');
        $menu->icon = $request->get('icon');
        $menu->bg_color = $request->get('bg_color');
        $menu->base_path = $request->get('base_path');
        $result = $menu->save();
        return response()->json($result);
    }

    public function subMenus(Request $request){
        return Submenu::orderBy('submenu_name')->get();
    }

    public function subMenusDatatable(Request $request){
        $menu = new Submenu();
        $menu = $menu->with(['menu','parent_submenu']);
        if ($request->get('filter') != 'null') {
            $menu = $menu
                ->where(DB::raw('lower(submenu_name)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(submenu_text_eng)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(submenu_text_bng)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(controller_name)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(action_name)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(route_name)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhere(DB::raw('lower(menu_order_no)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhereHas('parent_submenu', function($q) use ($request) {
                    if ($request->get('filter')) {
                        $q->where(DB::raw('lower(submenu_name)'), 'like', "%".strtolower($request->get('filter'))."%");
                    }
                })
                ->orWhereHas('menu', function($q) use ($request) {
                    if ($request->get('filter')) {
                        $q->where(DB::raw('lower(menu_name)'), 'like', "%".strtolower($request->get('filter'))."%");
                    }
                });
        }
        return $menu->orderBy('submenu_name')->paginate($request->get('size'));
    }

    public function storeSubMenu(Request $request){
        $submenu = new Submenu();
        $submenu->submenu_name = $request->get('submenu_name');
        $submenu->submenu_text_eng = $request->get('submenu_text_eng');
        $submenu->submenu_text_bng = $request->get('submenu_text_bng');
        $submenu->parent_submenu_id = $request->get('parent_submenu_id');
        $submenu->menu_id = $request->get('menu_id');
        $submenu->controller_name = $request->get('controller_name');
        $submenu->action_name = $request->get('action_name');
        $submenu->route_name = $request->get('route_name');
        $submenu->menu_order_no = $request->get('menu_order_no');
        $submenu->active_yn = $request->get('active_yn');
        $result = $submenu->save();
        return response()->json($result);
    }

    public function updateSubMenu(Request $request, $id){
        $submenu = Submenu::find($id);
        $submenu->submenu_name = $request->get('submenu_name');
        $submenu->submenu_text_eng = $request->get('submenu_text_eng');
        $submenu->submenu_text_bng = $request->get('submenu_text_bng');
        $submenu->parent_submenu_id = $request->get('parent_submenu_id');
        $submenu->menu_id = $request->get('menu_id');
        $submenu->controller_name = $request->get('controller_name');
        $submenu->action_name = $request->get('action_name');
        $submenu->route_name = $request->get('route_name');
        $submenu->menu_order_no = $request->get('menu_order_no');
        $submenu->active_yn = $request->get('active_yn');
        $result = $submenu->save();
        return response()->json($result);
    }



    public function findInstituteById($id){
        $institute = new LInstitute();
        $instituteList = $institute->where('exam_body_id',$id)->get();
        $institutes = [];
        $institutes[] = ["value" => null, 'text' => 'Select  Institute'];
         foreach ($instituteList as $item) {
            $institutes[] = ["text" => $item->institute_name, 'value' => $item->institute_id];
        }
         return $institutes;
    }

    public function findExamBodiesByExam($id){
        $sql = "SELECT EB.*, EB.exam_body_id AS \"Value\", EB.EXAM_BODY_NAME AS \"Text\"
  FROM L_EXAM_BODY_MAPPING EBM
       JOIN L_EXAM E ON E.EXAM_ID = EBM.EXAM_ID
       JOIN L_EXAM_BODY EB ON EB.EXAM_BODY_ID = EBM.EXAM_BODY_ID
 WHERE E.EXAM_ID = :id";
        return DB::select($sql, ['id'=>$id]);
    }

    public function findResultTypeByExam($id){
        $sql = "SELECT ERT.*, ERT.EXAM_RESULT_TYPE_ID AS \"Value\", ERT.EXAM_RESULT_TYPE AS \"Text\"
  FROM L_EXAM_RESULT_TYPE_MAPPING ERTM
       JOIN L_EXAM E ON E.EXAM_ID = ERTM.EXAM_ID
       JOIN L_EXAM_RESULT_TYPE ERT
          ON ERT.EXAM_RESULT_TYPE_ID = ERTM.EXAM_RESULT_TYPE_ID
 WHERE E.EXAM_ID = :id";
        return DB::select($sql, ['id'=>$id]);
    }


    public function findResultByType($id){
        $sql = "SELECT EXAM_RESULT_ID,
       EXAM_RESULT,
       MIN_VALUE,
       MAX_VALUE
  FROM L_EXAM_RESULT
 WHERE RESULT_TYPE_ID = :id";
        return DB::select($sql, ['id'=>$id]);
    }

    public function findSubjectByExam($id){
        $sql = "SELECT ES.*, ES.EXAM_SUBJECT_ID AS \"Value\",
       ES.EXAM_SUBJECT_NAME AS \"Text\"
  FROM L_EXAM_SUBJECT_MAPPING ESM
       JOIN L_EXAM E ON E.EXAM_ID = ESM.EXAM_ID
       JOIN L_EXAM_SUBJECT ES ON ES.EXAM_SUBJECT_ID = ESM.EXAM_SUBJECT_ID
 WHERE E.EXAM_ID = :id";
        return DB::select($sql, ['id'=>$id]);
    }

    public function findInstituteByBody($id){
        $sql = "SELECT INS.*, INS.INSTITUTE_ID AS \"Value\", INS.INSTITUTE_NAME AS \"Text\"
  FROM L_EXAM_BODY_INSTITUTE_MAPPING EBIM
       JOIN L_EXAM_BODY EB ON EB.EXAM_BODY_ID = EBIM.EXAM_BODY_ID
       JOIN L_INSTITUTE INS ON INS.INSTITUTE_ID = EBIM.INSTITUTE_ID
 WHERE EB.EXAM_BODY_ID = :id";
        return DB::select($sql, ['id'=>$id]);
    }

    public function findGeoDistrictById($id){
        $district = new LGeoDistrict();
        $districtsList = $district->where('geo_division_id',$id)->get();
        $districts = [];
        $districts[] = ["value" => null, 'text' => 'Select  District'];
         foreach ($districtsList as $item) {
            $districts[] = ["text" => $item->geo_district_name, 'value' => $item->geo_district_id];
        }
         return $districts;
    }
    public function findGeoThanaById($id){
        $thana = new LGeoThana();
        $thanasList = $thana->where('geo_district_id',$id)->get();
        $thanas = [];
        $thanas[] = ["value" => null, 'text' => 'Select  Thana'];
         foreach ($thanasList as $item) {
            $thanas[] = ["text" => $item->geo_thana_name, 'value' => $item->geo_thana_id];
        }
         return $thanas;
    }

    public function findAuthorizedDepartments(){
        $departments = $this->adminManager->findDepartments();
        $employee = Auth()->user()->employee->dpt_department_id;
        return [
            'departments' => $departments,
            'department_id'=> $employee
        ];

    }
}
