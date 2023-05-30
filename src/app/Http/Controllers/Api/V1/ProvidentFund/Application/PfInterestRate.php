<?php


namespace App\Http\Controllers\Api\V1\ProvidentFund\Application;

use App\Entities\Pf\GpfInterestRate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PfInterestRate extends Controller
{

    public function store(Request $request)
    {

        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_gpf_interest_rate_id" => $request->get("gpf_interest_rate_id"),
                "p_active_date_from" => empty($request->get("active_date_from"))?'':date("Y-m-d", strtotime($request->get("active_date_from"))),
                "p_active_date_end" => empty($request->get("active_date_end"))?'':date("Y-m-d", strtotime($request->get("active_date_end"))),
                "p_interest_rate" => $request->get("interest_rate"),
                "p_active_yn" => $request->get("active_yn"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pfprocess.gpf_interest_rate_define", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function get(Request $request) {
        $gpf_interest=new GpfInterestRate();
        return $gpf_interest->get();
    }

    public function put(Request $request) {
        return $this->store($request);
    }





}
