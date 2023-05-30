<?php


namespace App\Http\Controllers\Api\V1\Leave;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LHoliday;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;
use PhpParser\Node\Param;

class HolidayController extends Controller
{
    protected $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        $holiday = DB::table('l_holiday')
            ->orderBy('holiday_id', 'asc')
            ->get();

        return [
            "holiday" => $holiday
        ];
    }

    public function holidayCalendar()
    {
        $holidays = new LHoliday();
        $holidayList = $holidays->orderBy('holiday_id', 'asc')->get();
        //die($holidayList);
        $holidayArr = [];
        foreach ($holidayList as $holiday) {
            $holidayArr[] = [
                'title' => $holiday->holiday,
                'start' => $holiday->date_from,
                'end' => date('Y-m-d H:i:s', strtotime($holiday->date_to . ' +1 day')),
            ];
        }

        return [
            "holiday" => $holidayArr
        ];
    }

    public function view(Request $request, $id)
    {
        $holiday = new LHoliday();
        return $holiday->find($id);
    }

    public function store(Request $request)
    {
        {
            try {

                $status_code = sprintf("%4000s", "");
                $status_message = sprintf("%4000s", "");
                $params = [

                    "p_holiday_id" => $request->get("holiday_id"),
                    "p_holiday" => $request->get("holiday"),
                    "p_holiday_bng" => $request->get("holiday_bng"),
                    "p_date_from" => date("Y-m-d", strtotime($request->get("date_from"))),
                    "p_date_to" => date("Y-m-d", strtotime($request->get("date_to"))),
                    "p_description" => $request->get("description"),
                    "p_insert_by" => $request->get("insert_by"),
                    "p_update_by" => '',
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("PR_HOLIDAY_SETUP", $params);
            } catch (\Exception $e) {
                return ["exception" => true, "status" => false, "message" => $e->getMessage()];
            }

            return $params;
        }

    }

    public function update(Request $request, $id)
    {
        {
            try {

                $status_code = sprintf("%4000s", "");
                $status_message = sprintf("%4000s", "");
                $params = [

                    "p_holiday_id" => $id,
                    "p_holiday" => $request->get("holiday"),
                    "p_holiday_bng" => $request->get("holiday_bng"),
                    "p_date_from" => date("Y-m-d", strtotime($request->get("date_from"))),
                    "p_date_to" => date("Y-m-d", strtotime($request->get("date_to"))),
                    "p_description" => $request->get("description"),
                    "p_insert_by" => '',
                    "p_update_by" => $request->get("insert_by"),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("PR_HOLIDAY_SETUP", $params);
            } catch (\Exception $e) {
                return ["exception" => true, "status" => false, "message" => $e->getMessage()];
            }

            return $params;
        }

    }

    public function remove(Request $request, $id)
    {

    }
}
