<?php

namespace App\Http\Controllers\Api\V2;

use App\Contracts\Authorization\AuthContact;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmpNominee;
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


class NomineeController extends Controller
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
     * path="/api/nominee",
     * summary="All nominee of the employee",
     * description="Login by user, password",
     * operationId="authLogin",
     * tags={"nominee"},
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
    public function nominee(Request $request)
    {
        // $credentials['is_verified'] = 1;

        try {

            $user_id  = Auth::id();

            $user = $this->authManager->get_user_by_user_id($user_id);

            $emp_id = $user->emp_id;

            $query = <<<QUERY

 SELECT ROWNUM
           AS "index",
       EN.NOMINEE_NAME,
       EN.NOMINEE_EMAIL,
       NOMINEE_CONTACT_NO,
       (SELECT RELATION_TYPE
          FROM L_RELATION_TYPE RT
         WHERE RT.RELATION_TYPE_ID = EN.RELATIONSHIP_ID)
           RELATION_TYPE_NAME,
       EN.PERCENTAGE,
       EN.NOMINEE_ID,
       En.nominee_photo,
       NF.NOMINEE_FOR_NAME
  FROM EMP_NOMINEE EN
   JOIN L_NOMINEE_FOR NF ON NF.NOMINEE_FOR_ID = EN.NOMINEE_FOR_ID
   LEFT JOIN PMIS.EMPLOYEE E on EN.EMP_ID = E.EMP_ID
    WHERE EN.EMP_ID = $emp_id
    ORDER BY NF.NOMINEE_FOR_NAME ASC

QUERY;


            $data =  DB::select($query);

            if(isset($data) && count($data)){

                foreach ($data as $nominee) {
                    $nominee_photo = $nominee->nominee_photo;

                    if (isset($nominee_photo) && $nominee_photo !="") {
                        $nominee->nominee_photo_link = route('nominee-photo-link', ["id" => $nominee->nominee_id]);
                    } else {
                        $nominee->nominee_photo_link = null;
                    }
                    unset($nominee->nominee_photo);
                }
            }



            return response()->json(['success' => true, 'data' => ['nominee' => $data]], 200);

        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }


    }

    public function nominee_photo_link(Request $request, $id)
    {
        $emp_nominee = EmpNominee::with([])->where('nominee_id', '=', $id)->first();


        if(isset($emp_nominee)  && isset($emp_nominee->nominee_photo) && $emp_nominee->nominee_photo != ""){
            $nominee_photo_name = $emp_nominee->nominee_id;
            $nominee_photo = $emp_nominee->nominee_photo;


            $path = public_path($nominee_photo_name);
            $offset = strpos($nominee_photo, ',');
            $contents = base64_decode(substr($nominee_photo, $offset));

            file_put_contents($path, $contents);


            return response()->download($path)->deleteFileAfterSend(true);
        }




    }


}
