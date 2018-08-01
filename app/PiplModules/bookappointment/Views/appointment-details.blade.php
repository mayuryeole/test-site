@extends('layouts.app')
@section('meta')
    <title>Appointment Details</title>
@endsection
<input type="hidden" id="login-name" value="{{ $username }}">
<input type="hidden" id="create-channel-display-name" value="{{ $appointmentName }}"/>
<input type="hidden" id="create-channel-unique-name" value="{{ $appointmentName }}"/>
<input type="hidden" id="create-channel-desc" value="{{ $appointmentName }}"/>
<input type="hidden" id="current_appointment_id" value="{{ $appointment->id }}"/>

{{--<input type="checkbox" id="create-channel-private" value="1"/>--}}

<section class="account-setting dash-cms-cust">
    <div class="container">
        <div class="choose_experts">
            <div class="row">
                <div class="col-md-12">
                    <div class="experts-head text-center manage-bottm-head">
                        <!-- <h3>Appointment Detail</h3> -->
                    </div>
                </div>
            </div>
            <!------------------------------Review and Rating section------------------------------>
            <div class="row">
                <div class="appt-detail">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-10">
                        <div class="in-appts-detail apt-de">
                            <div class="appt-cust-profile-inner clearfix">
                                <div class="appt-cust-profile-img">
                                    @if($appointment->customer->userInformation->gender=='1')
                                        <img src="{{url('public/media/front/img/male-user.png')}}" alt="customer profile image" class="img-responsive">
                                    @else
                                        <img src="{{url('public/media/front/img/woman-avatar.png')}}" alt="customer profile image" class="img-responsive">
                                    @endif
                                </div>
                                <div class="appt-cust-profile-name app-cu-pn">
                                    <h3>@if(isset($appointment->customer) && $appointment->customer!=''){{$appointment->customer->userInformation->first_name.' '.$appointment->customer->userInformation->last_name}} @endif</h3>
                                </div>
                                <div class="appt-chat-btns">
                                       
                                        {{--<a href="{{url('/text-chat/'.$appointment->id)}}" class="appt-cust-btn btn-success">Start Chat</a>--}}
                                        @if($appointment->is_appointment_enable=='Active' && $appointment->appointment_type=='1')
                                        {{--<a id="create-appointment-channel" href="{{url('/text-chat/'.$appointment->id)}}"  class="appt-cust-btn btn-success ">Chat</a>--}}
                                        <button id="create-appointment-channel" type="button" class="appt-cust-btn btn-success ">Chat</button>
                                        @else
                                        {{--<a id="create-appointment-channel" href="{{url('/text-chat/'.$appointment->id)}}"  class="appt-cust-btn isDisabled">Chat</a>--}}
                                        <button id="create-appointment-channel" type="button" class="appt-cust-btn isDisabled">Chat</button>
                                        @endif
                                        @if($appointment->appointment_type=='5')
                                        <a href="{{url('/video-chat/'.$appointment->id)}}" class="appt-cust-btn btn-success">Video</a>
                                        @endif
                                   </div>
                            </div>

                            <div class="appt-cust-profile-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-5 col-sm-4 col-xs-4">
                                            <p class="cust-prof-name">Email :</p>
                                        </div>
                                        <div class="col-md-7 col-sm-8 col-xs-8">
                                            <p class="xcust-prof-name">@if(isset($appointment->customer->email) && $appointment->customer->email!=''){{$appointment->customer->email}} @endif</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-6 col-sm-5 col-xs-5">
                                            <p class="cust-prof-name ">Mobile Number :</p>
                                        </div>
                                        <div class="col-md-6 col-sm-7 col-xs-7">
                                            <p class="xcust-prof-name aptd">@if(isset($appointment->customer) && $appointment->customer!=''){{$appointment->customer->userInformation->user_mobile}} @endif</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-5 col-sm-4 col-xs-4">
                                            <p class="cust-prof-name ">Plan :</p>

                                        </div>
                                        <div class="col-md-7 col-sm-8 col-xs-8">
                                            <p class="xcust-prof-name">  @if(isset($appointment->appointmentType)&& $appointment->appointmentType!=''){{$appointment->appointmentType->mode}} @endif </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-6 col-sm-4 col-xs-4">
                                            <p class="cust-prof-name ">Status :</p>
                                        </div>
                                        <div class="col-md-6 col-sm-8 col-xs-8">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-3 col-sm-5 col-xs-5">
                                            <p class="cust-prof-name">Date and Time :</p>
                                        </div>
                                        <div class="col-md-9 col-sm-7 col-xs-7">
                                            <p class="xcust-prof-name apt-da-ti aptd"> <?php echo date('d M Y h:i a',strtotime($appointment->appointment_datetime))?></p>
                                            <input type="hidden" id="app_id" value="{{$appointment->id}}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-2 col-sm-3 col-xs-4">
                                            <p class="cust-prof-name">Description :</p>
                                        </div>
                                        <div class="col-md-10 col-sm-9 col-xs-8">
                                            <p class="xcust-prof-name xcust-prof-name-detail aptd">@if(isset($appointment->customer) && $appointment->customer!=''){{$appointment->customer->userInformation->description}} @endif</p>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div class="appt-cust-detail-btns">
                                <div class="row">
                                    @if($appointment->status!='2' && $appointment->status!='3' && $appointment->expired!='true')
                                        <div class="col-md-4">
                                            <a href="{{url('/my-appointments/reject-appointment/'.$appointment->id)}}" class="appt-cust-btn">Reject Appointment</a>
                                        </div>
                                        @if($appointment->status!='1' && $appointment->status!='4')
                                            <div class="col-md-4">
                                                <a href="{{url('my-appointments/accept-appointment/'.$appointment->id)}}" class="appt-cust-btn">Schedule Appointment</a>
                                            </div>
                                        @endif
                                        <div class="col-md-4">
                                            <a href="{{url('my-appointments/reschedule-appointment/'.$appointment->id)}}" class="appt-cust-btn">Reschedule Appointment</a>
                                        </div>
                                    @else
                                        <div class="col-md-4">
                                            <a href="{{url('service-provider/appointments-list')}}" class="appt-cust-btn">Back</a>
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
@section('footer')
    <script src="{{ url('/') }}/public/media/front/js/twilio-chat/vendor/fingerprint2.js"></script>
    <script src="{{ url('/') }}/public/media/front/js/twilio-chat/vendor/superagent.js"></script>

    <script src="https://media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
    <script src="https://media.twiliocdn.com/sdk/js/chat/v1.0/twilio-chat.min.js"></script>

    {{--<script src="https://apis.google.com/js/platform.js" async defer></script>--}}
    <script src="https://apis.google.com/js/platform.js" ></script>
    <script type="text/javascript" src="{{ url('/') }}/public/media/front/js/twilio-chat/md5.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/public/media/front/js/twilio-chat/index.js"></script>
    
    <script>
       
       /* (function(seconds) {
            var refresh,       
                intvrefresh = function() {
                    alert("Hello");
                    var appointment= $("#app_id").val();
                    clearInterval(refresh);
                    refresh = setTimeout(function() {
                      $.ajax({
                            url: '{{url( "/check-appointment-time" )}}',
                            data: {'appointment_id': appointment},
                            dataType: "html",
                            success: function(res) {

                                if(res=='Active')
                                {
                                    $('#create-appointment-channel').removeClass('isDisabled');  
                                    $('#create-appointment-channel').addClass('btn-success');  
                                } else {
                                     $('#create-appointment-channel').addClass('isDisabled');
                                }
                        }
                    });
                    }, seconds * 1000);
                };

            $(document).on('keypress click', function() { intvrefresh() });
            intvrefresh();

        }(10));*/
        
        function checkAptTime(){
            var appointment= $("#app_id").val();
                    $.ajax({
                            url: '{{url( "/check-appointment-time" )}}',
                            data: {'appointment_id': appointment},
                            dataType: "html",
                            success: function(res) {

                                if(res=='Active')
                                {
                                    $('#create-appointment-channel').removeClass('isDisabled');  
                                    $('#create-appointment-channel').addClass('btn-success');  
                                } else {
                                     $('#create-appointment-channel').addClass('isDisabled');
                                }
                        }
                    });
        }
        (function(){
        // do some stuff
            setInterval(checkAptTime, 5000);
        })();
    </script>    
@endsection