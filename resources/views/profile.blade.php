@extends('layouts.app')

@section('meta')
    <title>User Profile</title>
@endsection

@section('content')
<!----------------------------------------------------Dashboard Section Start------------------------------------------------------>
<section class="dashboard-blk fullHt">
    <!-- <div class="burger-menu">
        <span class="dash_line"></span>
    </div> -->

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
                <a style="color: black" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                @endif
               @if (session('profile-updated'))
               <div class="alert alert-success">
                {{ session('profile-updated') }}
                <a style="color: black" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                @endif
                @if (session('profile-updated-failure'))
               <div class="alert alert-danger">
                {{ session('profile-updated-failure') }}
                <a style="color: black" href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
                @endif
                <?php
                  Session::forget("password-update-success");
                  Session::forget("password-update-failure");
                  Session::forget("profile-updated");
                  ?>
                  
              
            <div class="profiler_information">
                <div class="profiler_info_form">
                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3"><label>First Name: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" value="{{$user_info->userInformation->first_name}}" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3"><label>Last Name: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" value="{{$user_info->userInformation->last_name}}" />
                        </div>
                    </div>                    
                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3"><label>Email: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="email" class="form-control" value="{{$user_info->email}}" />
                        </div>
                    </div>     
                    <div class="row form-group">
                        <div class="col-md-2 col-sm-3"><label>Mobile No: </label></div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="tel" class="form-control" disabled="" value="{{$user_info->userInformation->user_mobile}}" />
                        </div>
                    </div>                        
                    
                        
                </div>
                <div class="row form-group">
                <div style="display: inline-block" class="col-sm-12 col-xs-12 col-md-offset-2">
                            <a href="{{url('update-profile')}}"><button type="button" class="edit_profile_button">Edit Profile</button></a>
                            <a href="{{url('change-email')}}"><button type="button" class="edit_profile_button">Change Email</button></a>
                            <a  href="{{url('change-password')}}"><button type="button" class="edit_profile_button">Change Password</button></a>
                </div>
                </div>
            </div>
        </div> <!--End of Dashboard Area-->
    </div>
</section>
@endsection