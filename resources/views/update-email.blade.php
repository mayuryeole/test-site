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

    <div style="margin-top:30px" class="right-panel release-positions">
        <div style="margin-left:50px;margin-right:50px" class="cust-breadcrumbs">
            <ul>
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a></li>
                <li><i class="fa fa-dashboard"></i>&nbsp;<a href="{{url('/profile')}}">Dashboard</a></li>
                
            </ul>
        </div>
        <div class="dashboard-area">
            <div class="dashboard_content">
                <div class="dash_heading"><span><i class="fa fa-user"></i> Profile Information</span></div>
                
            </div>
             @if (session('password-update-success'))
               <div class="alert alert-success">
                {{ session('password-update-success') }}
                </div>
                @endif
               @if (session('profile-updated'))
               <div class="alert alert-success">
                {{ session('profile-updated') }}
                </div>
                @endif
            <div class="profiler_information">
              
                    <form class="profiler_info_form" name="update_email" id="update_email" role="form" method="POST" action="{{ url('/change-email-post') }}">
                        {!! csrf_field() !!}
                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3"><label>Your current Email: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text"  name="old_email"class="form-control" value="{{$user_info->email}}" />
                      </div>
                    </div>
                    <div class="row form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-2 col-sm-3"><label>New Email:</label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" id="email" name="email" class="form-control" value="{{old('email')}}" />
                            @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>                    
                    <div class="row form-group {{ $errors->has('confirm_email') ? ' has-error' : '' }}">
                        <div class="col-md-2 col-sm-3"><label>Confirm Email: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="email" class="form-control" id="confirm_email" name="confirm_email" value="{{old('confirm_email')}}"/>
                             @if ($errors->has('confirm_email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('confirm_email') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div>     
                                         
                    <div class="row form-group">
                <div class="col-sm-9 col-xs-12 col-md-offset-2">
                    <button type="submit" class="edit_profile_button">Update Email</button>
                            
                </div>
                </div>
                        
                </form>
                
            </div>
        </div> <!--End of Dashboard Area-->
    </div>
</section>
@endsection