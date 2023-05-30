<?php

namespace App\Http\Controllers\Api\V1\Admin\General;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LBranch;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /** @var AdminContract|AdminManager */
    protected $adminManager;

    /**
     * BasicInfoController constructor.
     * @param AdminContract $adminContract
     */
    public function __construct(AdminContract $adminContract)
    {
        $this->adminManager = $adminContract;
    }
    public function index(Request $request)
    {
        return [
            "branches" => $this->adminManager->findBranches()
        ];
    }


    public function view(Request $request, $id)
    {
        $data = LBranch::find($id);
        return [
            "branch" => $data
        ];
    }
    public function store(Request $request){
        try {
            LBranch::create([
                'branch_name' => strtoupper($request->input('branch_name')),
                'branch_name_bng' => strtoupper($request->input('branch_name_bng')),
                'routing_no' => strtoupper($request->input('routing_no')),
                'bank_id' => $request->input('bank_id'),
                'branch_address' => strtoupper($request->input('branch_address')),
                'geo_district_id' => $request->input('geo_district_id'),
                'geo_district' => strtoupper($request->input('geo_district')),
                'geo_thana_id' => $request->input('geo_thana_id'),
                'geo_thana' => strtoupper($request->input('geo_thana')),
                'post_code' => strtoupper($request->input('post_code')),
                'insert_date' => new \DateTime(),
                'insert_by' => Auth::id(),
            ]);
            return ['status_code' => '1','o_status_message' => 'Successfully Inserted'];
        }catch (\Exception $exception){
            return ['status_code' => '99','o_status_message' => $exception->getMessage()];
        }

    }
    public function update(Request $request, $id) {
        try {
        LBranch::where('branch_id',  $id)
            ->update([
                'branch_name' => strtoupper($request->input('branch_name')),
                'branch_name_bng' => $request->input('branch_name_bng'),
                'bank_id' => $request->input('bank_id'),
                'routing_no' => strtoupper($request->input('routing_no')),
                'branch_address' => strtoupper($request->input('branch_address')),
                'geo_district_id' => $request->input('geo_district_id'),
                'geo_district' => strtoupper($request->input('geo_district')),
                'geo_thana_id' => $request->input('geo_thana_id'),
                'geo_thana' => strtoupper($request->input('geo_thana')),
                'post_code' => strtoupper($request->input('post_code')),
                'update_date' => new \DateTime(),
                'update_by' => Auth::id(),
            ]);
            return ['status_code' => '1','o_status_message' => 'Successfully Updated'];
        }catch (\Exception $exception){
            return ['status_code' => '99','o_status_message' => $exception->getMessage()];
        }
    }

    public function remove($id){
        try {
         LBranch::destroy($id);
      //  dd($status);
            return ['status_code' => '1','o_status_message'=>'Successfully Deleted'];
        }catch (\Exception $exception){
            return ['status_code' => '99','o_status_message' => 'Something went wrong'];
        }

    }
}
