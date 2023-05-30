<?php

namespace App\Http\Controllers\SendMail;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function sendPlainMail($to)
    {
        $from='cnsrokan@gmail.com';
        $body='Please collected your PRL Notice ';
        $sub='PRL Notice';
        $files = '';
        Mail::raw($body, function ($message) use ($from, $sub, $to, $files) {
            $message->subject($sub);
            $message->from($from); //$from = ‘rakon@gmail.com’, $sender=’rakon'
            $message->to($to); //$to = ['test1@email.com','test2']
//            if ($cc) {
//                $message->cc($cc); //$cc = ['test1@email.com','test2']
//            }
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
        echo('PRL Notice is sending to this mail :'.$to);

    }
}
