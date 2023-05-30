<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Contracts\Admin\AdminContract;
use App\Entities\Pmis\Employee\EmpExperienceTemp;
use Illuminate\Support\Facades\DB;

class ExperienceController extends Controller
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
        $experience = new EmpExperienceTemp;
        $experiences = $experience
            ->select('experience_id', 'employer_name', 'designation', 'work_from', 'work_to')
            ->where('emp_id', $id)
            ->orderBy('experience_id', 'desc')->get();

        return [
            'experience' => $experiences,
        ];
    }

    public function view(Request $request, $id)
    {
        $empExperience = new EmpExperienceTemp();
        return $empExperience->find($id);
    }

    public function store(Request $request)
    {
        try {
            $experienceid = $request->get("experience_id");
            $workduration = '';
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');

            $params = [
                "experience_id" => [
                    'value' => &$experienceid,
                    'type' => \PDO::PARAM_INPUT_OUTPUT,
                    'length' => 255
                ],
                'emp_id' => $request->emp_id,
                "employer_name" => $request->employer_name,
                "designation" => $request->designation,
                "employer_address" => $request->employer_address,
                "work_from" =>  date("Y-m-d", strtotime($request->get('work_from'))),
                "work_to" => date("Y-m-d", strtotime($request->get('work_to'))),
                "work_duration" => [
                    'value' => &$workduration,
                    'length' => 255
                ],
                "responsibility" => $request->responsibility,
                "insert_by" => auth()->id(),
                "update_by" => auth()->id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message
            ];

            //DB::executeProcedure('employees.create_new_family', $params);
            return $this->employees_create_new_experience($request);

            return $params;
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $this->getData();
    }

    public function employees_create_new_experience(Request $request)
    {
       //$to = date("Y-m-d", strtotime($request->get("work_from")));
       // $from = date("Y-m-d", strtotime($request->get("work_to")));
        $to = $request->get('work_from') ? date("Y-m-d", strtotime($request->get('work_from'))) : '';
        $from = $request->get('work_to') ? date("Y-m-d", strtotime($request->get('work_to'))) : '';

        //$duration = $this->duration($to,$from);

        try {
            $experienceid = $request->get("experience_id");
            $workduration = $this->duration($to,$from);
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');

            $params = [
                'experience_id' => [
                    'value' => &$experienceid,
                    'type' => \PDO::PARAM_INPUT_OUTPUT,
                    'length' => 255
                ],
                'emp_id' => $request->get('emp_id'),
                "employer_name" => $request->get("employer_name"),
                "designation" => $request->get("designation"),
                "employer_address" => $request->get("employer_address"),
                "work_from" =>  $to,
                "work_to" => $from,
                "work_duration" => [
                    'value' => &$workduration,
                    'length' => 255
                ],
                "responsibility" => $request->get("responsibility"),
                "insert_by" => auth()->id(),
                "update_by" => auth()->id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message
            ];

            DB::executeProcedure("employees.create_new_experience", $params);
        }
        catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function update(Request $request)
    {
        //TODO: Default template for action.
    }

    public function remove($id, Request $request)
    {
        return $this->employees_delete_new_experience($id);
    }

    public function employees_delete_new_experience($id)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "experience_id" => $id,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("employees.delete_new_experience", $params);
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public  function  getData()
    {
        return [];
    }

    private  function duration($to,$from){
        $to = Carbon::createFromFormat('Y-m-d', $to);
        $from = Carbon::createFromFormat('Y-m-d', $from);
        $duration = $to->diff($from)
         ->format('%y Years %m Months %d Days');
         return $duration;
    }
}
