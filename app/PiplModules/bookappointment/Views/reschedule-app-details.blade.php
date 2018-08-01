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
                            <h3 class="text-center">Your Reschduled Appointment Details</h3>
                            <div class="ap-detail">
                                <div class="row ex-rw">
                                    <div class="col-md-3 col-sm-2 col-xs-2">
                                        <div class="ex-txt">
                                            <p>Customer</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <div class="ex-coln">
                                            <p>:</p>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-8">
                                        <div class="ex-best">
                                            <p>{{ $customerData->first_name ." ".$customerData->last_name }}</p>
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
                               
                               
                            </div>
                           	<div class="re-at-btn">
                            	<a href="{{url('book-reschedule-appointment/'.$appointment_data->id.'/'.$selectedDatetime->id)}}" class="appt-cust-btn"> Appointment</a>
                            </div>
                        </div>
                         <div class="col-md-4">
                               
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