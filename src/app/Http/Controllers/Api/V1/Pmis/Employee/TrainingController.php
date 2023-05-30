<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LTraining;
use App\Entities\Admin\LTrainingType;
use App\Entities\Pmis\Employee\EmpTrainingTemp;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;


class TrainingController extends Controller
{
    private $adminManager;

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
        $training = new EmpTrainingTemp();
        $adminManager = $this->adminManager;
        $trainings = $training
            ->select('training_name', 'training_type_id', 'training_institute', 'training_duration', 'training_completion_date', 'training_id', 'training_start_date','approved_yn')
            ->where('emp_id', $id)
            ->orderBy('training_id', 'desc')->get();

         return [
            "countryList"=>$adminManager->findGeoCountries(),
            "trainingTypeList" => $adminManager->findTrainingType(),
            "data" => $trainings
        ];
    }

     public function getData() {
        $training = new EmpTrainingTemp();
        $adminManager = $this->adminManager;
        return [
            "countryList"=>$adminManager->findGeoCountries(),
            "trainingTypeList" => $adminManager->findTrainingType()
        ];
     }


    public function view(Request $request, $id)
    {
        $training = new EmpTrainingTemp();
        return $training->find($id);

    }

    public function store(Request $request)
    {
        return $this->createNewTraining($request);
    }

    public function update(Request $request, $id)
    {
        if($id > 0) {
            return $this->createNewTraining($request, $id);
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not updated!'];
        }
    }

    public function remove(Request $request, $id)
    {
        if($id > 0) {
            return $this->removeTraining($request, $id);
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not deleted!'];
        }
    }

    //---INSERT AND UPDATE METHOD---//
    private function createNewTraining(Request $request, $id = '')
    {
        try {
            $training_id = $id;
            $status_code = sprintf('%4000s', '');
            $status_message = sprintf('%4000s', '');
            $training_completion_date = $request->get('training_completion_date') ? date("Y-m-d", strtotime($request->get('training_completion_date'))) : '';

            $params = [
                "training_id" => [
                    'value' => &$training_id,
                    'type' => PDO::PARAM_INPUT_OUTPUT,
                    'length' => 255
                ],
                'emp_id' => $request->get('emp_id'),
                'training_name' => $request->get('training_name'),
                'training_type_id' => $request->get('training_type_id'),
                'trainig_country_id' => $request->get('trainig_country_id'),
                'training_description' => $request->get('training_description'),
                'training_institute' => $request->get('training_institute'),
                'training_duration' => $request->get('training_duration'),
                'training_start_date' => date('Y-m-d', strtotime($request->get('training_start_date'))),
                'training_completion_date' => $training_completion_date,

                'training_report_document'=> [
                    'value' => $request->get("training_report_document"),
                    'type' => SQLT_CLOB,
                ],
                'training_acheivment' => $request->get('training_acheivment'),
                'training_rep_document_name' => $request->get('training_report_document_name'),
                'training_rep_document_type' => $request->get('training_report_document_type'),
                'insert_by' => auth()->id(),
                'update_by' => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message
            ];

            DB::executeProcedure('employees.create_new_training', $params);
            return $params;
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }

    //----DELETE METHOD----//
    public function removeTraining(Request $request, $id)
    {
        if($id > 0) {
            try {
                $o_status_code = sprintf('%4000s', '');
                $o_status_message = sprintf('%4000s', '');
                $training_id = $id;

                $params = [
                    'training_id' => [
                        'value' => &$training_id,
                        "type" => PDO::PARAM_INPUT_OUTPUT,
                        "length" => 255
                    ],
                    'o_status_code' => &$o_status_code,
                    'o_status_message' => &$o_status_message,
                ];

                DB::executeProcedure('employees.delete_new_training', $params);
                return $params;
            }
            catch (Exception $e) {
                return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
            }
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not deleted!'];
        }
    }

    public function checkCountryField(Request $request, $id)
    {
        $trainingType = new LTrainingType();
        $trainingType = $trainingType->find($id);

        $enable = false;
        if($trainingType->country_flag == 'Y') {
            $enable = true;
        }

        return response()->json(['enable_country' => $enable]);
    }
}
