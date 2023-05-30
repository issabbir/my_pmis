<?php

namespace App\Http\Controllers\Api\V1\Payroll;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Payroll\PayrollContract;
use App\Entities\Payroll\PrBonusSetup;
use App\Entities\Payroll\PrSalaryHeads;
use App\Entities\Pmis\Employee\EmpFamily;
use App\Entities\Pmis\Employee\EmpFamilyTemp;
use App\Entities\Payroll\PrMonths;
use App\Entities\Payroll\PrSalarySetup;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class BonusSetupController extends Controller
{
    private $payrollManager;

    public function __construct(PayrollContract $payrollManager)
    {
        $this->payrollManager = $payrollManager;
    }

    public function index(Request $request)
    {
        $PrBonusSetup = new PrBonusSetup();
//        if ($request->get('filter') != 'null') {
//            $PrProcessUsers = $PrProcessUsers
//                ->where('bonus_effective_date', 'like', "%".$request->get('filter')."%")
//                ->orWhereHas('salary_heads', function($q) use ($request) {
//                    if ($request->get('filter')) {
//                        $q->where('salary_heads.salary_head','=',$request->get('filter'))
//                            ->orWhere(DB::raw('LOWER(salary_heads.salary_head)'),'like',strtolower('%'.trim($request->get('filter')).'%'));
//                    }
//                });
//        }
//        $PrBonusSetup = $PrProcessUsers->orderBy('bonus_effective_date','DESC')->paginate($request->get('size'));
        return [
            "bonus_data" => $PrBonusSetup->orderBy('bonus_effective_date','DESC')->get(),
        ];
    }

    public function store(Request $request)
    {
        try {
            $bonus_setup_id = $request->get('bonus_setup_id') ? $request->get('bonus_setup_id') : '';
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $params = [
                'p_bonus_setup_id' => $bonus_setup_id,
                'p_salary_head_id' => $request->get('salary_head_id'),
                'p_pr_month_id' => $request->get('pr_month_id'),
                'p_bonus_effective_date' => $request->get('bonus_effective_date'),
                'p_active_yn' => $request->get('active_yn'),
                'p_insert_by' => Auth::id(),
                'p_update_by' => Auth::id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];
          //  dd($params);
            DB::executeProcedure("PAYROLL.pr_bonus_date_setup_entry", $params);
            return $params;
         }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'o_status_code' => 0, 'o_status_message' => $e->getMessage()];
        }

    }


    public function remove($id,$month_id, Request $request)
    {
      try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_pr_month_id" => $month_id,
                "p_salary_head_id" => $id,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PAYROLL.delete_salary_setup", $params);
        }
        catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }



}
