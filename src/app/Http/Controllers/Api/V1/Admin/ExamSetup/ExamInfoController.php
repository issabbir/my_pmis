<?php

namespace App\Http\Controllers\Api\V1\Admin\ExamSetup;

use App\Contracts\Admin\AdminContract;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use DB;

class ExamInfoController extends Controller {

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
            $examid = '';
            $statusCode = '';
            $statusMessage = sprintf('%4000s', '');
            $params = [
                "p_exam_name" => $request->name,
                "p_exam_name_bng" => $request->nameBangla,
                "p_exam_public_yn" => $request->examInsType,
                "p_insert_by" => Auth()->ID(),
                "o_exam_id" => &$examid,
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];
            DB::executeProcedure('PMIS.L_EXAM_INS', $params);
            if ($params['o_status_code'] == 1) {
                return response()->json([
                            'success' => true, 'message' => 'Exam Information Added Successfully', 'data' => $this->getInitData(), 200
                ]);
            }
        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

    public function update(Request $request) {
        //TODO: Default template for action.
    }

    public function remove(Request $request) {
        //TODO: Default template for action.
    }

    private function getInitData() {
        return [
            "examinfodata" => $this->adminManager->findExam()
        ];
    }

}
