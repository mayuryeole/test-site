@extends('layouts.app')
@section('content')
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5abf4c49ac6a854d"></script>
    {{--<section class="cust-bread">--}}
        {{--<div class="container">--}}
            {{--<ul class="clearfix">--}}
                {{--<li><a href="javascript:void(0);">Home</a></li>--}}
                {{--<li>APPOINTMENT FORM</li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--</section>--}}
    @php $c1= 0; @endphp
    @php $c2= 0; @endphp
    <section class="purchase-product second_details adj-pad">
        <div class="container-fluid">
            <div class="product_details_block">
                <div class="cust-bread">
                    <ul class="clearfix">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        @if(isset($parent_cats) && count($parent_cats)>0)
                         @foreach($parent_cats as $cat)
                                <li><a href="{{ url('/search-product?category=').$cat->category_id }}">{{ $cat->name }}</a></li>
                         @endforeach
                        @endif
                        <li><a href="javascript:void(0)">{{ $pro->name }}</a></li>
                        {{----}}
                        {{--<li><a href="{{ url('/search-product') }}">Search Product</a></li>--}}
                        {{--<li><a href="javascript:void(0);">Product Details</a></li>--}}
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="product_details_information">
                            <h3>{{ $pro->name }}
                                 @if($pro->is_original == 1)
                                    <span id="spn-price">
                                    {{ App\Helpers\Helper::getCurrencySymbol().number_format(App\Helpers\Helper::getRealPrice($pro->discount_rate),2,'.','')  }}
                                     </span>
                                        @elseif($pro->is_original == 0)
                                    <span id="spn-price">
                                      {{ App\Helpers\Helper::getCurrencySymbol().number_format(App\Helpers\Helper::getRealPrice($pro->price),2,'.','') }}
                                    </span>
                                         @elseif($pro->is_original == 2)
                                    <span id="spn-price" class="h-interested-link">
                                    <a style="text-decoration: none" onclick="productRateRequest('{{ $pro->id }}')">Request For Rate</a>
                                    </span>
                                          @if($pro->productDescription['is_featured'] == 1)
                                              <button class="btn btn-success" type="button">Featured</button>
                                          @endif
                                      @endif
                            </h3>
                            <!-- <div class="product_details_desp">
                                <p>
                                    {{ (strlen($pro->productDescription['description'])>100)?substr($pro->productDescription['description'],0,100)."...":$pro->productDescription['description'] }}

                                </p>
                            </div> -->
                            <div class="hidden_information">
                                <div class="panel-group" id="accordion" role="tablist">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseOne">View Details</a>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                <p>{{ $pro->productDescription['description'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="customize-product text-center">--}}
                                {{--<button type="button" class="btn notify_me" data-toggle="modal"--}}
                                        {{--data-target="#customize-prodct-btn">Customize Product--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="product_details_slider text-center">
                            <div class="details_product_slider owl-carousel">
                                    @if(isset($pro->productImages) && count($pro->productImages)>0)
                                    @foreach($pro->productImages as $im)
                                        @if($im->color == $pro->productDescription['color'])
                                        @if(isset($im->productColorImages) && count($im->productColorImages)>0)
                                        @foreach($im->productColorImages as $colrImg)
                                        @if(!empty($colrImg->image))
                                        <div id="dv-itm-colr-img-{{ $im->id.'-'.$colrImg->id }}" class="item all-car-col-img-dv car-col-img-dv-{{ $colrImg->product_image_id }}">
                                            <img src="{{ url('storage/app/public/product/product_images') }}/{{ $colrImg->image }}"
                                                 alt="product_image">
                                        </div>
                                        @endif
                                        @endforeach
                                      @endif
                                     @endif
                                    @endforeach
                                    @else
                                    @if(!empty($pro->productDescription->image))
                                        <div class="item">
                                            <img  alt="product_image" src="{{ url('storage/app/public/product/image') }}/{{ $pro->productDescription->image  }}">
                                        </div>
                                    @endif
                                    @endif
                            </div>
                        </div>
                        <div class="demo-gallery">
                            <ul id="lightgallery" class="list-unstyled row">
                                @if(isset($pro->productImages) && count($pro->productImages)>0)
                                    @foreach($pro->productImages as $im)
                                        @if($im->color == $pro->productDescription['color'])
                                        @if(isset($im->productColorImages) && count($im->productColorImages)>0)
                                            @foreach($im->productColorImages as $colrImg)
                                                @if(!empty($colrImg->image))
                                <li id="li-light-gal-{{ $im->id.'-'.$colrImg->id }}" class="col-xs-6 col-sm-4 col-md-3 btm_img all-t-col-img t-col-img-{{ $colrImg->product_image_id }}"
                                    data-responsive="{{ url('storage/app/public/product/product_images') }}/{{ $colrImg->image }}, {{ url('storage/app/public/product/product_images') }}/{{ $colrImg->image }}, {{ url('storage/app/public/product/product_images') }}/{{ $colrImg->image }}"
                                    data-src="{{ url('storage/app/public/product/product_images') }}/{{ $colrImg->image }}"
                                    data-sub-html="<h4>{{ $pro->name }}</h4><p>{{ $pro->productDescription->description }}</p>">
                                    <a href="">
                                        <img src="{{ url('storage/app/public/product/product_images') }}/{{ $colrImg->image }}"
                                             alt="product_image">
                                    </a>
                                </li>
                                                @endif
                                            @endforeach
                                        @endif
                                        @endif
                                    @endforeach
                                @else
                                    <li class="col-xs-6 col-sm-4 col-md-3 btm_img"
                                        data-responsive="{{ url('storage/app/public/product/image') }}/{{ $pro->productDescription->image }}"
                                        data-src="{{ url('storage/app/public/product/image') }}/{{ $pro->productDescription->image }}"
                                        data-sub-html="<h4></p>">
                                        <a href="">
                                            <img src="{{ url('storage/app/public/product/image') }}/{{ $pro->productDescription->image }}"
                                                 alt="product_image">
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <div class="click-to-slide text-center">Click on smaller image to see slider</div>

                        <!--  <div class="product_details_inf">
                             <h3>Paras Fassion</h3>
                         </div> -->
                    </div>
                    @if(isset($cartItem) && count($cartItem)>0 && $cartItem !='')
                        <form id="update-cart-pro-dets" action="{{ url('update-product-to-cart-form') }}" method="post"
                              type="form" onsubmit="return validateForm()">
                            <input type="hidden" id="ip-cart-id"
                                   @if(isset($cart) && count($cart)>0) value="{{ $cart->id }}" @endif>
                            <input type="hidden" id="ip-cart-item-id"
                                   @if(isset($cartItem) && count($cartItem)>0) value="{{ $cartItem->id }}" @endif >
                    @else
                                <form id="add-to-cart-pro-dets" action="{{ url('add-product-to-cart-form') }}"
                                      method="post" type="form" onsubmit="return validateForm()">
                    @endif
                                    {!!  csrf_field() !!}
                                    <input type="hidden" id="id-product-id" name="product_id"
                                           @if(isset($pro)) value="{{ $pro->id }}" @endif>
                                    <div class="col-md-3 col-sm-3">
                                        <div class="h-paras-video relative">
                                            <video width="100%" height="100%" autoplay loop>
                                                <source src="{{url("storage/app/public/product/video/".$pro->productDescription->video)}}" type="video/mp4">
                                                <source src="{{url("storage/app/public/product/video/".$pro->productDescription->video)}}" type="video/ogg">
                                            </video>
                                            <div style="" class="video-opt mg-vid-ic">
                                            <a href="{{ url('/product/show-video').'/'.$pro->id}}"><img class="video_img" src="{{ url('/public/media/front/img/video icon.png') }}"></a>
                                        </div>
                                        </div>
                                        <div class="product_details_information">
                                            @if(!empty($pro->getColor) ||  !empty($pro->productDescription->color))
                                                <div class="color-optn font-2">
                                                    <label> <span class="option"> Colors</span> <span
                                                                class="red-color"></span></label>
                                                    <ul class="list-unstyled">
                                                        {{--<li class="pro-color-apply"><img--}}
                                                                                {{--onclick="changeColor(this.id)"--}}
                                                                                {{--title="{{ strtolower($pro->productDescription->color) }}"--}}
                                                                                {{--id="{{ strtolower($pro->productDescription->color) }}"--}}
                                                                                {{--src="{{ url('public/media/front/color'.'/'.strtolower($pro->productDescription->color).'.jpg')}}"--}}
                                                                                {{--alt="{{ strtolower($pro->productDescription->color) }}">--}}
                                                                    {{--</li>--}}
                                                                
                                                        @if(isset($pro->productImages))
                                                            @foreach($pro->productImages as $c)
                                                                @if(isset($c->color) && $c->color !='')
                                                                    <li id="li-pro-color-{{ $c->id }}" class="pro-color-apply all-pro-clr-cls"><img
                                                                                onclick="changeColor(this.id)"
                                                                                title="{{ strtolower($c->color) }}"
                                                                                id="color-{{ strtolower($c->id) }}"
                                                                                src="{{ url('public/media/front/color'.'/'.strtolower($c->color).'.jpg')}}"
                                                                                alt="{{ strtolower($c->color) }}">
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                    <input id="color-name" name="color_name" type="hidden"/>
                                                </div>
                                            @endif
                                           @if(isset($pro->getProductAttribute))
                                                <div class="size-optn font-2">
                                                    <label> <span class="option"> SIZE OPTIONS </span> </label>
                                                    <ul class="list-inline">
                                                        @php $chkProdSize=0; @endphp
                                                        @foreach($pro->getProductAttribute as $attr)
                                                            @if(!empty($attr->getAttr) && !empty($attr->getAttr->trans->name) && !empty($attr->value) )
                                                                @if($attr->getAttr->trans->name == "Size")
                                                                    @php $chkProdSize++; @endphp
                                                                <li class="pro-size-apply">
                                                                    <span class="eff" title="{{ $attr->value }}"  rel="{{ $attr->value }}" id="{{ $attr->id }}" onclick="changeSizeProperties(this.id)">{{ $attr->value  }}</span>
                                                                </li>
                                                                @endif
                                                                @endif
                                                        @endforeach
                                                    </ul>
                                                    <input id="size-name" name="size_name" type="hidden"/>
                                                    <input id="chk-size" name="chk_size" value="{{ $chkProdSize }}" type="hidden"/>
                                                <span style="display: none;color: orange" id="error-msg"></span>

                                                </div>
                                            @endif


                                            <h3>
                                            @if($pro->productDescription['availability'] == 1)
                                            <span class="h-red">
                                                <input type="hidden" name="available" id="available" value="1">
                                            {{ "Out Of Stock" }}
                                            </span>
                                            @else
                                            <span class="h-green">
                                                <input type="hidden" name="available" id="available" value="0">
                                           
                                                {{ "In Stock" }}
                                            @endif
                                            </span>
                                            </h3>
                                            @if($pro->is_original != 2)
                                            <div style="margin-top: 15px;margin-bottom: 15px" class="h-add-cart-h text-center">
                                                @if(isset($cartItem) && count($cartItem)>0 && $cartItem !='')
                                                <button id="update-in-cart" class="add-cart" type="submit"><i class="fa fa-shopping-bag"></i>
                                                <span>Buy Now</span>
                                                </button>
                                                @else
                                                    <button id="add-in-cart" class="add-cart" type="submit"><i class="fa fa-shopping-bag"></i> <span>Buy Now</span>

                                                    </button>
                                                @endif
                                                    @if(Auth::check())
                                                        <button id="add-wishlist-{{ $pro->id }}" data-toggle="modal" onclick="addToWishlist('{{ $pro->id }}')" type="button" class="add-cart-data"><i
                                                                    class="fa fa-heart"></i> <span>Wishlist</span>
                                                        </button>
                                                    @endif
                                            </div>
                                            @endif
                                            @if($pro->productDescription['availability'] == 1)
                                            <div class="subscribe_email">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Email" id="subscribe-email" name="subscriber-email"/>
                                                    <span style="color: orange;font-size: 12px" id="subscribe-email-msg"></span>
                                                        <p class="notify_btn">
                                                        <button type="button" class="notify_me" onclick="subscribeNewsletter()">Notify Me</button>
                                                    </p>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="order_links">
                                                <ul class="text-center">
                                                    <!-- <li><a href="javascript:void(0);">Order by Phone</a></li> -->
                                                    {{--<li><a type="button" href="javascript:void(0);">Share</a></li>--}}
                                                    <li><a type="button" href="{{ url('/terms_conditions') }}">Terms &
                                                            Condition</a></li>
                                                            <li><a type="button" href="javascript:void(0);" data-target="#h-cust-modal-size" data-toggle="modal">Size-Guide</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @if(isset($cartItem)&& count($cartItem)>0)
                                </form>
                                @else
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>


    <section class="recomanded_products recommanded-pro-second adj-pad">
        <div class="container-fluid">
            {{--<h3>product Attributes</h3>--}}
            <div class="row">
                <div class="col-md-12"><h3 class="cart-prod-head">product Attributes</h3></div>
                <div class="col-md-7">
                    <div class="card-product-image clearfix">
                        <div class="stylist-art-imformation">
                            <div class="stylist-heading">
                                Description
                            </div>
                            <div class="stylist-description">
                                @if(isset($pro))
                                    <p> {{ $pro->productDescription['description'] }}</p>
                                @endif
                            </div>

                        </div>
                        <div class="card-accordion-info">
                            <div class="panel-group" id="accordion1" role="tablist">
                                @if(isset($pro->getProductAttribute) && count($pro->getProductAttribute)>0)
                                <div id="dv-prop-id" class="panel panel-default">
                                    <div class="panel-heading relative">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#one"
                                           aria-expanded="true">
                                             Product Properties
                                            <span class="h-icon-view-dt"><i class="fa fa-minus"></i></span>
                                        </a>
                                    </div>
                                    <div id="one" class="panel-collapse collapse in" role="tabpanel">
                                         <div class="panel-body">

                                                @foreach($pro->getProductAttribute as $attr)
                                                    @if(!empty($attr->getAttr) && !empty($attr->getAttr->trans->name) && !empty($attr->value))
                                                       @if($attr->getAttr->trans->name != "Gross Weight" && $attr->getAttr->trans->name != "Width" && $attr->getAttr->trans->name != "Height" && $attr->getAttr->trans->name != "Length" && $attr->getAttr->trans->name != "Size" && $attr->id != '31')
                                                             @php $c1++; @endphp
                                                        <div class="row">
                                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                                    <p>{{ $attr->getAttr->trans->name  }}</p></div>
                                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                                    <p>@if($attr->getAttr->trans->name == 'Country')
                                                                            @if(is_numeric($attr->value))
                                                                                @php $countryTrans =\App\PiplModules\admin\Models\CountryTranslation::where('country_id',$attr->value)->first();@endphp
                                                                                {{ $countryTrans->name }}
                                                                            @else
                                                                                {{ $attr->value }}
                                                                            @endif
                                                                       @elseif(($attr->id == 150 && $attr->value.strtolower() == 'no'))
                                                                       @else{{ $attr->value  }}
                                                                       @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                    @endif
                                                    @endif
                                                @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(isset($pro->getProductAttribute) && count($pro->getProductAttribute)>0)
                                <div id="dv-dim-id" class="panel panel-default">
                                    <div class="panel-heading relative">
                                        <a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion1"
                                           href="#two" aria-expanded="true">
                                           Product Dimensions
                                            <span class="h-icon-view-dt"><i class="fa fa-minus"></i></span>
                                        </a>
                                    </div>
                                    <div id="two" class="panel-collapse collapse" role="tabpanel">
                                        <div class="panel-body">
                                                @foreach($pro->getProductAttribute as $attrpo)
                                                    @if(!empty($attrpo->getAttr))
                                                       @if(!empty($attrpo->getAttr->trans->name) && !empty($attr->value))
                                                        @if($attrpo->getAttr->trans->name == "Gross Weight" || $attrpo->getAttr->trans->name == "Width" || $attrpo->getAttr->trans->name == "Height" || $attrpo->getAttr->trans->name == "Length")
                                                            @php $c2++; @endphp
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                                    <p>{{ $attrpo->getAttr->trans->name  }}</p></div>
                                                                <div class="col-md-6 col-sm-6 col-xs-6"><p>{{ $attrpo->value  }}</p></div>
                                                            </div>
                                                        @endif
                                                        @endif
                                                    @endif
                                                @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>                            
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="frequently-product-list">
                        @if(count($freq)>0 && $pro->is_original != 2 && $freq->is_original != 2)
                        <div class="frequently-panel">
                            <div class="panel panel-default">
                                <div class="panel-heading">Frequently Bought Together</div>
                                <div class="panel-body">
                                    <div class="freqently-body">
                                        <div class="frequently-body-inner clearfix">
                                            <div class="freq-left-side">
                                                <span class="freq-img"><img src="{{ url('storage/app/public/product/image') }}/{{ $pro->productDescription['image'] }}"></span>
                                                <span class="freq-add"><i class="fa fa-plus"></i></span>
                                                <span class="freq-img"><img src="{{ url('storage/app/public/product/image') }}/{{ $freq->productDescription['image'] }}"></span>
                                            </div>
                                            <div class="freq-right-side">
                                                <div class="freq-price">
                                                    @php
                                                    $prodPrice =0;
                                                    $freqPrice =0;
                                                        if((isset($pro) && $pro->is_original == 0) || (isset($freq) && $freq->is_original == 0))
                                                        {
                                                            if(isset($pro) && $pro->is_original == 0)
                                                            {
                                                              $prodPrice =$pro->price;
                                                            }
                                                            if(isset($freq) && $freq->is_original == 0)
                                                            {
                                                              $freqPrice =$freq->price;
                                                            }
                                                        }
                                                        elseif((isset($pro) && $pro->is_original == 1) || (isset($freq) && $freq->is_original == 1))
                                                        {
                                                             if(isset($pro) && $pro->is_original == 1)
                                                            {
                                                              $prodPrice =$pro->discount_price;
                                                            }
                                                            if(isset($freq) && $freq->is_original == 1)
                                                            {
                                                              $freqPrice =$freq->discount_price;
                                                            }
                                                        }
                                                    @endphp
                                                    <h3 class="freq-price"><span>Total Price :</span> {{ App\Helpers\Helper::getCurrencySymbol().number_format(App\Helpers\Helper::getRealPrice($prodPrice +$freqPrice),2,'.','')  }}</h3>
                                                    <form method="get" action="{{url("/add-both-to-cart")}}/{{$pro->id}}/{{$freq->id}}">
                                                    <button type="submit" class="h-cart-btn">Add both to cart</button>
                                                    </form>   
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(isset($rec) && count($rec)>0)
                        <div class="frequently-panel">
                            <div class="panel panel-default">
                                <div class="panel-heading">You might also like</div>
                                <div class="panel-body">
                                    <div class="freqently-body">
                                        <div class="might-like-block">
                                            <div class="might-like-img owl-carousel">
                                                @foreach($rec as $recm)
                                                <div class="item">
                                                    <div class="might-block">
                                                        <span class="might-img"><a href="{{ url('product').'/'.$recm->id}}"><img src="{{ url('storage/app/public/product/image') }}/{{ $recm->productDescription['image'] }}" height="100" width="100"></a></span>
                                                        <div class="might-information" style="text-align: center;">
                                                            <a href="{{ url('product').'/'.$recm->id}}">{{ $recm->name }}</a>
                                                            <h3 class="might-price">
                                                                @if($recm->is_original == 0)
                                                                    {{ App\Helpers\Helper::getCurrencySymbol().number_format(App\Helpers\Helper::getRealPrice($recm->price),2,'.','')  }}
                                                                @elseif($recm->is_original == 1)
                                                                    {{ App\Helpers\Helper::getCurrencySymbol().number_format(App\Helpers\Helper::getRealPrice($recm->discount_rate),2,'.','') }}
                                                                @elseif($recm->is_original == 2)
                                                                    Request For Rate
                                                                @endif
                                                            </h3>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="rating">--}}
            {{--<div class="container-fluid">--}}
                {{--<div class="row review_sec">--}}
                    {{--<hr>--}}
                    {{--<div class="col-md-7 col-md-offset-1">--}}

                        {{--<div class="review_head">--}}
                            {{--<h2>STYLE GALLERY</h2>--}}
                            {{--<p> The style gallery a great new way of you to outfit The style gallery a great new way of--}}
                                {{--you to outfit The style gallary a great new way of you to out fit .</p>--}}
                            {{--<p>Earn 20 own photos uploading</p>--}}
                            {{--<button>UPLOAD YOUR PHOTO</button>--}}
                        {{--</div><!-- reveiw_head -->--}}


                        {{--<div class="rating_head clearfix">--}}

                            {{--<h2>CUSTOMER REVIEW(102)</h2>--}}
                            {{--<div class="left_rating">--}}
                                {{--<h4>Average Rating</h4>--}}
                                {{--<span class="fa fa-star checked"></span>--}}
                                {{--<span class="fa fa-star checked"></span>--}}
                                {{--<span class="fa fa-star checked"></span>--}}
                                {{--<span class="fa fa-star"></span>--}}
                                {{--<span class="fa fa-star"></span>--}}
                                {{--<span>4.6</span>--}}
                            {{--</div><!-- left_rating -->--}}

                            {{--<div class="right_rating">--}}
                                {{--<h4>Did The item fit well</h4>--}}
                                {{--<div class="progress orangebar">--}}
                                    {{--<div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0"--}}
                                         {{--aria-valuemax="100" style="width:70%">--}}
                                        {{--<span class="sr-only">70% Complete</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="progress redbar">--}}
                                    {{--<div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0"--}}
                                         {{--aria-valuemax="100" style="width:80%">--}}
                                        {{--<span class="sr-only">80% Complete</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="progress bluebar">--}}
                                    {{--<div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"--}}
                                         {{--aria-valuemax="100" style="width:90%">--}}
                                        {{--<span class="sr-only">90% Complete</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div><!-- right_rating -->--}}
                        {{--</div><!-- reveiw_head -->--}}

                        {{--<div class="rating_items">--}}
                            {{--<div class="rat_1">--}}
                                {{--<p>1-4 Of 102 Review</p>--}}
                            {{--</div>--}}
                            {{--<div class="rat_1">--}}
                                {{--<div class="dropdown">--}}
                                    {{--<button class="btn btn-primary dropdown-toggle" type="button"--}}
                                            {{--data-toggle="dropdown">Size--}}
                                        {{--<span class="fa fa-angle-down"></span></button>--}}
                                    {{--<ul class="dropdown-menu">--}}
                                        {{--<li><a href="#">Large</a></li>--}}
                                        {{--<li><a href="#">Midium</a></li>--}}
                                        {{--<li><a href="#">Extra Large</a></li>--}}
                                        {{--<li><a href="#">Small</a></li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="rat_1">--}}
                                {{--<div class="dropdown">--}}
                                    {{--<button class="btn btn-primary dropdown-toggle" type="button"--}}
                                            {{--data-toggle="dropdown">Images--}}
                                        {{--<span class="fa fa-angle-down"></span></button>--}}
                                    {{--<ul class="dropdown-menu">--}}
                                        {{--<li><a href="#">Large</a></li>--}}
                                        {{--<li><a href="#">Midium</a></li>--}}
                                        {{--<li><a href="#">Extra Large</a></li>--}}
                                        {{--<li><a href="#">Small</a></li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="rat_1">--}}
                                {{--<span>Sort By</span>--}}
                                {{--<select name="Recomanded">--}}
                                    {{--<option value="volvo">Recomended</option>--}}
                                    {{--<option value="saab">Saab</option>--}}
                                    {{--<option value="fiat">Fiat</option>--}}
                                    {{--<option value="audi">Audi</option>--}}
                                {{--</select>--}}

                            {{--</div>--}}
                        {{--</div><!-- rating_items -->--}}

                    {{--</div><!-- col-md-8 -->--}}

                    {{--<div class="col-md-4">--}}
                        {{--<div class="insta_img">--}}
                            {{--<img src="https://192.168.2.26/p1116/storage/app/public/product/image/1518603754-8124.jpeg"--}}
                                 {{--style="width:110px; height:135px">--}}
                            {{--<img src="https://192.168.2.26/p1116/storage/app/public/product/image/1518603754-8124.jpeg"--}}
                                 {{--style="width:110px; height:135px">--}}
                            {{--<img src="https://192.168.2.26/p1116/storage/app/public/product/image/1518603754-8124.jpeg"--}}
                                 {{--style="width:110px; height:135px">--}}
                        {{--</div><!-- insta_img -->--}}
                    {{--</div><!-- col-md-4 -->--}}
                {{--</div><!-- row -->--}}

            {{--</div><!-- container -->--}}
        {{--</div><!-- review_rat -->--}}

        {{--<div class="review_verifed">--}}
            {{--<div class="container">--}}
                {{--<div class="row">--}}
                    {{--<hr>--}}
                    {{--<div class="col-md-4">--}}
                        {{--<p>a""r</p>--}}
                        {{--<p><i class="fa fa-minus-circle"></i> Verified Purchase</p>--}}
                        {{--<p><b>Height</b> 137cm/ 5.9in</p>--}}
                        {{--<p><b>width</b> 37cm/ 3.9in</p>--}}
                        {{--<!-- <p><b>True</b> 80cm</p> -->--}}
                        {{--<p><b>Height</b> 137cm/ 5.9in</p>--}}
                    {{--</div><!-- col-md-4 -->--}}
                    {{--<div class="col-md-4">--}}
                        {{--<span class="fa fa-star checked"></span>--}}
                        {{--<span class="fa fa-star checked"></span>--}}
                        {{--<span class="fa fa-star checked"></span>--}}
                        {{--<span class="fa fa-star"></span>--}}
                        {{--<span class="fa fa-star"></span>--}}
                        {{--<span><b>item size :</b> 8</span>--}}
                        {{--<span><b>Overall fit :</b> true to size</span>--}}
                        {{--<p>So cute and fit perfect!</p>--}}
                        {{--<p><img src="https://192.168.2.26/p1116/storage/app/public/product/image/1518603754-8124.jpeg"--}}
                                {{--style="width:150px; height:100px"></p>--}}
                        {{--<p>Was this review helpful to you <i class=" fa fa-thumbs-o-up"></i></p>--}}
                    {{--</div><!-- col-md-4 -->--}}
                    {{--<div class="col-md-4 text-right">--}}
                        {{--<p>13 sep 2017</p>--}}
                    {{--</div><!-- col-md-4 -->--}}
                {{--</div><!-- row -->--}}
            {{--</div><!-- container -->--}}
        {{--</div><!-- review_verifed -->--}}

        {{--<div class="recently-view">--}}
            {{--<div class="container">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-8">--}}
                        {{--<div class="rcent_heading"><h2> Recently Viewed Jewellery</h2></div>--}}
                        {{--<div class="owl-carousel" id="view_slider">--}}
                            {{--<div class="item">--}}
                                {{--<div class="view-sld-img">--}}
                                    {{--<img class="site" src="https://192.168.2.26/p1116/public/media/front/img/ring.jpg">--}}
                                {{--</div>--}}
                                {{--<p>Rs 15779.00</p>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<div class="view-sld-img">--}}
                                    {{--<img class="site" src="https://192.168.2.26/p1116/public/media/front/img/ring.jpg">--}}
                                {{--</div>--}}
                                {{--<p>Rs 5779.00</p>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<img src="https://192.168.2.26/p1116/public/media/front/img/list6.jpg">--}}
                                {{--<p>Rs 7579.00</p>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<img src="https://192.168.2.26/p1116/public/media/front/img/list4.jpg">--}}
                                {{--<p>Rs 5779.00</p>--}}
                            {{--</div>--}}
                            {{--<div class="item">--}}
                                {{--<img src="https://192.168.2.26/p1116/public/media/front/img/list5.jpg">--}}
                                {{--<p>Rs 7579.00</p>--}}
                            {{--</div>--}}
                        {{--</div><!-- owl-slider -->--}}
                    {{--</div>--}}
                    {{--<div class="col-md-3 col-md-offset-1 single_slider">--}}
                        {{--<div class="rcent_heading"><h2> Complete your Look </h2></div>--}}
                        {{--<div class="owl-carousel" id="view_slider2">--}}
                            {{--<div class="item site_slider">--}}
                                {{--<div class="view-sld-img">--}}
                                    {{--<img class="site" src="https://192.168.2.26/p1116/public/media/front/img/ring.jpg">--}}
                                {{--</div>--}}
                                {{--<p>Ring Gift Box</p>--}}
                                {{--<p><b>Price 10254</b></p>--}}
                            {{--</div>--}}
                            {{--<div class="item site_slider">--}}
                                {{--<img src="https://192.168.2.26/p1116/public/media/front/img/ring.jpg">--}}
                                {{--<p>Ring Gift Box</p>--}}
                                {{--<p><b>Price 10254</b></p>--}}
                            {{--</div>--}}
                            {{--<div class="item site_slider">--}}
                                {{--<img src="https://192.168.2.26/p1116/public/media/front/img/ring.jpg">--}}
                                {{--<p>Ring Gift Box</p>--}}
                                {{--<p><b>Price 10254</b></p>--}}
                            {{--</div>--}}
                        {{--</div><!-- owl-slider -->--}}
                    {{--</div>--}}
                {{--</div><!-- row -->--}}
            {{--</div><!-- container -->--}}
        {{--</div><!-- recently-view -->--}}
    </section>



<div id="h-cust-modal-size" class="modal h-cust-modal open-my-custom-modal">

      <!-- Modal content -->
      <div class="modal-content">
          <button type="button" class="close h-cust-close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><img src="{{url("/public/media/front/img/cancel.png")}}" alt="close" height="20px;" width="20px;"></span>
                        </button>
                    
         <div class="size-heading"><h2>SIZE GUIDE</h2></div> 
         <div class="container">
            <div class="row">
               <div class="arrow-up"></div>
              <div class="top_head">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h3>WOMEN</h3>
                </div><!-- col-md-4 -->
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h3>MEN</h3>
                </div><!-- col-md-4 -->
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h3>KIDS</h3>
                </div><!-- col-md-4 -->
              </div><!-- top_head -->
            </div><!-- row -->

            <div class="row main_mnu">
                  <ul class="nav nav-pills mnu">
                    <li class="active"><a data-toggle="pill" href="#home"><i class="fa fa-female"></i></a></li>
                    <li><a data-toggle="pill" href="#menu1"><i class="fa fa-male"></i></a></li>
                    <li><a data-toggle="pill" href="#menu2"><i class="fa fa-child"></i></a></li>
                  </ul>
            </div><!-- row -->

            <!-- <div class="row">
                <div class="size-head">
                  <div class="col-md-4">
                    <h4><a href="#"> REGULAR </a></h4>
                  </div>
                  <div class="col-md-8">
                    <h4><a href="#">BIG AND TALL </a></h4>
                  </div>
                </div>
            </div> -->

            <div class="row">
                <div class="mesurment tab-content">

                  <div id="home" class="tab-pane fade in active">
                  <div class="col-md-4">
                    <div class="left_pan">
                        <h4> HOW TO MEASURE </h4>
                        <p><span class="number"><b> 1 </b></span> <span class="mwsure_head"><b> Chest </b></span> Measure across  the fullest part. </p>
                        <p><span class="number"><b> 2 </b></span> <span class="mwsure_head"><b> Waist </b></span> Measure around the natural waistline. </p>
                        <p><span class="number"><b> 3 </b></span> <span class="mwsure_head"><b> Hips </b></span> Measure at the widest  part. </p>
                        <p><span class="number"><b> 4 </b></span> <span class="mwsure_head"><b> Inside Leg </b></span> Measure from top of inside leg at the crotch to the ankle bone. </p>
                    </div><!-- left_pan -->
                    <div class="right_pan">
                        <img src="{{url("public/media/front/img/women-size-guide.png")}}" alt="size image">
                    </div><!-- right_pn -->
                  </div><!-- col-md-4 -->

                  <div class="col-md-8">
                    <div class="tbl_head">
                        <span class="left_head"> <h4>INTERNATIONAL CONVERSION</h4> </span>
                        <span class="right_head"> <h4>IN CM</h4> </span>
                    </div><!-- tbl_head -->
                    <div class="table-responsive">
                        <table>
                          <tr>
                            <th>SIZE</th>
                            <th>XSS</th>
                            <th>XS</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                            <th>XXL</th>
                          </tr>
                          <tr>
                            <td>UK</td>
                            <td>32 </td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                            <td>40</td>
                            <td>42</td>
                            <td>44-46</td>
                          </tr>
                          <tr>
                            <td>EUROPE</td>
                            <td>44 </td>
                            <td>46</td>
                            <td>48</td>
                            <td>56</td>
                            <td>58</td>
                            <td>60</td>
                            <td>62-64</td>
                          </tr>
                          <tr>
                            <td>USA</td>
                            <td>32 </td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                            <td>40</td>
                            <td>42</td>
                            <td>44</td>
                          </tr>
                          <tr>
                            <td>CANADA</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>AUS/NZ</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>CHEST(in)</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>COLLAR(in)</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                            <td>19</td>
                          </tr>
                        </table>
                    </div>
                  </div><!-- col-md-8 -->
                </div><!-- tab_pane -->

                <div id="menu1" class="tab-pane fade in">
                  <div class="col-md-4">
                    <div class="left_pan">
                        <h4> HOW TO MEASURE </h4>
                        <p><span class="number"><b> 1. </b></span> <span class="mwsure_head"><b> Chest </b></span> Measure across  the fullest part. </p>
                        <p><span class="number"><b> 2. </b></span> <span class="mwsure_head"><b> Waist </b></span> Measure around the natural waistline. </p>
                        <p><span class="number"><b> 3. </b></span> <span class="mwsure_head"><b> Hips </b></span> Measure at the widest  part. </p>
                        <p><span class="number"><b> 4. </b></span> <span class="mwsure_head"><b> Inside Leg </b></span> Measure from top of inside leg at the crotch to the ankle bone. </p>
                    </div><!-- left_pan -->
                    <div class="right_pan">
                        <img src="{{url("public/media/front/img/size.png")}}" alt="size image">
                    </div><!-- right_pn -->
                  </div><!-- col-md-4 -->

                  <div class="col-md-8">
                    <div class="tbl_head">
                        <span class="left_head"> <h4>INTERNATIONAL CONVERSION 2</h4> </span>
                        <span class="right_head"> <h4>IN CM</h4> </span>
                    </div><!-- tbl_head -->
                    <div class="table-responsive">
                        <table>
                          <tr>
                            <th>SIZE</th>
                            <th>XSS</th>
                            <th>XS</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                            <th>XXL</th>
                          </tr>
                          <tr>
                            <td>UK</td>
                            <td>34 </td>
                            <td>36</td>
                            <td>38</td>
                            <td>42</td>
                            <td>52</td>
                            <td>472</td>
                            <td>80-90</td>
                          </tr>
                          <tr>
                            <td>Europe</td>
                            <td>52</td>
                            <td>54</td>
                            <td>56</td>
                            <td>58</td>
                            <td>60</td>
                            <td>62</td>
                            <td>64-66</td>
                          </tr>
                          <tr>
                            <td>USA</td>
                            <td>42 </td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                            <td>50</td>
                            <td>52</td>
                            <td>54</td>
                          </tr>
                          <tr>
                            <td>CANADA</td>
                            <td>30</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                            <td>40</td>
                            <td>42</td>
                          </tr>
                          <tr>
                            <td>AUS/NZ</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>CHEST(in)</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>           
                          </tr>
                          <tr>
                            <td>COLLAR(in)</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                          </tr>
                        </table>
                    </div>
                  </div><!-- col-md-8 -->
                </div><!-- tab_pane -->

                <div id="menu2" class="tab-pane fade">

                  <div class="col-md-12">
                    <div class="tbl_head">
                        <span class="left_head"> <h4>INTERNATIONAL CONVERSION</h4> </span>
                    </div><!-- tbl_head -->
                        <div class="table-responsive">
                        <table>
                          <tr>
                            <th>SIZE</th>
                            <th>XSS</th>
                            <th>XS</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                            <th>XXL</th>
                          </tr>
                          <tr>
                            <td>UK</td>
                            <td>32 </td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                            <td>40</td>
                            <td>42</td>
                            <td>44-46</td>
                          </tr>
                          <tr>
                            <td>EUROPE</td>
                            <td>44 </td>
                            <td>46</td>
                            <td>48</td>
                            <td>56</td>
                            <td>58</td>
                            <td>60</td>
                            <td>62-64</td>
                          </tr>
                          <tr>
                            <td>USA</td>
                            <td>32 </td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                            <td>40</td>
                            <td>42</td>
                            <td>44</td>
                          </tr>
                          <tr>
                            <td>CANADA</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>AUS/NZ</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>CHEST(in)</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>COLLAR(in)</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                            <td>19</td>
                          </tr>
                        </table>
                    </div>
                  </div><!-- col-md-12 -->
                </div><!-- tab_pane -->


                </div><!-- mesurment tab-content -->
            </div><!-- row -->

         </div><!-- container -->
      </div><!-- modal-content -->
    </div>
    <!-- Customizatiion Modal -->
    <div class="cust-modal modal fade" id="customize-prodct-btn" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="mod-head">Customization Form</div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><img src="{{ url('public/media/front/img/cancel.png')  }}" alt="close"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="custome-textarea">
                                <label class="shipping-label">Add extra element/ accessories<sup>*</sup> :</label>
                                <input type="" name="" class="form-control" placeholder="Add extra element/ accessories">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <!-- <div class="custome-textarea clearfix">
                                <label class="shipping-label pull-left">Upload Image :</label>
                                <div class="uplo-img relative pull-left">
                                    <input type="file" name="">
                                    <span>Upload Image</span>
                                </div>
                            </div> -->
                            <div class="custome-textarea clearfix">
                                <label class="shipping-label pull-left">Upload Image :</label>
                                <div class="uplo-img pull-left">
                                    <input type="file" name="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <div class="custome-textarea">
                                <label class="shipping-label">Select Color</label>
                                <ul class="col-op-one">
                                    <li><span class="red"></span></li>
                                    <li><span class="green"></span></li>
                                    <li><span class="blue"></span></li>
                                    <li><span class="yellow"></span></li>
                                    <li><span class="black"></span></li>
                                </ul>
                                <div class="h-add-cart-h text-center">
                                    <button id="update-in-cart" class="h-cart-btn" type="submit">Update
                                        to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#bzoom").zoom({
            zoom_area_width: 300,
            autoplay_interval: 3000,
            small_thumbs: 4,
            autoplay: false
        });
    </script>
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#lightgallery').lightGallery();
        });
    </script>
    <script>
        function changeColor(id)
        {
            var colImgId = id.split('-').pop();
            $('.pro-color-apply').removeClass('active');
            var color = $('#' + id).attr('title');
            $('#color-name').val(color);
            $('#' + id).parent().addClass('active');

            // var elements = document.getElementsByClassName('car-col-img-dv-'+colImgId);
            // var requiredElement = elements[0];
            // // console.log(requiredElement.id);return;
            // $('.all-car-col-img-dv').removeClass('active');
            // $('.all-car-col-img-dv').hide();
            // $('#'+requiredElement.id).show();
            // $('#'+requiredElement.id).parent().addClass('active');
            // $('.all-t-col-img').hide();
            // $('.t-col-img-'+colImgId).show();
        }
    </script>
    <script>
        function changeSizeProperties(id) {
            $('.pro-size-apply').removeClass('active');
            var size = $('#' + id).attr('rel');
            $('#size-name').val(size);
            $('#' + id).parent().addClass('active');
        }

        function validateForm()
        {

            var size = $('#size-name').val();
            var color = $('#color-name').val();
            var available=$("#available").val();
//             alert(available);
             if(available=="1"){
                $('#error-msg').show();
                $('#error-msg').text('Sorry!! Product is out of stock');
                return false;
            }
            else if(available=="0"){
//                return true;
            

            if (size != '' && color != '') {
                return true;
            }
            else if(size == '' && color == '') {
                $('#error-msg').show();
                $('#error-msg').text('Please select product color and size');

                return false;
            }
            else if(size != '' && color == '') {
                $('#error-msg').show();
                $('#error-msg').text('Please select product color');

                return false;
            }
            else if(size == '' && color != ''){
                $('#error-msg').show();
                $('#error-msg').text('Please select product size');
                return false;
            }
           
        } 
        }

    </script>
    <script>
        $(function(){
           var price = $("#spn-price").text().trim().split('$').pop();
            $("#prod-amt").val(price);
            
         });
        function productRateRequest(product_id)
        {
            $.ajax({
                url: '{{url( "/user/product-rate-request")}}'+'/'+product_id,
                dataType: "json",
                type:"get",
                success: function (res) {
                    if(res.success =='1')
                    {
                        $('#spn-price a').html('Rate Requested');
                    }
                    else{
                        alert(res.msg);
                    }
                }
            });
        }
        
        
        function subscribeNewsletter()
        {
       // alert(123);return;
       var  subEmail = $('#subscribe-email').val();
        if(subEmail != ''){
            $.ajax({
                url: '{{  url('/newsletter/subscribe') }}',
                type: "post",
                dataType: 'json',
                data: {
                    email: subEmail,
                    _token:"{{ csrf_token() }}"
                },
                success: function (response) {
                   // console.log(response);return;
                    if (response.success == "1") {
                        $('#subscribe-email-msg').text("We'll notify you once product comes in stock");
                        //  console.log(123);
                        //  console.log(response.success);
                        // console(response.success);return;
                        //$('#added-in-cart').show();
                        //  $('
                    }
                    else {
                        if(response.msg == "The email has already been taken.")
                        {
                            $('#subscribe-email-msg').text("We'll notify you once product comes in stock");
                        }
                        else{
                            $('#subscribe-email-msg').text(response.msg);
                        }

                    }

                }
            });
        }
        else{
            $('#subscribe-email-msg').text("Please enter your email id");
        }
    }
        function addToWishlist(product_id)
        {
//        alert($("#price").val());
//        alert($("#prod-dis-rate").val());
            var chkSize =$('#chk-size').val();
            var size = $('#size-name').val();
            var color = $('#color-name').val();
            var available=$("#available").val();
//             alert(prod_price);
            if(available=="1")
            {
                $('#error-msg').show();
                $('#error-msg').text('Sorry!! Product is out of stock');
                return false;
            }
            else if(available=="0")
            {
                if(chkSize >"0")
                {
                    if(size == '' && color == '')
                    {
                        $('#error-msg').show();
                        $('#error-msg').text('Please select product color and size');

                        return false;
                    }
                    else if(size != '' && color == '')
                    {
                        $('#error-msg').show();
                        $('#error-msg').text('Please select product color');

                        return false;
                    }
                    else if(size == '' && color != '')
                    {
                        $('#error-msg').show();
                        $('#error-msg').text('Please select product size');
                        return false;
                    }
                    else{
                        $.ajax({
                            url: '{{url( "/ajax-add-product-in-wishlist")}}',
                            data: {'product_id': product_id,'color':color,'size':size},
                            dataType: "json",
                            type:"get",
                            success: function (res) {
                                if (res.msg == 'Deleted From Wishlist') {
                                    $("#add-wishlist-" + product_id).removeClass('active');
                                } else if (res.msg == 'Added In Wishlist') {
                                    $("#add-wishlist-" + product_id).addClass('active');
                                    window.location.href= javascript_site_path + 'wishlist';
                                }
                            }
                        });
                    }
                }
                else
                {
                    if(color == '')
                    {
                        $('#error-msg').show();
                        $('#error-msg').text('Please select product color');
                        return false;
                    }
                    else{
                        $.ajax({
                            url: '{{url( "/ajax-add-product-in-wishlist")}}',
                            data: {'product_id': product_id,'color':color,'size':size},
                            dataType: "json",
                            type:"get",
                            success: function (res) {
                                if (res.msg == 'Deleted From Wishlist') {
                                    $("#add-wishlist-" + product_id).removeClass('active');
                                } else if (res.msg == 'Added In Wishlist') {
                                    $("#add-wishlist-" + product_id).addClass('active');
                                    window.location.href= window.location.href;
                                }

                            }
                        });
                    }
                }
            }
        }
    
    </script>
    <script>
        $(function(){
            if('@php echo $c1 @endphp' == 0)
            {
                $("#dv-prop-id").hide();
            }
            if('@php echo $c2 @endphp' == 0)
            {
                $("#dv-dim-id").hide();
            }
        });
    </script>
    <style>
        span.h-red {
  color: #CC0D00;
  text-transform: capitalize;
}

    </style>
    {{--<script>--}}
        {{--$(function(){--}}

            {{--$colorId = $('ul .all-pro-clr-cls').first().attr('id');--}}
            {{--$('#'+$colorId).addClass('active');--}}
            {{--$colorImgId = $colorId.split('-').pop();--}}
            {{--$('.all-t-col-img').hide();--}}
            {{--$('.t-col-img-'+ $colorImgId).show();--}}

            {{--$('.all-car-col-img-dv').each(function(i,obj){--}}
                {{--$('#'+obj.id).hide();--}}
                {{--// $(this).closest('.a');--}}
                {{--$('#'+obj.id).closest('.owl-item').hide();--}}
                {{--$('#'+obj.id).closest('.owl-item').removeClass('active');--}}

            {{--});--}}

            {{--$('.car-col-img-dv-'+$colorImgId).each(function(i, obj) {--}}
                {{--$('#'+obj.id).show();--}}
                {{--$('#'+obj.id).closest('.owl-item').show();--}}
                {{--if(i==0)--}}
                {{--{--}}
                    {{--$('#'+obj.id).first().closest('.owl-item').addClass('active');--}}
                {{--}--}}
            {{--});--}}
            {{--// $('.car-col-img-dv-'+ $colorImgId).parent().show();--}}
            {{--// $('.car-col-img-dv-'+ $colorImgId).first().parent().addClass('active');--}}
        {{--});--}}
    {{--</script>--}}
@endsection
