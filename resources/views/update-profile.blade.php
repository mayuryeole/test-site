@extends('layouts.app')

@section('meta')
<title>User Profile</title>
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
            @if (session('profile-updated'))
            <div class="alert alert-success">
                {{ session('profile-updated') }}
                <a style="color: black" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            </div>
            @endif
            
            @if (session('password-update-success'))
            <div class="alert alert-success">
                {{ session('password-update-success') }}
                <a style="color: black" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            </div>
            @endif
            <div class="profiler_information">

                <form class="profiler_info_form" name="update_profile" id="update_profile" role="form" method="POST" action="{{ url('/update-profile-post') }}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id" value="{{$user_info->id}}">
                    <div class="row form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <div class="col-md-2 col-sm-3"><label>First Name: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" name="first_name" value="{{old('first_name',$user_info->userInformation->first_name)}}">
                            @if ($errors->has('first_name'))
                            <span class="help-block">
                                <p>{{ $errors->first('first_name') }}</p>
                            </span>
                            @endif
                        </div>
                    </div>

                   
                    <div class="row form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <div class="col-md-2 col-sm-3"><label>Last Name: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" name="last_name" value="{{old('last_name',$user_info->userInformation->last_name)}}">
                            @if ($errors->has('last_name'))
                            <span class="help-block">
                                <p>{{ $errors->first('last_name') }}</p>
                            </span>
                            @endif
                        </div>
                    </div>                        
                    <div class="row form-group{{ $errors->has('user_mobile') ? ' has-error' : '' }}">
                        <div class="col-md-2 col-sm-3"><label>Mobile: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" name="user_mobile" value="{{old('user_mobile',$user_info->userInformation->user_mobile)}}">
                            @if ($errors->has('user_mobile'))
                            <span class="help-block">
                                <p>{{ $errors->first('user_mobile') }}</p>
                            </span>
                            @endif
                        </div>
                    </div>             
                    <div class="row form-group">
                        <div style="display: inline-block" class="col-md-12 col-sm-9 col-xs-12 col-md-offset-2">
                            <button type="submit" class="edit_profile_button">Update Profile</button>

                        </div>
                    </div>  

                </form>

            </div>
        </div> <!--End of Dashboard Area-->
    </div>
</section>
@endsection