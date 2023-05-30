<?php


namespace App\Http\Controllers\Api\V1\Leave;


use App\Entities\Leave\LHolidayTeacher;
use App\Helper\HelperClass;
use App\Http\Controllers\Controller;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HolidayTeacherController extends Controller
{
    public function index(Request $request)
    {
        $holiday = DB::table('l_holiday_teacher')
            ->orderBy('holiday_id', 'desc')
            ->get();
        foreach ($holiday as $key=>$value){
            $date_from = date("Y-m-d", strtotime($value->date_from));
            $date_to = date("Y-m-d", strtotime($value->date_to));
            $holiday[$key]->total_count  = HelperClass::dateDiffInDays($date_from, $date_to) + 1;
        }
        return [ "holiday" => $holiday ];
    }

    public function store(Request $request)
    {
        $date_from = date("Y-m-d", strtotime($request->get("date_from")));
        $date_to = date("Y-m-d", strtotime($request->get("date_to")));

       /* $period = CarbonPeriod::create($date_from, $date_to);
        $count = null;
        foreach ($period as $date) {
            $sql = "select count(holiday_id) holiday_id from pmis.l_holiday where :given_date between date_from and date_to";
            $count = DB::selectOne($sql, ['given_date' => $date->format('Y-m-d')]);
            if($count->holiday_id > 0){
                return ["exception" => true, "status" => false, "message" => 'Sorry, the date is already created as holiday in general.'];
                break;
            }

        }*/

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_holiday_id" => $request->get("holiday_id"),
                "p_holiday" => $request->get("holiday"),
                "p_holiday_bng" => $request->get("holiday_bng"),
                "p_date_from" => $date_from,
                "p_date_to" => $date_to,
                "p_description" => $request->get("description"),
                "p_active_yn" => $request->get("active_yn"),
                "p_insert_by" => $request->get("holiday_id") ? $request->get("insert_by"): auth()->id(),
                "p_update_by" => $request->get("holiday_id") ? auth()->id() : '',
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pr_teacher_holiday_setup", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;

    }

    public function remove(Request $request, $id)
    {

        $status =  DB::table('l_holiday_teacher')->where('holiday_id', $id)->delete();
        return response()->json($status);
    }
}
