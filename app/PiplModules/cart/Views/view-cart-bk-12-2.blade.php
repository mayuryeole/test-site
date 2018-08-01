@extends('layouts.app')
@section('meta')
    <title>Profile</title>
@endsection
@section('content')
    @include('include.header')
    <section class="h-inner-banner" style="background-image:url({{url("/public/media/front/img/inner-banner.jpg")}});">
        <div class="container relative">
            <div class="h-caption">
                <h3 class="h-inner-heading">Cart Page</h3>
            </div>
        </div>
    </section>
    <section class="h-add-cart-page">
        <div class="container-fluid">
            @if(isset($cart) && count($cart)>0)
            <div class="row">

                <form id="proceed-to-checkout-form" action="" method="post" class="add-ct-form">
                    {!! csrf_field() !!}
                    <div class="col-md-12">
                        <div class="cart-table table-responsive">
                            <table>
                                <thead>
                                <th><b>Image</b></th>
                                <th><b>Product</b></th>
                                <th><b>Price</b></th>
                                <th><b>Wishlist</b></th>
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
                                            <input id="max-order-qty_{{ $cart_item->id }}" type="hidden" @if(isset($product) && $product->productDescription->max_order_qty != "") value="{{ $product->productDescription->max_order_qty }}" @endif>
                                            <input id="max-qty_{{ $cart_item->id }}" type="hidden" @if(isset($product) && $product->productDescription->quantity != "") value="{{ $product->productDescription->quantity }}" @endif>

                                            <tr>
                                                <td class="pro-thumbnail pro-remove">
                                                    <a href="{{ url('product').'/'.$cart_item->product->id }}">
                                                        <img src="{{url('/storage/app/public/product/image/'.$cart_item->product->productDescription->image)}}" alt="product image"/>
                                                    </a>
                                                    <span class="span-block">
                                        <button type="button" data-toggle="modal" onclick="showQuickView('{{ $cart_item->product_id }}')"><i class="fa fa-edit"></i> Edit</button>
                                        <button type="button" href="#" id="rm-cart-tem_{{$cart_item->id}}" onclick="removeCartItem(this.id)"><i class="fa fa-trash"></i> Remove</button>
                                   </span>
                                                </td>
                                                <td class="pro-title">
                                                    <a href="{{ url('product').'/'.$cart_item->product->id }}">{{$cart_item->product->name}}</a>
                                                    <div class="product-id"><span>Product Id : AB-12345678</span></div>
                                                    <div class="h-color"><span>Color : Red</span></div>
                                                    <div class="h-size"><span>Size : S</span></div>
                                                <!--<div class="product-color"><img src="{{url('/storage/app/public/product/image/'.$cart_item->product->productDescription->image)}}"/></div>-->
                                                </td>
                                                <td class="pro-price"><span class="amount">${{$cart_item->productPrice($cart_item->product_id)}}</span></td>
                                                <td class="pro-quantity"><button class="add-cart" type="button"><i class="fa fa-heart"></i></button></td>
                                                <td class="pro-quantity">
                                                    <div class="h-quantity">
                                                        <button id="minus-cnt-btn_{{ $cart_item->id }}" type="button" onclick="addRemoveProductQuantity(this.id,'min')" class="h-minus-pro"><i class="icon-substract"></i></button>
                                                        <input id="show-product-count_{{ $cart_item->id }}" name="product_qty" type="text" class="form-control" @if(isset($cart_item) && $cart_item->product_quantity !=0)value="{{ $cart_item->product_quantity }}"@endif disabled />
                                                        <button id="add-cnt-btn_{{ $cart_item->id }}" type="button" onclick="addRemoveProductQuantity(this.id,'add')" class="h-plus-pro"><i class="icon-add"></i></button>
                                                        <span style="display: none;color: red" id="add-minus-status_{{ $cart_item->id }}"></span>
                                                    </div>
                                                </td>
                                                <input type="hidden" id="one-qty-price_{{$cart_item->id}}" value="{{ $cart_item->productPrice($cart_item->product_id) }}">
                                                <td class="pro-subtotal"><p id="subtotal_{{$cart_item->id}}"> ${{$cart_item->productPrice($cart_item->product_id) * $cart_item->product_quantity}}</p></td>
                                                {{--<!--<td class="pro-remove"><button type="button" data-toggle="modal" onclick="showQuickView('{{ $cart_item->product_id }}')"><i class="fa fa-edit"></i> Edit</button><button type="button" href="#" id="rm-cart-tem_{{$cart_item->id}}" onclick="removeCartItem(this.id)"><i class="fa fa-trash"></i> Remove</button></td>-->--}}
                                            </tr>
                                        @endif

                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    @else
                        <div class="empty-cart-image">
                            <img src="{{url('public/media/front/img/empty-cart.png')}}" alt="Empty Cart"/>
                        </div>
                        <h4 class="empty-cart text-center">Your cart is empty</h4>
                </form>
            </div>
            @endif
        </div>
    </section>
    @if(isset($cart) && count($cart)>0)
    <section class="h-ecard-page shipping-details-block">
        <form>
            {{--{{ csrf_token() }}--}}
            <input id="ip-token" type="hidden" value="{{ csrf_token() }}">
        <div class="container-fluid">
            <div class="card-details">
                <div class="col-md-12"><h3 class="card-title"><span>Customer Details</span></h3></div>
                <div class="sender-receiver-details">
                    <div class="row">
                        <div class="adderss_wrapper">
                            <div class="col-md-6">
                                <div class="form-head">
                                    <h5>Customer Details:</h5>
                                </div>
                                <div class="inner-address">
                                    @if(\Auth::check())
                                        <p class="buyer_name">@if(\Auth::check()){{ \Auth::user()->userInformation->first_name.' '.\Auth::user()->userInformation->last_name }} @endif</p>
                                        <p class="buyer_addrss">Hadapsar Pune-28,</p>
                                        <p class="buyer_city">@if(\Auth::check()){{ \Auth::user()->userInformation->city }} @endif</p>
                                        <p class="buyer_country">India</p>
                                        <p class="buyer_phone">@if(\Auth::check())Phone Number:{{ \Auth::user()->userInformation->user_mobile }} @endif</p>
                                    @else
                                        <p class="buyer_name">You are not login yet! In order to checkout, we will require few details! Please <a href="{{url('login')}}" target="new">click here</a> to login</p>
                                    @endif
                                </div>
                                @if(\Auth::check())
                                {{--<div class="text-right edit-option clearfix" style="position:relative">--}}
                                    {{--<input type="button" class="h-update-cart pull-right" value="Edit" data-toggle="modal" data-target="#cust-modal-edit"/>--}}
                                {{--</div>--}}
                                    @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-head">
                                    <h5>Shipping Address:</h5>
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
                                        <p class="buyer_addrss">{{ $cart->shipping_address1  }}, {{ $cart->shipping_address2  }} </p>
                                        <p class="buyer_city">{{ $city_name }}, {{$state_name}} {{$cart->shipping_zip}}</p>
                                        <p class="buyer_country">{{ $country_name }}</p>
                                        <p class="buyer_phone">Phone Number: {{$cart->shipping_telephone}}</p>
                                    @else
                                        <p>No shipping address provided! Click below button to enter shipping / billing details for your order!</p>
                                    @endif
                                </div>
                                <div class="text-right edit-option clearfix" style="position:relative">
                                    <input type="button" class="h-update-cart pull-right" value="Edit" data-toggle="modal"  data-target="#h-quick-view"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                            <table>
                                <tr>
                                    <td class="notop-border notop-padding" colspan="2">
                                        <a class="apply-coupon-code" href="javascript:void(0)" id="add_coupon">+ Apply Coupon Code</a>
                                    </td>
                                </tr>
                                <tr id="enter_coupon" style="display: none">
                                    <td class="notop-border notop-padding" colspan="2">
                                        <form class="coupon-code-form">
                                            <input class="form-control input-sm" type="text" placeholder="Enter Coupon Code" id="coupon_code" @if(isset($cart)) rel="{{ $cart->id }}" @endif>
                                            <input type="button" class="btn btn-sm btn-w-b" value="Apply" id="apply_coupon" onclick="addCoupon()">
                                            <span class="text-danger" style="display: none" id="coupon_invalid">Invalid Coupon Code</span>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="notop-border notop-padding" colspan="2">
                                        <a class="apply-coupon-code" href="javascript:void(0)" id="add_promo_code">+ Apply Promo Code</a>
                                    </td>
                                </tr>
                                <tr id="enter_promo_code" style="display: none">
                                    <td class="notop-border notop-padding" colspan="2">
                                        <form class="coupon-code-form">
                                            <input class="form-control input-sm" type="text" placeholder="Enter Promo Code" id="promo_code" @if(isset($cart)) rel="{{ $cart->id }}" @endif>
                                            <input type="button" class="btn btn-sm btn-w-b" value="Apply" id="apply_promo_code" onclick="addPromoCode()">
                                            <span class="text-danger" style="display: none" id="promo_invalid">Invalid Coupon Code</span>
                                        </form>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Total</td>
                                    <td class="ar"><strong><span id="sub_total">@if(isset($cart)) {{ $totalAmount }} @else 0 @endif</span></strong></td>
                                </tr>
                                <tr>
                                    <td>Coupon Amount</td>
                                    <td class="ar"><strong><span id="coupon_total">@if(isset($cart) && $totalMinusCoupon != 0) {{ $totalAmount-$totalMinusCoupon }} @else 0 @endif</span></strong></td>
                                </tr>
                                <tr>
                                    <td>Grand Total</td>
                                    <td class="ar"><strong><span id="grand_total">@if(isset($cart) && $totalMinusCoupon!=0) {{ $totalMinusCoupon }} @else {{ $totalAmount }} @endif</span></strong></td>
                                </tr>

                            </table>
                    </div>
                    @if(isset($cart) && $cart->shipping_name !='')
                    <div class="row">
                    <div class="h-btn-blk text-center">
                        <input id="{{ $cart->id }}" style="align-content: center" onclick="checkOut(this.id)" class="h-update-cart center-button" type="button" value="Checkout">
                    </div>
                    </div>
                    @endif
    
            </div>
            </div>
        </div>
    </form>
</section>
@endif
<div class="cust-modal modal fade in" id="cust-modal-edit">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="header-blk-name">Edit Customer Details</div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><!--<img src="img/cancel.png" alt="close">--><i class="fa fa-close"></i></span></button>
                </div>
                <div class="modal-body">
                    <form class="form-sender mCustomScrollbar" enctype="multipart/form-data" method="post" action="{{ url('proceed-customer-shipping-details') }}" role="form" name="customer-shipping-details-form" id="customer-shipping-details-form">
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
                                    <input type="text" placeholder="First Name" class="form-control" name="first_name" >
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Last Name<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="text" value="" placeholder="Last Name" class="form-control" name="last_name" >
                                </div>
                            </div>
                        </div>


                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Email<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="email" placeholder="Email" class="form-control" name="email" id="email" >
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Confirm Email<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="email" placeholder="Confirm Email" class="form-control" name="confirm_email" >
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
    <div class="cust-modal modal fade in" id="h-quick-view">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="header-blk-name">Edit Shipping Address</div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><!--<img src="img/cancel.png" alt="close">--><i class="fa fa-close"></i></span></button>
                </div>
                <div class="modal-body">
                    <form class="form-sender mCustomScrollbar" enctype="multipart/form-data" method="post" action="{{ url('proceed-shipping-details') }}" role="form" name="shipping-details-form" id="shipping-details-form">
                        {!!  csrf_field()  !!}

                        <input type="hidden" name="ip_cart_id" @if(!empty($cart->id)) value="{{ $cart->id }}" @endif />
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Name of Contact<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="shipping_name" value="@if(\Auth::Check() && isset($cart) && $cart->shipping_name == '') {{ \Auth::user()->userInformation->first_name." ".\Auth::user()->userInformation->last_name }} @elseif(isset($cart)) {{$cart->shipping_name}} @else  @endif">
                            </div>
                        </div>
                        <input type="hidden" name="shipping_iso2" id="shipping_country_code" value="{{ old('shipping_iso2',isset($cart) ? $cart->shipping_iso2 : "")}}"/>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Country<sup>*</sup> :</label>
                            </div>

                            <div class="col-md-8">
                                <div class="h-cust-sel">
                                    <select name="country" id="shipping-country" class="form-control" onchange="getAllStates(this.value,this.id)">
                                        <option class="select-option" label="Please Select" value="" name="country">Please Select</option>
                                        @foreach($all_countries as $country)
                                        <option class="select-option" label="{{ $country->name }}" @if(isset($cart) && $cart->shipping_country == $country->id) selected @endif value={{ $country->id }}>{{ $country->name }}</option>
                                        {{--<option class="select-option" label="India" @if(isset($cart) && $cart->shipping_country == 'India') selected @endif value="India">India</option>--}}
                                        {{--<option class="select-option" label="United States" @if(isset($cart) && $cart->shipping_country == 'United States') selected @endif value="United States">United States</option>--}}
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Address Line 1<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="text" placeholder="Address Line 1" @if(isset($cart) && count($cart)>0) value="{{$cart->shipping_address1}}" @endif class="form-control" name="house_no" required>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Address Line 2 (optional) :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="text" placeholder="Address Line 2 (optional)" @if(isset($cart) && count($cart)>0) value="{{$cart->shipping_address2}}" @endif class="form-control" name="address_line" required>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">City<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    {{--<input id="" type="text" placeholder="City" class="form-control"   @if(!empty($cart->shipping_city))   value="{{$cart->shipping_city}}"  @endif  name="city" required>--}}
                                    <div class="h-cust-sel">
                                        <select name="city" id="shipping-city" class="form-control" required>
                                            <option class="select-option" label="Please Select" value="">Please Select</option>
                                            @php
                                                $cities=null;
                                                 if(isset($cart) && $cart->billing_state !=''){
                                                 $cities = \App\PiplModules\admin\Models\City::where('state_id',$cart->billing_state)->get();
                                                }
                                            @endphp
                                            @if(isset($cities) && count($cities)>0)
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}" @if(isset($cart) && $cart->shipping_city == $city->id) selected @endif>{{$city->name}}</option>
                                            @endforeach
                                            @endif
                                            {{--<option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Maharashtra')) selected @endif label="Maharashtra" value="Maharashtra">Maharashtra</option>--}}
                                            {{--<option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Gujarat')) selected @endif label="Gujarat" value="Gujarat">Gujarat</option>--}}
                                            {{--<option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Madhya Pradesh')) selected @endif label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>--}}
                                        </select>
                                    </div>
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
                                        <select name="region" id="shipping-state" class="form-control" onchange="getAllCities(this.value,this.id)" required>
                                            <option class="select-option" label="Please Select" value="">Please Select</option>
                                            @php
                                                $states =null;
                                                 if(isset($cart) && $cart->shipping_country !=''){
                                                 $states = \App\PiplModules\admin\Models\State::where('country_id',$cart->shipping_country)->get();
                                                }
                                            @endphp
                                            @if(isset($states) && count($states)>0)
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}" @if(isset($cart) && $cart->shipping_state == $state->id) selected @endif>{{$state->name}}</option>
                                            @endforeach
                                            @endif
                                            {{--<option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Maharashtra')) selected @endif label="Maharashtra" value="Maharashtra">Maharashtra</option>--}}
                                            {{--<option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Gujarat')) selected @endif label="Gujarat" value="Gujarat">Gujarat</option>--}}
                                            {{--<option class="select-option" @if(!empty($cart->shipping_state) && ($cart->shipping_state == 'Madhya Pradesh')) selected @endif label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>--}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Postal Code (optional) :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="text" placeholder="Postal Code (optional)" @if(!empty($cart->shipping_zip))  value="{{$cart->shipping_zip}}"  @endif   class="form-control" name="postal_code" >
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="shipping-label">Phone Number<sup>*</sup> :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="h-cust-input">
                                    <input type="tel" id="shipping-mobile-no" class="form-control"   @if(!empty($cart->shipping_telephone))   value="{{$cart->shipping_telephone}}"  @endif  name="telephone">
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="h-cust-input">
                                    <div class="form-group categories-details-filter">
                                        <label class="custom-checkbox">Use this address for billing<input type="checkbox" checked onclick="toggleDisplayBillingAddress(this)" name="billing_address"><span class="checkmark"></span></label>
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
                                    <input type="text" class="form-control" name="billing_name" value="@if(\Auth::Check() && !empty($cart->billing_name)) {{ \Auth::user()->userInformation->first_name." ".\Auth::user()->userInformation->last_name }} @elseif(!empty($cart->billing_name)) {{$cart->billing_name}} @endif">
                                </div>
                            </div>
                            <input type="hidden" name="billing_iso2" id="billing_country_code" value="{{ old('billing_iso2',isset($cart) ? $cart->billing_iso2 : "")}}"/>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Country<sup>*</sup> :</label>
                                </div>

                                <div class="col-md-8">
                                    <div class="h-cust-sel">
                                        <select name="billing_country" id="billing-country" onchange="getAllStates(this.value,this.id)" class="form-control" >
                                            <option class="select-option" label="Please Select" value="" name="country">Please Select</option>
                                            @if(isset($all_countries) && count($all_countries)>0)
                                            @foreach($all_countries as $country)
                                                <option class="select-option" label="{{ $country->name }}" @if(isset($cart) && $cart->shipping_country == $country->id) selected @endif value={{ $country->id }}>{{ $country->name }}</option>
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
                                    <label class="shipping-label">Address Line 1<sup>*</sup> :</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        <input type="text" placeholder="Address Line 1" class="form-control"  @if(!empty($cart->billing_address1))  value="{{$cart->billing_address1}}"   @endif   name="billing_house_no" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Address Line 2 (optional) :</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        <input type="text" placeholder="Address Line 2 (optional)" class="form-control"  @if(!empty($cart->billing_address2))  value="{{$cart->billing_address2}}"   @endif name="billing_address_line" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">City<sup>*</sup> :</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        {{--<input type="text" id="billing-city" placeholder="City" class="form-control" @if(!empty($cart->billing_city))  value="{{$cart->billing_city}}"   @endif     name="billing_city" required>--}}
                                        <select name="billing_city" id="billing-city" class="form-control" required>
                                            <option class="select-option" label="Please Select" value="">Please Select</option>
                                            @php
                                                $cities=null;
                                                 if(isset($cart) && $cart->billing_state !=''){
                                                 $cities = \App\PiplModules\admin\Models\City::where('state_id',$cart->billing_state)->get();
                                                }
                                            @endphp
                                            @if(isset($cities) && count($cities)>0)
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" @if(isset($cart) && $cart->billing_city !='' && $cart->billing_city == $city->id) selected @endif>{{ $city->name }}</option>
                                                @endforeach
                                            @endif
                                            {{--<option class="select-option" @if(!empty($cart->billing_state)  && $cart->billing_state == 'Maharashtra') selected @endif label="Maharashtra" value="Maharashtra">Maharashtra</option>--}}
                                            {{--<option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Gujarat') selected @endif label="Gujarat" value="Gujarat">Gujarat</option>--}}
                                            {{--<option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Madhya Pradesh') selected @endif label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>--}}
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
                                            <select name="billing_region" id="billing-state" onchange="getAllCities(this.value,this.id)" class="form-control" required>
                                                <option class="select-option" label="Please Select" value="">Please Select</option>
                                                @php
                                                    $states =null;
                                                     if(isset($cart) && $cart->billing_country !=''){
                                                     $states = \App\PiplModules\admin\Models\State::where('country_id',$cart->billing_country)->get();
                                                    }
                                                @endphp
                                                @if(isset($states) && count($states)>0)
                                                    @foreach($states as $state)
                                                        <option value="{{$state->id}}" @if(isset($cart) && $cart->billing_state == $state->id) selected @endif>{{$state->name}}</option>
                                                    @endforeach
                                                @endif
                                                {{--<option class="select-option" @if(!empty($cart->billing_state)  && $cart->billing_state == 'Maharashtra') selected @endif label="Maharashtra" value="Maharashtra">Maharashtra</option>--}}
                                                {{--<option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Gujarat') selected @endif label="Gujarat" value="Gujarat">Gujarat</option>--}}
                                                {{--<option class="select-option" @if(!empty($cart->billing_state) && $cart->billing_state == 'Madhya Pradesh') selected @endif label="Madhya Pradesh" value="Madhya Pradesh">Madhya Pradesh</option>--}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Postal Code (optional) :</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        <input type="text" name="billing_postal_code"  placeholder="Postal Code (optional)" class="form-control"  @if(!empty($cart->billing_zip))  value="{{$cart->billing_zip}}"   @endif >
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label class="shipping-label">Phone Number<sup>*</sup> :</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="h-cust-input">
                                        <input type="text" id="billing-mobile-no" name="billing_telephone" class="form-control" @if(!empty($cart->billing_telephone))  value="{{$cart->billing_telephone}}"   @endif>
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
    <link rel="stylesheet" href="{{ asset('public/media/front/intl-telephone/css/intlTelInput.css') }}">
    <script src="{{ asset('public/media/front/intl-telephone/js/intlTelInput.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        function checkOut(id)
        {
            cartId =id;
            // Disable
            $(this).attr("disabled","disabled");
            $.ajax({
                url: '{{url("/chekout-all-cart")}}',
                type: "get",
                dataType: "json",
                data: {
                    cartId: cartId,
                    _token:$('#ip-token').val()
                },
                success: function(response) {
                    if(response.success=="1"){
                        alert(response.msg);
                        window.location.href = javascript_site_path;
                    }
                    else{
                        console.log(response.msg);
                        window.location.href = javascript_site_path;
                    }
                }
            });
        }
    </script>
    <script>
        function showQuickView(product_id)
        { var status = '0';
            if(product_id!="")
            {
                $.ajax({
                    type:"get",
                    url: javascript_site_path + 'get-product-quick-view',
                    dataType:'html',
                    data:{
                        _token: $("[name=_token]").val(),
                        product_id : product_id,
                        status : status
                    },
                    success:function(res)
                    {
                        // alert(res);return;
                        $("#h-quick-view").html(res);
                        $("#h-quick-view").modal('show');
                    }
                });
            }
        }
    </script>

    <script>
        var totalAmt =0;
        function addRemoveProductQuantity(id, action)
        {
            totalAmt =0;
            cartItemId = id.split('_').pop();
            $.ajax({
                url: '{{url("/add-remove-product-quantity")}}',
                type: "get",
                dataType:'json',
                data: {
                    cart_item_id: cartItemId,
                    action: action
                },
                success: function(result) {
                    $('#add-minus-status_'+cartItemId).hide();
                    if(result.success == 1){
                        $('#cart_count').text(result.msg['product_count']);
                        //addCoupon();
                        for(var i=0; result.msg[i]; i++)
                        {
                            $('#show-product-count_'+result.msg[i].id).val(result.msg[i].quantity);
                            $('#subtotal_'+result.msg[i].id).html(result.msg[i].subtotal);
                            totalAmt +=result.msg[i].subtotal;
                        }
                        $('#all-sub-total').html(totalAmt);
                        $('#all-total').html(totalAmt);
                    }
                    else{
                        $('#add-minus-status_'+cartItemId).show();
                        $('#add-minus-status_'+cartItemId).html(result.msg);
                    }

                }

            });
        }
    </script>
    <script>
        $('#add_promo_code').click(function() {
            $('#enter_promo_code').toggle();
            $('#promo_code').val('');
        });

        function addPromoCode(id){
            var promo_code = $('#promo_code').val();
            var cart_id = $('#promo_code').attr('rel');
            var remove_promo_code='';
            if(id)
            {
                remove_promo_code=id;
            }
            if(!promo_code)
            {
                promo_code='';
            }
            $.ajax({
                url: '{{url("/add-promo-code")}}',
                type: "get",
                dataType: "json",
                data: {
                    promo_code: promo_code,
                    cart_id: cart_id,
                    remove_promo_code: remove_promo_code
                },
                success: function(response) {
                    // console.log(response);return;
                    if (response.success  == "1") {
                        $('#enter_coupon').hide();
                        $('#add_coupon').hide();
                        grandTotal.innerText(response.total);
                        // alert(response.msg);return;
                    }
                    else{
                        $('#coupon_invalid').show();
                        // alert(response.msg);return;
                    }

                }
            });
        }

    </script>

    <script>
        var grandTotal = document.getElementById('grand_total');
        $('#add_coupon').click(function() {
            $('#enter_coupon').toggle();
            // $('#add_coupon').hide();
            $('#coupon_code').val('');
        });

        function addCoupon(id){
            var coupon_code = $('#coupon_code').val();
            var cart_id = $('#coupon_code').attr('rel');
            var remove_coupon='';
            if(id)
            {
                remove_coupon=id;
            }
            if(!coupon_code)
            {
                coupon_code='';
            }
            $.ajax({
                url: '{{url("/add-coupon")}}',
                type: "get",
                dataType: "json",
                data: {
                    coupon_code: coupon_code,
                    cart_id: cart_id,
                    remove_coupon: remove_coupon
                },
                success: function(response) {
                      // console.log(response);return;
                    if (response.success  == "1") {
                        $('#enter_coupon').hide();
                        $('#add_coupon').hide();
                        grandTotal.innerText(response.total);
                       // alert(response.msg);return;
                    }
                    else{
                        $('#coupon_invalid').show();
                       // alert(response.msg);return;
                    }

                }
            });
        }

    </script>
    <script>
        function toggleDisplayBillingAddress(obj){
            if(jQuery(obj).is(":checked")){
                jQuery("#billing_details").hide();
            } else {
                jQuery("#billing_details").show();
            }
        }
        function removeCartItem(id)
        {
            cartItemId =id.split('_').pop();
            $.ajax({
                url: '{{url("/remove-cart-item")}}',
                type: "get",
                dataType: "json",
                data: {
                    cart_item_id: cartItemId
                },
                success: function(response) {
                    if(response.success=="1"){
                        window.location.href = window.location.href
                    }
                    else{
                        alert(response.msg);
                        window.location.href = window.location.href
                    }
                }
            });
        }
    </script>
    <script>

        function getAllStates(country_id,id)
        {
            if(country_id!='' && country_id!=0)
            {
                // alert(country_id);return;
                $.ajax({
                    url:"{{url('/states/getAllStates')}}/"+country_id,
                    method:'get',
                    success:function(data)
                    {
                        console.log(data);
                        if(id == 'shipping-country'){
                            $("#shipping-state").html(data);
                        }
                        else if(id == 'billing-country'){
                            $("#billing-state").html(data);
                        }
                    }

                });
            }
        }
        function getAllCities(state_id,id)
        {
            if(state_id!='' && state_id!=0)
            {
                $.ajax({
                    url:"{{url('/cities/getAllCities')}}/"+state_id,
                    method:'get',
                    success:function(data)
                    {
                        console.log(data);
                        if(id == 'shipping-state'){
                            $("#shipping-city").html(data);
                        }
                        else if(id == 'shipping-state'){
                            $("#billing-city").html(data);
                        }
                    }

                });
            }
        }
    </script>
    <?php
    $all_iso = [];
    if(isset($all_countries) && count($all_countries)>0){
        foreach ($all_countries as $cntry => $country){
            $all_iso[] = strtolower($country->trans['iso_code']);
        }
        $isoCodes = json_encode($all_iso);
    }else{
        $isoCodes = [];
    }
//    echo $isoCodes; die;
    ?>
    <script>
        var countries = '{{ $isoCodes }}';
        var selectedShippingFlag = $('#shipping_country_code').val();
        var selectedBillingFlag = $('#billing_country_code').val();
        var selectedCountry = JSON.parse(countries.replace(/&quot;/g,'"'));
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
@endsection
