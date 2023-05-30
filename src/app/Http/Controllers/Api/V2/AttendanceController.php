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


class AttendanceController extends Controller
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
     * path="/api/attendance",
     * summary="Sign in",
     * description="Login by user, password",
     * operationId="authLogin",
     * tags={"attendance"},
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
    public function attendance(Request $request)
    {
        try {

            $userInfo  = Auth::user();
            $user = $this->authManager->get_user_by_user_id($userInfo->user_id);
            $emp_code = $userInfo->user_name;
            $emp_id = $user->emp_id;
            $department_id = null;
            $year = $request->get('year');
//            $month = $request->get('month');
            $month = $year .'-'.$request->get('month');
            $data = DB::select('select ATTENDANCE.PER_EMP_MONTHLY_ATTEN_DTL(:empId, :month,:department_id) from dual', ['empId' => $emp_id, 'month' => $month, 'department_id' => $department_id]);
//            dd($data);
//            $query = <<<QUERY
//   SELECT TO_CHAR (ROSTER_DATE, 'fmDAY') ROSTER_DAY,
//       CASE WHEN ROSTER_DATE = TRUNC (SYSDATE) THEN 'Y' ELSE 'N' END
//          AS TODAY_YN,
//       TO_CHAR (ROSTER_DATE, 'DD/MM/YYYY') ROSTER_DATE,
//       TO_CHAR (ROSTER_DATE, 'MMYYYY') ROSTER_MONTH_YEAR,
//       TO_CHAR (EA.IN_TIME, 'HH:MI AM') IN_TIME,
//       TO_CHAR (EA.OUT_TIME, 'HH:MI AM') OUT_TIME,
//       CASE
//          WHEN        ea.EMP_CODE IS NOT NULL
//                  AND (ea.HOLIDAY_YN = 'Y' OR ea.HOLIDAY_YN IS NOT NULL)
//                  AND ea.IN_TIME IS NULL
//               OR EA.OUT_TIME IS NULL
//          THEN
//             'HOLIDAY'
//          WHEN TO_CHAR (ea.roster_date, 'fmDY') IN ('SAT', 'FRI')
//          THEN
//             'WEEKLY REST DAY'
//          WHEN     ea.EMP_CODE IS NOT NULL
//               AND (ea.OFF_DAY_YN = 'N' OR ea.OFF_DAY_YN IS NULL)
//               AND (ea.HOLIDAY_YN = 'N' OR ea.HOLIDAY_YN IS NULL)
//               AND (ea.ONLEAVE_YN = 'N' OR ea.ONLEAVE_YN IS NULL)
//               AND ea.IN_TIME IS NOT NULL
//               AND TRIM (TO_CHAR (ea.IN_TIME, 'HH24:MI')) < TO_CHAR ('09:31')
//          THEN
//             'ON TIME'
//          WHEN     (TO_CHAR (ea.roster_date, 'DD-MM-YYYY HH24:MI') <=
//                       TO_CHAR (SYSDATE, 'DD-MM-YYYY HH24:MI'))
//               AND ea.in_time IS NULL
//               AND ea.out_time IS NULL
//          THEN
//             'ABSENT'
//          WHEN     ea.EMP_CODE IS NOT NULL
//               AND (ea.OFF_DAY_YN = 'N' OR ea.OFF_DAY_YN IS NULL)
//               AND (ea.HOLIDAY_YN = 'N' OR ea.HOLIDAY_YN IS NULL)
//               AND (ea.ONLEAVE_YN = 'N' OR ea.ONLEAVE_YN IS NULL)
//               AND ea.IN_TIME IS NOT NULL
//               AND TRIM (TO_CHAR (ea.IN_TIME, 'HH24:MI')) > TO_CHAR ('09:30')
//          THEN
//             'LATE'
//          WHEN     ea.EMP_CODE IS NOT NULL
//               AND (ea.OFF_DAY_YN = 'N' OR ea.OFF_DAY_YN IS NULL)
//               AND (ea.HOLIDAY_YN = 'N' OR ea.HOLIDAY_YN IS NULL)
//               AND (ea.ONLEAVE_YN = 'N' OR ea.ONLEAVE_YN IS NULL)
//               AND ea.IN_TIME IS NULL
//               AND ea.OUT_TIME IS NOT NULL
//          THEN
//             'IN_TIME_NOT_FOUND'
//          WHEN     ea.EMP_CODE IS NOT NULL
//               AND (ea.OFF_DAY_YN = 'N' OR ea.OFF_DAY_YN IS NULL)
//               AND (ea.HOLIDAY_YN = 'N' OR ea.HOLIDAY_YN IS NULL)
//               AND (ea.ONLEAVE_YN = 'N' OR ea.ONLEAVE_YN IS NULL)
//          THEN
//             CASE
//                WHEN TRIM (TO_CHAR (ea.IN_TIME, 'HH24:MI')) <
//                        TO_CHAR ('09:31')
//                THEN
//                   'PRSENT - ON TIME'
//                WHEN TRIM (TO_CHAR (ea.IN_TIME, 'HH24:MI')) >
//                        TO_CHAR ('09:30')
//                THEN
//                   'PRSENT - LATE'
//                WHEN ea.IN_TIME IS NULL AND ea.OUT_TIME IS NOT NULL
//                THEN
//                   'OUT TIME FOUND'
//             END
//          WHEN ONLEAVE_YN = 'Y'
//          THEN
//             'LEAVE'
//          ELSE
//             NULL
//       END
//          status
//  FROM PMIS.EMP_ATTENDANCE EA
// WHERE     EA.EMP_ID = $emp_id
//       AND TO_CHAR (ROSTER_DATE, 'fmMM') = $month
//       AND TO_CHAR (ROSTER_DATE, 'YYYY') = $year
//QUERY;
//            $query = <<<QUERY
//   SELECT TO_CHAR (ROSTER_DATE, 'fmDAY')
//           ROSTER_DAY,
//       ROSTER_DATE,
//       CASE WHEN ROSTER_DATE = TRUNC (SYSDATE) THEN 'Y' ELSE 'N' END
//           AS TODAY_YN,
//       TO_CHAR (ROSTER_DATE, 'DD/MM/YYYY')
//           ROSTER_DATE,
//       TO_CHAR (ROSTER_DATE, 'MMYYYY')
//           ROSTER_MONTH_YEAR,
//       TO_CHAR (EA.IN_TIME, 'HH:MI AM')
//           IN_TIME,
//       TO_CHAR (EA.OUT_TIME, 'HH:MI AM')
//           OUT_TIME,
//       CASE
//           WHEN IN_TIME IS NULL AND OUT_TIME IS NULL THEN 'Absent'
//           ELSE 'Present'
//       END
//           presence
//  FROM PMIS.EMP_ATTENDANCE EA
// WHERE     EA.EMP_ID = $emp_id
//       AND TO_CHAR (ROSTER_DATE, 'fmMM') = $month
//       AND TO_CHAR (ROSTER_DATE, 'YYYY') = $year
//QUERY;
//            dd($query);
//            $data = DB::select($query);


            return response()->json(['success' => true, 'data' => ['attendance' => $data,'emp_code' => $emp_code]], 200);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }


    }

}
