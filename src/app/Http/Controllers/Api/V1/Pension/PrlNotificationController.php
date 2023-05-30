<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Contracts\Admin\AdminContract;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class PrlNotificationController extends Controller
{

    public function searchPrlNotification(Request $request){

        if($request->get("prl_date")!=null){
            $prl_date= date('Y-m-d', strtotime($request->get('prl_date')));
        }else{
            $prl_date="";
        }

        $sql = "select pension.pension_notification_list(:department_id,:emp_id,:prl_date) from dual";

        return DB::select($sql, ['department_id' => $request->get('department_id'),
                                'emp_id' =>$request->get('emp_id'),
                                'prl_date' =>$prl_date]);
    }

    public function sendPlainMail(Request $request)
    {
            $from='cnsrokan@gmail.com';
            $body=$request->get('message_body');
            $sub=$request->get('subject');
            $files = '';
            $to=$request->get('email');
            $cc = explode(';', $request->get('cc_mail'));
            //$cc=['eleash83@gmail.com','hasan@co.cnsbd.com','iliachh@co.cnsbd.com','eleash83@yahoo.com'];
            Mail::raw($body, function ($message) use ($from, $sub, $to,$cc, $files) {
                $message->subject($sub);
                $message->from($from); //$from = ‘rakon@gmail.com’, $sender=’rakon'
                $message->to($to); //$to = ['test1@email.com','test2']
               // $message->attachData($data, 'prlNotice.pdf');
            if ($cc) {
                foreach ($cc as $i){
                    $message->cc($i); //$cc = ['test1@email.com','test2']
                }

            }
//            if ($bcc) {
//                $message->bcc($bcc); //$bcc = ['test1@email.com','test2']
//            }
                if ($files) {
                    $message->attach($files);
//                foreach ($files as $file) { //$files = ['http://google.com/test.doc', ‘http://tese.com/kjdfksdf.pdf’]
//
//                }
                }
            });
            if($to==null){
                $erromsg='Sorry! receiver email address not found';
                return ["o_status_code" => 99, "message" =>$erromsg];
            }else{
                DB::table('employee')
                    ->where('emp_id', $request->get('emp_id'))
                    ->update(['prl_sent_email_yn' => "Y"]);
                $successmsg='Email send successfully to the '.$to;
                return ["o_status_code" => 1, "message" =>$successmsg];
            }


    }

    public function automaticSendMail(){
        $from = env('MAIL_FROM');
        $list = DB::select("select pension.pension_notification_auto() from dual");
        if(count($list)>0){
            foreach ($list as $employee){
                $body = $employee->message;
                $sub = $employee->notification_subject;
                $files = [];
                $to = $employee->email;
                $cc = explode(';', $employee->cc_mail);
                $bcc = explode(';', $employee->bcc_mail);
                Mail::raw($body, function ($message) use ($from, $sub, $to, $cc, $files, $bcc) {
                    $message->subject($sub);
                    $message->from($from);
                    $message->to($to);
                    if ($bcc){
                        foreach ($bcc as $i){
                            $message->bcc($i);
                        }
                    }
                    if ($cc) {
                        foreach ($cc as $i){
                            $message->cc($i);
                        }
                    }
                    if ($files) {
                        foreach ($files as $i){
                            $message->attach($i);
                        }
                    }
                });


                try {
                    $status_code = sprintf("%4000s","");
                    $status_message = sprintf("%4000s","");
                    $params = [
                        "p_notification_id" => null,
                        "p_emp_id"=>$employee->emp_id,
                        "p_notification_subject" => $sub,
                        "p_message" => $body,
                        "p_notify_from" => $from,
                        "p_notify_to" => $to,
                        "p_cc_to" => $employee->cc_mail,
                        "p_bcc_to" => $employee->bcc_mail,
                        "p_auto_send_yn" => 'N',
                        "p_insert_by" => Auth::id(),
                        "o_status_code" => &$status_code,
                        "o_status_message" => &$status_message,
                    ];
                    DB::executeProcedure("PENSION.pension_emp_notification", $params);
                }
                catch (\Exception $e) {
                    return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
                }



                if($to == null){
                    $erromsg = 'Sorry! receiver email address not found';
                    return ["o_status_code" => 99, "message" =>$erromsg];
                }else{
                    $successmsg = 'Email send successfully to the '.$to;
                    return ["o_status_code" => 1, "message" =>$successmsg];
                }
            }
        } else {
            $erromsg = 'Sorry! there is no receiver.';
            return ["o_status_code" => 99, "message" =>$erromsg];
        }

    }

}
