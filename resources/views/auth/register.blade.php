@extends('layouts.app')

@section('meta')
<title>User Registration</title>
@endsection

@section('content')
<!-------------------------------------------------------REGISTRATION START------------------------------------------------------>
<section class="registration_blk fullHt">
	<div class="h-video">
         <video controls="false" loop autoplay>
            <source src="{{url('/public/media/front/video/video_1.mp4')}}" type="video/mp4">
            <source src="{{url('/public/media/front/video/video_1.ogg')}}" type="video/ogg">
            Your browser does not support the video tag.
        </video> 
    </div>
    <div class="container login_form">
        <form class="form_login" name="register_normal" id="register_normal" role="form" method="POST" action="{{ url('/register') }}">
            {!! csrf_field() !!}
            <input type='hidden' name='user_type' id='user_type' value="{{ $user_type }}">
            <input  type='hidden' name='country_flag' id='country_flag' value="{{ $flag }}">
            <div class="top_heading">
                Sign Up
                <span>welcome to <strong>Paras Fashions</strong> sign-up form! <br />
                    Please fill in these boxes so we can get started...</span>
        
                <span style="font-style: italic">If you already have an account?<a href="{{url('/login')}}">Click Here!</a></span>
            </div>
            @if (session('otp-error'))
            <div class="alert alert-danger">
                {{ session('otp-error') }}
                <a class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            </div>
            @endif
            <div class="form-group">
                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" />
                    @if ($errors->has('first_name'))
                    <span class="help-block">
                        <p>{{ $errors->first('first_name') }}</p>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" />
                    @if ($errors->has('last_name'))
                    <span class="help-block">
                        <p>{{ $errors->first('last_name') }}</p>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group relative manage-stat stat-msg-manage {{ $errors->has('email') ? ' has-error' : '' }}">
                <input title="Verification will be sent on this email. This will be used as your Username." type="email" class="form-control" placeholder="Enter Email Id" id="email" name="email" value="{{ old('email') }}" />
                
                @if ($errors->has('email'))
                <span class="help-block">
                    <p>{{ $errors->first('email') }}</p>
                </span>
                @endif
            </div>
            <div class="form-group relative manage-stat stat-msg-manage {{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" title="Password should contain at least 6 characters." id="password" name="password" class="form-control" placeholder="Enter Password"  />
                <label class="show_pass"><input type="checkbox" onchange="document.getElementById('password').type = this.checked ? 'text' : 'password'"> <i class="fa fa-eye"></i></label>
                @if ($errors->has('password'))
                <span class="help-block">
                    <p>{{ $errors->first('password') }}</p>
                </span>
                @endif
            </div>
            <div class="form-group relative manage-stat stat-msg-manage{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" title="Click on eye-image to see your entered password." class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"/>
                <label class="show_pass"><input type="checkbox" onchange="document.getElementById('password_confirmation').type = this.checked ? 'text' : 'password'"> <i class="fa fa-eye"></i></label>
               @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <p>{{ $errors->first('password_confirmation') }}</p>
                </span>
                @endif

                
            </div>
{{--<!--                <div class="form-group relative">--}}
                    {{--<div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">--}}
                        {{--<select class="form-control" name="gender" id="gender">--}}
                            {{--<option value="" >Select Gender</option>--}}
                            {{--<option value="1"  @if (old("gender") === "1") selected @endif>Male</option>--}}
                            {{--<option value="2" @if (old("gender") === "2") selected @endif>Female</option>--}}
                        {{--</select>--}}
                        {{--@if ($errors->has('gender'))--}}
                        {{--<span class="help-block">--}}
                            {{--<p>{{ $errors->first('gender') }}</p>--}}
                        {{--</span>--}}
                        {{--@endif--}}
                        {{--<span class="drop_icon"><i class="fa fa-angle-down"></i></span>--}}
                    {{--</div>--}}
                {{--</div>-->--}}
                <div class="form-group relative">
                    <div class="form-group{{ $errors->has('user_country') ? ' has-error' : '' }}">
                        <?php $countries = App\PiplModules\admin\Models\Country::all(); ?>
                        <select name="user_country" id="user_country" class="form-control">
                        <!--<select name="user_country" id="user_country" class="form-control" >-->

                            <option value="">Select Your Location</option> 
                            @foreach($countries as $country)
                            <option value="{{$country->id}}" @if(old('country')==$country->id) selected @endif>{{$country->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('user_country'))
                        <span class="help-block">
                            <p>{{ $errors->first('user_country') }}</p>
                        </span>
                        @endif
                        <span class="drop_icon"><i class="fa fa-angle-down"></i></span>
                    </div>
                </div>

                <div class="form-group relative">
                    <div class="form-group {{ $errors->has('user_mobile') ? ' has-error' : '' }}">
                        <input type="tel" title="OTP will be sent on this mobile number for Verification (India only)." class="form-control" placeholder="Enter Mobile No." id="user_mobile" name="user_mobile" value="{{old('user_mobile')}}" />
                        @if ($errors->has('user_mobile'))
                        <span class="help-block">
                            <p>{{ $errors->first('user_mobile') }}</p>
                        </span>
                        @endif
                        <span style="color:orange;font-size: 14px;display:none; " id="no_mobile" name="no_mobile" >Please enter mobile number</span>
                    </div>
                </div>

                @if($user_type ==4)
                <div class="business_user_fild">
                    <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                        <input type="text" name="company_name" class="form-control" placeholder="Company Name" value="{{ old('company_name') }}" />
                        @if ($errors->has('company_name'))
                        <span class="help-block">
                            <p>{{ $errors->first('company_name') }}</p>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('company_type') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" name="company_type" placeholder="Company Type" value="{{ old('company_type') }}" />
                        @if ($errors->has('company_type'))
                        <span class="help-block">
                            <p>{{ $errors->first('company_type') }}</p>
                        </span>
                        @endif
                    </div>
                    
                    <div class="form-group{{ $errors->has('addressline1') ? ' has-error' : '' }}">
                        <input type="text" name="addressline1" class="form-control" placeholder="Address Line 1" value="{{ old('addressline1') }}" />
                        @if ($errors->has('addressline1'))
                        <span class="help-block">
                            <p>{{ $errors->first('addressline1') }}</p>
                        </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('addressline2') ? ' has-error' : '' }}">
                        <input type="text" name="addressline2" class="form-control" placeholder="Address Line 2" value="{{ old('addressline2') }}" />
                        @if ($errors->has('addressline2'))
                        <span class="help-block">
                            <p>{{ $errors->first('addressline2') }}</p>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('pancard_no') ? ' has-error' : '' }}">
                        <input type="text" name="pancard_no" class="form-control" placeholder="Pan Card No" value="{{ old('pancard_no') }}" />
                        @if ($errors->has('pancard_no'))
                        <span class="help-block">
                            <p>{{ $errors->first('pancard_no') }}</p>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('gst_no') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" name="gst_no" placeholder="GST No" value="{{ old('gst_no') }}" />
                        @if ($errors->has('gst_no'))
                        <span class="help-block">
                            <p>{{ $errors->first('gst_no') }}</p>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('tax_id') ? ' has-error' : '' }}">
                        <input type="text" name="tax_id" class="form-control" placeholder="Tax Id" value="{{ old('tax_id') }}" />
                        @if ($errors->has('tax_id'))
                        <span class="help-block">
                            <p>{{ $errors->first('tax_id') }}</p>
                        </span>
                        @endif
                    </div>
                </div>
                @endif
                <button type="submit" class="login_btn" id="btn_register">
                    Register
                </button>
                <img id="btn_loader" style="display:none;" src="{{url('public/media/front/images/loader.gif')}}">
                </form> 
    </div>
    {{--<div class="registration_images_block">--}}
        {{--<ul class="text-center">--}}
            {{--<li><img src="{{ url('/') }}/public/media/front/img/icon1.png" alt="image"/></li>                        --}}
            {{--<li><img src="{{ url('/') }}/public/media/front/img/icon2.jpg" alt="image"/></li>--}}
            {{--<li><img src="{{ url('/') }}/public/media/front/img/icon4.jpg" alt="image"/></li>--}}
            {{--<li><img src="{{ url('/') }}/public/media/front/img/icon4.png" alt="image"/></li>--}}
            {{--<li><img src="{{ url('/') }}/public/media/front/img/icon3.jpg" alt="image"/></li>                        --}}
        {{--</ul>--}}
    {{--</div>      --}}
</section>

<script>
    
    function validateMobile(id)
    {
        
    }
</script>    
@endsection
    