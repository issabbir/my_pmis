<?php


namespace App\Http\Controllers\Api\V1\Leave;


use App\Entities\Admin\LHolidayTeacher;
use App\Entities\Pmis\Employee\EmpAcademicHolidayDuty;
use App\Helper\HelperClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpAcademicHolidayDutyController extends Controller
{
    public function index(Request $request)
    {
        $duty = EmpAcademicHolidayDuty::orderByDesc('duty_start_date')->get();
        foreach ($duty as $key=>$value){
            $duty_start_date = date("Y-m-d", strtotime($value->duty_start_date));
            $duty_end_date = date("Y-m-d", strtotime($value->duty_end_date));
            $duty[$key]->total_count  = HelperClass::dateDiffInDays($duty_start_date, $duty_end_date) + 1;
        }
        return response()->json($duty);
    }

    public function store(Request $request)
    {
        $duty_start_date = date("Y-m-d", strtotime($request->get("duty_start_date")));
        $duty_end_date = date("Y-m-d", strtotime($request->get("duty_end_date")));
        $total_duty = HelperClass::dateDiffInDays($duty_start_date, $duty_end_date) + 1;
      // dd($duty_end_date);
       $holiday = LHolidayTeacher::where('date_from','<=',$duty_start_date)->where('date_to','>=',$duty_end_date)->where('active_yn','Y')->first();
      // dd($holiday);

        if (!filled($holiday)){
            return response()->json(['status'=>false,'message'=>'Date not exits on holiday for date '.$duty_start_date. ' to ' .$duty_end_date], 200);
        }

        $existingDuty = EmpAcademicHolidayDuty::where('emp_id', $request->get('emp_id'))
            ->where('emp_code', $request->get('emp_code'))
            ->where('duty_start_date','<=', $duty_start_date)
            ->where('duty_end_date','>=', $duty_end_date)->first();

        if (filled($existingDuty)){
            return response()->json(['status'=>false,'message'=>'Already exits given date '.$duty_start_date. ' to ' .$duty_end_date], 200);
        }

        if($existingDuty != null){
            $existingDuty->emp_id = $request->get('emp_id');
            $existingDuty->emp_code = $request->get('emp_code');
            $existingDuty->duty_start_date = $duty_start_date;
            $existingDuty->duty_end_date = $duty_end_date;
            $existingDuty->total_duty = $total_duty;
            $existingDuty->remarks = $request->get('remarks');
            $existingDuty->update_by = Auth::id();
            $existingDuty->update_date = new \DateTime();
            $existingDuty->office_order = $request->get('office_order');
            $result = $existingDuty->save();
            return response()->json($result, 200);
        }else{
            $duty = new EmpAcademicHolidayDuty;
            $duty->emp_id = $request->get('emp_id');
            $duty->emp_code = $request->get('emp_code');
            $duty->duty_start_date = $duty_start_date;
            $duty->duty_end_date = $duty_end_date;
            $duty->total_duty = $total_duty;
            $duty->remarks = $request->get('remarks');
            $duty->insert_by = Auth::id();
            $duty->insert_date = new \DateTime();
            $duty->office_order = $request->get('office_order');
            $new_result = $duty->save();
            return response()->json($new_result, 200);
        }
    }

    public function approve(Request $request){
        $duty_start_date = date("Y-m-d", strtotime($request->get("duty_start_date")));
        $duty_end_date = date("Y-m-d", strtotime($request->get("duty_end_date")));

        $existingDuty = EmpAcademicHolidayDuty::where('emp_id', $request->get('emp_id'))
            ->where('emp_code', $request->get('emp_code'))
            ->where('duty_start_date', $duty_start_date)
            ->where('duty_end_date', $duty_end_date)->first();

        if($existingDuty != null){
            $existingDuty->approve_yn = 'Y';
            $existingDuty->approve_by = Auth::id();
            $existingDuty->approve_date = new \DateTime();
            $result = $existingDuty->save();
            return response()->json($result, 200);
        }
    }

    public function remove($emp_id, $emp_code, $duty_start_date, $duty_end_date)
    {
        $status =  DB::table('emp_academic_holiday_duty')
            ->where('emp_id', $emp_id)
            ->where('emp_code', $emp_code)
            ->where('duty_start_date', $duty_start_date)
            ->where('duty_end_date', $duty_end_date)
            ->delete();
        return response()->json($status);
    }

    public function allTeachers(){
        $sql = "SELECT emp_id, emp_code, emp_code || ' ' || emp_name AS option_name
    FROM pmis.employee_temp
   WHERE academic_yn = 'Y'
ORDER BY emp_code";
        return DB::select($sql);
    }
}
