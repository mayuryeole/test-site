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
                            @if(isset($cart) && count($cart)>0)
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
                <!--<div class="col-md-4">
                	<div class="h-location-blk">
                      <!-- Nav tabs -->
                      <!--<ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab">Domestic</a></li>
                        <li role="presentation"><a href="#profile" role="tab" data-toggle="tab">International</a></li>
                      </ul>-->
                      <!-- Tab panes -->
                      <!--<div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                        	<div class="row">
                            	<div class="col-md-6">
                                    <div class="h-sel-loc relative">
                                        <select class="form-control">
                                            <option>Select Contry</option>
                                            <option>India</option>
                                            <option>USA</option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="h-sel-loc relative">
                                        <select class="form-control">
                                            <option>Select City</option>
                                            <option>Pune</option>
                                            <option>Mumbai</option>
                                        </select>
                                    </div>
                                 </div>
                             </div>
                             <div class="row">
                             	<div class="col-md-12">
                                	<div class="h-proceed-to-checkout text-right">
                                        <input type="button" value="check">
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profile">
                        	<div class="row">
                            	<div class="col-md-6">
                                    <div class="h-sel-loc relative">
                                        <select class="form-control">
                                            <option>Select Contry</option>
                                            <option>India</option>
                                            <option>USA</option>
                                        </select>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="h-sel-loc relative">
                                        <select class="form-control">
                                            <option>Select City</option>
                                            <option>Pune</option>
                                            <option>Mumbai</option>
                                        </select>
                                    </div>
                                 </div>
                             </div>
                             <div class="row">
                             	<div class="col-md-12">
                                	<div class="h-proceed-to-checkout">
                                        <input type="submit" value="Proceed to Checkout">
                                    </div>
                                </div>
                             </div>
                        </div>
                      </div>
                    </div>
                </div>-->
                <!--<div class="col-md-8 col-sm-7 col-xs-12">
                    <div class="h-cart-buttons clearfix">
                        {{--<input type="button" class="h-update-cart" value="Update Cart"/>--}}
                        {{--<a href="javascript:void(0);" class="h-continue">Continue Shopping</a>--}}
                    </div>
                    <div class="h-coupen-code clearfix">
                        {{--<h4>Coupon</h4>--}}
                        {{--<p>Enter your coupon code if you have one.</p>--}}
                        {{--<input type="text" placeholder="Coupon code"/>--}}
                        {{--<input type="submit" value="Apply Coupon">--}}
                    </div>
                </div>-->
                <!--<div class="col-md-4 col-sm-5 col-xs-12">
                    <div class="h-cart-total clearfix">
                        <h3>Cart Totals</h3>
                        <div class="h-cart-table-total clearfix">
                            <table>
                                <tbody>
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td><span id="all-sub-total" class="amount">{{ $totalAmount }}</span></td>
                                </tr>
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td>
                                        <strong><span id="all-total" class="amount">{{ $totalAmount }}</span></strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="h-proceed-to-checkout">
                            <input type="submit" value="Proceed to Checkout">
                        </div>
                    </div>
                </div>-->
                @else
                  <div class="empty-cart-image">
		      <img src="{{url('public/media/front/img/empty-cart.png')}}" alt="Empty Cart"/>
		  </div>
		  <h4 class="empty-cart text-center">Your cart is empty</h4>
                @endif
            </form>
        </div>
    </div>
</section>
<section class="h-ecard-page shipping-details-block">
    <div class="container-fluid">
        <div class="card-details">
            <div class="col-md-12"><h3 class="card-title"><span>Customer Details</span></h3></div>
            <div class="sender-receiver-details">
                <div class="row">
                    <div class="adderss_wrapper">
                        <div class="col-md-6">
                            <div class="form-head">
                                <h5>Customer Details:</h5>
                                <!--<a class="edit-addrs" href="javascript:void(0);" title="Delivery">
                                    <span>Edit Address</span>
                                </a>-->
                            </div>
                            <div class="inner-address">
                                <p class="buyer_name">@if(\Auth::check()){{ \Auth::user()->userInformation->name }} @else Mr. David John @endif</p>
                                <p class="buyer_addrss">Hadapsar Pune-28,</p>
                                <p class="buyer_city">@if(\Auth::check()){{ \Auth::user()->userInformation->city }} @else Pune, Maharashtra 411028 @endif</p>
                                <p class="buyer_country">India</p>
                                <p class="buyer_phone">@if(\Auth::check())Phone Number:{{ \Auth::user()->userInformation->user_mobile }} @else Phone Number: 9087654321 @endif</p>
                            </div>
                            <div class="text-right edit-option clearfix" style="position:relative">
                                <input type="button" class="h-update-cart pull-right" value="Edit" data-toggle="modal" data-target="#cust-modal-edit"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-head">
                                <h5>Shipping Address:</h5>
                                <!--<a class="edit-addrs" href="javascript:void(0);" title="Delivery">
                                    <span>Edit Address</span>
                                </a>-->
                            </div>
                            <div class="inner-address">
                                <p class="buyer_name">Mr. David John</p>
                                <p class="buyer_addrss">Hadapsar Pune-28,</p>
                                <p class="buyer_city">Pune, Maharashtra 411028</p>
                                <p class="buyer_country">India</p>
                                <p class="buyer_phone">Phone Number: 9087654321</p>
                            </div>
                            <div class="text-right edit-option clearfix" style="position:relative">
                                <input type="button" class="h-update-cart pull-right" value="Edit" data-toggle="modal"  data-target="#h-quick-view"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                	{{--<!--<div class="h-customer-details-frm">--}}
                    {{--<div class="row ">--}}
                        {{--<div class="col-md-12">--}}
                            {{--<h3 class="card-title"><span>Customer Details Form</span></h3>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-7">                                --}}
                            {{--<form id="shipping-details-form" name="shipping-details-form" role="form" action="{{ url('proceed-shipping-details') }}" method="post" enctype="multipart/form-data" class="form-sender">--}}
                                {{--{!! csrf_field() !!}--}}
                                {{--<div class="form-head"><h5>Enter a Delivery Address:</h5></div>--}}
                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">Title :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-sel">--}}
                                            {{--<select id="name_initial" name="name_initial" class="form-control">--}}
                                                {{--<option value="">Please Select</option>--}}
                                                {{--<option  value="mr">Mr.</option>--}}
                                                {{--<option  value="mrs">Mrs.</option>--}}
                                                {{--<option  value="miss">Miss.</option>--}}
                                                {{--<option  value="ms">Ms.</option>--}}
                                                {{--<option  value="dr">Dr.</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">First Name :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<input type="text" name="first_name" class="form-control" placeholder="First Name *"/>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">Last Name :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<input type="text" name="last_name" class="form-control" placeholder="Last Name *" value="{{ old('first_name') }}"/>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}


                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">Email :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<input id="email" type="email" name="email" class="form-control" placeholder="Email *"/>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">Confirm Email :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<input type="email" name="confirm_email" class="form-control" placeholder="hancy@panacetek.com *"/>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-12">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<div class="form-group categories-details-filter">--}}
                                                {{--<label class="custom-checkbox">I'd like to receive exclusive discounts and news from paaras fashions by email and post<input name="exclusive_discount" type="checkbox"><span class="checkmark"></span></label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">Country :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-sel">--}}
                                            {{--<select class="form-control" id="country" name="country">--}}
                                                {{--<option name="country" value="" label="Please Select" class="select-option" value="">Please Select</option>--}}
                                                {{--<option value="AL"  label="Albania" class="select-option" value="Albania">Albania</option>--}}
                                                {{--<option value="DZ"  label="Algeria" class="select-option" value="Albania">Algeria</option>--}}
                                                {{--<option value="AS"  label="American Samoa" class="select-option" value="Albania">American Samoa</option>--}}
                                                {{--<option value="AD"  label="Andorra" class="select-option" value="Albania">Andorra</option>--}}
                                                {{--<option value="AO"  label="Angola" class="select-option" value="Albania">Angola</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">House Number and Street :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<input type="text" name="house_no" class="form-control" placeholder="House Number and Street *"/>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">Address Line 2 (optional) :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<input type="text" name="address_line" class="form-control" placeholder="Address Line 2 (optional) *"/>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">City :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<input type="text" name="city" class="form-control" placeholder="City *"/>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">Region/Province :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<div class="h-cust-sel">--}}
                                                {{--<select class="form-control" id="region" name="region">--}}
                                                    {{--<option value=""  label="Please Select" class="select-option" value="">Please Select</option>--}}
                                                    {{--<option value="AL"  label="Albania" class="select-option" value="Maharashtra">Maharashtra</option>--}}
                                                    {{--<option value="DZ"  label="Algeria" class="select-option" value="Gujrat">Gujrat</option>--}}
                                                    {{--<option value="AS" label="American Samoa" class="select-option" value="MP">MP</option>--}}
                                                    {{--<option value="AD"  label="Andorra" class="select-option" value="UP">UP</option>--}}
                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">Postal Code (optional) :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<input type="text" name="postal_code" class="form-control" placeholder="Postal Code (optional) *"/>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-4">--}}
                                        {{--<label class="shipping-label">Phone Number :</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-md-8">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<input type="tel" name="telephone" class="form-control" placeholder="Mobile No *"/>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-12">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<div class="form-group categories-details-filter">--}}
                                                {{--<label class="custom-checkbox">Use this address for billing<input name="billing_address" type="checkbox"><span class="checkmark"></span></label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="row form-group">--}}
                                    {{--<div class="col-md-12">--}}
                                        {{--<div class="h-cust-input">--}}
                                            {{--<label class="custom-checkbox">Submit<input type="submit" class="h-update-cart" value="Add to Cart"></label>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                            {{--</form>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-5">--}}
                            {{--<form class="form-sender">--}}
                                {{--<div class="form-head clearfix"><h5>Order Summary: <span class="h-edit-bag pull-right"><a href="javascript:void(0);">Edit Bag</a></span></h5></div>--}}
                                {{--<div class="checkout-mini-cart clearfix">--}}
                                {{--<span class="mini-cart-span min-cart-image">--}}
                                    {{--<img src="img/list1.jpg" alt="image"/>--}}
                                {{--</span>--}}
                                    {{--<span class="mini-cart-span mini-cart-content">--}}
                                    {{--<p class="min-pro-name">Product Name</p>--}}
                                    {{--<p><span>Colour:</span> cognac</p>--}}
                                    {{--<p><span>UK Size:</span> 8 </p>--}}
                                    {{--<p><span>Quantity:</span> 1 </p>--}}
                                {{--</span>--}}
                                    {{--<span class="mini-cart-span min-cart-price carts-price">--}}
                                    {{--<p><i class="fa fa-rupee"></i> 20.00</p>--}}
                                {{--</span>--}}
                                {{--</div>--}}
                                {{--<div class="min-cart-total">--}}
                                    {{--<div class="select_paument_method">--}}
                                        {{--<div class="h-sel-pay-method clearfix">--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<label class="h-title">Have a promo code?</label>--}}
                                                {{--<div class="h-promo-code">--}}
                                                    {{--<input type="text" class="form-control" placeholder="Enter Promo Code"/>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-6 text-right">--}}
                                                {{--<label class="h-title text-right">Payable Amount:</label>--}}
                                                {{--<div class="h-promo-code">--}}
                                                    {{--<span><i class="fa fa-rupee"></i> 100.00</span>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-12 text-center clearfix" style="margin-top:10px;">--}}
                                                {{--<label class="pull-left">Order Total</label>--}}
                                                {{--<label class="pull-right font-weight"><i class="fa fa-rupee"></i> 100.00</label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div> -->--}}
                </div>            
            </div>
        </div>
        {{--<div class="select_paument_method shipping-cart clearfix">--}}
            {{--<a href="javascript:void(0);">Proceed</a>--}}
            {{--<input type="button" class="h-update-cart" value="Proceed">--}}
      {{--</div>--}}
    </div>
</section>

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
{{--<script>--}}
    {{--var maxOrderQty = 0;--}}
    {{--var qty = 0;--}}
    {{--var res = "";--}}
    {{--var cnt = 0;--}}
    {{--var oneQtyPrice =0;--}}
    {{--function addCount(id){--}}
        {{--cnt = id.split('_').pop();--}}
        {{--$('#add-minus-status_'+cnt).html('');--}}
        {{--oneQtyPrice = $('#one-qty-price_'+cnt).attr('value');--}}
        {{--qty =$('#max-qty_'+cnt).val();--}}
        {{--maxOrderQty = $('#max-order-qty_'+cnt).val();--}}
        {{--$('#minus-cnt-btn_'+cnt).removeAttr('disabled');--}}
        {{--var value = $('#show-product-count_'+cnt).val();--}}
        {{--value =parseInt(value)+1;--}}
        {{--if(value > maxOrderQty || value > qty ){--}}
            {{--$('#add-minus-status_'+cnt).show();--}}
            {{--if(value > maxOrderQty){--}}
                {{--res = "You can only order max "+maxOrderQty+" products";--}}
                {{--$('#add-minus-status_'+cnt).html(res);--}}
                {{--$('#add-cnt-btn_'+cnt).attr('disabled','disabled');--}}
            {{--}--}}
            {{--else if(value > qty){--}}
                {{--res = "Only "+qty+" products are available";--}}
                {{--$('#add-minus-status_'+cnt).html(res);--}}
                {{--$('#add-cnt-btn_'+cnt).attr('disabled','disabled');--}}
            {{--}--}}
        {{--}--}}
        {{--else{--}}
            {{--$('#show-product-count_'+cnt).val(value);--}}
            {{--$('#subtotal_'+cnt).html(oneQtyPrice*value);--}}
        {{--}--}}

    {{--}--}}
    {{--function minusCount(id){--}}
        {{--cnt = id.split('_').pop();--}}
        {{--oneQtyPrice = $('#one-qty-price_'+cnt).attr('value');--}}
        {{--$('#add-minus-status_'+cnt).html('');--}}
        {{--$('#add-cnt-btn_'+cnt).removeAttr('disabled');--}}
        {{--var value = $('#show-product-count_'+cnt).val();--}}
        {{--value =parseInt(value);--}}
        {{--if(value > 1){--}}
            {{--value -=1;--}}
        {{--}--}}
        {{--else{--}}
            {{--$('#add-minus-status_'+cnt).show();--}}
            {{--$('#minus-cnt-btn_'+cnt).attr('disabled','disabled');--}}
        {{--}--}}
        {{--$('#show-product-count_'+cnt).val(value);--}}
        {{--$('#subtotal_'+cnt).html(oneQtyPrice*value);--}}
    {{--}--}}
{{--</script>--}}
<script>
    var totalAmt =0;
    function addRemoveProductQuantity(id, action)
    {
        totalAmt =0;
        //alert(id + "@@@@" + action);return;
        cartItemId = id.split('_').pop();
        // alert(cartItemId);return;
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
                // console.log(result.msg['1'].id);
                // console.log(JSON.stringify(result.msg));return;
                //            console.log(result.msg);return;
                if(result.success == 1){
                    //var jsonObj =JSON.stringify(result.msg);

                    //alert(jsonObj);return;
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

                    // window.location.href = window.location.href;
                }
                else{
                    $('#add-minus-status_'+cartItemId).show();
                    $('#add-minus-status_'+cartItemId).html(result.msg);
                }

            }

        });
    }
</script>
{{--<script>--}}
   {{--var totalAmt =0;--}}
    {{--function addRemoveProductQuantity(id, action)--}}
    {{--{    totalAmt =0;--}}
        {{--//alert(id + "@@@@" + action);return;--}}
        {{--cartItemId = id.split('_').pop();--}}
       {{--// alert(cartItemId);return;--}}
        {{--$.ajax({--}}
            {{--url: '{{url("/add-remove-product-quantity")}}',--}}
            {{--type: "get",--}}
            {{--dataType:'json',--}}
            {{--data: {--}}
                {{--cart_item_id: cartItemId,--}}
                {{--action: action--}}
                {{--},--}}
            {{--success: function(result) {--}}
                           {{--//console.log(result);--}}
                    {{--$('#cart_count').text(result.product_count);--}}
                    {{--//addCoupon();--}}
                        {{--for(var i=0; result[i]; i++)--}}
                        {{--{--}}
                            {{--$('#show-product-count_'+result[i].id).val(result[i].quantity);--}}
                            {{--$('#subtotal_'+result[i].id).html(result[i].subtotal);--}}
                            {{--totalAmt +=result[i].subtotal;--}}
                        {{--}--}}
                        {{--$('#all-sub-total').html(totalAmt);--}}
                        {{--$('#all-total').html(totalAmt);--}}

               {{--// window.location.href = window.location.href;--}}

            {{--}--}}

            {{--});--}}
    {{--}--}}
    {{--</script>--}}
<script>
    $(document).ready(function() {

       // addCoupon();
    });



    $('#add_coupon').click(function() {
        $('#enter_coupon').show();
        $('#add_coupon').hide();
        $('#coupon_code').val('');
    });

    function addCoupon(id){
        var coupon_code = $('#coupon_code').val();
        var remove_coupon='';
        if(id)
        {
            remove_coupon=id;
        }
        if(!coupon_code)
        {
            coupon_code='';
        }
        var vendor_ids = "";
        {{--var vendor_ids ={!! json_encode($vendor_ids) !!};--}}
        $.ajax({
            url: '{{url("/add-coupon")}}',
            type: "get",
            dataType: "json",
            data: {
                coupon_code: coupon_code,
                vendor_ids: vendor_ids,
                remove_coupon: remove_coupon,
            },
            success: function(result) {
//                        console.log();
                if (result){
                    if(result.all_vendor_subtotal)
                    {
                        $('#coupons').show();
                        $('#order_subtotal').text('$'+result.all_vendor_subtotal.toFixed(2));
                        $('#shipping').text('$'+result.shipping_cost.toFixed(2));
                        $('#tax').text('$'+result.tax.toFixed(2));
                        $('#grand_total').text('$'+result.grand_total.toFixed(2));
                    }

                    $('#coupons').html("");
                    if(typeof result.coupon != "undefined")
                    {
                        $('#coupon_invalid').hide();
                        for(var i=0;i<result.coupon.code.length;i++)
                        {
                            $('#coupons').append('<tr><td id="vedor_coupon_' + result.coupon.id[i] + '"><strong class="blue-txt">' + result.coupon.code[i] + '</strong><br>\n\
                                                <span>' + result.coupon.offer[i] + '</span> off from ' + result.coupon.store_name[i] + '<br>\n\
                                            </td>\n\
                                            <td id="vedor_price_' + result.coupon.id[i] + '" class="ar"><a class="checkout-remove" onclick="addCoupon(' + result.coupon.id[i] + ')" href="javascript:void[0]" title="remove"><i class="fa fa-remove"></i></a><br>\n\
                                                <strong class="blue-txt">-$<span class="off-price">'+result.coupon.deduct_amount[i]+'</span></strong></td></tr>');
                        }
                        $('#enter_coupon').hide();
                        $('#add_coupon').show();

                    }
                    console.log($('#coupons').html()=='');


                }

                if(coupon_code!='' && $('#coupons').html()!='')
                {
                    if(!result.coupon.code.includes(coupon_code))
                    {
                        $('#coupon_invalid').show();
                        $('#enter_coupon').show();
                        $('#add_coupon').hide();
                    }
                }
                else if(coupon_code!='' &&  $('#coupons').html()=='')
                {
                    $('#coupon_invalid').show();
                    $('#enter_coupon').show();
                    $('#add_coupon').hide();
                }

            }
        });
    }

</script>
<script>
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

<div class="cust-modal modal fade in" id="cust-modal-edit">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
    	<div class="header-blk-name">Edit Customer Details</div>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><!--<img src="img/cancel.png" alt="close">--><i class="fa fa-close"></i></span></button>
      </div>
      <div class="modal-body">
      		<form class="form-sender mCustomScrollbar" enctype="multipart/form-data" method="post" action="{{ url('proceed-customer-shipping-details') }}" role="form" name="customer-shipping-details-form" id="customer-shipping-details-form">
                                {{csrf_field()}}
                                <!--<div class="form-head"><h5>Enter a Delivery Address:</h5></div>-->
                                    <input type="hidden" id="ip_cart_id" name="ip_cart_id" @if(isset($cart) && count($cart)>0) value="{{ $cart->id }}" @endif>
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

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">Country<sup>*</sup> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-sel">
                                            <select name="country" id="country" class="form-control" >
                                                <option class="select-option" label="Please Select" value="" name="country">Please Select</option>
                                                <option class="select-option" label="Albania" value="AL">Albania</option>
                                                <option class="select-option" label="Algeria" value="DZ">Algeria</option>
                                                <option class="select-option" label="American Samoa" value="AS">American Samoa</option>
                                                <option class="select-option" label="Andorra" value="AD">Andorra</option>
                                                <option class="select-option" label="Angola" value="AO">Angola</option>
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
                                            <input type="text" placeholder="Address Line 1" class="form-control" name="house_no" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">Address Line 2 (optional) :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input type="text" placeholder="Address Line 2 (optional)" class="form-control" name="address_line" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">City<sup>*</sup> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input type="text" placeholder="City" class="form-control" name="city" required>
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
                                                <select name="region" id="region" class="form-control" required>
                                                    <option class="select-option" label="Please Select" value="">Please Select</option>
                                                    <option class="select-option" label="Albania" value="AL">Maharashtra</option>
                                                    <option class="select-option" label="Algeria" value="DZ">Gujrat</option>
                                                    <option class="select-option" label="American Samoa" value="AS">MP</option>
                                                    <option class="select-option" label="Andorra" value="AD">UP</option>
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
                                            <input type="text" placeholder="Postal Code (optional)" class="form-control" name="postal_code" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">Phone Number<sup>*</sup> :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input type="tel" placeholder="Mobile No" class="form-control" name="telephone">
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <div class="h-cust-input">
                                            <div class="form-group categories-details-filter">
                                                <label class="custom-checkbox">Use this address for billing<input type="checkbox" name="billing_address"><span class="checkmark"></span></label>
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
@endsection
