@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
    <title>Rivaah Story Details</title>
@endsection
@section("content")
    @if(isset($gal_details) && count($gal_details)>0)
        @if(isset($gal_img_details) && count($gal_img_details)>0)
    <section class="our-story-banner">
        <img src="{{ url('public/media/front/img/paras-story-banner.jpg') }}" alt="banner image"/>
        @endif
        <div class="paras-pos-absu paras-ban-cap">
            <div class="dis_table">
                <div class="disp_tabcell width50">
                    <div class="paras_maxWid">
                        <h1>@if(!empty($gal_details->name)){{ $gal_details->name }} @endif</h1>
                        <div class="paras-step">
                        </div>
                        <div class="paras-ban-desp">
                            {{--{{ $gal_details->description }}--}}
                            <p id="see_less">
                            @if(isset($gal_details->description) && strlen($gal_details->description)>150)
                            {{ stripslashes(substr($gal_details->description,0,200)) }}
                            @elseif(isset($gal_details->description) && strlen($gal_details->description)<150)
                            {{ stripslashes($gal_details->description) }}
                            @endif
                            </p>
                            <p id="see_more" style="display: none;" >
                            @if(isset($gal_details->description))
                            {{ stripslashes($gal_details->description) }} <a id="see-more-anchor" class="hide-less" href="javascript:void(0);" onclick="replaceDown(this.id)">See less</a>
                            @endif
                            </p>
                        </div>
                        <div class="paras-ban-desp">
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="dis_tabcell wid50 vis_hid"></div>
            </div>
        </div>
    </section>
    @endif
    @if(isset($all_product) && count($all_product)>0)
    <section class="history-details">
        <div id="mybook">
            @foreach($all_product as $riv_product)
                @if(isset($riv_product->productDescription) && count($riv_product->productDescription)>0 )
            <div class="book-img">
                <img src="{{ url('storage/app/public/product/image').'/'.$riv_product->productDescription->image }}" alt="image"/>
            </div>
            <div class="book-desp">
                <div class="booklet-desp-holder">
                    @if(isset($riv_product->name) && $riv_product->name!='')
                    <h3>{{ $riv_product->name }}</h3>
                    @else
                    <h3>Product Name</h3>
                    @endif
            <div class="book-content mCustomScrollbar">
                <p>

                    @if(isset($riv_product->productDescription->description) && strlen($riv_product->productDescription->description)>150)
                        {{ stripslashes(substr($riv_product->productDescription->description,0,200)) }}
                    @elseif(isset($riv_product->productDescription->description) && strlen($riv_product->productDescription->description)<150)
                         {{ stripslashes($riv_product->productDescription->description) }}
                    @endif
                </p>

            </div>
            @endif
            @if(!empty($riv_product))
            <div class="details-buy">
                <a  href="{{ url('product').'/'.$riv_product['id'] }}" type="button" class="buy-bow">Buy Now</a>
            </div>
            @endif
        </div>
        
        </div>
        @endforeach
        @endif
</div>
<p class="mgt-inf-plg text-center">Click on Page Number to Explore More Products or Slide Open our Lookbook</p>
</section>
   {{--{{ dd(245) }}--}}
{{--{!! $all_product->render()  !!}--}}

<div class="modal fade" id="video_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Pre Order Video</h4>
        </div>
        <div class="modal-body">
            <div class="video_section">
                <video width="400" controls>
                    <source src="{{url('public/media/front/video/video_1.mp4')}}" type="video/mp4">
                    <source src="{{ url('public/media/front/video/video_1.ogg') }}" type="video/ogg">
                </video>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    var cnt;
    function replaceUp(id)
    {
         cnt = id.split('_').pop();
        if(id == "see-less-anchor")
            {
                $("#see_more").show();
                $("#see_less").hide();
            }
        else{
            $("#see_more_"+cnt).show();
            $("#see_less_"+cnt).hide();
        }

    }
    function replaceDown(id)
    {
        cnt = id.split('_').pop();
        if(id == "see-more-anchor"){
            $("#see_more").hide();
            $("#see_less").show();
        }
        else{
            $("#see_more_"+cnt).hide();
            $("#see_less_"+cnt).show();
        }

    }
</script>
<script> window.jQuery || document.write('<script src="{{url('public/media/front/js/jquery-2.1.0.min.js')}}"><\/script>') </script>
<script> window.jQuery || document.write('<script src="{{url('public/media/front/js/js/jquery-ui.min.js')}}"><\/script>') </script>
<!--JS FOR BOOKLET-->
{{--<script src="{{url('public/media/front/js/jquery.easing.1.3.js')}}"></script>--}}
{{--<script src="{{url('public/media/front/js/wow.js')}}"></script>--}}
    {{--<script src="{{url('public/media/front/js/jquery.booklet.latest.min.js')}}"></script>--}}
    
 <script>
$(window).resize(function(){
	if ($(window).width() <= 1024){	
		$(function() {
    $('#mybook').booklet({
        width:  800,
        height: 645
    });
});
	}	
});
</script>   
<script>
$(window).resize(function(){
	if ($(window).width() <= 800){	
		$(function() {
    $('#mybook').booklet({
        width:  650,
        height: 450
    });
});
	}	
});
</script>
 <script>
$(window).resize(function(){
	if ($(window).width() <= 678){	
		$(function() {
    $('#mybook').booklet({
        width:  500,
        height: 350
    });
});
	}	
});
</script>   
<script>
$(window).resize(function(){
	if ($(window).width() <= 500){	
		$(function() {
    $('#mybook').booklet({
        width:  350,
        height: 300
    });
});
	}	
});
</script>
<script>
$(window).resize(function(){
	if ($(window).width() <= 340){	
		$(function() {
    $('#mybook').booklet({
        width:  280,
        height: 300
    });
});
	}	
});
</script>
<script>
//booklet js
new WOW().init();
$(function() {
    $('#mybook').booklet({
        width:  1000,
        height: 643
    });
});
</script>

@endsection