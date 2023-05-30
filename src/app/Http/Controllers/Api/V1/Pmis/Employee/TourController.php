<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Contracts\Admin\AdminContract;
use App\Entities\Pmis\Employee\EmpTourTemp;
use Illuminate\Support\Facades\DB;
use PDO;

class TourController extends Controller
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

       $tour = new EmpTourTemp;
       $tours = $tour
           ->select('tour_id', 'emp_id','tour_name','tour_name_bng','tour_type_id','country_id','note','travel_date','return_date',
               'tour_duration',
               'sponsor' ,'approved_yn',
               'sponsor_bng')
           ->where('emp_id', $id)
           ->orderBy('tour_id', 'desc')->get();

        return [
            'countries' => $this->geoCountry(),
            'tourtypes' => $this->alltourtypes(),
            'tours' => $tours
        ];
    }

    public function view($id,Request $request)
    {
         $empTour = new EmpTourTemp();
         return $empTour->find($id);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        try {
            $tour_id = $request->get("tour_id");
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');

            $params = [
                "emp_id" => $request->emp_id,
                "tour_id" => [
                    'value' => &$tour_id,
                    'type' => PDO::PARAM_INPUT_OUTPUT,
                    'length' => 255
                ],
                "tour_name" => $request->tour_name,
                "tour_name_bng" => $request->tour_name_bng,
                "tour_type_id" => $request->tour_type_id,
                "tour_country_id" => $request->country_id,
                "tour_description" => $request->note,
                "tour_start_date" =>  date("Y-m-d",strtotime($request->get('travel_date'))),
                "tour_end_date" => date("Y-m-d",strtotime($request->get('return_date'))),
                "tour_duration" => $request->tour_duration,
                "tour_sponsor" => $request->sponsor,
                "tour_sponsor_bng" => $request->sponsor_bng,
                "insert_by" => auth()->id(),
                "update_by" => auth()->id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message
            ];

            return $this->employees_create_new_tour($request);
        }catch (Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

    public function update(Request $request)
    {

    }

    public function employees_create_new_tour(Request $request)
    {
        try {
            $tour_id = $request->get("tour_id");
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $p_tour_start_date = $request->get('tour_start_date') ? date("Y-m-d", strtotime($request->get('tour_start_date'))) : '';
            $p_tour_end_date = $request->get('tour_end_date') ? date("Y-m-d", strtotime($request->get('tour_end_date'))) : '';

            $params = [
                "emp_id" => $request->emp_id,
                "tour_id"=>[
                    "value" => &$tour_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "tour_name" => $request->tour_name,
                "tour_name_bng" => $request->tour_name_bng,
                "tour_type_id" => $request->tour_type_id,
                "tour_country_id" => $request->country_id,
                "tour_description" => $request->note,
                "tour_start_date" =>  date("Y-m-d",strtotime($request->get('travel_date'))),
                "tour_end_date" => date("Y-m-d",strtotime($request->get('return_date'))),
                "tour_duration" => $request->tour_duration,
                "tour_sponsor" => $request->sponsor,
                "tour_sponsor_bng" => $request->sponsor_bng,
                "insert_by" => auth()->id(),
                "update_by" => auth()->id(),
                'o_status_code' => &$status_code,
                'o_status_message' => &$status_message
            ];

            DB::executeProcedure("employees.create_new_tour", $params);

            return $params;
        }
        catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function remove(Request $request,$id)
    {
        try {
                $status_code = sprintf("%4000s","");
                $status_message = sprintf("%4000s","");
                $params = [

                "tour_id" => $id,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("EMPLOYEES.DELETE_NEW_TOUR", $params);
                }
                catch (Exception $e) {
                    return ["exception" => true, "status" => false, "message" => $e->getMessage()];
                }
           return $params;
    }

    public function getData()
    {
        $tour = new EmpTourTemp;

        return [
            'countries' => $this->geoCountry(),
            'tourtypes' => $this->alltourtypes()
        ];
    }

    private function geoCountry() {
        $country = [];
        $country[] = ["value" => null, 'text' => 'Select Country'];
        foreach ($this->adminManager->findGeoCountries() as $item) {
            $country[] = ["text" => $item->country, 'value' => $item->country_id];
        }
        return $country;
    }

    private function alltourtypes()
    {
        $tourtypes = [];
        $tourtypes[] = ["value" => null, 'text' => 'Select Tour Types'];
        foreach ($this->adminManager->findTourType() as $item) {
            $tourtypes[] = ["text" => $item->tour_type, 'value' => $item->tour_type_id];
        }
        return $tourtypes;
    }
}
