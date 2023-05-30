<?php

namespace App\Http\Controllers\Api\V1\Admin\ExamSetup;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LExamResult;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use DB;

class ExamResultController extends Controller
{
    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getInitData();
    }

    public function view(Request $request,$id)
    {
        $exam_result = new LExamResult();
        return $exam_result->find($id);
    }

    public function store(Request $request)
    {
          try {
              $o_status_code = sprintf('%4000s', '');
              $o_status_message = sprintf('%4000s', '');
            $params = [
                "p_exam_result_id" => $request->get('exam_result_id'),
                "p_EXAM_RESULT" => $request->get('exam_result'),
                "p_EXAM_RESULT_BNG" => $request->get('exam_result_bng'),
                "p_result_type" => $request->get('result_type'),
                "p_insert_by" => auth()->id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message
            ];
            DB::executeProcedure('employees.create_new_exam_result', $params);

              return $params;

          } catch (Exception $e) {
              return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
          }
    }

    public function update(Request $request)
    {
        //TODO: Default template for action.
    }

    public function remove(Request $request)
    {
        //TODO: Default template for action.
    }
    private function getInitData() {
        $exam_result=new LExamResult();
          return [
             "exam_result" =>$exam_result->get()
        ];
    }
}
