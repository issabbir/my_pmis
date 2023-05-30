<?php

namespace App\Http\Controllers\Api\V1\Admin\EmployeePosition;

use App\Contracts\Admin\AdminContract;
//use App\Entities\Admin\HrClass;
//use App\Entities\Admin\HrDepartment;
use App\Entities\Admin\LDesignation;
//use App\Entities\Admin\HrGrade;
//use App\Entities\Admin\HrProfiessionalType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    /**
     * @var AdminContract
     */
    private $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        // Dependency injection
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getInitData();
    }

    private function getInitData() {
         //$designation = new LDESIGNATION();

         $designation = DB::table('l_designation')
             ->leftjoin('L_PROFESSION_TYPE', 'L_PROFESSION_TYPE.PROFESSION_TYPE_ID', '=', 'l_designation.PROFESSION_TYPE_ID')
//             ->join('L_SANCTIONED_POST','L_SANCTIONED_POST.DESIGNATION_ID', '=', 'l_designation.DESIGNATION_ID')
             ->leftjoin('L_EMP_TYPE','L_EMP_TYPE.EMP_TYPE_ID', '=', 'l_designation.EMP_TYPE_ID' )
             ->leftjoin('L_EMP_GRADE','L_EMP_GRADE.EMP_GRADE_ID', '=', 'l_designation.grade_id' )
        ->select(
         'l_designation.grade_id',
         'l_designation.designation_id',
         'l_designation.designation',
         'l_designation.designation_bng',
         'l_designation.enable_yn',
         'l_designation.short_name',
         'l_designation.post_type_id',
         'l_designation.post_type_id',
         'l_designation.min_grade_id',
         'l_designation.max_grade_id',
         'l_designation.emp_type_id',
         'L_PROFESSION_TYPE.profession_type',
         'l_designation.ministerial_yn',
         'L_EMP_TYPE.EMP_TYPE_ID',
         'L_EMP_TYPE.EMP_TYPE_NAME',
         'L_EMP_GRADE.EMP_CLASS as CLASS'
//         'L_SANCTIONED_POST.CLASS',

         )
        ->orderBy('l_designation.designation','asc')
        ->get();

        return [
            "post"          => $this->postType(),
            "empType"       => $this->empTypes(),
            "empClass"       => $this->adminManager->findEmpClass(),
            "professionType"=> $this->professionType(),
            "table_info"    => $designation //->all()
        ];

    }

    public function view(Request $request,$id)
    {
        $designation = LDesignation::with('sanctionedPost')->find($id);
        return [
            'designation' => [
                'p_designation_id'         => $designation->designation_id,
                'p_designation'            => $designation->designation,
                'p_designation_bng'        => $designation->designation_bng,
                'p_enable_yn'              => $designation->enable_yn,
                'p_short_name'             => $designation->short_name,
//                "p_post_type_id"           => $designation->post_type_id,
//                "p_min_grade_id"           => $designation->min_grade_id,
//                "p_max_grade_id"           => $designation->max_grade_id,
                "p_emp_type_id"            => $designation->emp_type_id,
                "p_emp_type_name"          => $designation->emp_type_name,
//                "p_profession_type_id"     => $designation->profession_type_id,
                "p_ministerial_yn"         => $designation->ministerial_yn,
                "grade_id"                 => $designation->grade_id,
                "class"                    => isset($designation->sanctionedPost) ? $designation->sanctionedPost->class : '',
             ]
        ];

    }

    public function store(Request $request)
    {
        try {
            $designationId = $request->get("designation_id");
            $statusCode = sprintf("%4000s", "");
            $statusMessage = sprintf('%4000s', '');
            $params = [
                "p_designation_id" => [
                    "value" => &$designationId,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "p_designation"         => $request->p_designation,
                "p_designation_bng"     => $request->p_designation_bng,
                "p_enable_yn"           => $request->p_enable_yn,
                "p_short_name"          => $request->p_short_name,
                "p_post_type_id"        => $request->p_post_type_id,
                "p_min_grade_id"        => $request->p_min_grade_id,
                "p_max_grade_id"        => $request->p_max_grade_id,
                "p_emp_type_id"         => $request->p_emp_type_id,
                //"p_emp_type_name"       => $request->p_emp_type_name,
                "p_profession_type_id"  => $request->p_profession_type_id,
                "p_ministerial_yn"      => $request->p_ministerial_yn,
                "p_grade_id"            => $request->grade_id,
                "p_insert_by"           => Auth()->ID(),
                "p_update_by"           => '',
                //"o_designation_id" => &$designationId,
                'o_status_code'         => &$statusCode,
                'o_status_message'      => &$statusMessage
            ];
             DB::executeProcedure('EMPLOYEES.EMP_DESIGNATION_SETUP', $params);
//             dd($params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

            return $params;
//        dd($params);
    }

/*
    public function remove($id)
    {
        $designation = $this->adminContract->findDesignations($id);
        $designation->delete();
    }

    */
    public function update(Request $request,$id) {

        try {
            $designationId = $id;
            $statusCode = sprintf("%4000s","");
            $statusMessage = sprintf("%4000s","");
            $params = [
                "p_designation_id" => [
                    "value" => &$designationId,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "p_designation"         => $request->p_designation,
                "p_designation_bng"     => $request->p_designation_bng,
                "p_enable_yn"           => $request->p_enable_yn,
                "p_short_name"          => $request->p_short_name,
                "p_post_type_id"        => $request->p_post_type_id,
                "p_min_grade_id"        => $request->p_min_grade_id,
                "p_max_grade_id"        => $request->p_max_grade_id,
                "p_emp_type_id"         => $request->p_emp_type_id,
//                "p_emp_type_name"       => $request->p_emp_type_name,
                "p_profession_type_id"  => $request->p_profession_type_id,
                "p_ministerial_yn"      => $request->p_ministerial_yn,
                "p_grade_id"            => $request->grade_id,
                "p_insert_by"           => Auth::id(),
                "p_update_by"           => Auth()->ID(),
                //"o_designation_id" => &$designationId,
                'o_status_code'         => &$statusCode,
                'o_status_message'      => &$statusMessage
            ];
//            dd($params);
            DB::executeProcedure('EMPLOYEES.EMP_DESIGNATION_SETUP', $params);

        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    private function postType(){
        $postType = [];
        $postType[] = ["value" => null, 'text' => 'Select Post'];
         foreach ($this->adminManager->findPostType() as $item) {
            $postType[] = ["text" => $item->post_type, 'value' => $item->post_type_id];
        }
         return $postType;
    }
    private function professionType(){
        $professions = [];
        $professions[] = ["value" => null, 'text' => 'Select Profession'];
         foreach ($this->adminManager->findProfessionTypes() as $item) {
            $professions[] = ["text" => $item->profession_type, 'value' => $item->profession_type_id];
        }
         return $professions;
    }


    private function empTypes(){
        $empType = [];
        $empType[] = ["value" => null, 'text' => 'Select Employee Type'];
         foreach ($this->adminManager->findEmpTypes()  as $item) {
            $empType[] = ["text" => $item->emp_type_name, 'value' => $item->emp_type_id];
        }
         return $empType;
    }

}
