@extends('layouts.app')
<!-- Main Content -->
@section('content')
<section class="registration_blk fullHt">
    <div class="h-video">
        <video autoplay="" muted="" loop="" controls="">
           <source type="video/mp4" src="http://192.168.2.14/p1116/public/media/front/video/video_1.mp4"></source>
           <source type="video/ogg" src="http://192.168.2.14/p1116/public/media/front/video/video_1.ogg"></source>
           Your browser does not support the video tag.
       </video> 
   </div>
    <div class="login_form forgot_pass">        
        <form class="form_login" role="form" method="POST" action="{{ url('/password/email') }}">
            {!! csrf_field() !!}

            <div class="top_heading">
                Forgot Password
                <span>welcome to <strong>Paras Fashions</strong> Forgot Password form!
                  </span>
            </div>
            <div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                @endif
            </div>
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control"  name="email" placeholder="Enter Email Id" required />
                 @if ($errors->has('email'))
                    <span class="help-block">
                        <p>{{ $errors->first('email') }}</p>
                    </span>
                    @endif
            </div>

            <div class="form-group">
                <button type="submit" class="login_btn send-email-but">Send Password Reset Link</button>
            </div>            
            <p class="create_ac_link text-center"><a href="{{url('/login')}}">Back to Login</a></p>
        </form>        
    </div>
</section>
@endsection
