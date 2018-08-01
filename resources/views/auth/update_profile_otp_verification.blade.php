@extends('layouts.app')

@section('meta')
<title>User Login</title>
@endsection

@section('content')
<section class="login_blk fullHt" style="background-image: url({{ url('/') }}/public/media/front/img/1.png);">
    <div class="login_form otp_verification">
        <div class="row">           
            <div class="col-md-12 col-sm-12 col-xs-12">

                @if (session('otp-error'))
                <div class="alert alert-danger">
                    {{ session('otp-error') }}
                    <a class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                @endif


                @if (session('verification-success'))
                <div class="alert alert-success">
                    {{ session('verification-success') }}
                    <a href="#" style="background-color: white" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>              
                @endif
                <?php
                Session::forget("verification-success");
                Session::forget("otp-error");
                ?>
                <form class="form_login" role="form" method="POST" >
                    {!! csrf_field() !!}
                    <div class="loger_img"><img src="{{ url('public/media/front/img/man-white.png')}}" alt="Image"/></div>
                    <div class="top_heading">Mobile Number Verification</div>
                    <div class="form-group">
                        
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <div class="form-group{{ $errors->has('otp') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" placeholder="Enter Verification Code" name="otp"  required />
                            @if ($errors->has('otp'))
                            <span class="help-block">
                                <p>{{ $errors->first('otp') }}</p>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="check-otp" id="check-otp" class="login_btn">Verify</button>
                    </div>
                    <p class="create_ac_link restnd_opt text-center">
                        <a href="{{url('get-user/update_resend-otp')}}/{{ $user_id }}">Resend OTP</a>
                    </p>
                    <!--<p class="create_ac_link text-center back_otp_btn"><a href="{{url('back')}}/{{$user_id}}"><i class="fa fa-backward"></i> Back</a></p>-->
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
