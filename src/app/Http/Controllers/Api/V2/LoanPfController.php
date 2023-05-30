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


class LoanPfController extends Controller
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
     * path="/api/loan-pf-loan-type",
     * summary="Long type",
     * description="Login by user, password",
     * operationId="authLogin",
     * tags={"lonnPf"},
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
    public function loan_type(Request $request)
    {
        // $credentials['is_verified'] = 1;

        try {

            /*  $user_id  = $request->get('user_id');

              $user = $this->authManager->get_user_by_user_id($user_id);

              $emp_id = $user->emp_id;*/

            $query = <<<QUERY

  SELECT LOAN_TYPE_ID,LOAN_NAME FROM PMIS.LOAN_TYPE

QUERY;

            $data = DB::select($query);

            return response()->json(['success' => true, 'data' => ['loan_types' => $data]], 200);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }


    }


    /**
     * @OA\Get(
     * path="/api/loans",
     * summary="Loans",
     * description="Login by user, password",
     * operationId="loans",
     * tags={"lonnPf"},
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
    public function loans(Request $request)
    {
        // $credentials['is_verified'] = 1;

        try {

            $user_id  = Auth::id();

              $user = $this->authManager->get_user_by_user_id($user_id);

              $emp_id = $user->emp_id;
            //  $emp_id = 2010300108329439;

            $query = <<<QUERY

   SELECT LOAN_ID, EMP_ID, LOAN_NO
  FROM PMIS.LOANS
 WHERE EMP_ID = $emp_id

QUERY;

            $data = DB::select($query);

            return response()->json(['success' => true, 'data' => ['loans' => $data]], 200);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }


    }





}
