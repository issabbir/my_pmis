<?php


namespace App\Http\Controllers\Api\V1\Admin\Biller;

use App\Entities\Admin\PrProcessUsers;
use App\Contracts\Admin\AdminContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillerController extends Controller
{
    protected $adminManager;

    public function __construct(AdminContract $adminManager) {
        $this->adminManager = $adminManager;
    }
    public function index(Request $request)
    {
        $PrProcessUsers = new PrProcessUsers();
        if ($request->get('filter') != 'null') {
            $PrProcessUsers = $PrProcessUsers
                ->where('bill_code', 'like', "%".$request->get('filter')."%")
                ->orWhereHas('employee', function($q) use ($request) {
                    if ($request->get('filter')) {
                        $q->where('employee.emp_code','=',$request->get('filter'))
                            ->orWhere(DB::raw('LOWER(employee.emp_name)'),'like',strtolower('%'.trim($request->get('filter')).'%'));
                    }
                });
        }
        $PrProcessUsers = $PrProcessUsers->paginate($request->get('size'));
        return [
            'records' => $PrProcessUsers
        ];
    }

    public function specific(Request $request, $id)
    {
        $PrProcessUsers = new PrProcessUsers();
        $PrProcessUsers = $PrProcessUsers->find($id);
        $PrProcessUsers->employee;
        return [
            "data" => $PrProcessUsers
        ];
    }

    public function save(Request $request){
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_emp_id" => $request->get("emp_id"),
                "p_bill_code" => $request->get("bill_code"),
                "p_insert_by" => auth()->id(),
                "p_active_yn" => $request->get("active_yn"),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            //dd($params);
            DB::executeProcedure("payroll.pr_process_user_entry", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }
}
