<?php

namespace App\Http\Controllers\Api\V1\Admin\LeaveSetup;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\HrHoliday;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;

use DB;

class HolidayController extends Controller
{
    private $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return ["holiday" => $this->adminManager->findHolidays()];
    }

    public function view(Request $request, $id)
    {
        return $this->adminManager->findHolidays($id);
    }

    public function fetch(Request $request, $id)
    {
        $hrHoliday = $this->adminManager->findHolidays($id);

        return [
            'hrHoliday' => [
                'description' => $hrHoliday->description,
                'holiday_type_id' => $hrHoliday->holiday_type_id,
                'holiday_status_id' => $hrHoliday->holiday_status_id,
                'fromdate' => (new DateTime($hrHoliday->fromdate))->format('Y-m-d'),
                'todate' => (new DateTime($hrHoliday->todate))->format('Y-m-d')
            ]
        ];
    }

    public function store(Request $request)
    {
        try {
            $holidayId = '';
            $statusCode = '';
            $statusMessage = sprintf('%4000s', '');
            $params = [
                "p_holiday" => $request->p_holiday,
                "p_holiday_bng" => $request->p_holiday_bng,
                "p_date_from" => $request->p_date_from,
                "pa_date_to" => $request->pa_date_to,
                "p_description" => $request->p_description,
                "p_insert_by" => Auth()->ID(),
                "o_holiday_id" => &$holidayId,
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];
            DB::executeProcedure('PMIS.L_HOLIDAY_INS', $params);
            if ($params['o_status_code'] == 1) {
                return response()->json([
                    'success' => true, 'message' => 'Holiday Added Successfully', 'data' =>  $this->adminManager->findHolidays(), 200
                ]);
            }
        }catch (Exception $e) {
            return response($e->getMessage(), 400);
        }

    }

    public function update(Request $request, $id)
    {
        $holiday = $this->adminManager->findHolidays($id);
        $holiday->setConnection('cpa_pmis');
        $holiday->fill($request->all());
        $holiday->created_by = auth()->ID();
        $holiday->update();
    }

    public function remove(Request $request, $id)
    {
        if(HrHoliday::destroy($id)) {
            return ['deleted' => true];
        }

        return ['deleted' => false];
    }
}
