<?php

namespace App\Http\Controllers\Api\V2;

use App\Contracts\Authorization\AuthContact;
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


class GpfController extends Controller
{

    /**
     * @var AuthContact|AuthorizationManager
     */
    protected $authManager;

    public function __construct(AuthContact $authManager)
    {
        $this->authManager = $authManager;
        //   $this->middleware('guest')->except('logout');
    }


    /**
     * @OA\Post(
     * path="/api/gpf-summary",
     * summary="Long type",
     * description="Login by user, password",
     * operationId="authLogin",
     * tags={"gpfSummary"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"fiscal_year_from","fiscal_year_to","month_from","month_to"},
     *       @OA\Property(property="fiscal_year_from", type="string", format="emp_id", example="2"),
     *       @OA\Property(property="fiscal_year_to", type="string", format="emp_id", example="2"),
     *       @OA\Property(property="month_from", type="string", format="emp_id", example="3"),
     *       @OA\Property(property="month_to", type="string", format="emp_id", example="4"),
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
    public function gpf_summary(Request $request)
    {
        // $credentials['is_verified'] = 1;

        try {

             $user_id  = Auth::id();

              $user = $this->authManager->get_user_by_user_id($user_id);

              $emp_id = $user->emp_id;
            $employee = Employee::with([])->where('emp_id', '=',$emp_id)->first();

            $emp_code = $employee->emp_code;


            $query = "select emp_gpf_summary_data_pmis(:p1) from dual";


            $gpf_summary_data=DB::selectOne($query,['p1' => $emp_code]);

            if(isset($gpf_summary_data)){
                $gpf_summary_data->employee = $employee;
            }

            return response()->json(['success' => true, 'data' => ['gpf_summary' => $gpf_summary_data]], 200);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }


    }





}
