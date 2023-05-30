<?php

namespace App\Http\Controllers\Api\V1\Admin\ExamSetup;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\HrExamBody;
use App\Entities\Admin\HrExamBodyType;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use DB;

class ExamBodyController extends Controller {

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

    public function view(Request $request) {

    }

    public function store(Request $request) {
        try {
            $exambodyId = '';
            $statusCode = '';
            $statusMessage = sprintf('%4000s', '');
            $params = [
                "p_exam_body_name" => $request->p_exam_body_name,
                "p_exam_body_name_bng" => $request->p_exam_body_name_bng,
                "p_foreign_yn" => $request->p_foreign_yn,
                "p_insert_by" => Auth()->ID(),
                "o_exam_body_id" => &$exambodyId,
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];
            DB::executeProcedure('PMIS.L_EXAM_BODY_INS', $params);
            if ($params['o_status_code'] == 1) {
                return response()->json([
                            'success' => true, 'message' => 'Exam Body Added Successfully', 'data' => $this->getInitData(), 200
                ]);
            }
        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }
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
    private function getInitData() {
          return [
             "exambody" => $this->adminManager->findExamBodies(),
              "institutes"=>$this->adminManager->findInstitute()
        ];
    }

}
