<?php


namespace App\Http\Controllers\Api\V1\Leave;


use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LLeaveType;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SummeryController extends Controller
{
    protected $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function search(Request $request) {
        $query = 'select leave.emp_leave_summary_list(:leave_type_id, :year, :emp_code ) from dual';
        $list = DB::select($query, ['leave_type_id'=>$request->get('type'), 'year' => $request->get('year'), 'emp_code' => $request->get('emp_code')]);

        return [
            "list" => $list,
            "total" => count($list)
        ];
    }

    /**
     * Get form data action
     *
     * @return array
     */
    public function formData() {
        return [
            "leave_types" => $this->adminManager->findLeaveType(),
            'leave_years' => $this->getYearsRange()
        ];
    }

    /**
     * Get  years range
     *
     * @return array
     */
    private function getYearsRange() {
        $start = 2019;
        $end = 2025;

        $years = array();
        for($i = $start; $i<=$end; $i++) {
            $years[] = ['text'=>$i, 'value' => $i];
        }

        return $years;
    }

}
