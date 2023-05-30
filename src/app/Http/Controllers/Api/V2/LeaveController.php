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


class LeaveController extends Controller
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
     * path="/api/leave",
     * summary="Sign in",
     * description="Login by user, password",
     * operationId="authLogin",
     * tags={"leave"},
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
    public function leave(Request $request)
    {
        // $credentials['is_verified'] = 1;

        try {

            $user_id  = Auth::id();

            $user = $this->authManager->get_user_by_user_id($user_id);

            $emp_id = $user->emp_id;
            $leave_query = <<<QUERY
SELECT LEAVE_DAYS, LEAVE_ENJOY, (LEAVE_DAYS - LEAVE_ENJOY) AS LEAVE_REMAINING
  FROM (SELECT NVL ( (SELECT SUM (LEAVE_DAYS)
                        FROM PMIS.EMP_LEAVE EL
                       WHERE EMP_ID = $emp_id),
                    0)
                  LEAVE_DAYS,
               NVL ( (SELECT SUM (LEAVE_ENJOY)
                        FROM PMIS.EMP_LEAVE_SUMMARY EL
                       WHERE EMP_ID = $emp_id),
                    0)
                  LEAVE_ENJOY
          FROM DUAL)
QUERY;
 //$emp_id

            $leave_data =  DB::select($leave_query);

            $leave_enjoy_query = <<<QUERY

SELECT EL.EMP_ID,
       EL.APPLICATION_DATE,
       EL.APPROVE_DATE,
       EL.LEAVE_START_DATE,
       EL.LEAVE_END_DATE,
       EL.LEAVE_DAYS,
       EL.LEAVE_STATUS,
       INITCAP (LT.LEAVE_TYPE) LEAVE_TYPE
  FROM PMIS.EMP_LEAVE EL
       INNER JOIN PMIS.L_LEAVE_TYPE LT ON LT.LEAVE_TYPE_ID = EL.LEAVE_TYPE_ID
 WHERE EMP_ID =  $emp_id


QUERY;
            //$emp_id

            $leave_enjoy_data =  DB::select($leave_enjoy_query);

            $leave_remaining_query = <<<QUERY

 SELECT ELS.EMP_ID,
       ELS.LEAVE_ENJOY,
       ELS.REMAINING_BALANCE,
       INITCAP (LT.LEAVE_TYPE) LEAVE_TYPE
  FROM PMIS.EMP_LEAVE_SUMMARY ELS
       INNER JOIN PMIS.L_LEAVE_TYPE LT
          ON LT.LEAVE_TYPE_ID = ELS.LEAVE_TYPE_ID
 WHERE ELS.EMP_ID  =  $emp_id

QUERY;
            //$emp_id

            $leave_remaining_data =  DB::select($leave_remaining_query);



            return response()->json(['success' => true, 'data' => ['leave' => $leave_data ,'leave_enjoy' => $leave_enjoy_data , 'leave_remaining'=>$leave_remaining_data]], 200);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }


    }

}
