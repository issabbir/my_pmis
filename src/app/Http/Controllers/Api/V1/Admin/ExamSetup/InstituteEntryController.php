<?php

namespace App\Http\Controllers\Api\V1\Admin\ExamSetup;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\HrExamBody;
use App\Entities\Admin\HrExamBodyType;
use App\Entities\Admin\LInstitute;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;


class InstituteEntryController extends Controller
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
            "institutes" => $this->adminManager->findInstitute(),
//            "exambody" => $this->adminManager->findExamBodies(),
//              "exambodyinstitutes"=>$this->getExam()
//            "exambodyinstitutes" => LExamBody::with('institutes')->get()

        ];
    }

    public function bodyStore(Request $request)
    {
//        dd( $request);

        try {
            $input = new LInstitute();
            if ($institute_id = $request->input('institute_id')) {
                $input->exists = true;
                $input->institute_id = $institute_id;
            }
            $input->institute_name = $request->input('institute_name');
            $input->institute_name_bng = $request->input('institute_name_bng');
//            $input->insert_by = Auth::user()->user_id;
//            $input->insert_date = date('d/m/y');
            $input->save();

            if ($request->input('institute_id')) {
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

        $data = LInstitute::orderby('institute_id', 'desc')->get();
        return $data;


    }

    public function destroy($id)
    {
        try {
            LInstitute::destroy($id);
            $message = 'Data Deleted Successfully';
        } catch (\Exception $e) {
//             return ['o_status_code' => 99, 'o_status_message' => $e->getMessage()];
            return ['o_status_code' => 99, 'o_status_message' => "Delete Unsuccessful."]; // Child Record Found."];

        }
        return ['o_status_code' => 1, 'o_status_message' => $message];
    }

}
