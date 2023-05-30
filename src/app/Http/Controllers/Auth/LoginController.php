<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Authorization\AuthContact;
use App\Http\Controllers\Controller;
use App\Managers\Authorization\AuthorizationManager;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/pmis';

    /**
     * @var AuthContact|AuthorizationManager
     */
    protected $authManager;

    /**
     * Create a new controller instance.
     * @param AuthorizationManager|AuthContact $authManager
     * @return void
     */
    public function __construct(AuthContact $authManager)
    {
        $this->authManager = $authManager;

        $this->middleware('guest')->except('logout');
    }

    /**
     * Authorization action
     *
     * @param Request $request
     * @return mixed
     */
    public function authorization(Request $request) {
        return $this->authManager->login($request->all());
    }

    /**
     * forget password action
     *
     * @param Request $request
     * @return mixed
     */
    public function forget_password(Request $request) {

        $request->validate([
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
        ]);
        $response=$this->authManager->forget_password($request->all());
        if($response['status']){
            Session::flash('success',$response['message']);
            return Redirect::back();
        }else{
            Session::flash('fail',$response['message']);
            return Redirect::back();
        }

    }

    /**
     * Logout action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request) {

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_user_id" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("cpa_security.security.sec_users_logout", $params);
            if($params['o_status_code'] == 1)
                Auth::logout();
            return redirect('/');
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_message" => $e->getMessage()];
        }

    }
}
