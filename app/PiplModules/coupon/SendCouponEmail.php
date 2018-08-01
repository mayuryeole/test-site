<?php

namespace App\PiplModules\coupon;

use App\User;
use App\PiplModules\coupon\Models\Coupon;

use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use GlobalValues;
use App\PiplModules\emailtemplate\Models\EmailTemplate;


class SendCouponEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $users,$coupon,$userInfo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Coupon $coupon,$users,$userInfo)
    {
        $this->users = $users;
        $this->coupon = $coupon;
        $this->userInfo =$userInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
      //dd(333);
        $site_email=GlobalValues::get('site-email');
        $site_title=GlobalValues::get('site-title');
            $user = $this->users;
            $user_information = $this->userInfo;
            $the_coupon = $this->coupon;

            $status = $mailer->queue("emailtemplate::user-coupon",array('FIRST_NAME'=>$user_information->first_name,'LAST_NAME'=>$user_information->last_name,'COUPON_CODE'=>$the_coupon->coupon_code,'VALID_FROM'=>$the_coupon->coupon_valid_from,'VALID_TO'=>$the_coupon->coupon_valid_from),function ($m) use ($user,$user_information,$the_coupon,$site_email,$site_title ) {
                $m->from($site_email, $site_title);
                $m->to($user)->subject($the_coupon->name);
            });

            if(!$status == 0){
                   return false;
            }
        return true;
    }
}
