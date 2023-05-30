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


class AuthController extends Controller
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
     * path="/api/login",
     * summary="Sign in",
     * description="Login by user, password",
     * operationId="authLogin",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"user_name","user_pass"},
     *       @OA\Property(property="user_name", type="string", format="user_name", example="033333"),
     *       @OA\Property(property="user_pass", type="string", format="password", example="a123456!A"),
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
    public function login(Request $request)
    {
        $credentials = $request->only('user_name', 'user_pass');

        $rules = [
            'user_name' => 'required',
            'user_pass' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 401);
        }

        // $credentials['is_verified'] = 1;

        try {
            $login = array();
            $login['_token'] = "";
            $login['p_user_name'] = $credentials['user_name'];
            $login['p_user_pass'] = $credentials['user_pass'];
            $mappedParams = $this->authManager->api_login($login);


            if ($mappedParams['o_status_code'] != 1) {
                /*$this->user = $this->user->where('user_id', '=', $mappedParams['o_user_id'])->first();
                if ($this->user && $this->user->user_id) {
                    Auth::login($this->user);
                    if ($this->user->need_pass_reset == YesNoFlag::YES)
                        return Redirect::to("/user/change-password");

                    return Redirect::to("/dashboard");
                }*/

                return response()->json(['success' => false, 'error' => $mappedParams['o_status_message']], 500);
            }


            $payload = JWTFactory::sub($mappedParams['o_user_id'])
                //->myCustomString('Foo Bar')
                //->myCustomArray(['Apples', 'Oranges'])
                //  ->myCustomObject($user)
                ->make();

            $token = JWTAuth::encode($payload);
            //$token = JWTAuth::attempt($credentials);

            // attempt to verify the credentials and create a token for the user
            if (!$token) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 404);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }

        $user_id = $mappedParams['o_user_id'];

        $user = $this->authManager->get_user_by_user_id($user_id);


        $emp_id = $user->emp_id;

/*        $query = <<<QUERY

SELECT E.* ,

(SELECT DEPARTMENT_NAME FROM  PMIS.L_DEPARTMENT D WHERE D.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID) DEPARTMENT_NAME,

(SELECT DESIGNATION FROM  PMIS.L_DESIGNATION D WHERE D.DESIGNATION_ID = E.DESIGNATION_ID) DESIGNATION,

(SELECT DPT_DIVISION_NAME FROM  PMIS.L_DPT_DIVISION D WHERE D.DPT_DIVISION_ID = E.DPT_DIVISION_ID) DIVISION_NAME


FROM PMIS.EMPLOYEE E

WHERE EMP_ID = $emp_id

QUERY;*/

        $employee = Employee::with("emp_status","grade","charge_designation")->where('emp_id', '=', $user->emp_id)->first();

       // $employee = DB::select($query);

       // $employee =  DB::table('employee')->with("empStatus")->first();

        $emp_photo = $employee->emp_photo;

        if($emp_photo){
            $employee->emp_photo_link = route('emp-photo-link',["id" =>$employee->emp_id]);
        }else{
            $employee->emp_photo_link = null;
        }

        /*$employee->menu_names = array(
            "0" => "Basic Info",
            "1" => "Payroll",
            "2" => "PF info",
        );*/

        $menu_names = new \stdClass();
        $menu_names->basic_info = "Basic Info";
        $menu_names->payroll = "Payroll";
        $menu_names->pf_info = "PF info";

        $employee->menu_names = $menu_names;


        unset($employee->emp_photo);

        // all good so return the token
        return response()->json(['success' => true, 'data' => ['token' => $token->get(), 'user' => $employee]], 200);
    }

    public function emp_photo_link(Request $request, $id)
    {
        $employee = Employee::with([])->where('emp_id', '=', $id)->first();



        $emp_photo_name = $employee->emp_photo_name;
        $emp_photo = $employee->emp_photo;

        if ($emp_photo) {
            $path = public_path($emp_photo_name);
            $offset = strpos($emp_photo, ',');
            $contents = base64_decode(substr($emp_photo, $offset));

//store file temporarily
            file_put_contents($path, $contents);

//download file and delete it
            return response()->download($path)->deleteFileAfterSend(true);

        }else{
            $path = public_path($emp_photo_name);
            //$file = Storage::get('public/assets/', 'place_holder.png');

            $imagedata = file_get_contents("assets/place_holder.png");

            return response()->file($imagedata);
            /*// alternatively specify an URL, if PHP settings allow
            $base64 = base64_encode($imagedata);

           // $place_holder_base64="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";
            $contents = base64_decode($base64);

//store file temporarily
            file_put_contents($path, $contents);

//download file and delete it
            return response()->download($path)->deleteFileAfterSend(true);*/

        }
        /*
        $result = DB::table('file_info')
            ->where('file_info_id', '=', $id)
            ->select(array('file_name', 'file_type', 'file_content'))
            ->first();
        $path = public_path($result->file_name);
        $contents = base64_decode($result->file_content);

//store file temporarily
        file_put_contents($path, $contents);

//download file and delete it
        return response()->download($path)->deleteFileAfterSend(true);*/
    }

    /**
     * @OA\Get(
     * path="/api/logout",
     * summary="Log out",
     * description="Logout by user, password",
     * operationId="authLogout",
     * tags={"auth"},
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

    public function logout(Request $request)
    {
        $token = $request->headers->get('authorization');
        // $this->validate($request, ['token' => 'required']);

        try {
            JWTAuth::invalidate($token);
            return response()->json(['success' => true, 'message' => "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }
}
