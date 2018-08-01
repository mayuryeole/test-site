@extends('layouts.app')

@section('meta')
    <title>Update Email</title>
@endsection

@section('content')
<!----------------------------------------------------Dashboard Section Start------------------------------------------------------>
<section class="dashboard-blk fullHt">
    <div class="burger-menu">
        <span class="dash_line"></span>
    </div>
    <div style="margin-top:30px" class="right-panel">
        
        <div class="dashboard-area">
           
            <div class="profiler_information">
                <form class="profiler_info_form" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                    <div class="row form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-2 col-sm-4"><label>E-Mail Address: </label></div>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                            <input type="email" class="form-control" required name="email" value="{{ $email or old('email')}}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>
                    <div class="row form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-2 col-sm-4"><label>Password: </label></div>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                          	<input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>            
                    <div class="row form-group form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <div class="col-md-2 col-sm-4"><label>Confirm Password:</div>
                        <div class="col-md-6 col-sm-6 col-xs-8">
                             <input type="password" class="form-control" name="password_confirmation">
								@if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                        </div>
                </div>     
                <div class="row form-group">
                <div class="col-md-12 col-sm-9 col-xs-12 col-md-offset-2">
                    <button type="submit" class="edit_profile_button">Reset Password</button>
                </div>
                </div>
               </form>
            </div>
        </div> <!--End of Dashboard Area-->
    </div>
</section>
@endsection