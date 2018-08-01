@extends('layouts.app')
@section('content')
<!-------------------------------------------------------BANNER START------------------------------------------------------>
<section class="banner fullHt">
<div class="banner-video">
    <video width="100%" height="100%" loop autoplay>
        <source type="video/mp4" src="public/media/front/video/paras-intro.mp4"></source>
        <source type="video/ogg" src="public/media/front/video/paras-intro.ogg"></source>
    </video>
</div>
<div class="shop_now_btn">
    <a href="{{ url('search-product') }}"><button type="submit" class="ban_shop_now">Shop Now</button></a>
</div>
<div class="down_arrow wow animated bounce">
	<a class="down-arro-ico" href="#product-collection"><i class="fa fa-angle-down"></i></a>
</div>
</section>
<!------------------------------------------------------GALLERY START------------------------------------------------------>
<!------------------------------------------------------GALLERY START------------------------------------------------------>
<section class="product_collection_blk" id="product-collection">
    <ul class="product_struct clearfix">
        <li>
            <div class="product_collection_holder relative" style="background-image:url('{{ url('public/media/front/img/p1.jpg') }}');">
                <span class="hover_line_1"></span>
                <span class="hover_line_2"></span>
                <sapn class="product_collection_btn"><a href="{{ url('/search-product') }}" class="cust-btn">Product Collection</a></sapn>
                <span class="product_info_caption">
                	<p>
                        Moments are created and captured with the special occasions in the
                        adventure of our journey called   life, therefore every piece of our
                        handcrafted jewellery becomes a part of someone’s special memories.
                        Come Explore and fall in Love with our breath-taking, artistically
                        crafted Jewellery Collections with exquisite unique designs catering to
                        all over the world on our wide platter of Fusion between rich
                        traditional Indian Bridal appeals to modern looks...
                        </p>
                    <!-- <a href="javascript:void(0)">Read More</a> -->
                </span>
            </div>
        </li>
        <li>
            <div class="product_collection_holder relative" style="background-image:url('{{ url('public/media/front/img/create your dream jewley.jpg') }}')">
                <span class="hover_line_1"></span>
                <span class="hover_line_2"></span>
                <sapn class="product_collection_btn"><a href="javascript:void(0);" class="cust-btn">Create Your Dream Jewellery</a></sapn>
                <span class="product_info_caption">
                	<p>Looking for something truly elegant and artistic.we give you chance to
                        create your own dream jewellery design for your special occasion.we will
                        craft your imagination into beautifully piece of jewellery.</p>
                    <!-- <a href="javascript:void(0)">Read More</a> -->
                </span>
            </div>
        </li>
        <li>
            <div class="product_collection_holder relative" style="background-image:url('{{ url('public/media/front/img/special offer and discount.jpg') }}')">
                <span class="hover_line_1"></span>
                <span class="hover_line_2"></span>
                <sapn class="product_collection_btn"><a href="javascript:void(0);" class="cust-btn">Special Offers & Discount</a></sapn>
                <span class="product_info_caption">
                	<p>As the saying goes “  Icing on the Cake "or “Sone pe Suhagaa”  !!!
                        Who doesn’t like offers , promos and discounts …we all love them and
                        sometimes even wait for them …SO !!!!!! here’s adding a little
                        sparkle to your glittery smile and lift your spirits… Hurry and grab
                        Before deals expire</p>
                    <!-- <a href="javascript:void(0)">Read More</a> -->
                </span>
            </div>
        </li>
        <li>
            <div class="product_collection_holder product_collection_vid relative" style="background-color:#000;">
                <video width="100%" height="100%" controls>
                    <source src="public/media/front/video/video_1.mp4" type="video/mp4">
                    <source src="public/media/front/video/video_1.ogg" type="video/ogg">
                </video>
                <!--<span class="hover_line_1"></span>
                <span class="hover_line_2"></span>
                <span class="play_video"><a href="#video_modal" data-toggle="modal"><img src="img/play.png" alt="play"/></a></span>-->
                <sapn class="product_collection_btn"><a href="javascript:void(0);" class="cust-btn">Pre-Order</a></sapn>


                <span class="product_info_caption">
                	<p>It's not here yet !!!….  BUT it’s been designed, crafted and on the
                        way. .... These are our Exclusive Premium limited edition designs, which
                        may or may not hit the stores ….</p>
                    <!-- <a href="javascript:void(0)">Read More</a> -->
                </span>
            </div>
        </li>
        <li>
            <div class="product_collection_holder relative" style="background-image:url('{{ url('public/media/front/img/trending.jpg') }}')">
                <span class="hover_line_1"></span>
                <span class="hover_line_2"></span>
                <sapn class="product_collection_btn"><a href="javascript:void(0);" class="cust-btn">Treanding</a></sapn>
                <span class="product_info_caption">
                	<p>
                        Which , Who , What ,When , Why….Find answers to all  about our
                        designs , our inspirations ,current  fashion trends , Traditions &
                        Rituals, Suggestions and the looks for the season and occasions   ,
                        about our  glitterati, Our Models ,  behind the scenes with the camera
                        read it all</p>
                    <!-- <a href="javascript:void(0)">Read More</a> -->
                </span>
            </div>
        </li>
        <li>
            <div class="product_collection_holder relative" style="background-image:url('{{ url('public/media/front/img/about us.jpg') }}')">
                <span class="hover_line_1"></span>
                <span class="hover_line_2"></span>
                <sapn class="product_collection_btn"><a href="{{url("/about-us")}}" class="cust-btn">About Us</a></sapn>
                <span class="product_info_caption">
                	<p>We are retailers & whole sellers delivering strikingly exquisite
                        designed Fashion jewellery, Accessories, Bridal wear & Juttis guarantees
                        enhancing your majestic and alluring looks
                         Our experienced designers and in house production ensures customers
                        satisfaction of the product which are Unique, stylish, exclusively
                        trendy & premium quality .</p>
                    <!-- <a href="javascript:void(0)">Read More</a> -->
                </span>
            </div>
        </li>
    </ul>
</section>
<!---------------------------------------------------------WEDDING GALLERY START------------------------------------------>
@if(isset($rivaah) && count($rivaah)>0)
<section class="weding-for-mobile hidden-lg hidden-md hidden-sm">
    @php
        $rivaah_gallery_images = \App\PiplModules\rivaah\Models\RivaahGalleryImage::groupBy('rivaah_gallery_id')->limit('12')->get();
    @endphp
    <div class="wed-mobile-image owl-carousel">
        {{--@if($rivaah_gallery_images->count() > 0 && isset($rivaah_gallery_images[0]))--}}
            {{--<div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[0]->image}}')">--}}
                {{--<a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[0]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[0]->image}}" alt="wedding image"/></a>--}}
                {{--<span class="modal-location-caption">--}}
                    	{{--<span class="mod-loc-name">{{$rivaah[0]['name']}}</span>--}}
                    {{--</span>--}}
            {{--</div>--}}
        {{--@endif--}}
            @if(isset($rivaah_gallery_images) && count($rivaah_gallery_images)>0)
                @foreach($rivaah_gallery_images as $riv_img_gal)
        <div class="item">
            <div class="mobile-wed-categories">
                <a href="{{ url('/rivaah-story') }}/{{ $riv_img_gal->id }}">
                    <div class="mobile-wed-img">
                        <img src="{{url('storage/app/public/rivaah/images').'/'.$riv_img_gal->image}}">
                    </div>
                    <div class="mobile-wed-head">{{ $riv_img_gal->name }}</div>
                </a>
            </div>
        </div>
        @endforeach
        @endif
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">Paras</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">Bihar</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">West Bengal</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">Haryana</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">Panjab</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">UP</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">MP</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">Andhra</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">Telangana</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">Kashmir</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="item">--}}
            {{--<div class="mobile-wed-categories">--}}
                {{--<a href="javascript:void(0);">--}}
                    {{--<div class="mobile-wed-img">--}}
                        {{--<img src="{{url('public/media/front/img/wed-6.png')}}">--}}
                    {{--</div>--}}
                    {{--<div class="mobile-wed-head">Tamilnadu</div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
</section>
@endif

@if(isset($rivaah) && count($rivaah)>0)
    <section class="wedding_gallery hidden-xs" style="background-image:url('{{url('/public/media/front/img/flower-bg.jpg')}}')">
        @php
            $rivaah_gallery_images = \App\PiplModules\rivaah\Models\RivaahGalleryImage::groupBy('rivaah_gallery_id')->limit('12')->get();
        @endphp
        <div class="wedding-gallery-block clearfix">
            <div class="wed-col-1 wed-home-ban">

                <div class="wed-inner-1 wed-two-imgs clearfix">
                    @if($rivaah_gallery_images->count() > 0 && isset($rivaah_gallery_images[0]))
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[0]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[0]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[0]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[0]['name']}}</span>
                    </span>
                        </div>
                    @endif
                    @if($rivaah_gallery_images->count() > 1 && isset($rivaah_gallery_images[1]))
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[1]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[1]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[1]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[1]['name']}}</span>
                    </span>
                        </div>
                    @endif
                </div>
                <div class="wed-inner-1 wed-three-imgs">
                    @if($rivaah_gallery_images->count() > 2 && isset($rivaah_gallery_images[2]))
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[2]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[2]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[2]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[2]['name']}}</span>
                    </span>
                        </div>
                    @endif
                    @if($rivaah_gallery_images->count() > 3 && isset($rivaah_gallery_images[3]))
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[3]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[3]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[3]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[3]['name']}}</span>
                    </span>
                        </div>
                    @endif
                    @if($rivaah_gallery_images->count() > 4 && isset($rivaah_gallery_images[4]))
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[4]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[4]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[4]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[4]['name']}}</span>
                    </span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="wed-col-1 wed-home-ban">
                <div class="wed-identity-outer relative">
                    <a href="javascript:void(0)" style="/*background-image:url('{{ url('public/media/front/img/logoold.png')}}')*/">
                        <div class="rivah-logo-holder">
                            <div class="riva-logo">
                                <img src="public/media/front/img/pink.png">
                            </div>
                            <div class="riva-heading">
                                <h5>Paras Fashions</h5>
                                <p>Makes you feel special</p>
                                <p class="strate-word">
                                    <span class="word-before"><img src="public/media/front/img/paras_sep.png" alt="image"></span>
                                    Wedding Jewellery
                                    <span class="word-after"><img src="public/media/front/img/paras_sep.png" alt="image"></span>
                                </p>
                                <p class="strate-word-alter">For Every Indian Bride</p>
                            </div>
                        </div>
                    </a>
                </div>
                @if($rivaah_gallery_images->count() > 5 && isset($rivaah_gallery_images[5]))
                    <div class="wed-inner-1 wed-one-imgs clearfix">
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[5]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[5]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[5]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[5]['name']}}</span>
                    </span>
                        </div>
                    </div>
                @endif
                @if($rivaah_gallery_images->count() > 6 && isset($rivaah_gallery_images[6]))
                    <div class="wed-inner-1 wed-one-imgs clearfix">
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[6]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[6]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[6]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[6]['name']}}</span>
                    </span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="wed-col-1 wed-home-ban">
                <div class="wed-inner-1 wed-two-imgs clearfix">
                    @if($rivaah_gallery_images->count() > 7 && isset($rivaah_gallery_images[7]))
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[7]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[7]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[7]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[7]['name']}}</span>
                    </span>
                        </div>
                    @endif
                    @if($rivaah_gallery_images->count() > 8 && isset($rivaah_gallery_images[8]))
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[8]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[8]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[8]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[8]['name']}}</span>
                    </span>
                        </div>
                    @endif
                </div>
                <div class="wed-inner-1 wed-three-imgs">
                    @if($rivaah_gallery_images->count() > 9 && isset($rivaah_gallery_images[9]))
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[9]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[9]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[9]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[9]['name']}}</span>
                    </span>
                        </div>
                    @endif
                    @if($rivaah_gallery_images->count() > 10 && isset($rivaah_gallery_images[10]))
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[10]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[10]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[10]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[10]['name']}}</span>
                    </span>
                        </div>
                    @endif
                    @if($rivaah_gallery_images->count() > 11 && isset($rivaah_gallery_images[11]))
                        <div class="wed-item wed-bg-img" style="background-image:url('{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[11]->image}}')">
                            <a href="{{ url('/rivaah-story') }}/{{ $rivaah_gallery_images[11]->id }}"><img src="{{ url('storage/app/public/rivaah/images').'/'. $rivaah_gallery_images[11]->image}}" alt="wedding image"/></a>
                            <span class="modal-location-caption">
                    	<span class="mod-loc-name">{{$rivaah[11]['name']}}</span>
                    </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
{{--<!---------------------------------------------------------HOT PRODUCTS START---------------------------------------------->--}}
{{--<section class="hot_product_blk" style="background-image:url('{{ url('public/media/front/img/hot_product.png') }}');">--}}
<section class="hot_product_blk" style="background-image:url('{{ url('public/media/front/img/background for join the conversation.jpg') }}')">
    <div class="container">
        <div class="main_heading"><span>HOT PRODUCTS</span></div>
        <div class="hot_product_holder">
            <div class="row">
                @if(isset($hot_prod) && count($hot_prod)>0)
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="hot_product_listing">
                                <h5 class="relative">@if(isset($hot_prod[0])) {{$hot_prod[0]->name}} @endif
                                <!--<span>1-22 off 20 <i class="fa fa-angle-down"></i></span>-->
                                </h5>
                                <div class="product_img">
                                    <img height="200" width="200" @if(isset($hot_prod[0])) src="{{url("/storage/app/public/product/image").'/'.$hot_prod[0]->productDescription->image}}" @endif alt="Product Image"/>
                                </div>
                                <div class="common_buttons">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a @if(isset($hot_prod[0])) href="{{url("/product/".$hot_prod[0]->id)}}" @endif class="cust-btn">See More</a>
                                        </div>
                                        <div class="col-md-6">
                                            <!--                                        	<span class="product_price">$ 2001 - $ 1500</span>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="hot_product_listing">
                                <h5 class="relative">@if(isset($hot_prod[1])) {{$hot_prod[1]->name}} @endif
                                <!--<span>1-22 off 20 <i class="fa fa-angle-down"></i></span>-->
                                </h5>
                                <div class="product_img">
                                    <img height="200" width="200" src="{{url("storage/app/public/product/image/".$hot_prod[1]->productDescription->image)}}" alt="Product Image"/>
                                </div>
                                <div class="common_buttons">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a @if(isset($hot_prod[1])) href="{{url("/product/".$hot_prod[1]->id)}}" @endif class="cust-btn">See More</a>
                                        </div>
                                        <div class="col-md-6">
                                            <!--<span class="product_price">$ 2001 - $ 1500</span>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="hot_product_listing no-margin">
                                <h5 class="relative">@if(isset($hot_prod[2])) {{$hot_prod[2]->name}} @endif
                                <!--<span>1-22 off 20 <i class="fa fa-angle-down"></i></span>-->
                                </h5>
                                <div class="product_img product_video relative">
                                    <!-- <img height="200" width="200" src="{{ url('public/media/front/images/bg-privacy-policy.jpg') }}" alt="Product Image"/> -->
                                    <img src="public/media/front/img/bg-privacy-policy.jpg" alt="play" class="video-png"/>
                                    <span class="play_video"><a href="#video_modal" data-toggle="modal"><img src="public/media/front/images/download.png" alt="play" class="video-png"/></a></span>
                                </div>
                                <div class="common_buttons">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a  @if(isset($hot_prod[2])) href="{{url("/product/".$hot_prod[2]->id)}}" @endif class="cust-btn">See More</a>
                                        </div>
                                        <div class="col-md-6">
                                            <!--<span class="product_price">$ 2001 - $ 1500</span>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="hot_product_listing no-margin">
                                <h5 class="relative">@if(isset($hot_prod[3])) {{$hot_prod[3]->name}} @endif
                                <!--<span>1-22 off 20 <i class="fa fa-angle-down"></i></span>-->
                                </h5>
                                <div class="product_img">
                                    <img height="200" width="200" @if(isset($hot_prod[3])) src="{{url("/storage/app/public/product/image/".$hot_prod[3]->productDescription->image)}}" @endif alt="Product Image"/>
                                </div>
                                <div class="common_buttons">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a @if(isset($hot_prod[3])) href="{{url("/product/".$hot_prod[3]->id)}}" @endif class="cust-btn">See More</a>
                                        </div>
                                        <div class="col-md-6">
                                            <!--<span class="product_price">$ 2001 - $ 1500</span>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if(isset($hot_products) && count($hot_products)>0)
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="best_categories">
                            <h5 class="relative">HOT PRODUCTS</h5>
                            <div class="best_cat_info">
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    @foreach($hot_products as $prods)
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne-{{ $prods->id }}">
                                                        <div class="prod_hold clearfix">
                                                            <span class="prod_img"><img src="{{ url('storage/app/public/product/image').'/'. $prods->productDescription->image }}" alt="image"/></span>
                                                            <span class="prod_info relative">
                                                        <h4>{{ $prods->name }}</h4>
                                                        <P>{{ $prods->productDescription->description }}</P>
                                                        <i class="fa fa-caret-down"></i>
                                                    </span>
                                                        </div>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne-{{ $prods->id }}" class="panel-collapse collapse" role="tabpanel">
                                                <div class="panel-body">
                                                    <p>{{ $prods->productDescription->description }}</p>
                                                    <a href="{{ url('/product').'/'.$prods->id }}" type="button" class="cust-btn">Book Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
{{--<!------------------------------------------------------BEST PRODUCT START------------------------------------------------>--}}
@if(isset($featured) && count($featured)>0)
{{--<section class="best_product_blk" style="background-image:url('{{ url('public/media/front/img/best_background.png') }}')">--}}
<section class="best_product_blk" style="background-image:url('{{ url('public/media/front/img/background for best products.jpg') }}')">
    <div class="container">
        <div class="main_heading"><span>BEST PRODUCTS</span></div>
        <div class="best_pro_blk">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="best_prod_lsiting">
                        <div class="best_pro_img">
                            <img height="300" width="500" @if(isset($featured[0])) src="{{url("storage/app/public/product/image/".$featured[0]->productDescription->image)}}" @endif alt="image"/>
                        </div>
                        <div class="rating_stars">
                            <span><i class="fa fa-star-o"></i></span>
                            <span><i class="fa fa-star-o"></i></span>
                            <span><i class="fa fa-star-o"></i></span>
                            <span><i class="fa fa-star-o"></i></span>
                            <span><i class="fa fa-star-o"></i></span>
                        </div>
                        <div class="product_info">
                            <p>@if(isset($featured[0])) {{$featured[0]->productDescription->description}}... @endif</p>
                        </div>
                        <div class="best_pro_action">
                            <ul class="clearfix">
                                <li><a @if(isset($featured[0])) href="{{url("/product/".$featured[0]->id)}}" @endif class="cust-btn">See More</a></li>
                                <!--                                <li><i class="fa fa-dollar"></i> 202</li>
                                                                <li><i class="fa fa-dollar"></i> 303</li>-->
                                <li><i class="fa fa-heart"></i> (15)</li>
                                <li><i class="fa fa-repeat"></i> (15)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div id="mid_product_slider" class="best_prod_lsiting middle_product owl-carousel">
                        <div class="item">
                            <div class="best_pro_action">
                                <ul class="clearfix text-left">
                                    <li>@if(isset($featured[1])) {{$featured[1]->name}} @endif</li>
                                    <!--                                    <li><i class="fa fa-dollar"></i> 202</li>
                                                                        <li><i class="fa fa-dollar"></i> 303</li>-->
                                    <li><a @if(isset($featured[1])) href="{{url("/product/".$featured[1]->id)}}" @endif class="cust-btn">See More</a></li>
                                </ul>
                            </div>
                            <div class="best_pro_img">
                                <img height="300" width="500" @if(isset($featured[1])) src="{{url("storage/app/public/product/image/".$featured[1]->productDescription->image)}}" @endif alt="image"/>
                            </div>
                        </div>

                        <div class="item">
                            <div class="best_pro_action">
                                <ul class="clearfix text-left">
                                    <li>@if(isset($featured[2])) {{$featured[2]->name}} @endif</li>
                                    <!--                                    <li><i class="fa fa-dollar"></i> 202</li>
                                                                        <li><i class="fa fa-dollar"></i> 303</li>-->
                                    <li><a @if(isset($featured[2])) href="{{url("/product/".$featured[2]->id)}}" @endif class="cust-btn">See More</a></li>
                                </ul>
                            </div>
                            <div class="best_pro_img">
                                <img height="300" width="500" @if(isset($featured[2])) src="{{url("storage/app/public/product/image/".$featured[2]->productDescription->image)}}" @endif alt="image"/>
                            </div>
                        </div>
                        <div class="item">
                            <div class="best_pro_action">
                                <ul class="clearfix text-left">
                                    <li>@if(isset($featured[3])){{$featured[3]->name}} @endif</li>
                                    <!--                                    <li><i class="fa fa-dollar"></i> 202</li>
                                                                        <li><i class="fa fa-dollar"></i> 303</li>-->
                                    <li><a @if(isset($featured[3])) href="{{url("/product/".$featured[3]->id)}}" @endif class="cust-btn">See More</a></li>
                                </ul>
                            </div>
                            <div class="best_pro_img">
                                <img height="300" width="500" @if(isset($featured[3])) src="{{url("storage/app/public/product/image/".$featured[3]->productDescription->image)}}" @endif alt="image"/>
                            </div>
                        </div>
                    </div>
                    <!-- <div id="mid_product_slider_sec" class="best_prod_lsiting middle_product owl-carousel">
                         <div class="item">
                             <div class="best_pro_action">
                                 <ul class="clearfix text-left">
                                     <li>Bangles</li>
                                     <li><i class="fa fa-dollar"></i> 202</li>
                                     <li><i class="fa fa-dollar"></i> 303</li>
                                     <li><a href="javascript:void(0);" class="cust-btn">Buy Now</a></li>
                                 </ul>
                             </div>
                             <div class="best_pro_img">
                                 <img src="public/media/front/img/25.png" alt="image"/>
                             </div>
                         </div>
                         <div class="item">
                             <div class="best_pro_action">
                                 <ul class="clearfix text-left">
                                     <li>Bangles</li>
                                     <li><i class="fa fa-dollar"></i> 202</li>
                                     <li><i class="fa fa-dollar"></i> 303</li>
                                     <li><a href="javascript:void(0);" class="cust-btn">Buy Now</a></li>
                                 </ul>
                             </div>
                             <div class="best_pro_img">
                                 <img src="public/media/front/img/25.png" alt="image"/>
                             </div>
                         </div>
                         <div class="item">
                             <div class="best_pro_action">
                                 <ul class="clearfix text-left">
                                     <li>Bangles</li>
                                     <li><i class="fa fa-dollar"></i> 202</li>
                                     <li><i class="fa fa-dollar"></i> 303</li>
                                     <li><a href="javascript:void(0);" class="cust-btn">Buy Now</a></li>
                                 </ul>
                             </div>
                             <div class="best_pro_img">
                                 <img src="public/media/front/img/25.png" alt="image"/>
                             </div>
                         </div>
                     </div>-->
                    <div class="best_prod_lsiting middle_product best-product-video">
                        <video width="100%" height="100%" controls>
                            <source src="public/media/front/video/video3.mp4" type="video/mp4">
                            <source src="public/media/front/video/video3.ogg" type="video/ogg">
                        </video>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="best_prod_lsiting">
                        <div class="best_pro_img">
                            <img height="300" width="500" @if(isset($featured[4])) src="{{url("storage/app/public/product/image/".$featured[4]->productDescription->image)}}" @endif alt="image"/>
                        </div>
                        <div class="rating_stars">
                            <span><i class="fa fa-star-o"></i></span>
                            <span><i class="fa fa-star-o"></i></span>
                            <span><i class="fa fa-star-o"></i></span>
                            <span><i class="fa fa-star-o"></i></span>
                            <span><i class="fa fa-star-o"></i></span>
                        </div>
                        <div class="product_info">
                            <p>@if(isset($featured[4])) {{$featured[4]->productDescription->description}}... @endif</p>
                        </div>
                        <div class="best_pro_action">
                            <ul class="clearfix">
                                <li><a  @if(isset($featured[4])) href="{{url("/product/".$featured[4]->id)}}" @endif class="cust-btn">See More</a></li>
                                <!--                                <li><i class="fa fa-dollar"></i> 202</li>
                                                                <li><i class="fa fa-dollar"></i> 303</li>-->
                                <li><i class="fa fa-heart"></i> (15)</li>
                                <li><i class="fa fa-repeat"></i> (15)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!---------------------------------------------------------OUR BRANDS------------------------------------------------------>
<section class="our_brands_blk our_brand_after" style="background-image:url('{{ url('public/media/front/img/PISTA.jpg') }}')">
    <div class="container">
        <div class="main_heading"><span>OUR BRANDS</span></div>
        <div class="brand_holder">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="brand_item_holder">
                        <div class="brand_item">
                            <div class="brand_item_image">
                                <img src="public/media/front/img/paras_fashions_logo.png" alt="Brand Image"/>
                            </div>
                            <a href="{{ url('/search-product?brand=parasfashions')  }}" type="button" class="product_purchase">Shop now</a>
                        </div>
                        <div class="brand_info">Paras Fashions Exclusive Fashion Jewellery</div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="brand_item_holder">
                        <div class="brand_item">
                            <div class="brand_item_image">
                                <img src="public/media/front/img/aksana_logo.png" alt="Brand Image"/>
                            </div>
                            <a href="{{ url('/search-product?brand=aksana')  }}" type="button" class="product_purchase">Shop now</a>
                        </div>
                        <div class="brand_info">Aksana Leggings Exclusive Legging</div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="brand_item_holder">
                        <div class="brand_item center_brand">
                            <div class="brand_item_image">
                                <img src="public/media/front/img/jutti.png" alt="Brand Image"/>
                            </div>
                            <a href="{{ url('/search-product?brand=jutti')  }}" type="button" class="product_purchase">Shop now</a>
                        </div>
                        <div class="brand_info">Designer  Jutti & Fashion Accessories By Paras Fashions</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--<!------------------------------------------------------OUR GALLERY-------------------------------------------------------->--}}
@if(isset($gallery_media) && count($gallery_media)>0)
{{--<section class="our_gallery" style="background-image:url('{{url('/public/media/front/img/hot_product.png')}}')">--}}
<section class="our_gallery" style="background-image:url('{{url('/public/media/front/img/background for our gallery.jpg')}}')">
	<div class="container">
        <div class="main_heading"><span>OUR GALLERY</span></div>
        <div class="gallery_slider_blk relative">
            <div class="row">
                <div class="col-md-12">
                    <div id="gallery_slider" class="gallery_images_slider owl-carousel shuffledv">
                        @foreach($gallery_media as $gallery)
                        @if($gallery->content_type == '0')
                        <div class="item">
                            <div class="gallery_holder">
                                <img src="{{ url('storage/app/public/gallery/images').'/'. $gallery->path }}" alt="image"/>
                                <!--<span class="gallery_heading">SHOP THIS PRODUCT</span>-->
                            </div>
                        </div>
                        @else
                        <div class="item">
                            <div class="gallery_holder">
                                <video width="400" controls>
                                    <source src="{{ url('storage/app/public/gallery/videos').'/'.$gallery->path }}" type="video/mp4">
                                </video>
                                <!--<span class="gallery_heading">SHOP THIS PRODUCT</span>-->
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="gallery_categories_blk">
        	<div id="gallery_categories_slider" class="owl-carousel">
            	<div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=290') }}"><img src="public/media/front/img/Bangles.jpg" alt="image"/></a>
                        <span class="gallery_heading">Bangles</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=286') }}"><img src="public/media/front/img/bridal mala.jpg" alt="image"/></a>
                        <span class="gallery_heading">Bridal mala</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=285') }}"><img src="public/media/front/img/Choker Set.jpg" alt="image"/></a>
                        <span class="gallery_heading">Choker Set</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=302') }}"><img src="public/media/front/img/damini.jpg" alt="image"/></a>
                        <span class="gallery_heading">Damini</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=231') }}"><img src="public/media/front/img/earrings.jpg" alt="image"/></a>
                        <span class="gallery_heading">Earrings</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=297') }}"> <img src="public/media/front/img/Finger Rings.jpg" alt="image"/></a>
                        <span class="gallery_heading">Finger Rings</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=305') }}"><img src="public/media/front/img/Haath Panja.jpg" alt="image"/></a>
                        <span class="gallery_heading">Haath Panja</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=280') }}"> <img src="public/media/front/img/Jumka.jpg" alt="image"/></a>
                        <span class="gallery_heading">Jumka</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=306') }}"> <img src="public/media/front/img/kalira.jpg" alt="image"/></a>
                        <span class="gallery_heading">kalira</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=244') }}"> <img src="public/media/front/img/Maang Tikka.jpg" alt="image"/></a>
                        <span class="gallery_heading">Maang Tikka</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=312') }}"><img src="public/media/front/img/Nath.jpg" alt="image"/></a>
                        <span class="gallery_heading">Nath</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=232') }}"><img src="public/media/front/img/Passa.jpg" alt="image"/></a>
                        <span class="gallery_heading">Passa</span>
                    </div>
                </div>
                <div class="item">
                	<div class="gallery_holder">
                        <a href="{{ url('search-product?category=288') }}"><img src="public/media/front/img/Payal.jpg" alt="image"/></a>
                        <span class="gallery_heading">Payal</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
{{--<!----------------------------OUR TESTIMONIALS & REVIEW BLOCK-------------------------------------------------------------->--}}
<section class="testimonials_blk">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="testimonials_holder">
                    <div class="testimonials_slider owl-carousel">
                        <div class="item">
                            <div class="main_heading"><span>Our testimonial</span></div>
                            <div class="test_img">
                                <img src="public/media/front/img/ashish.png" alt="testimonials image" height="100" width="100"/>
                            </div>
                            <div class="testionials_description">
                                <p>Thanks @parasfashions for the customised product i wanted something to go with my sister’s wedding dress but the jewellery which she selected was having different colour stones so their team  went out and customised the product as per my sister's  dress colour and in a very quick time ...a Big Thank You for timely customised  delivery</p>
                                <p><a href="javascript:void(0)">View all testmonials</a></p>
                                <div class="testimonial_writer">Ashish Chawla </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="main_heading"><span>Our testimonial</span></div>
                            <div class="test_img">
                                <img src="public/media/front/img/chawla.jpg" alt="testimonials image" height="100" width="100"/>
                            </div>
                            <div class="testionials_description">
                                <p>Very creative and beautiful products for every function of Punjabi shaadi, I usually go and buy from their shop at Canada but recently wanted to order for my cousin in UK so ordered online and got timely delivery.... Thank You Team</p>
                                <p><a href="javascript:void(0)">View all testmonials</a></p>
                                <div class="testimonial_writer">Manaa Chawla</div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="main_heading"><span>Our testimonial</span></div>
                            <div class="test_img">
                                <img src="public/media/front/img/vandana.jpg" alt="testimonials image" height="100" width="100"/>
                            </div>
                            <div class="testionials_description">
                                <p>Amazing Experience shopping @Parasfashions. They have a very good, unique and vast  collection of Traditional Indian Bridal jewellery covering all areas from head to toe ...they even arranged for online video call giving me experience of virtually being in their store and helping me select my jewellery...Wonderful !!!</p>
                                <p><a href="javascript:void(0)">View all testmonials</a></p>
                                <div class="testimonial_writer">Vandana Monga</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="testimonials_holder review_holder">
                    <div class="main_heading"><span>Our testimonial</span></div>
                    <div class="uploader_holder">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="upload_image text-center"><input type="file"><i class="fa fa-camera"></i> <span>Upload your image</span></div>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12 clearfix">
                                <div class="average_rating">Rating and Review <span>4.2 <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i></span></div>
                                <div class="rate_this"><a href="javascript:void(0);" class="rating-btn">Rate this Product</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="product_rating_blk">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="product_image text-center">
                                    <img style="margin-right:50px;" src="public/media/front/img/vandana.jpg" alt="product image" height="100" width="100"/>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="rating_review_count">
                                    <p>11 Rating  & 5 Reviews</p>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <div class="rating_progress_holder">
                                    <img src="public/media/front/img/rating.png" alt="rating image"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="coment_blks">
                        <div class="writer_information">Vandana Monga</div>
                        <div class="coment_hold_blk">
                            <ul class="clearfix">
                                <li><p>Certified buyer</p></li>
                                <li><p>19 Nov 2017</p></li>
                                <li><a href="javascript:void(0);"><span><i class="fa fa-thumbs-o-up"></i> 500</span></a></li>
                                <li><a href="javascript:void(0);"><span><i class="fa fa-thumbs-o-down"></i> 7</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="view_all_review">
                        <a href="javascript:void(0);" class="clearfix">View All Reviews <span class="plus_icon pull-right"><i class="fa fa-plus"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--<!------------------------------------------------------OUR PROFESSIONAL & ARTISTS APPOINMENT------------------------------>--}}
{{--<!-- <section class="our_story" style="url('public/media/front/img/story_bg.png')">--}}
    {{--<div class="container">--}}
        {{--<div class="main_heading"><span>OUR STORY</span></div>--}}
        {{--<div class="heading_description">--}}
            {{--Accumulation of Incredible Memories, Inspirations behind our Products, Customers Experiences &  Stories  all captured , collected  and presented beautifully in a place where everyone of us can connect and share with all . Come and be a part of our family and in our Journey--}}
            {{--<a href="{{url("/get-all-user-stories/user-story")}}">Read More</a>--}}
        {{--</div>--}}
        {{--<div class="story_holder">--}}
            {{--<div class="row">--}}
                {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                    {{--<div class="story_video_holder">--}}
                        {{--<video width="100%" height="420px" controls autoplay loop>--}}
                            {{--<source src="public/media/front/video/video3.mp4" type="video/mp4">--}}
                            {{--<source src="public/media/front/video/video3.ogg" type="video/ogg">--}}
                        {{--</video>--}}

                        {{--<!--<img src="img/31.jpg" alt="video"/>-->--}}
                        {{--<!--<span class="paly_opt"><a href="javascript:void(0);"><img src="public/media/front/img/youtube.png" alt="img"/></a></span>-->--}}
                        {{--<!--<div class="video_counter">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-md-6 col-sm-6 col-xs-12"><p>WATCH  THIS  VIDEO....</p></div>--}}
                                {{--<div class="col-md-4 col-sm-4 col-xs-12"><p><i class="fa fa-eye"></i> 250</p></div>--}}
                                {{--<div class="col-md-2 col-sm-2 col-xs-12"><p class="text-right"><span><a href="javascript:void(0);"><i class="fa fa-backward"></i></a></span> <span><a href="javascript:void(0);"><i class="fa fa-forward"></i></a></span></p></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                    {{--<div class="story_jwellory_design">--}}
                        {{--<div class="jwellory_caption clearfix">--}}
                            {{--<span class="pull-left">OUR CUSTOM JEWELLERY DESIGN</span>--}}
                            {{--<span class="pull-right"><a href="{{ url("/get-all-user-stories/user-story") }}" class="show_more">Show More</a></span>--}}
                        {{--</div>--}}
                        {{--<img src="public/media/front/img/32.jpg" alt="img"/>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</section> -->--}}
{{--<!-------------------------------------------OUR PROFESSIONAL & ARTISTS APPOINMENT------------------------>--}}
<section class="our_story" style="background-image:url('http://192.168.2.26/p1116/public/media/front/img/bg-privacy-policy1.jpg')">
    <div class="container">
        <div class="main_heading"><span>OUR STORY</span></div>
        <div class="heading_description">
            Accumulation of Incredible Memories, Inspirations behind our Products, Customers Experiences &  Stories  all captured , collected  and presented beautifully in a place where everyone of us can connect and share with all . Come and be a part of our family and in our Journey
            <a href="{{url("/get-all-user-stories/user-story")}}">Read More</a>
        </div>
        <div class="story_holder">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="story_video_holder">
                        <video width="100%" height="420px" controls autoplay loop>
                            <source src="public/media/front/video/video3.mp4" type="video/mp4">
                            <source src="public/media/front/video/video3.ogg" type="video/ogg">
                        </video>

                        <!--<img src="img/31.jpg" alt="video"/>-->
                        <!--<span class="paly_opt"><a href="javascript:void(0);"><img src="public/media/front/img/youtube.png" alt="img"/></a></span>-->
                        <div class="video_counter">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12"><p>WATCH  THIS  VIDEO....</p></div>
                                <div class="col-md-4 col-sm-4 col-xs-12"><p><i class="fa fa-eye"></i> 250</p></div>
                                <div class="col-md-2 col-sm-2 col-xs-12"><p class="text-right"><span><a href="javascript:void(0);"><i class="fa fa-backward"></i></a></span> <span><a href="javascript:void(0);"><i class="fa fa-forward"></i></a></span></p></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="story_jwellory_design">
                        <div class="jwellory_caption clearfix">
                            <span class="pull-left">OUR CUSTOM JEWELLERY DESIGN</span>
                            <span class="pull-right"><a href="{{ url("/get-all-user-stories/user-story") }}" class="show_more">Show More</a></span>
                        </div>
                        <img src="public/media/front/img/32.jpg" alt="img"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--<!------------------------------------------------------OUR PROFFESSIONALS BLOCK START------------------------------------>--}}
@if(isset($all_artist) && count($all_artist)>0)
<section class="professional_block">
	<div class="container">
    	<div class="main_heading"><span>Our PROFESSIONAL AND ARTISTS APPOINTMENT</span></div>
        <div class="professional_holder">
        	<div id="artist_gal" class="artist_gallery owl-carousel">
                @foreach($all_artist as $artist)
                <div class="item">
                    <div class="profess_holder">
                        <h5>{{ $artist->first_name. ''. $artist->last_name }}</h5>
                        <div class="artist_img counter-style">
                            <div class="artist_img_after">
                                <img src="{{ url('storage/app/public/artist/').'/'.$artist->profile_image }}" alt="image"/>
                            </div>
                        </div>
                        <div class="artist_countact">
                        	<div class="country_flag"><h5>Country :-</h5><span class="flag"><img src="{{ url('storage/app/public/artist/country/').'/'.$artist->country_flag }}" alt="country"/></span></div>
                            <!--<h5>Country :-</h5>-->
                            <p>{{ $artist->description }}</p>
                            <!--<div class="country_flag"><img src="img/india.png" alt="country"/></div>-->
                            {{--  href="{{ url('/artist/appointment').'/'. $artist->id }}" --}}
                            <a id ="{{ $artist->id }}" style="text-decoration: none" onclick="chkArtist(this.id)" type="button" class="contact_btn">Contact</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
{{--<!--------------------------------------JOIN THE CONVERSION START------------------------>--}}
{{--<section class="conversion_blk" style="background-image:url('{{ url('public/media/front/img/34.png') }}')">--}}
<section class="conversion_blk" style="background-image:url('{{ url('public/media/front/img/bg-hot-products.jpg') }}');">
    <div class="container">
        <div class="main_heading"><span>JOIN THE CONVERSATION</span></div>
        <div class="conversion_holder">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="conversion_video">
                        <div class="video_blk" style="background-image:url('{{ url('public/media/front/img/Paras-Fashions.jpg') }}'); background-size:cover; background-position:center center; background-repeat:no-repeat;">
                            <video width="100%" height="295px" controls>
                                <source src="{{url('public/media/front/video/video_1.mp4')}}" type="video/mp4">
                                <source src="{{url('public/media/front/video/video_1.ogg')}}" type="video/ogg">
                            </video>
                            <!--<img src="img/Paras-Fashions--New_109.jpg" alt="video"/>-->
                            <!--<div class="youtube_play"><img src="img/play_youtube.png" alt="play"/></div>-->
                            <!--<div class="video_desp"><i class="fa fa-list"></i> Lorem ipsum dolor sit amet</div>-->
                        </div>

                        <a style="cursor:pointer;text-decoration: none" onclick="openInNewTab('{{ GlobalValues::get("youtube-link") }}')">
                            <span class="title_conversion">On YouTube</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="on_facebook_page">
                        <div class="facebook_holder">
                            <div class="heading_holder clearfix">
                                <div class="fc_content_logo">
                                    <img src="public/media/front/img/logo.png" alt="logo"/>
                                </div>
                                <div class="fc_content">
                                    <p>Lorem ipsum dolor sit amet</p>
                                    <p><i class="fa fa-facebook"></i> Page like (2525)</p>
                                </div>
                            </div>
                            <div class="messages_holder">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active text-left"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Message</a></li>
                                    <li role="presentation" class="text-right"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Timeline</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">
                                        <div class="message_area mCustomScrollbar">Lorem ipsum dolor sit amet, consec adipiscing elit. Maecenas lacinia libero viverra scelerisque nec a velit. Quisq diam at elit tempus Maecenas lacinia l dolor viverra scelerisque nec a velit.  quis diam at elit tempus faucibus at massa. <a href="javascript:void(0);">Read More...</a></div></div>
                                    <div role="tabpanel" class="tab-pane" id="profile"><div class="message_area mCustomScrollbar">Lorem ipsum dolor sit amet, consec adipiscing elit. Maecenas lacinia libero viverra scelerisque nec a velit. Quisq diam at elit tempus Maecenas lacinia l dolor viverra scelerisque nec a velit.  quis diam at elit tempus faucibus at massa. <a href="javascript:void(0);">Read More...</a></div></div>
                                </div>
                            </div>
                        </div>
                        <a style="cursor:pointer;text-decoration: none" onclick="openInNewTab('{{ GlobalValues::get("facebook-link") }}')">     <span class="title_conversion">On Facebook Page</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="conversion_video">
                        <div class="video_blk">
                            <img src="public/media/front/img/35.jpg" alt="video"/>
                            <div class="youtube_play"><img src="public/media/front/img/insta.png" alt="play"/></div>
                        </div>
                        <a style="cursor:pointer;text-decoration: none" onclick="openInNewTab('{{ GlobalValues::get("instagram-link") }}')"> <span class="title_conversion">On Instagram</span></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="conversion_video">
                        <div class="video_blk">
                            <img src="public/media/front/img/35.jpg" alt="video"/>
                            <div class="youtube_play"><img src="public/media/front/img/pintrest.png" alt="play"/></div>
                        </div>
                        <a style="cursor:pointer;text-decoration: none" onclick="openInNewTab('{{ GlobalValues::get("pinterest-link") }}')"> <span class="title_conversion">On Pintrest</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--<!--------------------------------------OUR FOLLOWERS----------------------------------- -->--}}
<section class="our_followers">
	<div class="main_heading"><span>OUR FOLLOWERS</span></div>
    <div class="container">
    	<div class="map_blk">
        	<img src="public/media/front/img/Store_locator.png" alt="map"/>
        </div>
    </div>
</section>
<!------------------------------------------------------GET OFFERS START------------------------------------------------- -->
<section class="get_offers" style="display:none;">
    <div class="get_offers_heading">GET RS 200 OFF !</div>
    <div class="get_offers_info">

    </div>
</section>
@if(Auth::check())
    <?php
    $user=Auth::user();

    ?>
    @if($user->userInformation->birth_date=="")


        <div class="par-birthday relative" id="closepopup">
            <div class="closing-notify">
                <img alt="close" src="{{url("public/media/front/img/cancel.png")}}" onclick="closePopup();">

            </div>
            <div class="birth-message">
                <!--<h3 class="birth-head">Notification</h3>-->
                <div class="birth-messages">
                    <p class="birth-message">Update Birth Date and Anniversary Date to get more coupons and discounts</p>
                    <a href="{{url("/update-profile")}}">Update Profile</a>
                </div>
            </div>
        </div>
    @endif
@endif
@if(Auth::check())
    <?php
    $user=Auth::user();

    ?>
    @if(Session::has('subscription_message'))


        <div class="par-birthday relative" id="closenewslatter">
            <div class="closing-notify">
                <img alt="close" src="{{url("public/media/front/img/cancel.png")}}" onclick="closeNewslatter();">

            </div>
            <div class="birth-message">
                <!--<h3 class="birth-head">Notification</h3>-->
                <div class="birth-messages">
                    <p class="birth-message">You have successfully unsubscribe to newslatter </p>
                </div>
            </div>
        </div>
    @endif
@endif

<!------------------------------MODAL BLOCK HERE---------------------------->
<!-- Modal -->
<div class="modal fade" id="video_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Product Video</h4>
      </div>
      <div class="modal-body">
      	<div class="video_section">
        	<video width="400" controls>
                <source src="public/media/front/video/video_1.mp4" type="video/mp4">
                <source src="public/media/front/video/video_1.ogg" type="video/ogg">
            </video>
        </div>
      </div>      
    </div>
  </div>
</div>
<script>
        // $(".shuffledv").each(function() {
        //     var divs = $(this).find('div');
        //     for (var i = 0; i < divs.length; i++) $(divs[i]).remove();
        // });
        $(document).ready(function() {
            shuffle();
            // var $parent = $(".shuffledv");
            // var $divs = $parent.children().attr('class','items');
            // setInterval(function() {
            //     var $clone = $divs.slice();
            //     while ($clone.length) {
            //         $parent.append($clone.splice(Math.floor(Math.random() * $clone.length), 1));
            //     }
            // }, 2000);
            // var $parent = $(".shuffledv");
            // var $divs = $parent.children().attr('class','items');
            // setInterval(function() {
            //     var divs = $(this).children().attr('class', 'items');
            //     for (var i = 0; i < divs.length; i++) $(divs[i]).remove();
            //     //the fisher yates algorithm, from http://stackoverflow.com/questions/2450954/how-to-randomize-a-javascript-array
            //     var i = divs.length;
            //     if (i == 0) return false;
            //     while (--i) {
            //         var j = Math.floor(Math.random() * (i + 1));
            //         var tempi = divs[i];
            //         var tempj = divs[j];
            //         divs[i] = tempj;
            //         divs[j] = tempi;
            //     }
            //     for (var i = 0; i < divs.length; i++) $(divs[i]).appendTo(this);
            //
            // },2000);
            function shuffle() {
                $(".shuffledv").each(function () {
                    var divs = $(this).children().attr('class','items');
                    for (var i = 0; i < divs.length; i++) $(divs[i]).remove();
                    //the fisher yates algorithm, from http://stackoverflow.com/questions/2450954/how-to-randomize-a-javascript-array
                    var i = divs.length;
                    if (i == 0) return false;
                    while (--i) {
                        var j = Math.floor(Math.random() * (i + 1));
                        var tempi = divs[i];
                        var tempj = divs[j];
                        divs[i] = tempj;
                        divs[j] = tempi;
                    }
                    for (var i = 0; i < divs.length; i++) $(divs[i]).appendTo(this);
                });
            }
        });
    </script>

    <script>
		// $(document).ready(function(){
			// $('a[href^="#"]').on('click',function (e) {
			//     e.preventDefault();
			//     var target = this.hash,
			//     $target = $(target);

			//     $('html, body').stop().animate({
			//         'scrollTop': $target.offset().top
			//     }, 900, 'swing', function () {
			//         window.location.hash = target;
			//     });
			// });
		// });
	</script>
     <script>
        function closeNewslatter()
        {
          $("#closeNewslatter").hide();
        }
        function closePopup()
        {
            $("#closepopup").hide();
        }
     </script>
     <script>
         function openInNewTab(url) {
             var win = window.open(url, '_blank');
             win.focus();
         }

         function chkArtist(id) {
             if('<?php echo Auth::check() ?>')
             {
                path  = javascript_site_path + 'artist/appointment/' + id;
                 location.href = path;
             }
             else {
                 alert("Please login to make contact with artist");
             }

         }
     </script>
@endsection

 