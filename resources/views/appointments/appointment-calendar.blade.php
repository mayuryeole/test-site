@extends('layouts.app')
@section('meta')
<title>Set Your Availability</title>
@endsection
@section('header')
<style type="text/css">
    .appointment-cal{
        height: 600px !important;
    }
</style>
@endsection
@section('content')
<input type="hidden" id="main_url" value="{{ url('/') }}/" />
<input type="hidden" id="expert_id" value="1"/>
<input type="hidden" id="mode_of_contact" value="1"/>
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

@endsection