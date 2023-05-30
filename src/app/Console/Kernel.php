<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $this->automaticSendMail();
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


    public function automaticSendMail(){
        $from = 'mehedihasan.al.bd@gmail.com';
        $list = DB::select("select pension.pension_notification_auto() from dual");
        foreach ($list as $employee){
            $body = $employee->message;
            $sub = $employee->notification_subject;
            $files = [];
            $to = 'mehedihasan.al.bd@gmail.com';
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
                    "p_auto_send_yn" => 'Y',
                    "p_insert_by" => '',
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
    }
}
