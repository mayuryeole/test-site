@extends('layouts.app')
@section('meta')
    <title>Set Your Availability</title>
@endsection
@section('header')
    <link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css" rel="stylesheet">
    <style type="text/css">
        .avail-cal{
            height: 880px;
        }
    </style>
@endsection
@section('content')
    <input type="hidden" id="main_url" value="{{ url('/') }}/" />
    <section class="account-setting">
        <div class="container">
            <div class="row">
                <div class="avail-cal">
                    <div class="col-md-12">
                        <div class="available-cal experts-head text-center">
                            <h3> availability for the appointments</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                when an unknown printer took a galley of type and scrambled it to make a type
                                specimen book</p>
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