@extends('layouts.app')

@section('meta')
    <title>Mode Of Contact</title>
@endsection
<section class="account-setting dash-cms-cust">
    <div class="container">
        <div class="choose_experts">
            <div class="row">
                <div class="col-md-12">
                    <div class="experts-head text-center">
                        <h3>Book Your Appointment</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                            when an unknown printer took a galley of type and scrambled it to make a type
                            specimen book</p>
                    </div>
                </div>
            </div>
            <!-----------------------------Expert Detail--------------------------------------->
            <div class="row">
                <div class="ex-detail">
                    <div class="col-md-1 col-sm-1">

                    </div>
                    <div class="col-md-10 ex-inner-detail">
                        <div class="ex-in-detail pay-mode-detail">
                            <div class="col-md-4 col-sm-4">
                                <div class="ex-nam-img">
                                    <div class="col-md-5 col-sm-5">
                                        <div class="ex-img pay-mode-img">
                                            <img src="{{url('public/media/front/img/user/'.$selected_expert_info->user_id.'/'.$selected_expert_info->profile_picture)}}" alt="image" class="img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                        <div class="ex-nam">
                                            <h4>{{$selected_expert_info->first_name}}</h4>
                                            <p>Counseller</p>
                                            <p class="rating">
                                                <span>
                                                	 <?php

                                            $k = 0;
                                            $is_flot = false;
                                            $arr_rat = explode('.', $selected_expert_info->avg_rating);
                                            if (count($arr_rat) == 1) {
                                                $arr_rat[1] = '0';
                                            }
                                            if ($arr_rat[0] != "") {
                                                if ($arr_rat[1] != '0') {
                                                    $is_flot = "true";
                                                }
                                                for ($ii = 0; $ii < $arr_rat[0]; $ii++) {
                                                    ?>
                                                    <img  src="{{url('public/media/front/img/star-on.png')}}"/>
                                                    <?php
                                                    $k++;
                                                }
                                                if ($is_flot) {
                                                    ?>
                                                    <img  src="{{url('public/media/front/img/star-half.png')}}"/>
                                                    <?php
                                                }
                                                if ($is_flot) {
                                                    $s = $arr_rat[0] + 1;
                                                } else {
                                                    $s = $arr_rat[0];
                                                }
                                                if ($s < 5) {
                                                    for ($j = $s; $j < 5; $j++) {
                                                        ?>
                                                        <img  src="{{url('public/media/front/img/star-off.png')}}"/>
                                                        <?php
                                                        $s++;
                                                    }
                                                }
                                            }

                                        ?>
                                    
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <div class="ex-rev-conver-last-act">
                                    <div class="col-md-3 col-sm-3">
                                        <div class="ex-re">
                                            <p class="rev-txt">Total Reviews</p>
                                            <p class="rev-no">{{$selected_expert_info->total_reviews}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="ex-conver">
                                            <p class="conver-txt">Total Conversation</p>
                                            <p class="conver-no">12786</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5">
                                        <div class="ex-last-date-act">
                                            <p class="ex-last-date-txt">Last Active</p>
                                            <p class="ex-date-no">{{$selected_expert_info->last_login}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 col-sm-1">

                    </div>
                </div>
            </div>
            <!--------------------------------------Subscription Paln---------------------------------->
            <div class="cust-subscription-plans">
                <div class="row">
                    <div class="custom-sub-plan">
                        <h2 class="text-center">Choose your mode of Contact</h2>
                        @if(isset($contact_modes) && count($contact_modes)>0)
                        @foreach($contact_modes as $mode)
                        <div class="col-md-3 col-sm-6">
                            
                            <div class="inner-sub-plan transition">
                                <div class="text-msg-plan">
                                    <div class="pay-plan">{{$mode->mode}}</div>
                                    <h4 class="sub-price relative">
                                        <span class="currency"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                        <span class="price-no"> {{$mode->amount}} </span>
                                        <div class="sub-duration"> {{$mode->interval}} </div>
                                    </h4>
                                </div>
                                <div class="tex-sub-mid">
                                    <p><span class="pay-mod-check"><i class="fa fa-check pln-check" aria-hidden="true"></i></span>
                                        {!! $mode->description !!}</p>
                                   
                                </div>
                                <div class="text-sub-bottom">
                                    <a href="{{ action('BookingController@getCalendar',[\Request::segment(3),$mode->id]) }}">Select</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
