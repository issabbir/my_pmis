<?php

namespace App\Http\Controllers\Api\V1\Admin\ExamSetup;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\HrExamBody;
use App\Entities\Admin\HrExamBodyType;
use App\Entities\Admin\LExamBody;

use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Entities\Admin\LExam;

class ExamBodyMappingController extends Controller
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


    public function getExamByExamId($id)
    {
//        $sql = "select administration.dpt_section_grid_data(:p1) from dual";
//        $sections = DB::select($sql,['p1'=>$id]);
//        return $sections;


        $SearchExambody = DB::select("select EB.EXAM_BODY_ID,LI.INSTITUTE_ID ,EB.EXAM_BODY_NAME,LI.INSTITUTE_NAME from L_EXAM_BODY EB,L_INSTITUTE LI
                            where EB.EXAM_BODY_ID = LI.EXAM_BODY_ID and EB.EXAM_BODY_ID=$id");
        return $SearchExambody;
        //dd($SearchExambody);
    }

    public function getExam()
    {
        $examIns = DB::select("select EB.EXAM_BODY_ID,LI.INSTITUTE_ID ,EB.EXAM_BODY_NAME,LI.INSTITUTE_NAME from L_EXAM_BODY EB,L_INSTITUTE LI
                            where EB.EXAM_BODY_ID = LI.EXAM_BODY_ID");
        return $examIns;
    }

    public function view(Request $request)
    {

    }

    public function store(Request $request)
    {


        try {
            $exambodyId = $request->get('exam_body_id');
            /** @var LExamBody $exambody */
            $exambody = LExamBody::find($exambodyId);

            $instituteIds = [];
            foreach ($request->get('institute_id') as $instituteId) {
                $instituteIds[] = $instituteId['institute_id'];
            }
            $exambody->institutes()->sync($instituteIds);
        } catch (\Exception $e) {
            return ['o_status_code' => 99, 'o_status_message' => $e->getMessage()];
        }

        return ['o_status_code' => 1, 'o_status_message' => ' Updated Successfully', 'exam' => $exambody];
    }

    public function update(Request $request)
    {
        //TODO: Default template for action.
    }

    /**
     * Remove action
     * @param Request $request
     */
    public function remove(Request $request)
    {
        //TODO: Default template for action.
    }

    /**
     * Initial list of exambodies
     *
     * @return array
     */
    public function getInitData()
    {

        return [
            "institutes" => $this->adminManager->findInstitute(),
            "exambody" => $this->adminManager->findExamBodies(),
//              "exambodyinstitutes"=>$this->getExam()
            "exambodyinstitutes" => LExamBody::with('institutes')->get()

        ];
    }

    public function bodyStore(Request $request)
    {

        try {
            $input = new LExam;
            if ($exam_id = $request->input('exam_id')) {
                $input->exists = true;
                $input->exam_id = $exam_id;
            }
            $input->exam_name = $request->input('exam_name');
            $input->exam_name_bng = $request->input('exam_name_bng');
            $input->public_yn = $request->input('public_yn');
            $input->insert_by = Auth::user()->user_id;
            $input->insert_date = date('d/m/y');
            $input->save();

            if ($request->input('exam_id')) {
                $message = 'Updated Successfully';
            } else {
                $message = 'Stored Successfully';
            }

        } catch (\Exception $e) {
//             return ['o_status_code' => 99, 'o_status_message' => $e->getMessage()];
            return ['o_status_code' => 99, 'o_status_message' => 'Duplicate Value Found!.'];
        }

        return ['o_status_code' => 1, 'o_status_message' => $message];
    }

    public function bodyDatatable(Request $request)
    {

        $data = LExam::orderby('exam_id', 'desc')->get();
        return $data;


    }

    public function destroy($id)
    {
        try {
            LExam::destroy($id);
            $message = 'Data Deleted Successfully';
        } catch (\Exception $e) {
//             return ['o_status_code' => 99, 'o_status_message' => $e->getMessage()];
            return ['o_status_code' => 99, 'o_status_message' => "Delete Unsuccessful. Child Record Found."];

        }
        return ['o_status_code' => 1, 'o_status_message' => $message];
    }

}
