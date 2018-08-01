@extends('layouts.app')
@section('meta')
    <title>Profile</title>
@endsection
@section('content')
    <section class="h-inner-banner" style="background-image:url({{url("/public/media/front/img/cart-bg.jpg")}});">
        <div class="container relative manage-bottm-head">
            <div class="h-caption">
                <!-- <h3 class="h-inner-heading">My Shopping Bag</h3> -->
            </div>
        </div>
    </section>
    <section class="cust-bread">
        <div class="container">
            <ul class="clearfix">
                <li><a href="http://parasfashions.com">Home</a></li>
                <li>My Shopping Bag</li>
            </ul>
        </div>
    </section>
    <section class="h-add-cart-page">
        <div class="container-fluid">
            @if (session('cart-err'))
                <div class="alert alert-danger">
                    {{ session('cart-err') }}
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
            @endif
            @if(isset($cart->cartItems) && count($cart->cartItems)>0)
                <div class="row">

                    <form id="proceed-to-checkout-form" action="" method="post" class="add-ct-form">
                        {!! csrf_field() !!}
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="cart-table table-responsive">
                                <table>
                                    <thead>
                                    <th><b>Image</b></th>
                                    <th><b>Product</b></th>
                                    <th><b>Price</b></th>
                                    @if(Auth::check())
                                        <th><b>Move To Wishlist</b></th>
                                    @endif
                                    <th><b>Quantity</b></th>
                                    <th><b>Total</b></th>
                                    <!--<th>Action</th>-->
                                    </thead>
                                    <tbody>

                                    <input type="hidden" id="cart-id" name="cart_id" value="{{ $cart->id }}">
                                    @foreach($cart->cartItems as $cart_item)
                                        @php
                                            $product = \App\PiplModules\product\Models\Product::where('id',$cart_item->product_id)->first();
                                        @endphp
                                        @if(isset($product) && count($product) > 0)
                                            <input id="max-order-qty_{{ $cart_item->id }}" type="hidden"
                                                   @if(isset($product) && $product->productDescription->max_order_qty != "") value="{{ $product->productDescription->max_order_qty }}" @endif>
                                            <input id="max-qty_{{ $cart_item->id }}" type="hidden"
                                                   @if(isset($product) && $product->productDescription->quantity != "") value="{{ $product->productDescription->quantity }}" @endif>

                                            <tr id="{{ $cart_item->id }}">
                                                <td class="pro-thumbnail pro-remove">
                                                    <a href="{{ url('product').'/'.$cart_item->product->id }}">
                                                        <img src="{{url('/storage/app/public/product/image/'.$cart_item->product->productDescription->image)}}"
                                                             alt="product image"/>
                                                    </a>
                                                    <span class="span-block">
                                                        <button type="button" data-toggle="modal"
                                                                onclick="showQuickView('{{ $cart_item->product_id }}')"><i
                                                                    class="fa fa-edit"></i> Edit</button>
                                                        <button type="button" href="#"
                                                                id="rm-cart-tem_{{$cart_item->id}}"
                                                                onclick="removeCartItem(this.id)"><i
                                                                    class="fa fa-trash"></i> Remove</button>
                                                    </span>
                                                </td>
                                                <td class="pro-title">
                                                    <a href="{{ url('product').'/'.$cart_item->product->id }}">{{$cart_item->product->name}}</a>
                                                    <div class="product-id">
                                                        <span>Product Id : {{ $cart_item->product->productDescription->sku }}</span>
                                                    </div>
                                                    <div id="dv-prod-clr-{{ $cart_item->id }}" class="h-color">
                                                        <span>Color : @if(!empty($cart_item->product_color_name)) {{ $cart_item->product_color_name }}   @endif  </span>
                                                    </div>
                                                    <div id="dv-prod-siz-{{ $cart_item->id }}" class="h-size">
                                                        <span>Size : @if(!empty($cart_item->product_size_name)) {{ $cart_item->product_size_name }}  @endif</span>
                                                    </div>
                                                    <span class="span-block">
                                                    <div style="display:none;color:orange"
                                                         id="err-dv-prod-id-{{ $cart_item->id }}"></div>
                                                    </span>
                                                    <script>
                                                        var pSize = $("#dv-prod-siz-" + '<?php echo $cart_item->id; ?>').text().trim().split(':').pop().trim();
                                                        var pCLr = $("#dv-prod-clr-" + '<?php echo $cart_item->id; ?>').text().trim().split(':').pop().trim();
                                                        if (pCLr == '' && pSize == '') {
                                                            $("#err-dv-prod-id-" + '<?php echo $cart_item->id; ?>').show();
                                                            $("#err-dv-prod-id-" + '<?php echo $cart_item->id; ?>').text('Kindly edit product color and size');
                                                        }
                                                        else if (pCLr == '') {
                                                            $("#err-dv-prod-id-" + '<?php echo $cart_item->id; ?>').show();
                                                            $("#err-dv-prod-id-" + '<?php echo $cart_item->id; ?>').text('Kindly edit product color');
                                                        }
                                                        else if (pSize == '') {
                                                            $("#err-dv-prod-id-" + '<?php echo $cart_item->id; ?>').show();
                                                            $("#err-dv-prod-id-" + '<?php echo $cart_item->id; ?>').text('Kindly edit product size');
                                                        }
                                                    </script>
                                                </td>
                                                <td class="pro-price"><span
                                                            class="amount">{{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($cart_item->product_amount),2,'.','') }}</span>
                                                </td>
                                                @if(Auth::check())
                                                    <td class="pro-wishlist">
                                                        <button onclick="moveToWishlist('{{ $cart_item->id }}')"
                                                                class="add-cart" type="button"><i
                                                                    class="fa fa-heart"></i></button>
                                                    </td>
                                                @endif
                                                <td class="pro-quantity">
                                                    <div class="h-quantity">
                                                        <button id="minus-cnt-btn_{{ $cart_item->id }}" type="button"
                                                                onclick="addRemoveProductQuantity(this.id,'min')"
                                                                class="h-minus-pro"><i class="icon-substract"></i>
                                                        </button>
                                                        <input id="show-product-count_{{ $cart_item->id }}"
                                                               name="product_qty" type="text" class="form-control"
                                                               @if(isset($cart_item) && $cart_item->product_quantity !=0)value="{{ $cart_item->product_quantity }}"
                                                               @endif disabled/>
                                                        <button id="add-cnt-btn_{{ $cart_item->id }}" type="button"
                                                                onclick="addRemoveProductQuantity(this.id,'add')"
                                                                class="h-plus-pro"><i class="icon-add"></i></button>
                                                    </div>
                                                    <div style="display: none;color: red"
                                                         id="add-minus-status_{{ $cart_item->id }}">
                                                    </div>
                                                </td>
                                                <input type="hidden" id="one-qty-price_{{$cart_item->id}}"
                                                       value="{{ $cart_item->product_amount }}">
                                                <td class="pro-subtotal"><p id="subtotal_{{$cart_item->id}}">
                                                        {{\App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($cart_item->product_amount * $cart_item->product_quantity),2,'.','')}}</p>
                                                </td>
                                                <script>
                                                    if('<?php echo $product->productDescription->availability; ?>' == '1')
                                                    {
                                                        $("#err-dv-prod-id-" + '<?php echo $cart_item->id; ?>').show();
                                                        $("#err-dv-prod-id-" + '<?php echo $cart_item->id; ?>').text('This product is out of stock');
                                                    }
                                                </script>
                                                {{--<!--<td class="pro-remove"><button type="button" data-toggle="modal" onclick="showQuickView('{{ $cart_item->product_id }}')"><i class="fa fa-edit"></i> Edit</button><button type="button" href="#" id="rm-cart-tem_{{$cart_item->id}}" onclick="removeCartItem(this.id)"><i class="fa fa-trash"></i> Remove</button></td>-->--}}
                                            </tr>

                                        @endif

                                    </tbody>
                                    @endforeach
                                </table>
                            </div>

                            <div class="h-cust-details-info">
                                <form>

                                    <input id="ip-token" type="hidden" value="{{ csrf_token() }}">
                                    <div class="card-details clearfix">
                                        <div class="col-md-12"><h3 class="card-title"><span>Customer Details</span></h3>
                                        </div>
                                        <div class="sender-receiver-details">
                                            <div class="row">
                                                <div class="adderss_wrapper clearfix">
                                                    <div class="col-md-6">
                                                        <div class="form-head">
                                                            <h5>Customer Information:</h5>
                                                        </div>
                                                        <div class="inner-address">
                                                            @if(\Auth::check())
                                                                <p class="buyer_name">@if(\Auth::check()){{ \Auth::user()->userInformation->first_name.' '.\Auth::user()->userInformation->last_name }} @endif</p>
                                                                <p class="buyer_city">@if(\Auth::check()){{ \Auth::user()->userInformation->city }} @endif</p>
                                                                {{--<p class="buyer_country">@if(\Auth::check()){{ \Auth::user()->userAddress['user_country'] }} @endif</p>--}}
                                                                <p class="buyer_phone">@if(\Auth::check() && !empty(\Auth::user()->userInformation->user_mobile) )Mobile
                                                                    Number:{{ \Auth::user()->userInformation->user_mobile }} @endif</p>
                                                            @else
                                                                <p class="buyer_name">You are not login yet! Please <a
                                                                            href="{{url('login')}}" target="new">click
                                                                        here</a> to login</p>
                                                            @endif
                                                        </div>
                                                        @if(\Auth::check())
                                                            <input type="hidden" id="flag" value="1">
                                                        @else
                                                            <input type="hidden" id="flag" value="0">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-head">
                                                            <h5>Shipping & Billing Address:</h5>
                                                        </div>
                                                        <div class="inner-address">
                                                            @if($cart->shipping_name)
                                                                @php
                                                                    $city_name='';
                                                                    $state_name='';
                                                                    $country_name='';
                                                                    if(isset($cart) && $cart->shipping_city !=''){
                                                                      $city = \App\PiplModules\admin\Models\City::where('id',$cart->shipping_city)->first();
                                                                      if(isset($city) && count($city)>0){
                                                                         $city_name =$city->name;
                                                                      }
                                                                     }
                                                                    if(isset($cart) && $cart->shipping_country !=''){
                                                                      $country = \App\PiplModules\admin\Models\Country::where('id',$cart->shipping_country)->first();
                                                                      if(isset($country) && count($country)>0){
                                                                         $country_name =$country->name;
                                                                      }
                                                                     }

                                                                    if(isset($cart) && $cart->shipping_state !=''){
                                                                      $state = \App\PiplModules\admin\Models\State::where('id',$cart->shipping_state)->first();
                                                                      if(isset($state) && count($state)>0){
                                                                         $state_name =$state->name;
                                                                      }
                                                                     }
                                                                @endphp
                                                                <p class="buyer_name">{{$cart->shipping_name}}</p>
                                                                <p class="buyer_addrss">{{ $cart->shipping_address1  }}
                                                                    , {{ $cart->shipping_address2  }} </p>
                                                                <p class="buyer_city">{{ $city_name }}
                                                                    , {{$state_name}} {{$cart->shipping_zip}}</p>
                                                                <p class="buyer_country">{{ $country_name }}</p>
                                                                <p class="buyer_phone">Phone
                                                                    Number: {{$cart->shipping_telephone}}</p>
                                                                <input type="hidden" id="shipping_data_flag"
                                                                       name="shipping_data_flag" value="1">
                                                            @else
                                                                <p>No shipping address provided! Click below button to
                                                                    enter shipping & billing details for your order!</p>
                                                                <input type="hidden" id="shipping_data_flag"
                                                                       name="shipping_data_flag" value="0">
                                                            @endif
                                                        </div>
                                                        <div class="text-right edit-option clearfix"
                                                             style="position:relative">
                                                            <input type="button" class="h-update-cart pull-right"
                                                                   value="Edit" data-toggle="modal"
                                                                   data-target="#h-quick-view"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="pay-method-title">
                                                    <div class="col-md-12">
                                                        <h3 class="card-title"><span>Payment Methods</span></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="pay-mode">
                                                    <div class="col-md-12">
                                                        <div class="pay-mode-list">
                                                            <ul class="pay-method">
                                                                <li class="h-cust-radio">
                                                                    <label class="mode">
                                                                        <input id="ip-visa-id" type="radio"
                                                                               onclick="checkAmountForPayment(this)"
                                                                               name="payment_option" value="0">
                                                                        <span class="checks"></span>
                                                                        {{--<img src="{{url('/public/media/front/img/visa.png')}}">--}}
                                                                        Online Payment
                                                                    </label>
                                                                </li>
                                                                <li class="h-cust-radio">
                                                                    <label class="mode">
                                                                        <input id="ip-cod-id" type="radio"
                                                                               onclick="checkAmountForPayment(this)"
                                                                               name="payment_option" value="1">
                                                                        <span class="checks"></span>
                                                                        Cash On Delivery
                                                                    </label>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="chk-amt-for-pay" value="0">
                                                    <div id="err-select-pay-option"
                                                         style="display: none;color:orange;text-align: center"></div>
                                                </div>
                                            </div>
                                            {{--<div class="row">--}}
                                            {{--<table>--}}
                                            {{--<tr>--}}
                                            {{--<td class="notop-border notop-padding" colspan="2">--}}
                                            {{--<a class="apply-coupon-code" href="javascript:void(0)" id="add_coupon">+ Apply Coupon Code</a>--}}
                                            {{--</td>--}}
                                            {{--</tr>--}}
                                            {{--<tr id="enter_coupon" style="display: none">--}}
                                            {{--<td class="notop-border notop-padding" colspan="2">--}}
                                            {{--<form class="coupon-code-form">--}}
                                            {{--<input class="form-control input-sm" type="text" placeholder="Enter Coupon Code" id="coupon_code" @if(isset($cart)) rel="{{ $cart->id }}" @endif>--}}
                                            {{--<input type="button" class="btn btn-sm btn-w-b" value="Apply" id="apply_coupon" onclick="addCoupon()">--}}
                                            {{--<span class="text-danger" style="display: none" id="coupon_invalid">Invalid Coupon Code</span>--}}
                                            {{--</form>--}}
                                            {{--</td>--}}
                                            {{--</tr>--}}
                                            {{--<tr>--}}
                                            {{--<td class="notop-border notop-padding" colspan="2">--}}
                                            {{--<a class="apply-coupon-code" href="javascript:void(0)" id="add_promo_code">+ Apply Promo Code</a>--}}
                                            {{--</td>--}}
                                            {{--</tr>--}}
                                            {{--<tr id="enter_promo_code" style="display: none">--}}
                                            {{--<td class="notop-border notop-padding" colspan="2">--}}
                                            {{--<form class="coupon-code-form">--}}
                                            {{--<input class="form-control input-sm" type="text" placeholder="Enter Promo Code" id="promo_code" @if(isset($cart)) rel="{{ $cart->id }}" @endif>--}}
                                            {{--<input type="button" class="btn btn-sm btn-w-b" value="Apply" id="apply_promo_code" onclick="addPromoCode()">--}}
                                            {{--<span class="text-danger" style="display: none" id="promo_invalid">Invalid Coupon Code</span>--}}
                                            {{--</form>--}}
                                            {{--</td>--}}
                                            {{--</tr>--}}

                                            {{--<tr>--}}
                                            {{--<td>Total</td>--}}
                                            {{--<td class="ar"><strong><span id="sub_total">@if(isset($cart)) {{ $totalAmount }} @else 0 @endif</span></strong></td>--}}
                                            {{--</tr>--}}
                                            {{--<tr>--}}
                                            {{--<td>Coupon Amount</td>--}}
                                            {{--<td class="ar"><strong><span id="coupon_total">@if(isset($cart) && (isset($totalMinusCoupon) && $totalMinusCoupon!= 0)) {{ $totalAmount-$totalMinusCoupon }} @else 0 @endif</span></strong></td>--}}
                                            {{--</tr>--}}
                                            {{--<tr>--}}
                                            {{--<td>Grand Total</td>--}}
                                            {{--<td class="ar"><strong><span id="grand_total">@if(isset($cart) && (isset($totalMinusCoupon) &&  $totalMinusCoupon!=0)) {{ $totalMinusCoupon }} @else {{ $totalAmount }} @endif</span></strong></td>--}}
                                            {{--</tr>--}}

                                            {{--</table>--}}
                                            {{--</div>--}}
                                            {{--@if(isset($cart) && $cart->shipping_name !='')--}}
                                            {{--<div class="row">--}}
                                            {{--<div class="h-btn-blk text-center">--}}
                                            {{--<input id="{{ $cart->id }}" style="align-content: center" onclick="checkOut(this.id)" class="h-update-cart center-button" type="button" value="Checkout">--}}
                                            {{--</div>--}}
                                            {{--</div>--}}
                                            {{--@endif--}}

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="cart-right-panel">
                                <div class="panel-group" id="nrml-accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab">
                                            <a role="button" data-toggle="collapse" data-parent="#nrml-accordion"
                                               href="#nrml-ship-opt" class="relative">
                                                 CHECK AVAILABILITY & SELECT SHIPPING SERVICE
                                                <span drop-icon><i class="fa fa-angle-down"></i></span>
                                            </a>
                                        </div>
                                        <div id="nrml-ship-opt" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="cart-location">
                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="nrml-home">
                                                            <div class="locator-form text-center clearfix">
                                                                <div class="row clearfix">
                                                                    <div class="pay-mode">
                                                                        <div class="col-md-12">
                                                                            <div class="pay-mode-list">
                                                                                <ul class="pay-method clearfix">
                                                                                    <li class="h-cust-radio li-inc-lenth">
                                                                                        <label class="mode h-stat-mode">
                                                                                            <input id="ip-sel-fdx-id"
                                                                                                   type="radio"
                                                                                                   checked
                                                                                                   onclick="selShippingServices(this)"
                                                                                                   name="shipping_option"
                                                                                                   value="0">
                                                                                            <span class="checks"></span>
                                                                                            FEDEX
                                                                                        </label>
                                                                                    </li>
                                                                                    <li class="h-cust-radio li-inc-lenth">
                                                                                        <label class="mode h-stat-mode">
                                                                                            <input id="ip-sel-dhl-id"
                                                                                                   type="radio"
                                                                                                   onclick="selShippingServices(this)"
                                                                                                   name="shipping_option"
                                                                                                   value="1">
                                                                                            <span class="checks"></span>
                                                                                            DHL
                                                                                        </label>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div id="err-select-ship-option"
                                                                             style="display: none;color:orange;text-align: center">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="id-fdx-crt-loc" class="cart-location">
                                                    <!-- Nav tabs -->
                                                    <ul id="chk-rate-id" class="nav nav-tabs" role="tablist">
                                                        <li id="li-nat-tag" role="presentation" class="active"><a
                                                                    href="#home"
                                                                    aria-controls="home"
                                                                    role="tab"
                                                                    data-toggle="tab">FEDEX DOMESTIC</a>
                                                        </li>
                                                        <li id="li-int-tag" role="presentation"><a href="#profile"
                                                                                                   aria-controls="profile"
                                                                                                   role="tab"
                                                                                                   data-toggle="tab">FEDEX INTERNATIONAL</a>
                                                        </li>
                                                    </ul>
                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="home">
                                                            <div class="locator-form text-center clearfix">
                                                                <div class="check-country">
                                                                    <select name="dom_country_zip" id="dom-country-zip"
                                                                            class="form-control">
                                                                        <option class="select-option"
                                                                                label="Please Select" value=""
                                                                                name="dom_country_zip">
                                                                            Please Select
                                                                        </option>
                                                                        @if(isset($all_countries))

                                                                            @foreach($all_countries as $country)
                                                                                @if(!empty($country->name) && $country->name=="India")
                                                                                    <option class="select-option"
                                                                                            name="dom_country_zip"
                                                                                            label="{{ $country->name }}"
                                                                                            @if((isset($cart) && !empty($cart)) && $cart->shipping_country == $country->name) selected
                                                                                            @endif value={{ $country->id }}>{{ $country->name }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="check-country">
                                                                    <input id="ip-dom-pin-code" class="form-control"
                                                                           name="ip_pin_code" type="text"
                                                                           placeholder="Enter Pin Code"/>

                                                                </div>

                                                                <div id="err-nat-ship"
                                                                     style="font-size: 14px; margin-bottom:5px; color:orange;"></div>
                                                                <div class="harsh-btn-blk relative">
                                                                    <input onclick="chkValidatePincode()" type="button"
                                                                           class="check-btn" value="Check"/>
                                                                    <div id="dv-loader-national" style="display: none"
                                                                         class="harsh-lodar-blk">
                                                                        <img src="{{ url('public/media/front/img/25.gif') }}">
                                                                    </div>
                                                                </div>
                                                                <div id="main-all-national">

                                                                </div>
                                                                <input type="hidden" id="chk-service-session"
                                                                       @if(Session::has('service_details') && Session::get('service_details.service_name')!='' && Session::get('service_details.service_price')!=0) value="1"
                                                                       @else value="0" @endif>
                                                                <input type="hidden" id="hid-session-price"
                                                                       @if(Session::has('service_details') && Session::get('service_details.service_name')!='' && Session::get('service_details.service_price')!=0) value="{{ Session::get('service_details.service_price') }}"
                                                                       @else value="0" @endif>
                                                                <div id="all-national" style="display: none">
                                                                    <ul class="radio all-national-block-here">
                                                                        <li id="radio-li-replace-id">
                                                                            <div class="harsh-radio">
                                                                                <input
                                                                                       name="national_service"
                                                                                       value="replace-value"
                                                                                       onclick="getNationalService(this.value)"
                                                                                       replace-check
                                                                                       type="radio" id="crust1"
                                                                                       value="deep"/>Service No :
                                                                                replace-cnt
                                                                            </div>
                                                                            <p><span>Service Name:</span> replace-name
                                                                            </p>
                                                                            <p><span>Service Price:</span> replace-price
                                                                            </p>
                                                                            <p><span>Service Delivery Time:</span>
                                                                                replace-delivery</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div role="tabpanel" class="tab-pane view-cart-tab"
                                                             id="profile">
                                                            <div class="locator-form text-center clearfix">
                                                                <div class="check-country">
                                                                    <select name="inter_country_zip"
                                                                            id="inter-country-zip" class="form-control">
                                                                        <option class="select-option"
                                                                                label="Please Select" value=""
                                                                                name="inter_country_zip">
                                                                            Please Select
                                                                        </option>
                                                                        @if(isset($all_countries))

                                                                            @foreach($all_countries as $country)
                                                                                @if(!empty($country->name) && $country->name !="India")
                                                                                    <option class="select-option"
                                                                                            name="inter_country_zip"
                                                                                            label="{{ $country->name }}"
                                                                                            @if((isset($cart) && $cart!="") && $cart->shipping_country == $country->name) selected
                                                                                            @endif value={{ $country->id }}>{{ $country->name }}</option>
                                                                                @endif
                                                                                {{--<option class="select-option" label="India" @if(isset($cart) && $cart->shipping_country == 'India') selected @endif value="India">India</option>--}}
                                                                                {{--<option class="select-option" label="United States" @if(isset($cart) && $cart->shipping_country == 'United States') selected @endif value="United States">United States</option>--}}
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="check-country">
                                                                    <input id="ip-inter-pin-code" class="form-control"
                                                                           name="ip_inter_pin_code" type="text"
                                                                           placeholder="Enter Pin Code"/>
                                                                </div>
                                                                <div id="err-int-ship"
                                                                     style="font-size: 14px; margin-bottom:5px; color:orange;"></div>
                                                                <div class="harsh-btn-blk relative">
                                                                    <input onclick="chkValidateInternationalPincode()"
                                                                           type="button" class="check-btn"
                                                                           value="Check"/>
                                                                    <div id="dv-loader-international"
                                                                         style="display: none" class="harsh-lodar-blk">
                                                                        <img src="{{ url('public/media/front/img/25.gif') }}">
                                                                    </div>
                                                                </div>
                                                                <div id="main-all-international">

                                                                </div>
                                                                <div id="all-international" style="display: none">
                                                                    <ul class="radio all-national-block-here">
                                                                        <li id="nat-radio-li-replace-id">
                                                                            <div class="harsh-radio">
                                                                                <input
                                                                                       name="national_service"
                                                                                       value="replace-value"
                                                                                       onclick="getInterNationalService(this.value)"
                                                                                       type="radio"
                                                                                       replace-check
                                                                                       value="international"/>Service No
                                                                                : replace-cnt
                                                                            </div>
                                                                            <p><span>Service Name:</span> replace-name
                                                                            </p>
                                                                            <p><span>Service Price:</span> replace-price
                                                                            </p>
                                                                            <p><span>Service Delivery Time:</span>
                                                                                replace-delivery</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="display:none;" id="id-dhl-crt-loc" class="cart-location">
                                                    <!-- Nav tabs -->
                                                    <ul id="chk-dhl-rate-id" class="nav nav-tabs" role="tablist">
                                                        <li id="li-dhl-nat-tag" role="presentation" class="active"><a
                                                                    href="#dhl-home"
                                                                    aria-controls="dhl-home"
                                                                    role="tab"
                                                                    data-toggle="tab">DHL DOMESTIC</a>
                                                        </li>
                                                        <li id="li-dhl-int-tag" role="presentation"><a
                                                                    href="#dhl-profile"
                                                                    aria-controls="dhl-profile" role="tab"
                                                                    data-toggle="tab">DHL INTERNATIONAL</a>
                                                        </li>
                                                    </ul>
                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="dhl-home">
                                                            <div class="locator-form text-center clearfix">
                                                                <div class="check-country">
                                                                    <select name="dhl_dom_country_zip"
                                                                            id="dhl-dom-country-zip"
                                                                            class="form-control">
                                                                        <option class="select-option"
                                                                                label="Please Select" value=""
                                                                                name="dhl_dom_country_zip">
                                                                            Please Select
                                                                        </option>
                                                                        @if(isset($all_countries))

                                                                            @foreach($all_countries as $country)
                                                                                @if(!empty($country->name) && $country->name=="India")
                                                                                    <option class="select-option"
                                                                                            name="dhl_dom_country_zip"
                                                                                            label="{{ $country->name }}"
                                                                                            @if((isset($cart) && !empty($cart)) && $cart->shipping_country == $country->name) selected
                                                                                            @endif value={{ $country->id }}>{{ $country->name }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="check-country">
                                                                    <input id="dhl-ip-dom-pin-code" class="form-control"
                                                                           name="dhl_ip_pin_code" type="text"
                                                                           placeholder="Enter Pin Code"/>

                                                                </div>

                                                                <div id="err-dhl-nat-ship"
                                                                     style="font-size: 14px; margin-bottom:5px; color:orange;"></div>
                                                                <div class="harsh-btn-blk relative">
                                                                    <input id="dhl-chk-nat-btn" onclick="validateChkDHLService(this.id)" type="button"
                                                                           class="check-btn" rel="0" value="Check"/>
                                                                    <div id="dv-dhl-loader-national"
                                                                         style="display: none" class="harsh-lodar-blk">
                                                                        <img src="{{ url('public/media/front/img/25.gif') }}">
                                                                    </div>
                                                                </div>
                                                                <div id="main-all-dhl-national">

                                                                </div>
                                                                <input type="hidden" id="chk-dhl-service-session"
                                                                       @if(Session::has('service_details') && Session::get('service_details.service_name')!='' && Session::get('service_details.service_price')!=0) value="1"
                                                                       @else value="0" @endif>
                                                                <input type="hidden" id="hid-dhl-session-price"
                                                                       @if(Session::has('service_details') && Session::get('service_details.service_name')!='' && Session::get('service_details.service_price')!=0) value="{{ Session::get('service_details.service_price') }}"
                                                                       @else value="0" @endif>
                                                                <div id="all-dhl-national" style="display: none">
                                                                    <ul class="radio all-national-block-here">
                                                                        <li id="dhl-radio-li-replace-id">
                                                                            <div class="harsh-radio">
                                                                                <input id="dhl-nat-ip-id"
                                                                                       name="dhl_national_service"
                                                                                       value="replace-value"
                                                                                       replace-check
                                                                                       onclick="getDHLServices(this.id)"
                                                                                       type="radio" rel="0"/>Service
                                                                                No : replace-no
                                                                            </div>
                                                                            <p><span>Service Name:</span> replace-provider
                                                                            </p>
                                                                            <p><span>Service Price:</span> replace-max
                                                                            </p>
                                                                            <p><span>Estimated Days:</span>
                                                                                replace-estimate</p>
                                                                            <p><span>Total Delivery Days:</span>
                                                                                replace-days</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div role="tabpanel" class="tab-pane view-cart-tab"
                                                             id="dhl-profile">
                                                            <div class="locator-form text-center clearfix">
                                                                <div class="check-country">
                                                                    <select name="dhl_inter_country_zip"
                                                                            id="dhl-inter-country-zip"
                                                                            class="form-control">
                                                                        <option class="select-option"
                                                                                label="Please Select" value=""
                                                                                name="dhl_inter_country_zip">
                                                                            Please Select
                                                                        </option>
                                                                        @if(isset($all_countries))

                                                                            @foreach($all_countries as $country)
                                                                                @if(!empty($country->name) && $country->name !="India")
                                                                                    <option class="select-option"
                                                                                            name="dhl_inter_country_zip"
                                                                                            label="{{ $country->name }}"
                                                                                            @if((isset($cart) && $cart!="") && $cart->shipping_country == $country->name) selected
                                                                                            @endif value={{ $country->id }}>{{ $country->name }}</option>
                                                                                @endif
                                                                                {{--<option class="select-option" label="India" @if(isset($cart) && $cart->shipping_country == 'India') selected @endif value="India">India</option>--}}
                                                                                {{--<option class="select-option" label="United States" @if(isset($cart) && $cart->shipping_country == 'United States') selected @endif value="United States">United States</option>--}}
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                                <div class="check-country">
                                                                    <input id="dhl-ip-inter-pin-code"
                                                                           class="form-control"
                                                                           name="dhl_ip_inter_pin_code" type="text"
                                                                           placeholder="Enter Pin Code"/>
                                                                </div>
                                                                <div id="err-dhl-int-ship"
                                                                     style="font-size: 14px; margin-bottom:5px; color:orange;"></div>
                                                                <div class="harsh-btn-blk relative">
                                                                    <input id="dhl-chk-int-btn" onclick="validateChkDHLService(this.id)"
                                                                           type="button" class="check-btn"
                                                                           value="Check" rel="1"/>
                                                                    <div id="dv-dhl-loader-international"
                                                                         style="display: none" class="harsh-lodar-blk">
                                                                        <img src="{{ url('public/media/front/img/25.gif') }}">
                                                                    </div>
                                                                </div>
                                                                <div id="main-all-dhl-international">

                                                                </div>
                                                                <div id="all-dhl-international" style="display: none">
                                                                    <ul class="radio all-national-block-here">
                                                                        <li id="dhl-nat-radio-li-replace-id">
                                                                            <div class="harsh-radio">
                                                                                <input
                                                                                        id="dhl-int-ip-id"
                                                                                       name="dhl_national_service"
                                                                                       value="replace-value"
                                                                                       replace-check
                                                                                       onclick="getDHLServices(this.id)"
                                                                                       type="radio" rel="1"
                                                                                       />Service No
                                                                                : replace-no
                                                                            </div>
                                                                            <p><span>Service Name:</span> replace-provider
                                                                            </p>
                                                                            <p><span>Service Price:</span> replace-max
                                                                            </p>
                                                                            <p><span>Estimated Days:</span>
                                                                                replace-estimate</p>
                                                                            <p><span>Total Delivery Days:</span>
                                                                                replace-days</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="panel-group" id="accordion">--}}
                                {{--<div class="panel panel-default">--}}
                                {{--<div class="panel-heading" role="tab">--}}
                                {{--<a role="button" data-toggle="collapse" data-parent="#accordion"--}}
                                {{--href="#estimate-ship-tax" class="relative">--}}
                                {{--DHL Pincode / Zipcode Check--}}
                                {{--<span drop-icon><i class="fa fa-angle-down"></i></span>--}}
                                {{--</a>--}}
                                {{--</div>--}}
                                {{--<div id="estimate-ship-tax" class="panel-collapse collapse">--}}
                                {{--<div class="panel-body">--}}
                                {{--<div class="cart-location">--}}
                                {{--<!-- Tab panes -->--}}
                                {{--<div class="tab-content">--}}
                                {{--<div role="tabpanel" class="tab-pane active" id="home">--}}
                                {{--<div class="locator-form text-center clearfix">--}}
                                {{--<div class="check-country">--}}
                                {{--<select class="form-control">--}}
                                {{--<option>Select Country</option>--}}
                                {{--<option>India</option>--}}
                                {{--<option>USA</option>--}}
                                {{--<option>Canada</option>--}}
                                {{--<option>UK</option>--}}
                                {{--<option>Japan</option>--}}
                                {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="check-country">--}}
                                {{--<select class="form-control">--}}
                                {{--<option>Select State / Province</option>--}}
                                {{--<option>Pune</option>--}}
                                {{--<option>Mumbai</option>--}}
                                {{--<option>Chenai</option>--}}
                                {{--</select>--}}
                                {{--</div>--}}
                                {{--<div class="check-country">--}}
                                {{--<input class="form-control" placeholder="city"/>--}}
                                {{--</div>--}}
                                {{--<div class="check-country">--}}
                                {{--<input class="form-control" placeholder="zip"/>--}}
                                {{--</div>--}}
                                {{--<a href="javascript:void(0);"--}}
                                {{--class="check-btn">Estimate</a>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#apply-coupon-code" class="relative">
                                                Have a Coupon code
                                                <span drop-icon><i class="fa fa-angle-down"></i></span>
                                            </a>
                                        </div>
                                        <div id="apply-coupon-code" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="cart-location">
                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="home">
                                                            <div class="locator-form text-center clearfix">
                                                                <div class="promo-code-btn relative">
                                                                    <input id="ip-coupon-code" type="text"
                                                                           name="coupon_code"
                                                                           @if(isset($cart)) rel="{{ $cart->id }}"
                                                                           @endif @if(Session::has('all_cart_data') && Session::get('all_cart_data.coupon_code')!='') value="{{ Session::get('all_cart_data.coupon_code') }}" @endif class="form-control" placeholder=""/>
                                                                    <div class="promo-btn"><a id="ancr-coupon-code"
                                                                                              href="javascript:void(0);"
                                                                                              onclick="doCoupon(this.id)">
                                                                            @if(Session::has('all_cart_data') && Session::get('all_cart_data.coupon_code')!='') value="{{ Session::get('all_cart_data.coupon_code') }}" Remove Coupon @else Apply Code @endif</a></div>
                                                                    <p id="coupon-span"
                                                                       style="display:none;text-align:left;padding-left:5px;font-size: 14px;margin-bottom:5px;color:orange;"
                                                                       class="text-danger">Invalid Coupon Code</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#promo-code" class="relative">
                                                Have a promo code
                                                <span drop-icon><i class="fa fa-angle-down"></i></span>
                                            </a>
                                        </div>
                                        <div id="promo-code" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="cart-location">
                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="home">
                                                            <div class="locator-form text-center clearfix">
                                                                <div class="promo-code-btn relative">
                                                                    <input id="ip-promo-code" name="promo_code"
                                                                           type="text"
                                                                           @if(isset($cart)) rel="{{ $cart->id }}"
                                                                           @endif @if(Session::has('all_cart_data') && Session::get('all_cart_data.promo_code')!='') value="{{ Session::get('all_cart_data.promo_code') }}" @endif  class="form-control" placeholder=""/>
                                                                    <div class="promo-btn"><a id="ancr-promo-code"
                                                                                              href="javascript:void(0);"
                                                                                              onclick="doPromoCode(this.id)">
                                                                            @if(Session::has('all_cart_data') && Session::get('all_cart_data.promo_code')!='') Remove Promo @else Apply Code @endif </a></div>
                                                                    <p class="text-danger"
                                                                       style="text-align:left;padding-left:5px;font-size: 14px;margin-bottom:5px;color:orange;display:none"
                                                                       id="promo-code-invalid">Invalid Coupon Code</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#gift-voucher-code" class="relative">
                                                Apply gift card code
                                                <span drop-icon><i class="fa fa-angle-down"></i></span>
                                            </a>
                                        </div>
                                        <div id="gift-voucher-code" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="cart-location">
                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="home">
                                                            <div class="locator-form text-center clearfix">
                                                                <div class="promo-code-btn relative">
                                                                    {{--<input type="text" class="form-control" placeholder=""/>--}}
                                                                    {{--<div class="promo-btn"><a href="javascript:void(0);">Apply Code</a></div>--}}
                                                                    <input id="ip-gift-code" name="gift_code"
                                                                           @if(isset($cart)) rel="{{ $cart->id }}"
                                                                           @endif @if(Session::has('all_cart_data') && Session::get('all_cart_data.gift_voucher') !=0) @endif type="text" class="form-control"
                                                                           placeholder=""/>
                                                                    <div class="promo-btn"><a id="ancr-gift-code"
                                                                                              href="javascript:void(0);"
                                                                                              onclick="doGiftCode(this.id)">
                                                                            @if(Session::has('all_cart_data') && Session::get('all_cart_data.gift_voucher') !=0) Remove Gift Voucher  @else Apply Code @endif  </a></div>
                                                                    <p class="text-danger"
                                                                       style="text-align:left;padding-left:5px;font-size: 14px;margin-bottom:5px;color:orange;display:none"
                                                                       id="gift-code-invalid">Invalid Gift Code</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <a role="button" class="relative" class="open-packaging"
                                               onclick="packging()">
                                                Choose Packaging option
                                                <span drop-icon><i class="fa fa-angle-down"></i></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab">
                                            <a role="button"
                                               href="#invoice-blk" class="relative">
                                                Show Consolidate Total Of all
                                                <span drop-icon><i class="fa fa-angle-down"></i></span>
                                            </a>
                                        </div>
                                        <div id="invoice-blk" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="cart-location">
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="home">
                                                            <div class="locator-form text-center clearfix">
                                                                <ul class="invoice-list">
                                                                    <li class="clearfix">
                                                                        <span class="inv-left-list inv-left">PRODUCT TOTAL AMOUNT</span>
                                                                        <span id="all-total"
                                                                              class="inv-left-list inv-right">
                                                                       @if(count($arrCartData)>0 && $arrCartData['total'] !='') {{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($arrCartData['total']),2,'.','') }} @else {{ \App\Helpers\Helper::getCurrencySymbol().'0.00' }} @endif
                                                                </span>
                                                                    </li>
                                                                    <li class="clearfix">
                                                                        <span class="inv-left-list inv-left">ESTIMATED SHIPPING COST</span>
                                                                        <span id="shipping-total"
                                                                              class="inv-left-list inv-right">
                                                                   @if(count($arrCartData)>0 && $arrCartData['shipping_charge'] !='') {{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($arrCartData['shipping_charge']),2,'.','') }} @else {{ \App\Helpers\Helper::getCurrencySymbol().'0.00' }} @endif
                                                                </span>
                                                                    </li>
                                                                    <li class="clearfix">
                                                                        <span class="inv-left-list inv-left">COUPON AMOUNT</span>
                                                                        <span id="coupon-amt"
                                                                              class="inv-left-list inv-right">
                                                                    {{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice(Session::get('all_cart_data.coupon_amount')),2,'.','')  }}
                                                                </span>
                                                                    </li>
                                                                    <li class="clearfix">
                                                                        <span class="inv-left-list inv-left">PROMO CODE AMOUNT</span>
                                                                        <span id="promo-total"
                                                                              class="inv-left-list inv-right">
                                                                    {{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice(Session::get('all_cart_data.promo_amount')),2,'.','')  }}
                                                                </span>
                                                                    </li>
                                                                    <li class="clearfix">
                                                                        <span class="inv-left-list inv-left">GIFT CARD AMOUNT</span>
                                                                        <span id="gift-voucher-total"
                                                                              class="inv-left-list inv-right">
                                                                    {{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice(Session::get('all_cart_data.gift_voucher')),2,'.','')  }}
                                                                </span>
                                                                    </li>
                                                                    {{--<li class="clearfix">--}}
                                                                        {{--<span class="inv-left-list inv-left">REFFER POINTS AMOUNT</span>--}}
                                                                        {{--<span id="refer-total"--}}
                                                                              {{--class="inv-left-list inv-right">--}}
                                                                    {{--{{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice(Session::get('all_cart_data.refer_points')),2,'.','') }}--}}
                                                                {{--</span>--}}
                                                                    {{--</li>--}}
                                                                    <li class="clearfix">
                                                                        <span class="inv-left-list inv-left">PACKAGING COST</span>
                                                                        <span id="pakaging-total"
                                                                              class="inv-left-list inv-right">
                                                                 @if(count($arrCartData)>0){{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($arrCartData['box_amount'] + $arrCartData['paper_amount']),2,'.','')  }} @else
                                                                                {{\App\Helpers\Helper::getCurrencySymbol().'0.00'  }} @endif
                                                                </span>
                                                                    </li>
                                                                    <li class="clearfix">
                                                                        <span class="inv-left-list inv-left">DISPLAY COST</span>
                                                                        <span id="display-total"
                                                                              class="inv-left-list inv-right">
                                                                   @if(count($arrCartData)>0 && $arrCartData['display_amount'] !='') {{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($arrCartData['display_amount']),2,'.','') }} @else {{ \App\Helpers\Helper::getCurrencySymbol().'0.00' }} @endif
                                                               </span>
                                                                    </li>
                                                                    <li class="clearfix">
                                                                        <span class="inv-left-list inv-left">TOTAL TAXES</span>
                                                                        <span id="tax-total"
                                                                              class="inv-left-list inv-right">
                                                                    @if($cart->tax !=0){{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($cart->display_amount),2,'.','') }} @else
                                                                                {{ \App\Helpers\Helper::getCurrencySymbol().'0.00' }} @endif
                                                                </span>
                                                                    </li>
                                                                    <li class="clearfix">
                                                                        <span class="inv-left-list inv-left">TOTAL SAVINGS</span>
                                                                        <span id="total-savings"
                                                                              class="inv-left-list inv-right">
                                                                    {{ \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice(Session::get('all_cart_data.total_savings')),2,'.','')  }}
                                                                </span>
                                                                    </li>
                                                                    <li class="clearfix">
                                                                        <span class="inv-left-list inv-left total-bold">Grand Total</span>
                                                                        <span id="grand-total"
                                                                              class="inv-left-list inv-right total-bold">
                                                                      @if(count($arrCartData)>0) {{  \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($arrCartData['grand_total']),2,'.','')  }} @else {{ \App\Helpers\Helper::getCurrencySymbol().'0.00' }} @endif
                                                                </span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <form id="chek-out-all-form" name="chek_out_all_form" method="post" action="{{ url('/checkout-from-cart') }}">
                                            {!! csrf_field() !!}
                                            <input id="payment-option" type="hidden" name="payment_val">
                                            <div class="text-right edit-option clearfix"
                                                 style="position:relative">
                                                <input onclick="validateCheckout()" id="checkout-btn" style="text-decoration: none;" type="button"
                                                       value="CHECKOUT" class="h-update-cart pull-right">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                    <div class="row">
                            <div class="row empty-cart-image">
                                <img src="{{url('public/media/front/img/empty-cart.jpg')}}" alt="Empty Cart"/>
                            </div>
                    </div>
            @endif
        </div>
    </section>
    <div class="cust-modal modal fade in" id="cust-modal-edit">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="header-blk-name">Edit Customer Details</div>
                <div class="modal-header">


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><!--<img src="img/cancel.png" alt="close">--><i
                                    class="fa fa-close"></i></span></button>
                </div>
                <div class="modal-body">
                    <form class="form-sender mCustomScrollbar" enctype="multipart/form-data" method="post"
                          action="{{ url('proceed-customer-shipping-details') }}" role="form"
                          name="customer-shipping-details-form" id="customer-shipping-details-form">
                        <input type="hidden" value="B7WCSChvCnFvjwueymRZV9aM3GKbgeiwYZXg4rRO" name="_token">
                        <!--<div class="form-head"><h5>Enter a Delivery Address:</h5></div>-->
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Title<sup>*</sup>:</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-sel">
                                    <select class="form-control" name="name_initial" id="name_initial">
                                        <option value="">Please Select</option>
                                        <option value="mr">Mr.</option>
                                        <option value="mrs">Mrs.</option>
                                        <option value="miss">Miss.</option>
                                        <option value="ms">Ms.</option>
                                        <option value="dr">Dr.</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">First Name<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="text" placeholder="First Name" class="form-control" name="first_name">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Last Name<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="text" value="" placeholder="Last Name" class="form-control"
                                           name="last_name">
                                </div>
                            </div>
                        </div>


                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Email<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="email" placeholder="Email" class="form-control" name="email"
                                           id="email">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Confirm Email<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="email" placeholder="Confirm Email" class="form-control"
                                           name="confirm_email">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="h-cust-input">
                                    <button type="submit" value="Proceed" class="h-update-cart">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="cust-modal manage-modal modal fade in" id="h-quick-view">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="header-blk-name">Edit Shipping & Billing Address</div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><!--<img src="img/cancel.png" alt="close">--><i
                                    class="fa fa-close"></i></span></button>
                </div>
                <div class="modal-body">
                    <form class="form-sender mCustomScrollbar" enctype="multipart/form-data" method="post"
                          action="{{ url('proceed-shipping-details') }}" role="form" name="shipping_details_form"
                          id="shipping-details-form">
                        {!!  csrf_field()  !!}

                        <input type="hidden" name="ip_cart_id" @if(!empty($cart->id)) value="{{ $cart->id }}" @endif />
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Name of Contact<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="shipping_name"
                                       @if(!empty($cart->shipping_name)) value="{{$cart->shipping_name}}" @endif>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Email Id<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="shipping_email"
                                       @if(!empty($cart->shipping_email)) value="{{ $cart->shipping_email }}" @endif>
                            </div>
                        </div>
                        <input type="hidden" name="shipping_iso2" id="shipping_country_code"
                               value="{{ old('shipping_iso2',isset($cart) ? $cart->shipping_iso2 : "")}}"/>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Country<sup>*</sup> :</label>
                            </div>

                            <div class="col-md-8">
                                <div class="h-cust-sel">
                                    <select name="country" id="shipping-country" class="form-control"
                                            onchange="getAllStates(this.value,this.id)"
                                    >
                                        <option class="select-option" label="Please Select" value="" name="country">
                                            Please Select
                                        </option>

                                        @if(isset($all_countries))

                                            @foreach($all_countries as $country)
                                                <option class="select-option" label="{{ $country->name }}"
                                                        @if((isset($cart) && $cart!="") && $cart->shipping_country == $country->id) selected
                                                        @endif value={{ $country->id }}>{{ $country->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <script>
                                if('<?php echo $cart; ?>' != null)
                                {
                                    if('<?php echo $cart->shipping_country; ?>' != '')
                                    {
                                        getCountryInfo('<?php echo $cart->shipping_country; ?>');
                                    }
                                }

                            </script>
                            <input id="ship-ctry-digits" type="hidden">
                            <input id="ship-ctry-pattern" type="hidden">
                        </div>
                        {{--<div class="row form-group">--}}
                            {{--<div class="col-md-4">--}}
                                {{--<label class="shipping-label">Region/Province<sup>*</sup> :</label>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-8">--}}
                                {{--<input type="text" class="form-control" id="shipping-state" name="region"--}}
                                       {{--@if(!empty($cart->shipping_state)) value="{{$cart->shipping_state}}" @endif>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row form-group">--}}
                            {{--<div class="col-md-4">--}}
                                {{--<label class="shipping-label">City<sup>*</sup> :</label>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-8">--}}
                                {{--<input type="text" class="form-control" id="shipping-city" name="city"--}}
                                       {{--@if(!empty($cart->shipping_city)) value="{{$cart->shipping_city}}" @endif>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Region/Province<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <div class="h-cust-sel">
                                        <select name="region" id="shipping-state" class="form-control"
                                                onchange="getAllCities(this.value,this.id)" required>
                                                required>
                                            <option class="select-option" label="Please Select" value="">Please Select
                                            </option>
                                            @php
                                                $states =null;
                                                 if(isset($cart) && $cart->shipping_country !=''){
                                                 $states = \App\PiplModules\admin\Models\State::where('country_id',$cart->shipping_country)->get();
                                                }
                                            @endphp
                                            @if(isset($states) && count($states)>0)
                                                @foreach($states as $state)
                                                    <option value="{{$state->id}}"
                                                            @if(isset($cart) && $cart->shipping_state == $state->id) selected @endif>{{$state->name}}</option>
                                                @endforeach
                                            @endif
                                            <option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Maharashtra')) selected @endif label="Maharashtra" value="Maharashtra">Maharashtra</option>
                                            <option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Gujarat')) selected @endif label="Gujarat" value="Gujarat">Gujarat</option>
                                            <option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Madhya Pradesh')) selected @endif label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">City<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <div class="h-cust-sel">
                                        <select name="city" id="shipping-city" class="form-control" required>
                                            <option class="select-option" label="Please Select" value="">Please Select
                                            </option>
                                            @php
                                                $cities=null;
                                                 if(isset($cart) && $cart->billing_state !=''){
                                                 $cities = \App\PiplModules\admin\Models\City::where('state_id',$cart->billing_state)->get();
                                                }
                                            @endphp
                                            @if(isset($cities) && count($cities)>0)
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}"
                                                            @if(isset($cart) && $cart->shipping_city == $city->id) selected @endif>{{$city->name}}</option>
                                                @endforeach
                                            @endif
                                            <option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Maharashtra')) selected @endif label="Maharashtra" value="Maharashtra">Maharashtra</option>
                                            <option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Gujarat')) selected @endif label="Gujarat" value="Gujarat">Gujarat</option>
                                            <option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Madhya Pradesh')) selected @endif label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Shipping Address1<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="text" placeholder="Shipping Address1"
                                           @if(isset($cart) && count($cart)>0) value="{{$cart->shipping_address1}}"
                                           @endif class="form-control" name="house_no" required>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Shipping Address2:</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="text" placeholder="Shipping Address2"
                                           @if(isset($cart) && count($cart)>0) value="{{$cart->shipping_address2}}"
                                           @endif class="form-control" name="address_line" required>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Postal Code<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input id="shipping-zip" type="text" placeholder="Postal Code"
                                           @if(!empty($cart->shipping_zip))  value="{{$cart->shipping_zip}}"
                                           @endif   class="form-control" name="postal_code">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Phone Number<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="tel" id="shipping-mobile-no" class="form-control"
                                           @if(!empty($cart->shipping_telephone))   value="{{$cart->shipping_telephone}}"
                                           @endif  name="telephone">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="h-cust-input">
                                    <div class="form-group categories-details-filter">
                                        <label class="custom-checkbox">Use this address for billing<input
                                                    type="checkbox" checked onclick="toggleDisplayBillingAddress(this)"
                                                    name="billing_address"><span class="checkmark"></span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="billing_details" style="display: none">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Name of Contact<sup>*</sup> :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="billing_name"
                                           @if(!empty($cart->billing_name)) value="{{$cart->billing_name}}" @endif>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Email Id<sup>*</sup> :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="billing_email"
                                           @if(!empty($cart->billing_email)) value="{{$cart->billing_email}}" @endif>
                                </div>
                            </div>
                            <input type="hidden" name="billing_iso2" id="billing_country_code"
                                   value="{{ old('billing_iso2',isset($cart) ? $cart->billing_iso2 : "")}}"/>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Country<sup>*</sup> :</label>
                                </div>

                                <div class="col-md-8">
                                    <div class="h-cust-sel">
                                        <select name="billing_country" id="billing-country"
                                                onchange="getAllStates(this.value,this.id)" class="form-control">
                                                class="form-control">
                                            <option class="select-option" label="Please Select" value="" name="country">
                                                Please Select
                                            </option>
                                            @if(isset($all_countries) && count($all_countries)>0)
                                                @foreach($all_countries as $country)
                                                    <option class="select-option" label="{{ $country->name }}"
                                                            @if(isset($cart) && $cart->shipping_country == $country->id) selected
                                                            @endif value={{ $country->id }}>{{ $country->name }}</option>
                                                    {{--<option class="select-option" label="India" @if(isset($cart) && $cart->shipping_country == 'India') selected @endif value="India">India</option>--}}
                                                    {{--<option class="select-option" label="United States" @if(isset($cart) && $cart->shipping_country == 'United States') selected @endif value="United States">United States</option>--}}
                                                @endforeach
                                            @endif
                                            {{--<option class="select-option" @if(!empty($cart->billing_country) && $cart->billing_country == 'Canada') selected @endif label="Canada" value="Canada">Canada</option>--}}
                                            {{--<option class="select-option" @if(!empty($cart->billing_country) && $cart->billing_country == 'India') selected @endif label="India" value="India">India</option>--}}
                                            {{--<option class="select-option" @if(!empty($cart->billing_country) && $cart->billing_country == 'United States') selected @endif label="United States" value="United States">United States</option>--}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Region/Province<sup>*</sup> :</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        <div class="h-cust-sel">
                                            <select name="billing_region" id="billing-state"
                                                    onchange="getAllCities(this.value,this.id)" class="form-control"
                                                    class="form-control" required>
                                                <option class="select-option" label="Please Select" value="">Please
                                                    Select
                                                </option>
                                                @php
                                                    $states =null;
                                                     if(isset($cart) && $cart->billing_country !=''){
                                                     $states = \App\PiplModules\admin\Models\State::where('country_id',$cart->billing_country)->get();
                                                    }
                                                @endphp
                                                @if(isset($states) && count($states)>0)
                                                    @foreach($states as $state)
                                                        <option value="{{$state->id}}"
                                                                @if(isset($cart) && $cart->billing_state == $state->id) selected @endif>{{$state->name}}</option>
                                                    @endforeach
                                                @endif
                                                <option class="select-option" @if(!empty($cart->billing_state)  && $cart->billing_state == 'Maharashtra') selected @endif label="Maharashtra" value="Maharashtra">Maharashtra</option>
                                                <option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Gujarat') selected @endif label="Gujarat" value="Gujarat">Gujarat</option>
                                                <option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Madhya Pradesh') selected @endif label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="row form-group">--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label class="shipping-label">Region/Province<sup>*</sup> :</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-8">--}}
                                    {{--<input type="text" class="form-control" id="billing-state" name="billing_region"--}}
                                           {{--@if(!empty($cart->billing_state)) value="{{$cart->billing_state}}" @endif>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row form-group">--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label class="shipping-label">City<sup>*</sup> :</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-8">--}}
                                    {{--<input type="text" class="form-control" id="billing-city" name="billing_city"--}}
                                           {{--@if(!empty($cart->billing_city)) value="{{$cart->billing_city}}" @endif>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">City<sup>*</sup> :</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        <select name="billing_city" id="billing-city" class="form-control" required>
                                            <option class="select-option" label="Please Select" value="">Please Select
                                            </option>
                                            @php
                                                $cities=null;
                                                 if(isset($cart) && $cart->billing_state !=''){
                                                 $cities = \App\PiplModules\admin\Models\City::where('state_id',$cart->billing_state)->get();
                                                }
                                            @endphp
                                            @if(isset($cities) && count($cities)>0)
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                            @if(isset($cart) && $cart->billing_city !='' && $cart->billing_city == $city->id) selected @endif>{{ $city->name }}</option>
                                                @endforeach
                                            @endif
                                            <option class="select-option" @if(!empty($cart->billing_state)  && $cart->billing_state == 'Maharashtra') selected @endif label="Maharashtra" value="Maharashtra">Maharashtra</option>
                                            <option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Gujarat') selected @endif label="Gujarat" value="Gujarat">Gujarat</option>
                                            <option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Madhya Pradesh') selected @endif label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Billing Address1<sup>*</sup> :</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        <input type="text" placeholder="Billing Address1" class="form-control"
                                               @if(!empty($cart->billing_address1))  value="{{$cart->billing_address1}}"
                                               @endif   name="billing_house_no" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Billing Address2<sup>*</sup> :</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        <input type="text" placeholder="Billing Address2" class="form-control"
                                               @if(!empty($cart->billing_address2))  value="{{$cart->billing_address2}}"
                                               @endif name="billing_address_line" required>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="row form-group">--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label class="shipping-label">City<sup>*</sup> :</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-8">--}}
                                    {{--<div class="h-cust-input">--}}
                                        {{--<input type="text" id="billing-city" placeholder="City" class="form-control" @if(!empty($cart->billing_city))  value="{{$cart->billing_city}}"   @endif     name="billing_city" required>--}}
                                        {{--<select name="billing_city" id="billing-city" class="form-control" required>--}}
                                            {{--<option class="select-option" label="Please Select" value="">Please Select--}}
                                            {{--</option>--}}
                                            {{--@php--}}
                                                {{--$cities=null;--}}
                                                 {{--if(isset($cart) && $cart->billing_state !=''){--}}
                                                 {{--$cities = \App\PiplModules\admin\Models\City::where('state_id',$cart->billing_state)->get();--}}
                                                {{--}--}}
                                            {{--@endphp--}}
                                            {{--@if(isset($cities) && count($cities)>0)--}}
                                                {{--@foreach($cities as $city)--}}
                                                    {{--<option value="{{ $city->id }}"--}}
                                                            {{--@if(isset($cart) && $cart->billing_city !='' && $cart->billing_city == $city->id) selected @endif>{{ $city->name }}</option>--}}
                                                {{--@endforeach--}}
                                            {{--@endif--}}
                                            {{--<option class="select-option" @if(!empty($cart->billing_state)  && $cart->billing_state == 'Maharashtra') selected @endif label="Maharashtra" value="Maharashtra">Maharashtra</option>--}}
                                            {{--<option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Gujarat') selected @endif label="Gujarat" value="Gujarat">Gujarat</option>--}}
                                            {{--<option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Madhya Pradesh') selected @endif label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row form-group">--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label class="shipping-label">Region/Province<sup>*</sup> :</label>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-8">--}}
                                    {{--<div class="h-cust-input">--}}
                                        {{--<div class="h-cust-sel">--}}
                                            {{--<select name="billing_region" id="billing-state"--}}
                                                    {{--onchange="getAllCities(this.value,this.id)" class="form-control"--}}
                                                    {{--class="form-control"--}}
                                                    {{--required>--}}
                                                {{--<option class="select-option" label="Please Select" value="">Please--}}
                                                    {{--Select--}}
                                                {{--</option>--}}
                                                {{--@php--}}
                                                    {{--$states =null;--}}
                                                     {{--if(isset($cart) && $cart->billing_country !=''){--}}
                                                     {{--$states = \App\PiplModules\admin\Models\State::where('country_id',$cart->billing_country)->get();--}}
                                                    {{--}--}}
                                                {{--@endphp--}}
                                                {{--@if(isset($states) && count($states)>0)--}}
                                                    {{--@foreach($states as $state)--}}
                                                        {{--<option value="{{$state->id}}"--}}
                                                                {{--@if(isset($cart) && $cart->billing_state == $state->id) selected @endif>{{$state->name}}</option>--}}
                                                    {{--@endforeach--}}
                                                {{--@endif--}}
                                                {{--<option class="select-option" @if(!empty($cart->billing_state)  && $cart->billing_state == 'Maharashtra') selected @endif label="Maharashtra" value="Maharashtra">Maharashtra</option>--}}
                                                {{--<option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Gujarat') selected @endif label="Gujarat" value="Gujarat">Gujarat</option>--}}
                                                {{--<option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Madhya Pradesh') selected @endif label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Postal Code:</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        <input type="text" id="billing-zip" name="billing_postal_code"
                                               placeholder="Postal Code (optional)" class="form-control"
                                               @if(!empty($cart->billing_zip))  value="{{$cart->billing_zip}}" @endif >
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Phone Number<sup>*</sup> :</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        <input type="text" id="billing-mobile-no" name="billing_telephone"
                                               class="form-control"
                                               @if(!empty($cart->billing_telephone))  value="{{$cart->billing_telephone}}" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="h-cust-input">
                                    <button type="submit" value="Proceed" class="h-update-cart">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(isset($cart) && !empty($cart->shipping_country) && $cart->is_shipping_details_filled =='1')
        @php
            $ctryDetls = \App\PiplModules\admin\Models\CountryTranslation::where('country_id',$cart->shipping_country)->first();

        @endphp
    @endif
    <!-----------------------packaging modal here-------------------------------->
    <div class="h-calculated-measurement gift-packaging-container">
        <div class="h-calculated-content">
            <div class="gifting-wrapper relative">
                <div class="close-popup" onclick="packgingClose()"><img
                            src="{{url('/public/media/front/img/cancel1.png')}}"/></div>
                <!-- Nav tabs -->
                <ul id="ul-pakng-id" class="nav nav-tabs" role="tablist">
                    @if(isset($all_boxes) && count($all_boxes)>0)
                        <li role="presentation" class="active"><a href="#home1" aria-controls="home" role="tab"
                                                                  data-toggle="tab">Select Box</a></li>
                    @endif
                    @if(isset($all_papers) && count($all_papers)>0)
                        <li role="presentation"><a href="#profile1" aria-controls="profile" role="tab"
                                                   data-toggle="tab">Select Paper</a></li>
                    @endif
                    @if(isset($all_displays) && count($all_displays)>0)
                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab"
                                                   data-toggle="tab">Display Items</a></li>
                    @endif
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    @if(isset($all_boxes) && count($all_boxes)>0)
                        <div role="tabpanel" class="tab-pane active" id="home1">
                            <div class="my-tab-sld owl-carousel">
                                @foreach($all_boxes as $index=>$box)
                                    <div class="item">
                                        <div id="box-container-{{ $box->id }}" onclick="boxActive(this)"
                                             class="wrap-container box-containr relative @if(isset($cart->box_id) && $cart->box_id == $box->id) selected-wrap @endif">
                                            <div class="wrap-img">
                                                <img src="{{url('/storage/app/public/box_image').'/'.$box->image}}"/>

                                            </div>
                                            @if(isset($box->status) && $box->status=="1")
                                                <span class="wrap-price"> {{ App\Helpers\Helper::getCurrencySymbol().number_format(App\Helpers\Helper::getRealPrice(
                                                $box->price),2,'.','') }}</span>
                                            @else
                                                <span class="wrap-price">FREE</span>
                                            @endif
                                            <div class="wrap-info">
                                                <h3>{{ $box->name }}</h3>
                                                <p>{{ $box->description }}</p>
                                                {{--<!-- <a class="alter-box-text" id="ancr-box-tg-{{ $box->id }}" onclick="doBox('{{ $box->id }}')">Purchase</a> -->--}}
                                            </div>
                                            <div class="selct-serv"><i class="fa fa-check"></i></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{--<div class="added-messges">--}}
                                {{--<form class="added-messages">--}}
                                    {{--<div class="form-group user-msg relative">--}}
                                        {{--<input type="text" name="" class="form-control"--}}
                                               {{--placeholder="Enter your message">--}}
                                        {{--<span class="apply-btn"><button type="button"--}}
                                                                        {{--class="clear-sel apl-btn">Apply</button></span>--}}
                                    {{--</div>--}}
                                {{--</form>--}}
                            {{--</div>--}}
                            <div class="clear-selection-btn">
                                <a style="cursor: pointer;" id="ancr-clr-sel" onclick="clearBoxSel()" class="clear-sel">Clear
                                    Selection</a>
                                <a style="cursor: pointer;" onclick="boxNxt()" class="clear-sel">Next</a>
                            </div>
                            {{--<div class="clear-selection-btn">--}}
                            {{--<a href="javascript:void(0);" class="clear-sel">Clear Selection</a>--}}
                            {{--<a href="javascript:void(0);" class="clear-sel">Apply Gift Wrap Changes</a>--}}
                            {{--</div>--}}
                        </div>
                    @endif
                    @if(isset($all_papers) && count($all_papers)>0)
                        <div role="tabpanel" class="tab-pane" id="profile1">
                            <div class="my-tab-sld owl-carousel">
                                @foreach($all_papers as $paper)
                                    <div class="item">
                                        <div id="paper-container-{{ $paper->id }}" onclick="paperActive(this)"
                                             class="wrap-container paper-containr relative @if(isset($cart->paper_id) && $cart->paper_id ==$paper->id) selected-wrap @endif ">
                                            <div class="wrap-img">
                                                <img src="{{url('/storage/app/public/paper_image').'/'.$paper->image}}"/>
                                            </div>
                                            @if(isset($paper->status) && $paper->status=="1")
                                                <span class="wrap-price">{{ App\Helpers\Helper::getCurrencySymbol().number_format(App\Helpers\Helper::getRealPrice($paper->price),2,'.','') }}</span>
                                            @else
                                                <span class="wrap-price">FREE</span>
                                            @endif
                                            <div class="wrap-info">
                                                <h3>{{ $paper->name }}</h3>
                                                <p>{{ $paper->description }}</p>
                                                {{--<!-- <a class="alter-paper-text" id="ancr-paper-tg-{{ $paper->id }}" onclick="doPaper('{{ $paper->id }}')">Purchase</a> -->--}}
                                            </div>
                                            <div class="selct-serv"><i class="fa fa-check"></i></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="clear-selection-btn">
                                <a style="cursor: pointer;" id="ancr-clr-sel" onclick="clearPaperSel()"
                                   class="clear-sel">Clear Selection</a>
                                <a style="cursor: pointer;" onclick="paperNxt()" class="clear-sel">Next</a>
                            </div>
                        </div>
                    @endif
                    @if(isset($all_displays) && count($all_displays)>0)
                        <div role="tabpanel" class="tab-pane" id="messages">
                            <div class="my-tab-sld owl-carousel">
                                @foreach($all_displays as $display)
                                    <div class="item">
                                        <div id="msg-card-container-{{ $display->id }}" onclick="msgCardActive(this)"
                                             class="wrap-container message-card-containr relative  @if(isset($cart->display_id) && $cart->display_id == $display->id) selected-wrap @endif ">
                                            <div class="wrap-img">
                                                <img src="{{url('/storage/app/public/display_image').'/'.$display->image}}"/>
                                            </div>
                                            @if(isset($display->status) && $display->status=="1")
                                                <span class="wrap-price">{{ App\Helpers\Helper::getCurrencySymbol().number_format(App\Helpers\Helper::getRealPrice($display->price),2,'.','') }}</span>
                                            @else
                                                <span class="wrap-price">FREE</span>
                                            @endif
                                            <div class="wrap-info">
                                                <h3>{{ $display->name }}</h3>
                                                <p>{{ $display->description }}</p>
                                            </div>
                                            <div class="selct-serv"><i class="fa fa-check"></i></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="clear-selection-btn">
                                <a style="cursor: pointer;" id="ancr-clr-sel" onclick="clearDispSel()"
                                   class="clear-sel">Clear Selection</a>
                                <a style="cursor: pointer;" onclick="packgingClose()" class="clear-sel">Next</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-------------------------Script Section---------------------->
    <script type="text/javascript">
        $('.carousel[data-type="multi"] .item').each(function () {
            var next = $(this).next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));

            for (var i = 0; i < 2; i++) {
                next = next.next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }

                next.children(':first-child').clone().appendTo($(this));
            }
        });
    </script>
    <script>
        rtFlag = 0;
        tmpVar =0;
        function chkFinalRateRequest()
        {
            $.ajax({
                url: '{{url("/fedex/validate-final-rate-request")}}',
                type: "get",
                dataType: "json",
                success: function (response) {
                    if (response.success == "1")
                    {
                        $("#chek-out-all-form").submit();
                    }
                    else {
                        alert(response.msg);
                    }
                }
            });
        }
    </script>
    <script>
        var arr = [];
        statusFlag = '';
        var grandTotal = document.getElementById('grand-total');
        var paymentOptions = 0;
        var option = 0;

        function do_active(tab_id, id, value) {
            $('.tab-menu').removeClass('active');
            $('.tab-pane').removeClass('active');
            if (value == "box1") {
                $('#' + id).addClass('active');
                $('#' + tab_id).addClass('active');

            }
        }

        function packging() {
            $('body').addClass('open-custom-popup');

        }

        function packgingClose() {
            $('body').removeClass('open-custom-popup');
        }


    </script>
    <link rel="stylesheet" href="{{ asset('public/media/front/intl-telephone/css/intlTelInput.css') }}">
    <script src="{{ asset('public/media/front/intl-telephone/js/intlTelInput.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        pFlag = false;
        optionVal = '';
        function validateDataToCheckout()
        {
            $.ajax({
                url: '{{url("/cart/validate-for-checkout")}}',
                type: "get",
                dataType: "json",
                success: function (response) {

                    if(response.success == '1')
                    {
                        if ($('#payment-option').val() != '')
                        {
                            chkFinalRateRequest();
                        }
                        else
                        {
                            alert('Please select payment option');
                        }
                    }
                    else{
                        alert(response.msg);
                    }
                }
            });
        }

        function validateCheckout() {
            var chk = $('#chk-service-session').val();
            var shipping_data = $("#shipping_data_flag").val();
            var rtSerId = $('#chk-rate-id li.active').attr('id').slice(3, 6);
            var tmpChk =0;
            $("#err-" + rtSerId + "-ship").hide();

            if (chk == 1) {
                if (shipping_data == 1)
                {
                    if ($('#payment-option').val() != '')
                    {
                        validateDataToCheckout();
                    }
                    else {
                        alert('Please select payment option');
                    }

                }
                else {
                    alert('Please fill shipping and billing details to checkout');
                }
            }
            else {
                alert("Please select shipping services and check availability");
            }
        }

        function checkAmountForPayment(ele)
        {
            optionVal = ele.value;
            $('#payment-option').val('');
            $.ajax(
                {
                    type: "post",
                    url: '{{url("/get-cart-grandtotal")}}',
                    dataType: 'json',
                    data: {
                        option_val: optionVal,
                        _token: $("[name=_token]").val()
                    },
                    success: function (res) {
                        if (res.success == "1") {
                            if (res.status == "1") {
                                if (res.optional == "1") {
                                    if (res.domestic == "1") {
                                        alert("COD option is only available for India");
                                    }
                                    else {
                                        alert("COD option not avaliable for this amount");
                                    }
                                }
                                else {
                                    $('#payment-option').val(res.optional);
                                    pFlag = true;
                                }
                            }
                            else {
                                $('#payment-option').val(res.optional);
                                pFlag = true;
                            }
                        }
                        else{
                            alert("COD option is not available for DHL Services");
                        }
                    }
                });
        }

        function finalCheckout()
        {
            var chkOut =  $("#chk-amt-for-pay").val();
            if (ret == 1)
            {
                return true;
            }
            else {
                alert("Please select or update shipping services");
                return false;
            }
        }


    </script>
    <script>
        function showQuickView(product_id) {
            var status = '0';
            if (product_id != "") {
                $.ajax({
                    type: "get",
                    url: javascript_site_path + 'get-product-quick-view',
                    dataType: 'html',
                    data: {
                        _token: $("[name=_token]").val(),
                        product_id: product_id,
                        status: status
                    },
                    success: function (res) {
                        // alert(res);return;
                        $("#h-quick-view").html(res);
                        $("#h-quick-view").modal('show');
                    }
                });
            }
        }
    </script>

    <script>
        var totalAmt = 0;
        var grandTot = 0;

        function addRemoveProductQuantity(id, action) {
            totalAmt = 0;
            cartItemId = id.split('_').pop();
            $.ajax({
                url: '{{url("/add-remove-product-quantity")}}',
                type: "get",
                dataType: 'json',
                data: {
                    cart_item_id: cartItemId,
                    action: action
                },
                success: function (result) {
                    $('#add-minus-status_' + cartItemId).hide();
                    if (result.success == 1) {
                        //document.getElementById("cart_count").innerText = 10;
                        //return;
                        //toReplace = $('#cart_count:first').text();

                        //$('#cart_count:first').html(10);
                        //return;
                        // $('#cart_count:first').text('10');
                        // $('#cart_count:first').text();
                        // $('#cart_count').text(result.msg['product_count']);
                        $('.icon-cart-num.header-cart-count.cart-move').html(result.msg['product_count']);
                        $('#grand-total').text(result.msg['grand_total']);
                        $('#all-total').text(result.msg['main_total']);

                        if (result.msg['coupon_amount'] == 0 && result.msg['coupon_percent'] > 0) {
                            $('#coupon-amt').html(result.msg['coupon_percent']);
                        }
                        else if (result.msg['coupon_amount'] > 0 && result.msg['coupon_percent'] == 0) {
                            $('#coupon-amt').html(result.msg['coupon_amount']);
                        }
                        else {
                            $('#coupon-amt').html(result.msg['coupon_amount']);
                        }

                        for (var i = 0; result.msg[i]; i++) {
                            $('#show-product-count_' + result.msg[i].id).val(result.msg[i].quantity);
                            $('#subtotal_' + result.msg[i].id).html(result.msg[i].subtotal);
                        }
                    }
                    else {
                        $('#add-minus-status_' + cartItemId).show();
                        $('#add-minus-status_' + cartItemId).html(result.msg);
                    }

                }

            });
        }
    </script>
    <script>
        function addPromoCode(id) {
            var promo_code = $('#ip-promo-code').val();
            var cart_id = $('#ip-promo-code').attr('rel');
            var remove_promo_code = '';
            if (id) {
                remove_promo_code = id;
            }
            if (!promo_code) {
                promo_code = '';
            }
            $.ajax({
                url: '{{url("/add-promo-code")}}',
                type: "get",
                dataType: "json",
                data: {
                    coupon_code: promo_code,
                    cart_id: cart_id,
                    remove_promo_code: remove_promo_code,
                    code_type: 1
                },
                success: function (response) {
                    if (response.success == "1") {
                        arr = response.arr;
                        $('#promo-code-invalid').show();
                        $('#promo-code-invalid').text(response.msg);
                        $('#promo-total').text(arr['promo_amount']);
                        $('#grand-total').text(arr['grand_total']);
                        $('#total-savings').text(arr['total_savings']);
                        $('#ancr-promo-code').text('Remove Promo');
                    }
                    else {
                        arr = response.arr;
                        console.log(response.msg);
                        $('#promo-total').text(arr['currency'] + arr['promo_amount']);
                        $('#grand-total').text(arr['grand_total']);
                        $('#total-savings').text(arr['currency'] + arr['total_savings']);
                        $('#promo-code-invalid').show();
                        $('#promo-code-invalid').text(response.msg);
                    }

                }
            });
        }

    </script>

    <script>
        function addCoupon(id) {
            var coupon_code = $('#ip-coupon-code').val();
            var cart_id = $('#ip-coupon-code').attr('rel');
            var gTot = $('#grand-total').text();
            var totSav = $('#total-savings').text();
            $.ajax({
                url: '{{url("/add-coupon")}}',
                type: "get",
                dataType: "json",
                data: {
                    coupon_code: coupon_code,
                    cart_id: cart_id,
                    code_type: 0
                },
                success: function (response) {
                    if (response.success == "1") {
                        arr = response.arr;

                        $('#coupon-span').show();
                        $('#coupon-span').text(response.msg);
                        $('#coupon-amt').text(arr['coupon_amount']);
                        $('#ancr-coupon-code').text('Remove Coupon');
                        $('#grand-total').text(arr['grand_total']);
                        $('#total-savings').text(arr['total_savings']);
                    }
                    else {
                        arr = response.arr;
                        console.log(response.msg);
                        $('#coupon-amt').text(arr['currency'] + arr['coupon_amount']);
                        $('#grand-total').text(arr['grand_total']);
                        $('#total-savings').text(arr['currency'] + arr['total_savings']);
                        $('#coupon-span').show();
                        $('#coupon-span').text(response.msg);
                        // alert(response.msg);return;
                    }

                }
            });
        }

    </script>
    <script>
        function toggleDisplayBillingAddress(obj) {
            if (jQuery(obj).is(":checked")) {
                jQuery("#billing_details").hide();
            } else {
                jQuery("#billing_details").show();
            }
        }
    </script>
    <script>
        // function getAllStates(country_id, id) {
        //     getCountryInfo(country_id);
        // }
        function getAllStates(country_id, id) {
            if (country_id != '' && country_id != 0)
            {
                $.ajax({
                    url: "{{url('/states/getAllStates')}}/" + country_id,
                    method: 'get',
                    success: function (data)
                    {
                        if (id == 'shipping-country') {
                            $("#shipping-state").html(data);
                        }
                        else if (id == 'billing-country') {
                            $("#billing-state").html(data);
                        }
                        else if (id = 'dom-country-zip') {
                            $("#dom-region-zip").html(data);
                        }
                        getCountryInfo(country_id);
                    }

                });
            }
        }
        function getCountryInfo(country_id)
        {
            console.log(country_id);
            $.ajax({
                url: "{{url('/country/get-country-info')}}/" + country_id,
                method: 'get',
                dataType: "json",
                success: function (response)
                {
                    if(response.success == 1)
                    {
                        $('#ship-ctry-digits').val(response.msg['digit']);
                        $('#ship-ctry-pattern').val(response.msg['pattern']);
                    }
                    else
                    {
                        alert(response.msg);
                    }
                }

            });
        }
        function getAllCities(state_id, id)
        {
            if (state_id != '' && state_id != 0) {
                $.ajax({
                    url: "{{url('/cities/getAllCities')}}/" + state_id,
                    method: 'get',
                    success: function (data) {
                        if (id == 'shipping-state') {
                            $("#shipping-city").html(data);
                        }
                        else if (id == 'billing-state') {
                            $("#billing-city").html(data);
                        }
                        else if (id = 'dom-region-zip') {
                            $("#dom-city-zip").html(data);
                        }
                    }

                });
            }
        }
    </script>
    <?php
    $all_iso = [];
    if (isset($all_countries) && count($all_countries) > 0) {
        foreach ($all_countries as $cntry => $country) {
            $all_iso[] = strtolower($country->trans['iso_code']);
        }
        $isoCodes = json_encode($all_iso);
    } else {
        $isoCodes = [];
    }
    //    echo $isoCodes; die;
    ?>
    <script>
        var countries = '{{ $isoCodes }}';
        var selectedShippingFlag = $('#shipping_country_code').val();
        var selectedBillingFlag = $('#billing_country_code').val();
        var selectedCountry = JSON.parse(countries.replace(/&quot;/g, '"'));
        $("#shipping-mobile-no").intlTelInput({
//             allowDropdown: false,
//             autoHideDialCode: false,
//             dropdownContainer: "body",
//             excludeCountries: ["us"],
//             formatOnDisplay: false,
//             geoIpLookup: function(callback) {
//               $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
//                 var countryCode = (resp && resp.country) ? resp.country : "";
//                 callback(countryCode);
//               });
//             },
//             initialCountry: "auto",
//             nationalMode: false,
//             onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
//             placeholderNumberType: "MOBILE",
//             preferredCountries: ['cn', 'jp'],
//             separateDialCode: true,
            preferredCountries: ['in', 'us'],
            autoPlaceholder: true,
            onlyCountries: selectedCountry,
            initialCountry: selectedShippingFlag,
            utilsScript: '{{ asset('public/media/front/intl-telephone/js/utils.js') }}'
        });
        $("#shipping-mobile-no").on("countrychange", function (e, countryData) {
            // alert(countryData.iso2);
            $("#shipping_country_code").val(countryData.iso2);
        });
        $("#billing-mobile-no").intlTelInput({
//             allowDropdown: false,
//             autoHideDialCode: false,
//             dropdownContainer: "body",
//             excludeCountries: ["us"],
//             formatOnDisplay: false,
//             geoIpLookup: function(callback) {
//               $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
//                 var countryCode = (resp && resp.country) ? resp.country : "";
//                 callback(countryCode);
//               });
//             },
//             initialCountry: "auto",
//             nationalMode: false,
//             onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
//             placeholderNumberType: "MOBILE",
//             preferredCountries: ['cn', 'jp'],
//             separateDialCode: true,
            preferredCountries: ['in', 'us'],
            autoPlaceholder: true,
            onlyCountries: selectedCountry,
            initialCountry: selectedBillingFlag,
            utilsScript: '{{ asset('public/media/front/intl-telephone/js/utils.js') }}'
        });
        $("#billing-mobile-no").on("countrychange", function (e, countryData) {
            // alert(countryData.iso2);
            $("#billing_country_code").val(countryData.iso2);
        });
    </script>
    <script>
        function removeBox(id) {
            $.ajax({
                url: '{{url("/remove-box-from-cart")}}',
                type: "get",
                dataType: "json",
                data: {
                    box_id: id
                },
                success: function (response) {
                    if (response.success == "1") {
                        var arr = response.arr;
                        var packTot = parseFloat(arr['box_amount']) + parseFloat(arr['paper_amount']);
                        $('#pakaging-total').text(arr['currency'] + packTot.toFixed(2));
                        $('#grand-total').text(arr['currency'] + arr['grand_total']);
                    }
                }
            });
        }

        function removePaper(id) {
            $.ajax({
                url: '{{url("/remove-paper-from-cart")}}',
                type: "get",
                dataType: "json",
                data: {
                    paper_id: id
                },
                success: function (response) {

                    if (response.success == "1") {
                        var arr = response.arr;
                        var packTot = parseFloat(arr['box_amount']) + parseFloat(arr['paper_amount']);
                        $('#pakaging-total').text(arr['currency'] + packTot.toFixed(2));
                        $('#grand-total').text(arr['currency'] + arr['grand_total']);
                    }
                }
            });
        }

        function removeDisplay(id) {
            $.ajax({
                url: '{{url("/remove-display-from-cart")}}',
                type: "get",
                dataType: "json",
                data: {
                    display_id: id
                },
                success: function (response) {
                    if (response.success == "1") {
                        var arr = response.arr;
                        $('#display-total').text(arr['currency'] + parseFloat(arr['display_amount']).toFixed(2));
                        $('#grand-total').text(arr['currency'] + arr['grand_total']);
                    }
                }
            });
        }
    </script>
    <script>
        function moveToWishlist($cartItemId) {

            var count = $('#show-product-count_' + $cartItemId).val();
            $.ajax({
                url: "{{url('/move-product-to-wishlist')}}",
                method: 'get',
                dataType: 'json',
                data: {
                    cartItemId: $cartItemId,
                    count: count,
                    _token: $("[name=_token]").val()
                },
                success: function (response) {
                    if (response.success == "1") {
                        var arr = response.arr;
                        $('.icon-cart-num.header-cart-count.cart-move').html(arr['product_count']);
                        $('#grand-total').text(arr['currency'] + arr['grand_total']);
                        $('#all-total').text(arr['currency'] + arr['total_amount']);
                        $('#coupon-amt').text(arr['currency'] + arr['coupon_amount']);
                        $('#total-savings').text(arr['currency'] + arr['total_savings']);
                        $('#promo-total').text(arr['currency'] + arr['promo_amount']);
                        $('#' + $cartItemId).hide();
                        window.location.href = window.location.href;
                    }
                    else {
                        console.log(response.msg);
                    }
                }

            });
        }
    </script>
    <script>
        function purchaseBox(id) {
            $.ajax({
                url: "{{url('/add-box-to-cart')}}/" + id,
                type: 'get',
                dataType: "json",
                success: function (response) {
                    if (response.success == "1") {
                        var arr = response.arr;
                        var packTot = parseFloat(arr['box_amount']) + parseFloat(arr['paper_amount']);
                        $('#pakaging-total').text(arr['currency'] + packTot.toFixed(2));
                        $('#grand-total').text(arr['currency'] + arr['grand_total']);
                    }
                    else {
                        arr = response.arr;
                        var packTot = parseFloat(arr['box_amount']) + parseFloat(arr['paper_amount']);
                        $('#pakaging-total').text(arr['currency'] + packTot.toFixed(2));
                        $('#grand-total').text(arr['currency'] + arr['grand_total']);
                    }
                }

            });
        }

        function purchasePaper(id) {
            $.ajax({
                url: "{{url('/add-paper-to-cart')}}/" + id,
                type: 'get',
                dataType: "json",
                success: function (response) {
                    if (response.success == "1") {
                        var arr = response.arr;

                        var packTot = parseFloat(arr['box_amount']) + parseFloat(arr['paper_amount']);
                        $('#pakaging-total').text(arr['currency'] + packTot.toFixed(2));
                        $('#grand-total').text(arr['currency'] + arr['grand_total']);
                    }
                    else {
                        var arr = response.arr;
                        var packTot = parseFloat(arr['box_amount']) + parseFloat(arr['paper_amount']);
                        $('#pakaging-total').text(arr['currency'] + packTot.toFixed(2));
                        $('#grand-total').text(arr['currency'] + arr['grand_total'])
                    }
                }

            });
        }

        function purchaseDisplay(id) {
            $.ajax({
                url: "{{url('/add-display-to-cart')}}/" + id,
                type: 'get',
                dataType: "json",
                success: function (response) {
                    if (response.success == "1") {
                        var arr = response.arr;
                        $('#display-total').text(arr['currency'] + parseFloat(arr['display_amount']).toFixed(2));
                        $('#grand-total').text(arr['currency'] + arr['grand_total']);
                    }
                    else {
                        arr = response.arr;
                        $('#display-total').text(arr['currency'] + parseFloat(arr['display_amount']).toFixed(2));
                        $('#grand-total').text(arr['currency'] + arr['grand_total']);
                    }
                }

            });
        }
    </script>
    <script>
        function doCoupon(id) {

            var text = $('#' + id).text();
            text = text.trim();
            if (text == "Apply Code") {
                addCoupon(id);
            }
            else if ('Remove Coupon') {
                removeCoupon();
            }
        }

        function doPromoCode(id)
        {

            var text = $('#' + id).text();
            text = text.trim();
            if (text == "Apply Code")
            {
                addPromoCode(id);
            }
            else if ("Remove Promo")
            {
                removePromoCode();
            }
        }

        function doGiftCode(id) {
            var text = $('#' + id).text();
            text = text.trim();
            if (text == "Apply Code") {
                addGiftCode(id);
            }
            else if ("Remove Gift Voucher") {
                removeGiftCode();
            }
        }

        function removeCoupon() {

            $.ajax({
                url: '{{url("/remove-coupon")}}',
                type: "get",
                dataType: "json",
                success: function (response) {

                    if (response.success == "1") {
                        $('#coupon-span').show();
                        $('#coupon-span').text(response.msg);
                        var arr = response.arr;
                        $('#ancr-coupon-code').text('Apply Code');
                        $('#ip-coupon-code').val('');
                        $('#coupon-amt').text(arr['currency']+ parseFloat(arr['coupon_amount']).toFixed(2));
                        $('#grand-total').text(arr['currency']+parseFloat(arr['grand_total']).toFixed(2));
                        $('#total-savings').text(arr['currency']+ parseFloat(arr['total_savings']).toFixed(2));
                    }
                }
            });
        }

        function removeGiftCode(id) {
            var cart_id = $('#ip-gift-code').attr('rel');
            $.ajax({
                url: '{{url("/remove-gift-code")}}',
                type: "get",
                dataType: "json",
                data: {
                    cart_id: cart_id
                },
                success: function (response) {
                    if (response.success == "1") {
                        $('#coupon-span').show();
                        $('#coupon-span').text(response.msg);
                        var arr = response.arr;
                        $('#ancr-gift-code').text('Apply Code');
                        $('#ip-gift-code').val('');
                        $('#gift-code-invalid').show();
                        $('#gift-code-invalid').text(response.msg);
                        $('#gift-voucher-total').text(arr['currency'] + parseFloat(arr['gift_voucher']).toFixed(2));
                        $('#grand-total').text(arr['currency'] + parseFloat(arr['grand_total']).toFixed(2));
                        $('#total-savings').text(arr['currency'] + parseFloat(arr['total_savings']).toFixed(2));
                    }
                }
            });
        }

        function removePromoCode() {
            $.ajax({
                url: '{{url("/remove-promo-code")}}',
                type: "get",
                dataType: "json",
                success: function (response) {
                    if (response.success == "1") {

                        $('#promo-code-invalid').show();
                        $('#promo-code-invalid').text(response.msg);
                        var arr = response.arr;
                        $('#ip-promo-code').val('');
                        $('#ancr-promo-code').text('Apply Code');
                        $('#promo-total').text(arr['currency']+parseFloat(arr['promo_amount']).toFixed(2));
                        $('#grand-total').text(arr['currency']+parseFloat(arr['grand_total']).toFixed(2));
                        $('#total-savings').text(arr['currency']+parseFloat(arr['total_savings']).toFixed(2));

                    }
                }
            });
        }
    </script>
    <script>
        var elId = 0;

        function boxActive(ele) {
            elId = ele.id;
            elId = elId.split('-').pop();
            if ($(ele).hasClass('selected-wrap')) {
                $('.box-containr').removeClass('selected-wrap');
                removeBox(elId);
            }
            else {
                $('.box-containr').removeClass('selected-wrap');
                $(ele).addClass('selected-wrap');
                purchaseBox(elId);
            }
        }

        function paperActive(ele) {
            elId = ele.id;
            elId = elId.split('-').pop();
            if ($(ele).hasClass('selected-wrap')) {

                $('.paper-containr').removeClass('selected-wrap');
                removePaper(elId);
            }
            else {

                $('.paper-containr').removeClass('selected-wrap');
                $(ele).addClass('selected-wrap');

                purchasePaper(elId);
            }
        }

        function msgCardActive(ele) {
            elId = ele.id;
            elId = elId.split('-').pop();
            if ($(ele).hasClass('selected-wrap')) {
                $('.message-card-containr').removeClass('selected-wrap');
                removeDisplay(elId);
            }
            else {
                $('.message-card-containr').removeClass('selected-wrap');
                $(ele).addClass('selected-wrap');
                purchaseDisplay(elId);
            }
        }
    </script>
    <script>
        function removeCartItem(id) {

            if (confirm("Do you want to remove this product?")) {
                cartItemId = id.split('_').pop();
                $.ajax({
                    url: '{{url("/remove-cart-item")}}',
                    type: "get",
                    dataType: "json",
                    data: {
                        cart_item_id: cartItemId
                    },
                    success: function (response) {
                        if (response.success == "1") {
                            $('.icon-cart-num.header-cart-count.cart-move').html(arr['product_count']);
                            $('#grand-total').text(arr['currency'] + arr['grand_total']);
                            $('#all-total').text(arr['currency'] + arr['total_amount']);
                            $('#coupon-amt').text(arr['currency'] + arr['coupon_amount']);
                            $('#total-savings').text(arr['currency'] + arr['total_savings']);
                            $('#promo-total').text(arr['currency'] + arr['promo_amount']);

                            window.location.href = window.location.href
                        }
                        else {
                            alert(response.msg);
                            window.location.href = window.location.href
                        }
                    }
                });

            }
            return false;
        }
    </script>
    <script>
        function addGiftCode(id) {
            var gift_code = $('#ip-gift-code').val();
            var cart_id = $('#ip-gift-code').attr('rel');
            var gTot = $('#grand-total').text();
            var totSav = $('#total-savings').text();
            $.ajax({
                url: '{{url("/add-gift-card")}}',
                type: "get",
                dataType: "json",
                data: {
                    gift_code: gift_code,
                    cart_id: cart_id
                },
                success: function (response) {
                    if (response.success == "1") {
                        var arr = response.arr;
                        $('#gift-code-invalid').show();
                        $('#gift-code-invalid').text(response.msg);
                        $('#gift-voucher-total').text(arr['gift_voucher']);
                        $('#ancr-gift-code').text('Remove Gift Voucher');
                        $('#grand-total').text(arr['grand_total']);
                        $('#total-savings').text(arr['total_savings']);
                    }
                    else {
                        $('#gift-code-invalid').show();
                        $('#gift-code-invalid').text(response.msg);
                    }
                }
            });
        }
    </script>
    <script>
        function chkValidatePincode() {
            if ($('#dom-country-zip').val().trim() == '') {
                $('#err-nat-ship').text('Please select Country');
            }
            else {
                if ($('#ip-dom-pin-code').val().trim() == '') {
                    $('#err-nat-ship').text('Please enter Pincode');
                }
                else if (isNaN($('#ip-dom-pin-code').val().trim())) {
                    $('#err-nat-ship').text('Please enter digits only');
                }
                else if ($('#ip-dom-pin-code').val().trim().length != 6) {
                    $('#err-nat-ship').text('Please enter valid 6 digit pincode');
                }
                else {
                    $('#err-nat-ship').text('');
                    $('#err-nat-ship').hide();
                    validatePincode();
                }
            }

        }

        function chkValidateInternationalPincode() {
            if ($('#inter-country-zip').val().trim() == '') {
                $('#err-int-ship').text('Please select Country');
            }
            else {
                if ($('#ip-inter-pin-code').val().trim() == '') {
                    $('#err-int-ship').text('Please enter Pincode');
                }
                else {
                    $('#err-int-ship').text('');
                    $('#err-int-ship').hide();
                    validateInternationalPincode();
                }
            }

        }
        function validateChkDHLService(id)
        {
            var val = $("#"+id).attr('rel');
            if(val == "0")
            {
                if ($('#dhl-dom-country-zip').val().trim() == '') {
                    $('#err-dhl-nat-ship').text('Please select Country');
                }
                else {
                    if ($('#dhl-ip-dom-pin-code').val().trim() == '') {
                        $('#err-dhl-nat-ship').text('Please enter Pincode');
                    }
                    else if (isNaN($('#dhl-ip-dom-pin-code').val().trim())) {
                        $('#err-dhl-nat-ship').text('Please enter digits only');
                    }
                    else if ($('#dhl-ip-dom-pin-code').val().trim().length != 6) {
                        $('#err-dhl-nat-ship').text('Please enter valid 6 digit pincode');
                    }
                    else {
                        $('#err-dhl-nat-ship').text('');
                        $('#err-dhl-nat-ship').hide();
                        chkDHLServices(id);
                    }
                }
            }
            else if(val == "1")
            {
                if ($('#dhl-inter-country-zip').val().trim() == '') {
                    $('#err-dhl-int-ship').text('Please select Country');
                }
                else {
                    if ($('#dhl-ip-inter-pin-code').val().trim() == '') {
                        $('#err-dhl-int-ship').text('Please enter Pincode');
                    }
                    else {
                        $('#err-dhl-int-ship').text('');
                        $('#err-dhl-int-ship').hide();
                        chkDHLServices(id);
                    }
                }
            }
        }
        function validatePincode() {
            $('#dv-loader-national').show();
            $('#err-nat-ship').hide();
            var pincode = $('#ip-dom-pin-code').val().trim();
            var country = $('#dom-country-zip').val().trim();
            $.ajax({
                url: '{{url("/fedex/rate-nat-request")}}',
                type: "get",
                dataType: "json",
                data: {
                    pin_code: pincode,
                    country: country,
                    _token: $("[name=_token]").val()
                },
                success: function (response) {
                    if (response.success == "1") {

                        $('#dv-loader-national').hide();
                        var nationalArr = response.arr;
                        $('#main-all-national').html('');
                        if (nationalArr.length > 0) {
                            $(nationalArr).each(function (index, value) {
                                replace_main = $('#all-national').html();
                                $("#main-all-national").append(replace_main.replace("replace-id", index).replace("replace-value", index).replace("replace-cnt", index + 1).replace("replace-price", nationalArr[index][0]).replace("replace-name", nationalArr[index]['service-type']).replace("replace-delivery", nationalArr[index]['delivery']).replace("replace-check",'unchecked'));
                            });
                        }
                        else {
                            $('#err-nat-ship').show();
                            $('#err-nat-ship').text('No services are available at this moment');
                        }
                    }
                    else {
                        $('#dv-loader-national').hide();
                        $('#err-nat-ship').show();
                        $('#err-nat-ship').text(response.err);
                    }
                }
            });
        }

        function validateInternationalPincode() {
            $('#dv-loader-international').show();
            $('#err-int-ship').hide();
            var pincode = $('#ip-inter-pin-code').val().trim();
            var country = $('#inter-country-zip').val().trim();
            $.ajax({
                url: '{{url("/fedex/rate-int-request")}}',
                type: "get",
                dataType: "json",
                data: {
                    pin_code: pincode,
                    country: country,
                    _token: $("[name=_token]").val()
                },
                success: function (response) {
                    if (response.success == "1") {
                        $('#dv-loader-international').hide();
                        var interNationalArr = response.arr;
                        if (interNationalArr.length > 0) {
                            $('#main-all-international').html('');
                            $(interNationalArr).each(function (index, value) {
                                replace_main = $('#all-international').html();
                                $("#main-all-international").append(replace_main.replace("replace-id", index).replace("replace-value", index).replace("replace-cnt", index + 1).replace("replace-price", interNationalArr[index][0]).replace("replace-name", interNationalArr[index]['service-type']).replace("replace-delivery", interNationalArr[index]['delivery']).replace("replace-check",'unchecked'));
                            });
                        }
                    }
                    else {
                        $('#dv-loader-international').hide();
                        $('#err-int-ship').show();
                        $('#err-int-ship').text(response.err);
                    }
                }
            });
        }
    </script>
    <script>

        function getNationalService(value) {
            var name = $('#radio-li-' + value + ' p:first').text().split(':')[1].trim();
            var price = $('#radio-li-' + value + ' p:first').next().text().split(':')[1].trim().substr(1);
            var currency = $('#radio-li-' + value + ' p:first').next().text().split(':')[1].trim().substr(0, 1);
            var time = $('#radio-li-' + value + ' p:first').next().next().text().replace(/\:/, '&').split('&')[1].trim();
            if (currency == 'C') {
                price = $('#radio-li-' + value + ' p:first').next().text().split(':')[1].trim().substr(2);
                currency = $('#radio-li-' + value + ' p:first').next().text().split(':')[1].trim().substr(0, 2);
            }
            $.ajax({
                url: '{{url("/fedex/service-details")}}',
                type: "get",
                dataType: "json",
                data: {
                    service_name: name,
                    service_price: price,
                    service_time: time,
                    service_currency: currency,
                    service_type: "national",
                    _token: $("[name=_token]").val()
                },
                success: function (response) {
                    if (response.success == "1") {
                        $('#chk-service-session').val('1');
                        var natArr = response.arr;
                        $('#grand-total').text(natArr['grand_total']);
                        $('#shipping-total').text(natArr['shipping_charge']);
                    }
                    else {
                        console.log(response);
                        return;
                    }
                }
            });
        }

        function getInterNationalService(value)
        {
            var name = $('#nat-radio-li-' + value + ' p:first').text().split(':')[1].trim();
            var price = $('#nat-radio-li-' + value + ' p:first').next().text().split(':')[1].trim().substr(1);
            var currency = $('#nat-radio-li-' + value + ' p:first').next().text().split(':')[1].trim().substr(0, 1);
            if (currency == 'C') {
                price = $('#nat-radio-li-' + value + ' p:first').next().text().split(':')[1].trim().substr(2);
                currency = $('#nat-radio-li-' + value + ' p:first').next().text().split(':')[1].trim().substr(0, 2);
            }
            var time = $('#nat-radio-li-' + value + ' p:first').next().next().text().replace(/\:/, '&').split('&')[1].trim();
            $.ajax({
                url: '{{url("/fedex/service-details")}}',
                type: "get",
                dataType: "json",
                data: {
                    service_name: name,
                    service_price: price,
                    service_time: time,
                    service_currency: currency,
                    service_type: "international",
                    _token: $("[name=_token]").val()
                },
                success: function (response) {

                    if (response.success == "1") {
                        var intNatArr = response.arr;
                        $('#chk-service-session').val('1');
                        $('#grand-total').text(intNatArr['grand_total']);
                        $('#shipping-total').text(intNatArr['shipping_charge']);
                    }
                    else {
                        console.log(response);
                        return;
                    }
                }
            });
        }


        $(function () {
            var chk = $('#chk-service-session').val();
            if (chk == 1) {
                $.ajax({
                    url: '{{url("/fedex/get-service-details")}}',
                    type: "get",
                    dataType: "json",
                    data: {
                        _token: $("[name=_token]").val()
                    },
                    success: function (response)
                    {
                        if (response.success == "1") {
                            arr = response.msg;
                            console.log(arr);
                            $('#main-all-national').html('');
                            if (arr) {
                                $('#chk-service-session').val('1');
                                if(arr['service_provider'] == "FEDEX")
                                {
                                    $("#ip-sel-fdx-id").attr('checked',true);
                                    $("#id-fdx-crt-loc").show();
                                    if (arr['service_type'] == "national")
                                    {
                                        $("#li-int-tag").removeClass('active');
                                        $("#li-nat-tag").addClass('active');
                                        $("#profile").removeClass('active');
                                        $("#home").addClass('active');
                                        replace_main = $('#all-national').html();
                                        $("#main-all-national").append(replace_main.replace("replace-id", 0).replace("replace-value", 0).replace("replace-cnt",  1).replace("replace-price", arr['service_price']).replace("replace-name", arr['service_name']).replace("replace-delivery", arr['service_time']).replace("replace-check",'checked'));
                                    }
                                    else if (arr['service_type'] == "international")
                                    {
                                        $("#li-nat-tag").removeClass('active');
                                        $("#li-int-tag").addClass('active');
                                        $("#profile").addClass('active');
                                        $("#home").removeClass('active');
                                        replace_main = $('#all-international').html();
                                        $("#main-all-international").append(replace_main.replace("replace-id", 0).replace("replace-value", 0).replace("replace-cnt",  1).replace("replace-price", arr['service_price']).replace("replace-name", arr['service_name']).replace("replace-delivery", arr['service_time']).replace("replace-check",'checked'));

                                    }
                                }
                                else if(arr['service_provider'] == "DHL")
                                {
                                    $("#ip-sel-dhl-id").attr('checked',true);
                                    $("#id-dhl-crt-loc").show();
                                    if (arr['service_type'] == "national")
                                    {
                                        $("#li-dhl-int-tag").removeClass('active');
                                        $("#li-dhl-nat-tag").addClass('active');
                                        $("#dhl-profile").removeClass('active');
                                        $("#dhl-home").addClass('active');
                                        replace_main = $('#all-dhl-national').html();
                                        // $("#main-all-dhl-national").append(replace_main.replace("replace-id", 0).replace("replace-value", 0).replace("replace-cnt", 0 + 1).replace("replace-price", arr['service_price']).replace("replace-name", arr['service_name']).replace("replace-delivery", arr['service_time']).replace("replace-check",true));
                                        $("#main-all-dhl-national").append(replace_main.replace("replace-id", 0).replace("replace-value", 0).replace("replace-no", 1).replace("replace-days", arr['service_time']).replace("replace-provider", arr['service_name']).replace("replace-max", arr['service_price']).replace("replace-estimate", arr['service_estimated_days']).replace("replace-check",'checked'));
                                    }
                                    else if (arr['service_type'] == "international")
                                    {
                                        $("#li-dhl-nat-tag").removeClass('active');
                                        $("#li-dhl-int-tag").addClass('active');
                                        $("#dhl-profile").addClass('active');
                                        $("#dhl-home").removeClass('active');
                                        replace_main = $('#all-dhl-international').html();
                                        // $("#main-all-dhl-international").append(replace_main.replace("replace-id", 0).replace("replace-value", 0).replace("replace-cnt", 0 + 1).replace("replace-price", arr['service_price']).replace("replace-name", arr['service_name']).replace("replace-delivery", arr['service_time']).replace("replace-check",true));
                                        $("#main-all-dhl-international").append(replace_main.replace("replace-id", 0).replace("replace-value", 0).replace("replace-no", 1).replace("replace-days", arr['service_time']).replace("replace-provider", arr['service_name']).replace("replace-max", arr['service_price']).replace("replace-estimate", arr['service_estimated_days']).replace("replace-check",'checked'));
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });

        function clearBoxSel() {
            var elId = $(".box-containr.selected-wrap").attr('id').split('-').pop();
            $('.box-containr').removeClass('selected-wrap');
            if (elId) {
                removeBox(elId);
            }

        }

        function clearPaperSel() {
            var elId = $(".paper-containr.selected-wrap").attr('id').split('-').pop();
            $('.paper-containr').removeClass('selected-wrap');
            if (elId) {
                removePaper(elId);
            }

        }

        function clearDispSel() {
            var elId = $(".message-card-containr.selected-wrap").attr('id').split('-').pop();
            $('.message-card-containr').removeClass('selected-wrap');

            if (elId) {
                removeDisplay(elId);
            }
        }

        function boxNxt() {
            $('#ul-pakng-id li a[href="#home1"]').parent().removeClass('active');
            $('#home1').removeClass('active');
            $('#ul-pakng-id li a[href="#profile1"]').parent().addClass('active');
            $('#profile1').addClass('active');
        }

        function paperNxt() {
            $('#ul-pakng-id li a[href="#profile1"]').parent().removeClass('active');
            $('#profile1').removeClass('active');
            $('#ul-pakng-id li a[href="#messages"]').parent().addClass('active');
            $('#messages').addClass('active');
        }

        function selShippingServices(e) {
            var id = e.id;
            if (id == "ip-sel-fdx-id") {
                $("#id-dhl-crt-loc").hide();
                $("#id-fdx-crt-loc").show();
            }
            else if (id == "ip-sel-dhl-id") {
                $("#id-fdx-crt-loc").hide();
                $("#id-dhl-crt-loc").show();
            }
        }
    </script>
    <script>
        function getDHLServices(id)
        {
            var serviceDays="";
            var name="";
            var price="";
            var currency="";
            var estimDays="";
            var serviceType="";
            var val = $("#"+id).attr('rel');
            if(val == 0)
            {
                serviceDays = $('#dhl-radio-li-0 p:eq(3)').text().split(':')[1].trim();
                name = $('#dhl-radio-li-0 p:first').text().split(':')[1].trim();
                 price = $('#dhl-radio-li-0 p:eq(1)').text().split(':')[1].trim().substr(1);
                currency =$('#dhl-radio-li-0 p:eq(1)').text().split(':')[1].trim().substr(0, 1);
                if(currency == 'C')
                {
                    price = $('#dhl-radio-li-0 p:eq(1)').text().split(':')[1].trim().substr(2);
                    currency =$('#dhl-radio-li-0 p:eq(1)').text().split(':')[1].trim().substr(0, 2);
                }
                estimDays = $('#dhl-radio-li-0 p:eq(2)').text().split(':')[1].trim();
                serviceType='national';
            }
            else if(val == 1)
            {
                serviceDays = $('#dhl-nat-radio-li-0').text().split(':')[1].trim();
                name = $('#dhl-nat-radio-li-0 p:first').text().split(':')[1].trim();
                price = $('#dhl-nat-radio-li-0 p:eq(1)').text().split(':')[1].trim().substr(1);
                currency =$('#dhl-nat-radio-li-0 p:eq(1)').text().split(':')[1].trim().substr(0, 1);
                if(currency == 'C')
                {
                    price = $('#dhl-nat-radio-li-0 p:eq(1)').text().split(':')[1].trim().substr(2);
                    currency =$('#dhl-nat-radio-li-0 p:eq(1)').text().split(':')[1].trim().substr(0, 2);
                }
                estimDays = $('#dhl-nat-radio-li-0 p:eq(2)').text().split(':')[1].trim();
                serviceType='international';
            }
            $.ajax({
                url: '{{url("/dhl/add-service-details")}}',
                type: "get",
                dataType: "json",
                data: {
                    service_days: serviceDays,
                    service_name: name,
                    service_price: price,
                    service_currency: currency,
                    service_estimated_days: estimDays,
                    service_type: serviceType,
                    _token: $("[name=_token]").val()
                },
                success: function (response) {
                    if (response.success == "1") {
                        var intNatArr = response.arr;
                        $('#chk-service-session').val('1');
                        $('#grand-total').text(intNatArr['grand_total']);
                        $('#shipping-total').text(intNatArr['shipping_charge']);
                    }
                    else {
                        alert(response.msg);
                        return;
                    }
                }
            });
        }

        function chkDHLServices(id)
        {
           // var  val = ele.getAttribute('rel');
           var val = $("#"+id).attr('rel');
           var pincode='';
           var country='';
           if(val == '0')
           {
               $('#dv-dhl-loader-national').show();
               $('#err-dhl-nat-ship').hide();
                pincode = $('#dhl-ip-dom-pin-code').val().trim();
                country = $('#dhl-dom-country-zip').val().trim();
           }
           else if(val == '1')
           {
               $('#dv-dhl-loader-international').show();
               $('#err-dhl-int-ship').hide();
                pincode = $('#dhl-ip-inter-pin-code').val().trim();
                country = $('#dhl-inter-country-zip').val().trim();
           }
            $.ajax({
                url: '{{url("/dhl/rate-shipment")}}',
                type: "get",
                dataType: "json",
                data: {
                    pin_code: pincode,
                    country: country,
                    value:val,
                    _token: $("[name=_token]").val()
                },
                success: function (response)
                {
                    if (response.success == "1")
                    {
                        if(response.msg == 'SUCCESS')
                        {
                            if(val == '0')
                            {
                                $('#dv-dhl-loader-national').hide();
                                $('#main-all-dhl-national').html('');
                                var nationalArr = response.arr;

                                if (nationalArr.length > 0) {
                                    $(nationalArr).each(function (index, value) {
                                        replace_main = $('#all-dhl-national').html();
                                        $("#main-all-dhl-national").append(replace_main.replace("replace-id", index).replace("replace-value", index).replace("replace-no", index+1).replace("replace-days", nationalArr[index]['delivery_window']).replace("replace-provider", nationalArr[index]['service_provider']).replace("replace-max", nationalArr[index]['max']).replace("replace-estimate", nationalArr[index]['estimated_days']).replace("replace-check",'unchecked'));
                                    });
                                }
                                else {
                                    $('#err-dhl-nat-ship').show();
                                    $('#err-dhl-nat-ship').text('No services are available at this moment');
                                }

                            }
                            else if(val == '1')
                            {
                                $('#dv-dhl-loader-international').hide();
                                $('#main-all-dhl-international').html('');
                                var nationalArr = response.arr;

                                if (nationalArr.length > 0) {
                                    $(nationalArr).each(function (index, value) {
                                        replace_main = $('#all-dhl-international').html();
                                        $("#main-all-dhl-international").append(replace_main.replace("replace-id", index).replace("replace-value", index).replace("replace-no", index+1).replace("replace-days", nationalArr[index]['delivery_window']).replace("replace-provider", nationalArr[index]['service_provider']).replace("replace-max", nationalArr[index]['max']).replace("replace-estimate", nationalArr[index]['estimated_days']).replace("replace-check",'unchecked'));
                                    });
                                }
                                else {
                                    $('#err-dhl-int-ship').show();
                                    $('#err-dhl-int-ship').text('No services are available at this moment');
                                }
                            }
                        }
                        else {
                            if(val == '0')
                            {
                                $('#dv-dhl-loader-national').hide();
                                $('#err-dhl-nat-ship').show();
                                $('#err-dhl-nat-ship').text(response.msg);
                            }
                            else if(val == '1')
                            {
                                $('#dv-dhl-loader-international').hide();
                                $('#err-dhl-int-ship').show();
                                $('#err-dhl-int-ship').text(response.msg);
                            }
                        }
                    }
                    else {
                         if(val == '0')
                         {
                             $('#dv-dhl-loader-national').hide();
                             $('#err-dhl-nat-ship').show();
                             $('#err-dhl-nat-ship').text(response.msg);
                         }
                         else if(val == '1')
                         {
                             $('#dv-dhl-loader-international').hide();
                             $('#err-dhl-int-ship').show();
                             $('#err-dhl-int-ship').text(response.msg);
                         }
                    }
                }
            });
        }
        {{--$(function(){--}}
            {{--if('@php echo $cart->box_id @endphp' != null)--}}
            {{--{--}}
                  {{--$('#box-container-'+'@php echo $cart->box_id @endphp').addClass('selected-wrap');--}}
            {{--}--}}
            {{--if('@php echo $cart->paper_id @endphp' != null)--}}
            {{--{--}}
                {{--$('#paper-container-'+'@php echo $cart->paper_id @endphp').addClass('selected-wrap');--}}
            {{--}--}}
            {{--if('@php echo $cart->display_id @endphp' != null)--}}
            {{--{--}}
                {{--$('#msg-card-container-'+'@php echo $cart->display_id @endphp').addClass('selected-wrap');--}}
            {{--}--}}
        {{--});--}}
    </script>
    <script>
        $(function(){
            var ctrId = '';
            if('<?php echo $ctryDetls->country_id; ?>' !='')
            {
                ctrId = '<?php echo $ctryDetls->country_id; ?>';
                getCountryInfo(ctrId);
            }
        });

    </script>
@endsection
