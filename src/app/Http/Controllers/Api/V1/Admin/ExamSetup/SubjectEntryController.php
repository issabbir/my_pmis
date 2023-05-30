<?php

namespace App\Http\Controllers\Api\V1\Admin\ExamSetup;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\HrExamBody;
use App\Entities\Admin\HrExamBodyType;
use App\Entities\Admin\LExamSubject;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;


class SubjectEntryController extends Controller
{

    /** @var AdminContract|AdminManager */
    private $adminManager;

    /**
     * ExamBodyController constructor.
     *
     * @param AdminManager|AdminContract $adminManager
     */
    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getInitData();

    }


    public function getInitData()
    {

        return [
            "exam_subjects" => $this->adminManager->findSubject(),


        ];
    }

    public function bodyStore(Request $request)
    {
//        dd( $request);

        try {
            $input = new LExamSubject();
            if ($exam_subject_id = $request->input('exam_subject_id')) {
                $input->exists = true;
                $input->exam_subject_id = $exam_subject_id;
            }
            $input->exam_subject_name = $request->input('exam_subject_name');
            $input->exam_subject_name_bng = $request->input('exam_subject_name_bng');

            if ($exam_subject_id) {
                $input->update_by = Auth::user()->user_id;
                $input->update_date = date('d/m/y');
            } else {
                $input->insert_by = Auth::user()->user_id;
                $input->insert_date = date('d/m/y');
            }

            $input->save();

            if ($request->input('exam_subject_id')) {
                $message = 'Updated Successfully';
            } else {
                $message = 'Stored Successfully';
            }

        } catch (\Exception $e) {
//             return ['o_status_code' => 99, 'o_status_message' => $e->getMessage()];
            return ['o_status_code' => 99, 'o_status_message' => 'Unsuccessful Entry'];
        }

        return ['o_status_code' => 1, 'o_status_message' => $message];
    }

    public function bodyDatatable(Request $request)
    {

        $data = LExamSubject::orderby('exam_subject_id', 'desc')->get();

        return $data;


    }

    public function destroy($id)
    {
        try {
            LExamSubject::destroy($id);
            $message = 'Data Deleted Successfully';
        } catch (\Exception $e) {
//             return ['o_status_code' => 99, 'o_status_message' => $e->getMessage()];
            return ['o_status_code' => 99, 'o_status_message' => "Delete Unsuccessful."]; // Child Record Found."];

        }
        return ['o_status_code' => 1, 'o_status_message' => $message];
    }

}
