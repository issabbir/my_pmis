<?php
namespace App\Managers\Authorization;

use App\Contracts\Authorization\AuthContact;
use App\Contracts\MessageContract;
use App\Entities\Security\User;
use App\Entities\Security\UserRole;
use App\Enums\Auth\UserParams;
use App\Mail\SendMail;
use Dotenv\Exception\ValidationException;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/**
 * Class  as a services to maintain some business logic with db operation
 *
 * @package App\Managers\Authorization
 */
class AuthorizationManager implements AuthContact
{

    private $user;
    protected $messageManager;

    public function __construct(MessageContract $messageManager)
    {
        $this->user = new User();
        $this->user->setConnection('cpa_security');
        $this->messageManager = $messageManager;
    }

    public function api_login($params)
    {
        try {
            $fullName = sprintf('%4000s', '');
            $o_user_id = sprintf('%4000s', '');
            $o_status_code = sprintf('%4000s', '');
            $o_need_pass_reset = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');

            $mappedParams = UserParams::bindParams($params);
            $mappedParams['o_user_full_name'] = &$fullName;
            $mappedParams['o_user_id'] = &$o_user_id;
            $mappedParams['o_status_code'] = &$o_status_code;
            $mappedParams['o_need_pass_reset'] = &$o_need_pass_reset;
            $mappedParams['o_status_message'] = &$o_status_message;

            unset($mappedParams['_token']);

            DB::executeProcedure('cpa_security.SECURITY.SEC_USERS_LOGIN', $mappedParams);

            return $mappedParams;
        }
        catch (\Exception $e) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'error' => [$e->getMessage()]
            ]);
            throw $error;
        }
    }


    public function get_user_by_user_id($user_id){
        $user = $this->user->where('user_id', '=', $user_id)->first();
        return $user;
    }



    /**
     * Authorization Login process
     *
     * @return mixed
     */
    public function login($params)
    {
        try {
            $fullName = sprintf('%4000s', '');
            $o_user_id = sprintf('%4000s', '');
            $o_status_code = sprintf('%4000s', '');
            $o_need_pass_reset = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');

            $mappedParams = UserParams::bindParams($params);
            $mappedParams['o_user_full_name'] = &$fullName;
            $mappedParams['o_user_id'] = &$o_user_id;
            $mappedParams['o_status_code'] = &$o_status_code;
            $mappedParams['o_need_pass_reset'] = &$o_need_pass_reset;
            $mappedParams['o_status_message'] = &$o_status_message;

            DB::executeProcedure('cpa_security.SECURITY.SEC_USERS_LOGIN', $mappedParams);

            if ($mappedParams['o_status_code'] == 1) {
                $this->user = $this->user->where('user_id', '=', $mappedParams['o_user_id'])->first();
                if ($this->user && $this->user->user_id) {
                    Auth::login($this->user);

                    if ($this->user->need_pass_reset == 'Y')
                        return Redirect::to("/user/change-password");
                    if($this->user->hasRole('CPA_CHAIRMAN'))
                        return Redirect::to("/cdb");

                    return Redirect::to("/dashboard");
                }
            }
            $validator = \Illuminate\Support\Facades\Validator::make([], []);
            $validator->getMessageBag()->add('error', $mappedParams['o_status_message']);
            return Redirect::back()->withErrors($validator)->withInput();
        }
        catch (\Exception $e) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'error' => [$e->getMessage()]
            ]);
            throw $error;
        }
    }



    public function forget_password($requests)
    {
        try{
              $user=User::where('email',$requests['email'])->with('employee')
                ->first();
              if($user){
                  $random_password = Str::random(10);
                  $status_code = sprintf('%4000s', '');
                  $status_message = sprintf('%4000s', '');
                  $params = [
                      "p_USER_ID" =>$user->user_id,
                      "p_NEW_PASSWORD" =>  $random_password,
                      "o_status_code" => &$status_code,
                      "o_status_message" => &$status_message,
                  ];
                  DB::executeProcedure('cpa_security.SECURITY.user_reset_password', $params);

                  $data = [
                      'title' => 'Forget Password',
                      'subject ' => 'Forget Password',
                      'body' => 'Your temporary password is '.$random_password,
                      'receiver_name' => isset($user->employee)?$user->employee->emp_name:'',
                      'email' => $requests['email']
                  ];
                  $obj = new  SendMail($data, 'Forget Password');
                  $mail = $this->messageManager->sendMail($obj, $requests['email']);

                  if ($mail &&  $params['o_status_code'] == 1) {

                      $message = ['status' => true, 'message' => 'Successfully send Email'];
                  } else {
                      $message = ['status' => false, 'message' => 'Failed to send email, please try again.'];
                  }
              }else{

                  $message = ['status' => false, 'message' => 'This email is not found!.'];
              }

        }catch (\Exception $e){
            $message = ['status' => false, 'message' =>$e->getMessage()];
        }
        return $message;
    }


    /**Authorization Login process
     *
     * @return mixed
     */
    public function logout()
    {
        // TODO: Implement logout() method.
    }

    /**
     * Recovering password
     *
     * @return mixed
     */
    public function recoverPassword()
    {
        // TODO: Implement recoverPassword() method.
    }

    /**
     * Make active an user
     *
     * @param $userId
     * @return mixed
     */
    public function makeActive($userId)
    {
        // TODO: Implement makeActive() method.
    }

    /**
     * Make deactivate an user
     *
     * @param $uerId
     * @return mixed
     */
    public function makeDeactivate($uerId)
    {
        // TODO: Implement makeDeactivate() method.
    }
}
