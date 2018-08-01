@extends('layouts.app')
@section('meta')
    <title>Set Your Availability</title>
@endsection
@section('header')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="{{ url('/') }}/public/media/front/css/calendar.css"></script>
    <style type="text/css">
        .appointment-cal{
            height: 600px !important;
        }
    </style>
@endsection
@section('content')
    <input type="hidden" id="main_url" value="{{ url('/') }}/" />
    <input type="hidden" id="appointment_id" value="{{ $appointment->id }}" />

    <input type="hidden" id="expert_id" value="{{ base64_encode($appointment->expert_id) }}"/>
    <!--<input type="hidden" id="mode_of_contact" value="{{ \Request::segment(4) }}"/>-->
    <section class="account-setting">
        <div class="container">
            <div class="row">
                <div class="appointment-cal">
                    <div class="col-md-12">
                        <div class="available-cal experts-head text-center">
                            <h3> availability for the appointments</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                when an unknown printer took a galley of type and scrambled it to make a type
                                specimen book</p>
                            <div class="avail-img">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="calendar"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="daySelect">Select a Day</div>
                                        <div>
                                            <p id="dayTimes"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script src="{{ url('/') }}/public/media/front/js/appointment/moment.js"></script>
    
    <script>
        // var url = document.getElementById("url").textContent;
            var url = javascript_site_path;
            var jdays = [];
            cDate = moment();
           
            $('#currentDate').text("Current Date is " + cDate.format("MMMM Do, YYYY") );

            $(document).ready(function($){
                createCalendar();
            });

            /**
             * Instantiates the calendar AFTER ajax call
             */
            function createCalendar()
            {
                var expert_id = $("#expert_id").val();
              
                $.get(url+"api/get-available-days?expert_id="+expert_id, function(data) {
                    $.each(data, function(index, value) {
                        jdays.push(value.booking_datetime);
                    });
                  
                    //My function to intialize the datepicker
                    $('#calendar').datepicker({
                        inline: true,
                        minDate: 0,
                        dateFormat: 'yy-mm-dd',
                        beforeShowDay: highlightDays,
                        onSelect: getTimes,
                    });
                });
            }

            /**
             * Highlights the days available for booking
             * @param  {datepicker date} date
             * @return {boolean, css}
             */
            function highlightDays(date)
            {
                date = moment(date).format('YYYY-MM-DD');
               
                for(var i = 0; i < jdays.length; i++) {
                    jDate = moment(jdays[i]).format('YYYY-MM-DD');
                    if(jDate == date) {
                        return[true, 'available'];
                    }
                }
                return false;
            }

            /**
             * Gets times available for the day selected
             * Populates the daytimes id with dates available
             */
            function getTimes(d){
                var dateSelected = moment(d);
                document.getElementById('daySelect').innerHTML = dateSelected.format("MMMM Do, YYYY");
                $.get(url+"/api/get-booking-times?selectedDay="+d, function(data) {
                    $('#dayTimes').empty();
                    $('#dayTimes').append('<h6>Times Available</h6>');
                    for(var i in data) {
                        var rdate = data[i].booking_datetime;
                        rdate = rdate.split(" ");
                       
                        $("#dayTimes").append('<a href="'+url+'reschedule-appointment/booking-detail/'+ $("#appointment_id").val()+"/" +data[i].id+'">' + rdate[1] +' ' +rdate[2] +  '</a><br>');
                    }
                });
            }
    </script>    
@endsection