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


class FiscalYearController extends Controller
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
 * @OA\Get(
 * path="/api/fiscal-year",
 * summary="Fiscal year",
 * description="Login by user, password",
 * operationId="authLogin",
 * tags={"fiscalYear"},
 * security={{ "apiAuth": {} }},
 * @OA\Response(
 *    response=422,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
 *        )
 *     )
 * )
 */
    public function fiscal_year(Request $request)
    {
        // $credentials['is_verified'] = 1;

        try {

            /*  $user_id  = $request->get('user_id');

              $user = $this->authManager->get_user_by_user_id($user_id);

              $emp_id = $user->emp_id;*/

            $query = <<<QUERY

  SELECT FY_ID,REPLACE(FY_NAME,'FY','') FY_NAME,CURRENT_YN  FROM PMIS.PR_FISCAL_YEAR

QUERY;

            $data =  DB::select($query);

            return response()->json(['success' => true, 'data' => ['fiscal_year' => $data]], 200);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }


    }


    /**
     * @OA\Post(
     * path="/api/fiscal-year-wise-month",
     * summary="Fiscal year",
     * description="Login by user, password",
     * operationId="fiscalYearWiseMonth",
     * tags={"fiscalYear"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"fiscal_year"},
     *       @OA\Property(property="fiscal_year", type="string", format="fiscal_year", example="2"),
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
    public function fiscal_year_wise_month(Request $request)
    {

        // $credentials['is_verified'] = 1;

        try {
            $fiscal_year  = $request->get('fy_id');
            /*  $user_id  = $request->get('user_id');

              $user = $this->authManager->get_user_by_user_id($user_id);

              $emp_id = $user->emp_id;*/

            $query = <<<QUERY

  SELECT PM.PR_MONTH_ID ,PM.PR_YEAR , TO_CHAR(TO_DATE(PM.PR_MONTH,'MM'),'MONTH') MONTH FROM PMIS.PR_MONTHS  PM
  WHERE FY_ID = $fiscal_year

QUERY;

            $data =  DB::select($query);

            return response()->json(['success' => true, 'data' => ['fiscal_year' => $data]], 200);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }


    }

}
