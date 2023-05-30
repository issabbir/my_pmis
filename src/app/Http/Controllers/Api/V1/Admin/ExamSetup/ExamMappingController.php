<?php

namespace App\Http\Controllers\Api\V1\Admin\ExamSetup;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\HrExamBody;
use App\Entities\Admin\HrExamBodyType;
use App\Entities\Admin\LExam;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use DB;

class ExamMappingController extends Controller {

    /** @var AdminContract|AdminManager  */
    private $adminManager;

    /**
     * ExamBodyController constructor.
     *
     * @param AdminManager|AdminContract $adminManager
     */
    public function __construct(AdminManager $adminManager) {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request) {
        return $this->getInitData();
    }
    public function  getExamByExamId($id)
    {
//        $sql = "select administration.dpt_section_grid_data(:p1) from dual";
//        $sections = DB::select($sql,['p1'=>$id]);
$searchbyid = DB::select("select le.EXAM_ID,le.EXAM_NAME from L_EXAM le
                    where le.EXAM_ID =$id");
       return $searchbyid;

    }
    public function view(Request $request) {

    }

    public function store(Request $request) {
        try {
            $examId = $request->get('exam_id');
            /** @var LExam $exam */
            $exam = LExam::find($examId);

            $examBodyIds = [];

            $examSubjectId = [];
            $examResultTypeId = [];

            foreach ($request->get('exam_body_id') as $examBodyId) {
                $examBodyIds[] = $examBodyId['exam_body_id'];
            }
            $exam->exam_bodies()->sync($examBodyIds);
            foreach ($request->get('exam_subject_id') as $exam_subject_id) {
                $examSubjectId[] = $exam_subject_id['exam_subject_id'];
            }
            $exam->exam_subjects()->sync($examSubjectId);

            foreach ($request->get('exam_result_type_id') as $exam_result_type_id) {
                $examResultTypeId[] = $exam_result_type_id['exam_result_type_id'];
            }
            $exam->exam_result_types()->sync($examResultTypeId);
        }
        catch (\Exception $e) {
            return ['o_status_code' => 99, 'o_status_message' => $e->getMessage()];
        }

        return ['o_status_code' => 1, 'o_status_message' =>' Updated Successfully', 'exam' => $exam];
    }

    public function update(Request $request) {
        //TODO: Default template for action.
    }

    /**
     * Remove action
     * @param Request $request
     */
    public function remove(Request $request) {
        //TODO: Default template for action.
    }

    /**
     * Initial list of exambodies
     *
     * @return array
     */
    public  function getInitData() {
        //dd(LExam::all()[0]->exam_bodies);
          return [
              "exambody" => $this->adminManager->findExamBodies(),
              "examSubject" => $this->adminManager->findSubject(),
              "examResultType" => $this->adminManager->findExamResultType(),
              "exam" => $this->adminManager->findExam(),
              "exams"=>LExam::with(['exam_bodies','exam_subjects','exam_result_types'])->get()
        ];
    }

}
