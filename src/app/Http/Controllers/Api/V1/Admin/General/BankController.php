<?php

namespace App\Http\Controllers\Api\V1\Admin\General;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\HrDepartment;
use App\Entities\Admin\HrDivision;
use App\Entities\Admin\LBank;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use DB;

class BankController extends Controller
{
    /**
     * @var AdminContract
     */
    private $adminManager;

    public function __construct(AdminContract $adminManager)
    {
         $this->adminManager = $adminManager;
     }

    public function index(Request $request)
    {
        return $this->getInitData();
    }

    public function view(Request $request, $id)
    {

    }

    public function store(Request $request)
    {
        try {
            $bank = new LBank();
            $bank->bank_name = strtoupper($request->get('bank_name'));
            $bank->bank_name_bng = strtoupper($request->get('bank_name_bng'));
            $bank->bank_code = strtoupper($request->get('bank_code'));
            $bank->bank_logo = $request->get('bank_logo');
            $result = $bank->save();

            return response()->json($result, 200);
        }catch (Exception $e) {
            return response()->json('The bank is already exist!');
        }
    }

    public function update(Request $request,$id)
    {
        try {
            $bank = LBank::find($id);
            $bank->bank_name = strtoupper($request->get('bank_name'));
            $bank->bank_name_bng = strtoupper($request->get('bank_name_bng'));
            $bank->bank_code = strtoupper($request->get('bank_code'));
            $bank->bank_logo = $request->get('bank_logo');
            $result = $bank->save();
            return response()->json($result, 200);

        }catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function remove($id)
    {
        $bank = LBank::find($id);
        $result = $bank->delete();
        return response()->json($result, 200);
    }
    private function getInitData() {
        return [
                 "banks" => $this->adminManager->findBanks()
                ];
    }
}
