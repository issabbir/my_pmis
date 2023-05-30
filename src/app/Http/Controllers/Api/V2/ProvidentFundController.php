<?php

namespace App\Http\Controllers\Api\V2;

use App\Contracts\Authorization\AuthContact;
use App\Entities\Loan\LoanApplication;
use App\Entities\Loan\Loans;
use App\Entities\Loan\LoanType;
use App\Entities\Payroll\PrFiscalYear;
use App\Entities\Pmis\Employee\Employee;
use App\Enums\Auth\UserParams;
use App\Enums\YesNoFlag;
use App\Managers\Authorization\AuthorizationManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTFactory;
//use Tymon\JWTAuth\JWTAuth;
use Validator;
use JWTAuth;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;


class ProvidentFundController extends Controller
{
    protected $authManager;

    public function __construct(AuthContact $authManager)
    {
        $this->authManager = $authManager;
    }


    /**
     * @OA\Post(
     * path="/api/employee-provident-fund",
     * summary="Employes frovident fund",
     * description="Login by user, password",
     * operationId="authLogin",
     * tags={"employeeProvidentFund"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"fiscal_year_from","fiscal_year_to","month_from","month_to"},
     *       @OA\Property(property="year_from", type="string", format="year_from", example="2020"),
     *       @OA\Property(property="year_to", type="string", format="emp_id", example="2021"),
     *       @OA\Property(property="month_from", type="string", format="month_from", example="10"),
     *       @OA\Property(property="month_to", type="string", format="month_to", example="1"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function employee_provident_fund(Request $request)
    {

        // $credentials['is_verified'] = 1;

        try {
            $user_id  = Auth::id();

            $user = $this->authManager->get_user_by_user_id($user_id);

            $emp_id = $user->emp_id;

           // $emp_id = '2010300105334300';
           /* $loan = PrFiscalYear::with([])->where('emp_id','=',$emp_id)->first();*/
            $employee = Employee::with([])->where('emp_id', '=',$emp_id)->first();

            $emp_code = $employee->emp_code;

            $empCode = $emp_code;//$request->get('emp_code');
            $gpfId = $emp_id;//$request->get('gpf_id');
            $yearFrom = $request->get('year_from');
            $monthFrom = $request->get('month_from');
            $yearTo = $request->get('year_to');
            $monthTo = $request->get('month_to');
            $query = "select PFPROCESS.EMP_GPF_SUMMARY_DATA(:p1,:p2,:p3,:p4,:p5,:p6) from dual";
            $data =  DB::select($query, ['p1' => $empCode, 'p2' => $gpfId, 'p3' =>$yearFrom, 'p4' => $monthFrom, 'p5' => $yearTo, 'p6'=>$monthTo]);


            return response()->json(['success' => true, 'data' => ['provident_fund' => $data]], 200);

        } catch (\Exception $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }


    }

}
