@extends('layouts.app')
@section('meta')
    <title>Appointment Details</title>
@endsection
<section class="account-setting dash-cms-cust">
    <div class="container">
        <div class="choose_experts">
            <div class="row">
                <div class="col-md-12">
                    <div class="experts-head text-center">
                        <h3>Appointment Detail</h3>
                    </div>
                </div>
            </div>
            <!------------------------------Review and Rating section------------------------------>
            <div class="row">
                <div class="appt-detail">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-10 ">
                        <div class="in-appts-detail in-app-de">
                            <div class="appt-cust-profile-inner clearfix">
                                <div class="appt-cust-profile-img">
                                    @if($appointment->expert->userInformation->profile_picture !='')
                                        <img src="{{url('public/media/front/img/user/'.$appointment->expert_id.'/'.$appointment->expert->userInformation->profile_picture)}}" alt="customer profile image" class="img-responsive">
                                    @else
                                        <img src="{{url('public/media/front/img/woman-avatar.png')}}" alt="customer profile image" class="img-responsive">
                                    @endif

                                </div>
                                <div class="appt-cust-profile-name app-cu-pn">
                                    <h3>@if(isset($appointment->expert) && $appointment->expert!=''){{$appointment->expert->userInformation->first_name.' '.$appointment->expert->userInformation->last_name}} @endif</h3>
                                </div>
                                 <div class="appt-chat-btns">
                                     
                                        @if($appointment->chat_start=='1' && $appointment->appointment_type=='1' && $appointment->status=='1' )
                                        <a id="create-appointment-channel" href="{{url('/text-chat/'.$appointment->id)}}"  class="appt-cust-btn btn-success ">Chat</a>
                                        @else
                                        <a id="create-appointment-channel" href="{{url('/text-chat/'.$appointment->id)}}"  class="appt-cust-btn isDisabled">Chat</a>
                                        @endif
                                        @if($appointment->appointment_type=='5' && $appointment->status=='1')
                                        <a href="{{url('/video-chat/'.$appointment->id)}}" class="appt-cust-btn btn-success">Video</a>
                                        @endif
                                   </div>
                            </div>

                            <div class="appt-cust-profile-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-6">
                                            <p class="cust-prof-name">Email :</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="xcust-prof-name">@if(isset($appointment->expert->email) && $appointment->expert->email!=''){{$appointment->expert->email}} @endif</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-6">
                                            <p class="cust-prof-name">Mobile Number :</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="xcust-prof-name">@if(isset($appointment->expert) && $appointment->expert!=''){{$appointment->expert->userInformation->user_mobile}} @endif</p>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-6">
                                            <p class="cust-prof-name ">Appointment Status :</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="xcust-prof-name">
                                                @if(isset($appointment->status) && $appointment->status=='0')
                                                    Approval Pending
                                                @elseif($appointment->status=='1')
                                                    Appointment Scheduled
                                                @elseif($appointment->status=='2' && $appointment->message=='Cancelled By Customer')
                                                    Appointment Cancel
                                                @elseif($appointment->status=='2' && $appointment->message=='Rejected')
                                                    Appointment Rejected
                                                @elseif($appointment->status=='3')
                                                    Appointment Completed
                                                @elseif($appointment->status=='4')
                                                    Appointment Rescheduled
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-6">
                                            <p class="cust-prof-name ">Appointment Plan :</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="xcust-prof-name">  @if(isset($appointment->appointmentType)&& $appointment->appointmentType!=''){{$appointment->appointmentType->mode}} @endif </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <p class="cust-prof-name">Description :</p>
                                        </div>
                                        <div class="col-md-9">
                                            <p class="xcust-prof-name xcust-prof-name-detail x-profile">@if(isset($appointment->expert) && $appointment->expert!=''){{$appointment->expert->userInformation->description}} @endif</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="col-md-6">
                                        <div class="col-md-6">
                                            <p class="cust-prof-name">Appointment Date and Time :</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="xcust-prof-name"> <?php echo date('d M Y h:i a',strtotime($appointment->appointment_datetime))?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="appt-cust-detail-btns">
                                <div class="row">
                                    @if($appointment->status!='2' && $appointment->status!='3')
                                        <div class="col-md-4">
                                            <a href="{{url('/my-appointments/reject-appointment/'.$appointment->id)}}" class="appt-cust-btn">Cancel Appointment</a>
                                        </div>
                                        @if($appointment->status==4)
                                            <div class="col-md-6">
                                                <a href="{{url('my-appointments/accept-appointment/'.$appointment->id)}}" class="appt-cust-btn">Accept Reschedule Appointment</a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-md-4">
                                            <a href="{{url('my-appointments')}}" class="appt-cust-btn">Back</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>