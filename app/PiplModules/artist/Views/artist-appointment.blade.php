@extends('layouts.app')

@section('content')
<style type="text/css">
    .appointment-cal{
        height: 600px !important;
    }
    .btn.submit-chat:hover {
        color: #ffffff;
    }
    label.text-danger {
        color: #ff0000;
        display: table;
    }
</style>
    <link rel="stylesheet" href="{{url('/')}}/public/media/backend/css/bootstrap-datetimepicker.min.css">
<!--<section class="semi-banner" style="background-image: url('{{ url('public/media/front/img/appoinment.jpg') }}')">
    {{--<div class="semi-banner-caption">--}}
        {{--<div class="container">--}}
            {{--<div class="up-arrow">--}}
                {{--<a href="javascript:void(0);"><i class="fa fa-angle-up"></i></a>--}}
            {{--</div>--}}
            {{--<div class="paras-search-form-element clearfix">--}}
                {{--<div class="col-md-2 col-sm-4 search-col-6">--}}
                    {{--<div class="type-address first">--}}
                        {{--<input type="text" class="form-control" name="keyword" placeholder="Keyword" value="">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-2 col-sm-4 search-col-6">--}}
                    {{--<div class="type-address">--}}
                        {{--<input type="text" class="form-control" name="keyword" placeholder="Address" value="">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-2 col-sm-4 search-col-6">--}}
                    {{--<div class="type-address">--}}
                        {{--<input type="text" class="form-control" name="keyword" placeholder="Category" value="">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-2 col-sm-4 search-col-6">--}}
                    {{--<div class="type-address">--}}
                        {{--<input type="text" class="form-control" name="keyword" placeholder="Country" value="">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-2 col-sm-4 search-col-6">--}}
                    {{--<div class="type-address">--}}
                        {{--<input type="text" class="form-control" name="keyword" placeholder="City" value="">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-2 col-sm-4 search-col-6">--}}
                    {{--<div class="type-address last">--}}
                        {{--<button type="button" class="btn btn-search-filter">Find Provider</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</section>-->
<section  style="background-image: url('{{ url('public/media/front/img/my_appoitnments.jpg') }}')" class="semi-banner">
    <div class="semi-banner-caption-owner">
        <div class="container">
            <!-- <div class="semi-ban-head manage-bottm-head">
                APPOINTMENT FORM
            </div> -->
        </div>
    </div>
</section>
<section class="cust-bread">
    <div class="container">
        <ul class="clearfix">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li>APPOINTMENT FORM</li>
        </ul>
    </div>
</section>
@if(count($artist_info)>0)
<section class="paras-artist-info" style="background-image:url('{{ url('public/media/front/img/art-background.jpg')}}')">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="par-artist-details">
                    <div class="par-artist-img relative">
                        <img src="{{ url('storage/app/public/artist/').'/'.$artist_info->profile_image }}">
                        
                    </div>
                    <span class="paras-artist-name">{{ $artist_info->first_name.' '.$artist_info->last_name }}</span>
                    <ul class="text-center">
                       <li><a href=" {{ $artist_info->facebook_id }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                       <li><a href="{{ $artist_info->twitter_id}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                       <li><a href="{{ $artist_info->linkedin_id }}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                       <li><a href="{{ $artist_info->youtube_link }}" target="_blank"><i class="fa fa-youtube"></i></a></li>
                       <li><a href="{{ $artist_info->instagram_id }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                    <span class="par-check"><i class="fa fa-check"></i></span>
                </div>
            </div>
            <div class="pa-art-about-bx">
                <div class="content-managed">
                    <h2 class="pa-art-title">{{ $artist_info->first_name.' '.$artist_info->last_name }}</h2>
                    <span class="tagline">{{ $artist_info->description }}</span>
                    <div class="par-abt-desp">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-------------------------------------------------Artist service slider---------------------------------->
@if(count($img_gallery)>0)
<section class="atist-photo-gallery"  style="background-image:url('{{ url('public/media/front/img/hot_product.png') }}')">
    <div class="container">
        <h2 class="pa-art-title">Photo Gallery</h2>
        <div class="par-art-photo-slid">
            <div class="par-art-slid owl-carousel">
               @foreach($img_gallery as $gal)
                <div class="item relative">
                    <div class="image-slid">
                        <img src="{{ url('storage/app/public/artist/images').'/'.$gal->path }}" alt="photo gallery">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
<!-------------------------------------------BUSINESS HOURS SEC START---------------------------------------->
@if(count($artist_info)>0)
<section class="paras-business-hours par-video">
    <div class="container">
        <h2 class="pa-art-title">Our Video</h2>
        <div class="par-art-vid">
            <video loop autoplay controls>
                <source type="video/mp4" src="{{ url('storage/app/public/artist/video').'/'.$artist_info->video }}"></source>
                <source type="video/ogg" src="{{ url('storage/app/public/artist/video').'/'.$artist_info->video }}"></source>
            </video>
        </div>
    </div>
</section>
@endif
<!-----------------------------------------------book now appoinment---------------------------------------->
@if(count($artist_info)>0)
<section class="paras-artist-book">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="customer-booking-form">
                    @if (session('appointment-status'))
                        <div class="alert alert-success">
                            {{ session('appointment-status') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                        <script>
                            $('#prog-bar-dv').html('100%');
                            $('#prog-bar-dv').css('width','100%');
                        </script>
                    @endif
                    <!-- Nav tabs -->
                    <ul id="ul-serv-id" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">1. Select Service</a></li>
                        {{--<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">2. Choose Date & Time</a></li>--}}
                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">2. Customer info</a></li>
                        {{--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">4. Payment</a></li>--}}
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="cust-progressbr">
                            <div class="progress">
                                <div id="prog-bar-dv" style="width:0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-striped active">0%</div>
                            </div>
                        </div>
                        <div id="div-err-services" style="display: none" class="help-block">
                                       <p style="font-size: 16px" class="text-danger" id="err-services">{{ $errors->first('services') }}</p>
                                    </div>
                        <div role="tabpanel" class="tab-pane active" id="home">
                            <div class="step-holder">
                                {{--<div class="step-enter-loc relative">--}}
                                    {{--<input type="text" name="" class="form-control" placeholder="Enter Location">--}}
                                    {{--<span><i class="fa fa-location-arrow"></i></span>--}}
                                {{--</div>--}}
                                <div class="choose-services">
                                    <ul class="clearfix">
                                        @if(isset($artist_info) && $artist_info->services !='')
                                         @php
                                             $cnt = 0;
                                             $services = unserialize($artist_info->services);
                                         @endphp
                                        @if(count($services)>0)
                                        @foreach($services as $key => $val)
                                        <li>
                                            <div id="div-serv-{{ $cnt }}" rel="{{ $artist_info->id }}" onclick="chooseService(this)" class="aon-service-bx relative">
                                                <div class="service-name"><h5>{{ $key }}</h5></div>
                                                <div class="aon-service-price"><h5>{{ $val }}</h5></div>
                                                <div class="selct-serv"><i class="fa fa-check"></i></div>
                                            </div>
                                        </li>
                                            @php $cnt++;   @endphp
                                        @endforeach
                                        @endif
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="next-prev-btn clearfix">
                                {{--<button  id="pre-serv-btn" onclick="goPreTab()" style="display: none;" type="button" class="btn btn-next-step pull-left"><i class="fa fa-arrow-left"></i> Previous</button>--}}
                                <button id="nxt-serv-btn" onclick="validateServiceSelected()" type="button" class="btn btn-next-step pull-right"><i class="fa fa-arrow-right"></i> next</button>
                            </div>
                        </div>
                        
                        <div role="tabpanel" class="tab-pane" id="messages">
                            <div class="customer-booking-entry">
                                <form id="cust-artist-appointment" name="cust_artist_appointment" onsubmit="return chkServiceSelected()" class="cust-book-form" action="{{ url('artist/appointment/customer-info') }}" method="post" id="artist-customer-info" name="artist_customer_info">
                                     {{ csrf_field() }}

                                    <input id="ip-art-serv-id" name="artist_id" type="hidden">
                                    <input id="ip-service-name" name="service_nm" type="hidden">
                                    <input id="ip-service-price" name="service_price" type="hidden">
                                    {{--<div id="div-err-services" style="display: none" class="help-block">--}}
                                       {{--<p style="font-size: 16px" class="text-danger" id="err-services">{{ $errors->first('services') }}</p>--}}
                                    {{--</div>--}}
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>First Name:</label>
                                                <input type="text" name="first_name" class="form-control" placeholder="First Name">
                                                @if ($errors->has('first_name'))
                                                    <span class="help-block">
                                                            <p>{{ $errors->first('first_name') }}</p>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Last Name:</label>
                                                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                                                @if ($errors->has('last_name'))
                                                    <span class="help-block">
                                                            <p>{{ $errors->first('last_name') }}</p>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Email:</label>
                                                <input type="email" name="email" class="form-control" placeholder="Email">
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                            <p>{{ $errors->first('email') }}</p>
                                                    </span>
                                                @endif
                                             </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Phone:</label>
                                                <input type="text" name="mobile" class="form-control" placeholder="mobile No">
                                                @if ($errors->has('mobile'))
                                                    <span class="help-block">
                                                            <p>{{ $errors->first('mobile') }}</p>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Date:<!-- <sup>*</sup> --></label>                                               
                                                <div class='input-group date h-manage-inp' id='datepicker1'>
                                                    <input type='text' id='valid_from' name="valid_from" class="form-control" value="{{old('valid_from')}}" >
                                                    <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar">
                                                </span>
                                                </span>
                                                    @if ($errors->has('valid_from'))
                                                        <span class="help-block">
                                                            <p>{{ $errors->first('valid_from') }}</p>
                                                    </span>
                                                    @endif
                                                </div>                                                    
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Country Name:</label>
                                                <input type="text" name="country" class="form-control" placeholder="Country">
                                                @if ($errors->has('country'))
                                                    <span class="help-block">
                                                            <p>{{ $errors->first('country') }}</p>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label>Description:</label>
                                                <textarea type="text" name="description" class="form-control" placeholder="Describe your task"></textarea>
                                                @if ($errors->has('description'))
                                                    <span class="help-block">
                                                            <p>{{ $errors->first('description') }}</p>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <input type="submit" onclick="appendErrorMsg()" class="btn btn-next-step" value="Submit Appointment Request" placeholder="Submit">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="next-prev-btn clearfix">
                                <button  id="pre-serv-btn" onclick="goPreTab()" type="button" class="btn btn-next-step pull-left"><i class="fa fa-arrow-left"></i> Previous</button>
                                {{--<button id="nxt-serv-btn" onclick="validateServiceSelected()" type="button" class="btn btn-next-step pull-right"><i class="fa fa-arrow-right"></i> next</button>--}}
                            </div>
                        </div>
                        {{--<div role="tabpanel" class="tab-pane" id="settings">--}}
                            {{--<div class="payment-radio">--}}
                                {{--<label>--}}
                                    {{--<input type="radio" name="">--}}
                                    {{--<span><img src="img/master_card.png"></span>--}}
                                    {{--<span><img src="img/master_card.png"></span>--}}
                                    {{--<span><img src="img/master_card.png"></span>--}}
                                    {{--<span><img src="img/master_card.png"></span>--}}
                                {{--</label>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="next-prev-btn clearfix">--}}
                            {{--<button  id="pre-serv-btn" onclick="goPreTab()" style="display: none;" type="button" class="btn btn-next-step pull-left"><i class="fa fa-arrow-left"></i> Previous</button>--}}
                            {{--<button id="nxt-serv-btn" onclick="validateServiceSelected()" type="button" class="btn btn-next-step pull-right"><i class="fa fa-arrow-right"></i> next</button>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<script>
     function chooseService(ele)
     {
        var id = ele.id;
        id = id.split('-').pop();
        var text = $('#'+ele.id).text();
        var artistId = $('#'+ele.id).attr('rel');
        var val = $.trim(text);
         var res = val.replace(" ",'');
         var serVal = res.split(' ').pop();
         var serkey = res.split(' ');

         if($(ele).hasClass('selected')) {
             $(ele).removeClass('selected');
             // $('.aon-service-bx').removeClass('selected');
             $('#prog-bar-dv').html('0%');
             $('#prog-bar-dv').css('width','0%');
         }

         else{
             // $('.aon-service-bx').removeClass('selected');
             $(ele).addClass('selected');
             $('#prog-bar-dv').html('50%');
             $('#prog-bar-dv').css('width','50%');
             $('#div-err-services').hide();
              var serNm =$('#ip-service-name').val();
              var serPrice =$('#ip-service-price').val();
             serNm = serNm +"," + serkey[0];
             serPrice = serPrice +"," + serVal;
             $('#ip-art-serv-id').val(artistId);
             $('#ip-service-name').val(serNm);
             $('#ip-service-price').val(serPrice);
         }
     }
</script>
<script>
    var d = new Date();
    $(function() {
        $("#datepicker1").datetimepicker({
            use24hours: true,
            format: "yyyy/mm/dd hh:ii:ss",
            startDate: d
        });
    });
</script>
<script>

    function appendErrorMsg(){
        setTimeout(function () {


            jQuery("label[for='valid_from']").insertAfter(jQuery("#datepicker1"));

        }, 100);
    }
    function goPreTab()
    {
        $('#ul-serv-id li a[href="#messages"]').parent().removeClass('active');
        $('#messages').removeClass('active');
        $('#ul-serv-id li a[href="#home"]').parent().addClass('active');
        $('#home').addClass('active');
    }

    function chkServiceSelected() {
        appendErrorMsg();
        var atLeastOneFilled = false;
        $(".aon-service-bx").each(function(index, field)
        {

            if($(field).hasClass('selected') !='')
                atLeastOneFilled = true;
        });
        if(atLeastOneFilled == false)
        {
            $('#div-err-services').show();
            $('#err-services').html("Please select atleast one service to place appointment request");
        }
        else{
            $('#div-err-services').hide();
        }
        return atLeastOneFilled;
    }
    function validateServiceSelected()
    {
        if(chkServiceSelected())
        {
            $('#ul-serv-id li a[href="#home"]').parent().removeClass('active');
            $('#home').removeClass('active');
            $('#ul-serv-id li a[href="#messages"]').parent().addClass('active');
            $('#messages').addClass('active');
            $('#div-err-services').hide();
        }
        else
        {
            $('#div-err-services').show();
            $('#err-services').html("Please select atleast one service to place appointment request");
        }
    }
</script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/bootstrap-datetimepicker.min.js"></script>
@endsection