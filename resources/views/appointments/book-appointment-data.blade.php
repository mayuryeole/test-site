@extends('layouts.app')

@section('meta')
    <title>Mode Of Contact</title>
@endsection
@section('header')
    <style type="text/css">
        .account-setting{
            height: 830px !important;
        }
    </style>
@endsection
<section class="account-setting">
    <div class="container">
        <div class="choose_experts">
            <div class="row">
                <div class="col-md-12">
                    <div class="experts-head text-center">
                        <h3>Review Your Booking</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                            when an unknown printer took a galley of type and scrambled it to make a type
                            specimen book</p>
                    </div>
                </div>
            </div>
            <!-----------------------------Review Booking--------------------------------------->
            <div class="row">
                <div class="reviwe-booking">
                    <div class="col-md-1 col-sm-1">

                    </div>
                    <div class="col-md-5 col-sm-5">
                        <div class="appoint-detail">
                            <h3 class="text-center">Your Appointment Details</h3>
                            <div class="ap-detail">
                                <div class="row ex-rw">
                                    <div class="col-md-3 col-sm-2 col-xs-2">
                                        <div class="ex-txt">
                                            <p>Experts</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <div class="ex-coln">
                                            <p>:</p>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                        <div class="ex-best">
                                            <p>{{ $expertData->userInformation->first_name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ex-rw">
                                    <div class="col-md-3 col-sm-2 col-xs-2">
                                        <div class="ex-txt">
                                            <p>Date</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <div class="ex-coln">
                                            <p>:</p>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                        <div class="ex-best">
                                            <p>{{ date("d M Y", strtotime($selectedDatetime->booking_datetime)) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ex-rw">
                                    <div class="col-md-3 col-sm-2  col-xs-2">
                                        <div class="ex-txt">
                                            <p>Time</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <div class="ex-coln">
                                            <p>:</p>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                        <div class="ex-best">
                                            <p>{{ date("h:i a", strtotime($selectedDatetime->booking_datetime)) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ex-rw">
                                    <div class="col-md-3 col-sm-2 col-xs-2">
                                        <div class="ex-txt">
                                            <p>Type</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <div class="ex-coln">
                                            <p>:</p>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                        <div class="ex-best">
                                            <p>{{ isset($selectedMode) ? $selectedMode->mode : "N/A" }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-2 col-xs-2">
                                        <div class="ex-txt">
                                            <p>Charges</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <div class="ex-coln">
                                            <p>:</p>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                        <div class="ex-best">
                                            <p>{!! isset($selectedMode) ? "<i class='fa fa-rupee'></i>".$selectedMode->amount : "N/A" !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5">
                        <div class="appoint-details">
                            <h3 class="text-center apt">Please Provide Your Contact Information</h3>
                            <p class="text-center aptm">So we can update you on the status of the appointment
                            </p>
                            <div class="ap-detail">
                                <div class="apt-form">
                                    <form id="frm_make_appointment_payment" name="frm_make_appointment_payment" method="post" action="{{ action('BookingController@bookAppointment') }}" >
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="expert_id" @if(isset($expertData->id)&& $expertData->id!='')value="{{ $expertData->id }}" @else value="" @endif>
                                        <input type="hidden" name="datetime_id"@if(isset($selectedDatetime->id)&& $selectedDatetime->id!='')value="{{ $selectedDatetime->id}}" @else value="" @endif >
                                        <input type="hidden" name="mode_id" @if(isset( $selectedMode->id )&&  $selectedMode->id !='')value="{{  $selectedMode->id  }}" @else value="" @endif >
                                        <div class="apt-fr form-group">
                                            <input type="tel" placeholder="Phone Number" class="form-control apt-frm" name="customer_phone" value="{{ isset(\Auth::user()->userInformation->user_mobile) ? \Auth::user()->userInformation->user_mobile : "" }}"/>
                                            <span>Enter Your Phone Number</span>
                                        </div>
                                        <div class="apt-fr form-group">
                                            <input type="email" placeholder="Email Id" class="form-control apt-frm" name="customer_email" value="{{ isset(\Auth::user()->email) ? \Auth::user()->email : "" }}">
                                            <span>Important communication will be sent here</span>
                                        </div>
                                        <div class="apt-fr form-group">
                                            <input type="text" placeholder="Username" class="form-control apt-frm" name="customer_name" value="{{ isset(\Auth::user()->userInformation->first_name) ? \Auth::user()->userInformation->first_name." ".\Auth::user()->userInformation->last_name : "" }}">
                                            <span>If you are a new User, we will create an account for you.</span>
                                        </div>
                                        <div class="apt-fr text-center">
                                            <button type="submit" class="continue_payment" id="btn_make_appointment">Continue To Payment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@section('footer')
    <script src="{{ url('/') }}/public/media/front/js/appointment/moment.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js"></script>
    <script src="{{ url('/') }}/public/media/front/js/availability/availability.js"></script>
@endsection
