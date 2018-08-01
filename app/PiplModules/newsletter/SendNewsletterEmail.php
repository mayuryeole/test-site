<?php

namespace App\PiplModules\newsletter;

use App\PiplModules\newsletter\Models\Subscriber;
use App\PiplModules\newsletter\Models\Newsletter;
use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use GlobalValues;

class SendNewsletterEmail extends Job implements SelfHandling, ShouldQueue {

    use InteractsWithQueue,
        SerializesModels;

    protected $subscribers, $newsletter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Newsletter $newsletter, $subscribers) {
        $this->subscribers = explode(",", $subscribers);
        $this->newsletter = $newsletter;
//        dd($this->newsletter);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer) {
        $site_email = GlobalValues::get('site-email');
        $site_title = GlobalValues::get('site-title');



        foreach ($this->subscribers as $index => $subscriber) {
//            $str = "";
           // $fileData = file_get_contents(__DIR__ . '/Views/' . $this->newsletter->id . '.blade.php');
           // $fileData = str_replace('replace-user', base64_encode($subscriber), $fileData);
//            $mail = new \Illuminate\Mail\Mailer();
//            $mail->setMessage($fileData);
            $subject = $this->newsletter->subject;
            $unsubcribelink = url('/').'/admin/unsubscribe-user/'.base64_encode($subscriber);
            $mailer->queue('newsletter::' . $this->newsletter->id, array('email' => $subscriber,'replace_user'=>$unsubcribelink), function ($m) use ($subscriber, $subject,$site_email, $site_title) {
                $m->from($site_email, $site_title);
                $m->to($subscriber)->subject($subject);
            });
        }
        return "true";
    }

}
