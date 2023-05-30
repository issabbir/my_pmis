<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LExamResult;
use App\Entities\Admin\LExamResultType;
use App\Entities\Pmis\Employee\EmpEducationTemp;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class AcademicController extends Controller
{
    protected $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getData();
    }

    public function specific(Request $request, $id)
    {
        $academic = new EmpEducationTemp();

        $adminManager = $this->adminManager;
        $academics = $academic->where('emp_id',$id)->orderBy('exam_id','asc')->get();
        return [
            "exams" => $adminManager->findExam(),
            "subjects" => $adminManager->findSubject(),
            "exam_bodys" => $adminManager->findExamBodies(),
            "results" => $adminManager->findExamResult(),
            "institutes" => $adminManager->findInstitute(),
            "approved_yn" => $adminManager->findEmpStatus(),
            "result_types"=>$adminManager->findExamResultType(),
            "data" => $academics
        ];
    }

    public function getData()
    {
        $adminManager = $this->adminManager;

        return [
            "exams" => $adminManager->findExam(),
            "exam_bodys" => $adminManager->findExamBodies(),
            "results" => $adminManager->findExamResult(),
            "institutes" => $adminManager->findInstitute(),
            "result_types"=>$adminManager->findExamResultType()
        ];
    }

    public  function  getResultType(){
        $exam_result_type=new LExamResult();
        return $exam_result_type->whereNotNull('result_type')->distinct('result_type')->get('result_type');
    }

    public  function getResultByType($id){
        $exam_result_type=new LExamResult();
        return $exam_result_type->where('result_type',$id)->orderBy('exam_result','asc')->get();
    }

    public function view(Request $request, $id)
    {
        $academic = new EmpEducationTemp();
        $academic = $academic->find($id);
        $examResultType=new LExamResultType();
        $selectedExamResultType=$examResultType->where('exam_result_type_id',$academic->exam_result_type_id)->first();
        $academic->selectedResultType=$selectedExamResultType;
        return $academic;
    }

    public function store(Request $request)
    {

        try {
            return $this->employee_create_new_academic($request);
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }

    public function employee_create_new_academic(Request $request)
    {
        try {
            $emp_education_id = $request->get("emp_education_id");
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $params = [
                'emp_education_id' => [
                    'value' => &$emp_education_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'emp_id' => $request->get('emp_id'),
                'exam_id' => $request->get('exam_id'),
                'exam_body_id' => $request->get('exam_body_id'),
                'exam_result_id' => $request->get('exam_result_id'),
                'exam_result' => $request->get('exam_result'),
                'p_exam_subject_id' => $request->get('exam_subject_id'),
                'subject' => $request->get('subject'),
                'passing_year' => $request->get('passing_year'),
                'subject_bng' => $request->get('subject_bng'),
                'insert_by' => auth()->id(),
                'update_by' => auth()->id(),
                'institute_id' => $request->get('institute_id'),
                'institute_name' => $request->get('institute_name'),
                'exam_result_type_id' => $request->get('exam_result_type_id'),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];
            DB::executeProcedure('employees.create_new_education', $params);

            return $params;
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }

    public function remove(Request $request, $id)
    {
        if ($id > 0) {
            try {
                $o_status_code = sprintf('%4000s', '');
                $o_status_message = sprintf('%4000s', '');
                $emp_educationl_id = $id;
                $params = [
                    'emp_educationl_id' => [
                        'value' => &$emp_educationl_id,
                        "type" => PDO::PARAM_INPUT_OUTPUT,
                        "length" => 255],
                    'o_status_code' => &$o_status_code,
                    'o_status_message' => &$o_status_message,
                ];

                DB::executeProcedure('employees.delete_new_education', $params);
                return $params;
            } catch (Exception $e) {
                return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
            }
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not deleted!'];
        }
    }
}
