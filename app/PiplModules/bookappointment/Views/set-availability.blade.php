@extends('layouts.app')
@section('meta')
    <title>Set Your Availability</title>
@endsection
@section('header')
    <link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css" rel="stylesheet">
    <style type="text/css">
/*        .avail-cal{
            height: 880px;
        }*/
        .account-setting.h-account-setting {
            margin: 78px 0 0;
            padding: 40px 0;
        }
        .h-account-setting h3 {
            font-size: 20px;
            text-transform: uppercase;
            text-align: center;
        }
        .fc-center h2 {
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .h-avail-cal th {
            height: 50px;
            vertical-align: middle;
            background-color: #353535;
            color: #ffffff;
            text-transform: uppercase;
            font-size: 14px;
        }.fc-month-button{
            display:none;
        }
    </style>
@endsection
@section('content')           
    <input type="hidden" id="main_url" value="{{ url('/') }}/" />
    <section class="account-setting h-account-setting">
        <div class="container">
            <div class="row">
                <div class="avail-cal h-avail-cal">
                    <div class="col-md-12">
                        <a href="{{url("/admin/manage-appointments")}}"><button type="button" class="btn submit-chat" style="color:black;">Back</button></a>
                        <div class="available-cal experts-head text-center">
                            <h3>Availability of the appointments</h3>
                            <div class="avail-img">
                                {{--<center><img src="{{ url('/') }}/public/media/front/img/responsive-calendar.png" alt="image" class="img-responsive avail-cal-img"></center>--}}
                                <div id="error"></div>
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="{{ url('/') }}/public/media/front/js/appointment/moment.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js"></script>
    <script src="{{ url('/') }}/public/media/front/js/availability/availability.js"></script>
@endsection