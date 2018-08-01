@extends('layouts.app')
@section('meta')
<title>Profile</title>
<style>
    .autocomplete-suggestions {
        background-color: #fff;
        border: 1px solid #e3e3e3;
        overflow-y: auto;
    }   
    .autocomplete-suggestion {
        background-color: #fff;
        padding: 5px;
        font-size: 14px;
    }
    .myAccount-block .controls label {
        padding-left: 15px !important;
    }
</style>
@endsection
@section('content')
@include('includes.header-login')

<section class="content">
    <div class="coming-soon-content">
        <div class="container-fluid">
            <div class="forgot-password-top">
                <div class="row">
                    <div class="col-xs-12 ac">
                        <!--<h1>Checkout</h1>-->
                    </div>
                </div>
                <div class="row EmailCart-list">
                    <div class="col-xs-12">
                        <ul class="">
                            <li class="active"><span class="glyphicon glyphicon-ok"></span>
                                <strong>Shipping</strong>
                            </li>
                            <li class="step-line active"><span></span></li>
                            <li class="active"><span class="glyphicon glyphicon-ok"></span>
                                <strong>Payment</strong>
                            </li>
                            <li class="step-line active"><span></span></li>
                            <li class="active"><span>3</span>
                                <strong>Review and Submit</strong>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
            <div class="checkout-content">
                <div class="row">
                    @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                        {{Session::forget('error')}}
                        {{Session::save()}}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    </div>
                    @endif
                    
                    @if (Session::has('product_quantity_error'))
                    <div class="alert alert-danger">
                        @foreach(Session::get('product_quantity_error') as $error)
                            {{$error}}
                        @endforeach
                        {{Session::forget('product_quantity_error')}}
                        {{Session::save()}}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    </div>
                    @endif
                    <div class="col-xs-12 col-md-8">
                        <div class="checkout-03-main">
                            <h4>review and submit</h4>
                            <p class="marginbottom-40">Review your order details and submit.</p>

                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="box-shadow">
                                        <div class="checkout-03-box">
                                            <div class="checkout-03-box-title">
                                                <p>Shipping Address</p>
                                                <a href="javascript:void(0)" id="change_address"><strong class="red-txt">Change</strong></a>
                                            </div>
                                            <div class="checkout-03-box-main">
                                                <p><strong>{{$order->first_name}} {{$order->last_name}}<br>
                                                        {{$order->apartment}} {{$order->street}}<br>
                                                        {{$order->shippingCity->name}}, {{$order->shipping_zip}}<br>
                                                        {{$order->shippingState->name}}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="box-shadow">
                                        <div class="checkout-03-box">
                                            <div class="checkout-03-box-title">
                                                <p>Payment Method</p>
                                                <a href="javascript:void(0)" id="change_payment_method"><strong class="red-txt">Change</strong></a>
                                            </div>
                                            <div class="checkout-03-box-main">
                                                <p class="checkout-03-box-pay"><img class="" src="{{url('/')}}/public/media/front/images/visa-icon.png"><strong>Visa {{str_pad(substr($order->billing_card_number, -4), strlen($order->billing_card_number), '*', STR_PAD_LEFT)}}<br>
                                                        Exp: {{$order->billing_month}} / {{$order->billing_year}}</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                        <div class="checkout-aside checkout-aside-03 box-shadow">
                            <a class="btn btn-red" href="{{url('/submir-order')}}">submit order</a>
                            <div class="checkout-aside-03-table">
                                <table class="table">
                                    <tr>
                                        <td class="notop-border">Item(s) total</td>
                                        <td class="notop-border ar"><strong>$<span id="grand_total"></span></strong></td>
                                    </tr>
                                    <tr id="enter_coupon" style="display: none">
                                        <td class="notop-border notop-padding" colspan="2">
                                            <form class="coupon-code-form">
                                                <input class="form-control input-sm" type="text" placeholder="Enter Coupon Code" id="coupon_code">
                                                <input type="button" class="btn btn-sm btn-w-b" value="Apply" id="apply_coupon" onclick="addCoupon()">
                                                <span class="text-danger" style="display: none" id="coupon_invalid">Invalid Coupon Code</span>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="notop-border notop-padding" colspan="2">
                                            <a class="apply-coupon-code" href="javascript:void(0)" id="add_coupon">+ Apply Coupon Code</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="notop-border notop-padding">Discount(s)</td>
                                        <td class="notop-border notop-padding ar"><strong class="blue-txt">- $<span id="discount"></span></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="notop-border notop-padding">Shipping</td>
                                        <td class="notop-border notop-padding ar"><strong>$<span id="shipping">30.00</span></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="notop-border notop-padding">Tax</td>
                                        <td class="notop-border notop-padding ar"><strong>$<span id="tax">22.32</span></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Order Total (<span id="total_item"></span> items)</td>
                                        <td class="ar"><strong>$<span id="final_total"></span></strong></td>
                                    </tr>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box-shadow checkout-03-bottom">
                            <div class="checkout-03-bottom-title">
                                <div class="row">

                                    <div class="col-xs-12 col-sm-12 col-md-7">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-5">
                                                <h5>Item</h5>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 col-md-4">
                                                <h5>Quantity</h5>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 col-md-3">
                                                <h5>Subtotal</h5>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{$order_subtotal=0}}">
                            @if($vendor_ids && $cart && $cart->cartItems)
                            @foreach($vendor_ids as $vendor_id)
                            <input type="hidden" value="{{$specific_subtotal=0}}">
                            <input type="hidden" value="{{$vendor=0}}">
                            <input type="hidden" value="{{$subtotal=0}}">

                            <div class="checkout-03-bottom-line">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-7">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h6>
                                                    @foreach($cart->cartItems as $cart_item)
                                                    @if($cart_item->product->created_by==$vendor_id && $vendor==0)
                                                    <input type="hidden" value="{{$vendor=1}}">
                                                    <img src="@if($cart_item->product->vendor->storeLogo) {{url('/storage/app/public/vendor-store-logo/'.$cart_item->product->vendor->id.'/'.$cart_item->product->vendor->storeLogo->store_logo)}} @else {{url('/public/media/front/images/no-image.png')}} @endif"> {{$cart_item->product->vendor->store_name}}
                                                    @endif
                                                    @endforeach
                                                </h6>
                                            </div>
                                        </div>
                                        @foreach($cart->cartItems as $cart_item)
                                        @if($cart_item->product->created_by==$vendor_id)
                                        <div class="row checkout-03-bottom-line-in">
                                            <div class="col-xs-12 col-sm-6 col-md-5">
                                                <input type="hidden" value="{{$image_check=0}}">
                                                @foreach($cart_item->product->productImage as $image)
                                                @if($image->featured_image=="1")
                                                <input type="hidden" value="{{$image_check=$image->image}}">
                                                @endif
                                                @endforeach
                                                <h5 class="clears"><span>
                                                        @if($image_check!="0")
                                                        <img src="{{url('/storage/app/public/vendor-product/thumb/'.$image_check)}}">
                                                        @else
                                                        <img src="{{url('/storage/app/public/vendor-product/thumb/'.$cart_item->product->productImage[0]->image)}}">
                                                        @endif
                                                    </span> <span style="width:10px;"></span>
                                                    <span class="image_desp_here">{{$cart_item->product->name}}<br>
                                                        <span id="main_price_{{$cart_item->id}}">${{$cart_item->productPrice($cart_item->product_id)}}</span>
                                                    </span></h5>
                                            </div>
                                            <div class="col-xs-6 mob-padding-right-0 col-sm-3 col-md-4">
                                                <div class="form-group">
                                                    <div class="wan-spinner wan-spinner-1"> 
                                                        <a href="javascript:void(0)" class="minus" id="min_{{$cart_item->id}}" onclick="addRemoveProductQuantity(this.id.slice(4),'min')">-</a>
                                                        <input class="form-control input-sm" type="text" value="{{$cart_item->product_quantity}}" id="quantity_{{$cart_item->id}}" onchange="calSubtotal(this.id)">
                                                        <a href="javascript:void(0)" class="plus" id="add_{{$cart_item->id}}" onclick="addRemoveProductQuantity(this.id.slice(4),'add')">+</a> 
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-xs-6 mob-ac col-sm-3 col-md-3">
                                                <p><strong>$<span id="subtotal_{{$cart_item->id}}">{{$cart_item->productPrice($cart_item->product_id) * $cart_item->product_quantity}}</span></strong></p>
                                            </div>
                                            <input type="hidden" value="{{$order_subtotal=$order_subtotal + ($cart_item->productPrice($cart_item->product_id) * $cart_item->product_quantity)}}">
                                            <input type="hidden" value="{{$specific_subtotal=$specific_subtotal + ($cart_item->productPrice($cart_item->product_id) * $cart_item->product_quantity)}}">
                                            <input type="hidden" value="{{$subtotal=$subtotal+$cart_item->product_quantity}}">
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-5">
                                        <div class="checkout-03-shipping">
                                            <p>Choose Package Type</p>
                                            <ul>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="sampleRadio" id="">
                                                                <span class="custom-radio"></span> Molded Pulp Shipper</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="sampleRadio" id="">
                                                                <span class="custom-radio"></span> New Shipper</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="sampleRadio" id="">
                                                                <span class="custom-radio"></span> Foam Shipper</label>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <p>Choose a shipping method</p>
                                            <table class="table">
                                                <tr>
                                                    <td class="notop-border">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="sampleRadio" id="">
                                                                <span class="custom-radio"></span> Standard Shipping</label>
                                                        </div>
                                                    </td>
                                                    <td class="ar notop-border"><strong>$10.00</strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="notop-border">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="sampleRadio" id="">
                                                                <span class="custom-radio"></span> Priority Mail (2-3 days)</label>
                                                        </div>
                                                    </td>
                                                    <td class="ar notop-border"><strong>$10.00</strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="notop-border">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="sampleRadio" id="">
                                                                <span class="custom-radio"></span> Priority Express (Overnight)</label>
                                                        </div>
                                                    </td>
                                                    <td class="ar notop-border"><strong>$10.00</strong></td>
                                                </tr>
                                            </table>

                                            <table class="table">
                                                <tr>
                                                <tr>
                                                    <td>Item(s) total</td>
                                                    <td class="ar"><strong>$40.00</strong></td>
                                                </tr>
                                            </table>
                                            <table class="table tt" id="coupons_{{$vendor_id}}">

<!--                                                    <td class="notop-border"><strong class="blue-txt">MODERN10</strong><br>
        10% off from Modern Times<br>
    </td>
    <td class="ar notop-border"><a class="checkout-remove" href="#"><i class="fa fa-remove"></i></a><br>
        <strong class="blue-txt">-$5.00</strong></td>-->

                                            </table>
                                            <table class="table tt">
<!--                                                <tr>
                                                    <td class="notop-border " colspan="2">
                                                        <form class="coupon-code-form">
                                                            <input class="form-control input-sm" type="text" placeholder="Enter Coupon Code">
                                                            <input type="submit" class="btn btn-sm btn-w-b" value="Apply">
                                                        </form>
                                                    </td>
                                                </tr>-->
<!--                                                <tr>
                                                    <td class="notop-border " colspan="2">
                                                        <a class="apply-coupon-code" href="#">+ Apply Coupon Code</a>
                                                    </td>
                                                </tr>-->

                                                <tr>
                                                    <td class="notop-border">Shipping</td>
                                                    <td class="ar notop-border"><strong>$<span id="shipping_{{$vendor_id}}"></span></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="notop-border">Sales Tax</td>
                                                    <td class="ar notop-border"><strong>$<span id="tax_{{$vendor_id}}"></span></strong></td>
                                                </tr>
                                                </tr>
                                            </table>
                                            <table class="table">
                                                <tr>
                                                    <td>Subtotal (<span id="subtotal_item_{{$vendor_id}}">{{$subtotal}}</span> items)</td>
                                                    <td class="ar"><strong id="subtotal_{{$vendor_id}}">${{$specific_subtotal}}</strong></td>

                                                </tr>
                                            </table>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            @endforeach
                            @endif
                            <div class="checkout-03-bottom-bm ar">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <!--<form action="Checkout-04.html">-->
                                        <a href="{{url('/submir-order')}}"><input type="button" class="btn btn-red" value="submit order"></a>
                                        <!--</form>-->
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
<!-----------------change payment popup----------------------------------------->

<div class="pop-wrap payment-card-pop @if(count($errors)) active @endif" id="payment_method" @if(count($errors)) style="display:block" @endif>
     <div class="pop-wrap-bg"></div>
    <div class="div-table">
        <div class="table-cell">
            <div class="pop-main add-cart-pop-main payment-card-pop-main">
                <div class="add-cart-pop-box">
                    <div class="ac add-cart-pop-title"> <a class="close-icon" href="#"><span class="line-bar"></span><span class="line-bar"></span></a></div>
                    <div class="checkout-main">
                        <div class="container-fluid">

                            <div class="checkout-payment-bottom">
                                <form action="{{url('/change-payment-info')}}" method="post">
                                    {!! csrf_field() !!}
                                    <div class="form-group ac">
                                        <h4 class="upp">Edit payment method</h4>
                                        <h5>Enter your payment information</h5>
                                    </div>
                                    <div class="alert alert-danger" id="error_msg_container" style="display:none">
                                        <span id="error_msg"></span>
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input required type="text" onkeyup="checkCard()" id="card_number" class="floatLabel" name="card_number" value="{{old('card_number',$order->billing_card_number)}}">
                                                    <label for="">Card Number</label>
                                                </div>
                                                @if ($errors->has('card_number'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('card_number') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group">
                                                <div class="controls"> <i class="fa fa-angle-down"></i>
                                                    <select required class="floatLabel" onchange="checkCard()" name="month" id="month">
                                                        <option value=""></option>
                                                        <option value="1" @if(old('month',$order->billing_month)==1) selected @endif>Jan</option>
                                                        <option value="2" @if(old('month',$order->billing_month)==2) selected @endif>Feb</option>
                                                        <option value="3" @if(old('month',$order->billing_month)==3) selected @endif>Mar</option>
                                                        <option value="4" @if(old('month',$order->billing_month)==4) selected @endif>Apr</option>
                                                        <option value="5" @if(old('month',$order->billing_month)==5) selected @endif>May</option>
                                                        <option value="6" @if(old('month',$order->billing_month)==6) selected @endif>Jun</option>
                                                        <option value="7" @if(old('month',$order->billing_month)==7) selected @endif>Jul</option>
                                                        <option value="8" @if(old('month',$order->billing_month)==8) selected @endif>Aug</option>
                                                        <option value="9" @if(old('month',$order->billing_month)==9) selected @endif>Sep</option>
                                                        <option value="10" @if(old('month',$order->billing_month)==10) selected @endif>Oct</option>
                                                        <option value="11" @if(old('month',$order->billing_month)==11) selected @endif>Nov</option>
                                                        <option value="12" @if(old('month',$order->billing_month)==12) selected @endif>Dec</option>
                                                    </select>
                                                    <label for="fruit">MM</label>
                                                </div>
                                                @if ($errors->has('month'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('month') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group">
                                                <div class="controls"> <i class="fa fa-angle-down"></i>
                                                    <select required class="floatLabel" onchange="checkCard()" name="year" id="year">
                                                        <option @if(old('year') == "") selected @endif value=""></option>
                                                        @for($year=date("Y");$year<=date("Y")+10;$year++)
                                                        <option @if(old('year',$order->billing_year) == $year) selected
                                                                 @endif value="{{$year}}">{{$year}}</option>
                                                        @endfor
                                                    </select>
                                                    <label for="fruit">YY</label>
                                                </div>
                                                @if ($errors->has('year'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('year') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input required type="text" onkeyup="checkCard()" maxlength="3" id="cvv" class="floatLabel" name="cvv" value="{{$order->billing_cvv}}">
                                                    <label for="">CVV</label>
                                                </div>
                                                @if ($errors->has('cvv'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('cvv') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input required type="text" onkeyup="checkCard()" id="name" class="floatLabel" name="name" value="{{old('name',$order->billing_name)}}">
                                                    <label for="">Name on Card</label>
                                                </div>
                                                @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group btn-bottom-box" id="submit" style="display:none">
                                    <input type="submit" class="btn btn-red" value="Continue">
                                </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!---------------------end change payment popup--------------------------------------->

<!----------------------change shipping address popup--------------------------------->
<div class="pop-wrap myAccount-shipping-pop @if($errors->has('zip_code')) active @endif" id="change_address_popup" @if($errors->has('zip_code')) style:"display:none" @endif>
     <div class="pop-wrap-bg"></div>
    <div class="div-table">
        <div class="table-cell">
            <div class="pop-main add-cart-pop-main payment-card-pop-main">
                <div class="add-cart-pop-box">
                    <div class="ac add-cart-pop-title"> <a class="close-icon" href="#"><span class="line-bar"></span><span class="line-bar"></span></a></div>
                    <div class="checkout-main">
                        <div class="container-fluid">
                            <form action="{{url('/change-shipping-address')}}" method="post"  onsubmit="return validationEvent()">
                                {!! csrf_field() !!}
                                <div class="checkout-payment-bottom">
                                    <div class="form-group ac">
                                        <h4 class="upp">Edit address</h4>
                                        <h5>Enter your shipping information</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input required type="text" id="" class="floatLabel" name="first_name" value="{{old('first_name',$order->first_name)}}">
                                                    <label for="">First Name</label>
                                                    @if ($errors->has('first_name'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('first_name') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input required type="text" id="" class="floatLabel" name="last_name" value="{{old('last_name',$order->last_name)}}">
                                                    <label for="">Last Name</label>
                                                    @if ($errors->has('last_name'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input required type="text" id="" class="floatLabel" name="street" value="{{old('street',$order->shipping_address_1)}}">
                                                    <label for="">Street</label>
                                                    @if ($errors->has('street'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('street') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="text" id="" class="floatLabel" name="apt" value="{{old('apt',$order->apartment)}}">
                                                    <label for="">Apt/Suite <span>(Optional)</span></label>
                                                    @if ($errors->has('apt'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('apt') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="controls"> <i class="fa fa-angle-down"></i>
                                                    <select required class="floatLabel" name="state" required id="business_state" onchange="fetchCitiesForAutocomplete()">
                                                        <option value=""></option>
                                                        @foreach($states as $state)
                                                        <option value="{{$state->id}}" @if(old('state',$order->shipping_state)==$state->id) selected @endif>{{$state->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="">State</label>
                                                    @if ($errors->has('state'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('state') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="controls" id="business_city_autocomplete_container">
                                                    <div class="form-group hidden" id="cityProgress">
                                                        <img src="{{url('public/media/front/images/loader.gif')}}" height="25" /> Loading Cities....
                                                    </div>
                                                    <input type="text" value="{{old('business_city_autocomplete',$order->shippingCity->name)}}" id="business_city_autocomplete" class="floatLabel" name="city">
                                                    <label for="business_city_autocomplete" id="business_city_autocomplete_lable">City</label>
                                                    <input type="hidden" id="business_city" value="{{old('business_city',$order->shipping_city)}}" name="business_city">
                                                    @if ($errors->has('city'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('city') }}</strong>
                                                    </span>
                                                    @endif
                                                    <span class="help-block" id="select_city" style="display:none">
                                                        <strong class="text-danger">Please select valid city</strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input required type="text" maxlength="6" id="" class="floatLabel" name="zip_code" value="{{old('zip_code',$order->shipping_zip)}}">
                                                    <label for="">Zip Code</label>
                                                    @if ($errors->has('zip_code'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('zip_code') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5">
                                            <div class="form-group">
                                                <a href="javascript:void(0)" onclick="$('#change_address_popup').hide()" class="btn btn-black">cancel</a>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-7">
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-red" value="submit">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!---------------------end change address popup--------------------------------------->
<script>
    $(document).ready(function() {
        var x = document.querySelectorAll(".floatLabel");
        for (var i = 0; i < x.length; i++)
        {
            if (x[i].value)
            {
                var name = x[i].name;
                var select = x[i].name;

                var name = $('input[name=' + name + ']')
                name.next().addClass('floatLabel active');

                var select = $('select[name=' + select + ']')
                select.next().addClass('floatLabel active');

            }
        }
        
        checkCard();
    });

    function checkCard(){
        $('#submit').hide();
        var card_number= $('#card_number').val();
        var month= $('#month').val();
        var year= $('#year').val();
        var cvv= $('#cvv').val();
        var name= $('#name').val();
    if(card_number!='' && month!='' && year!='' && cvv!='' && name!='')
    {
        $.ajax({
            url: '{{url("/check-card")}}',
                    type: "get",
                    dataType: "json",
                    data: {
                    card_number: card_number,
                       month: month,
                       year: year,
                       cvv: cvv,
                       name: name,
                    },
                    success: function(result) {
//                        console.log(result);
                        if(result.res =='0')
                        {
                            $('#error_msg_container').show();
                            $('#error_msg').text(result.msg);
                        }
                        else
                        {
                            $('#submit').show();
                            $('#error_msg_container').hide();
                        }
                    }
               });
        }
    }

</script>   
<script>
    $(document).ready(function() {
        addCoupon();
    });
    $('#change_payment_method').click(function() {
        $('#payment_method').addClass('active');
        $('#payment_method').show();
    });

    $('#change_address').click(function() {
        $('#change_address_popup').addClass('active');
        $('#change_address_popup').show();
    });
    
    $('#add_coupon').click(function() {
        $('#enter_coupon').show();
        $('#add_coupon').hide();
        $('#coupon_code').val('');
        $('#coupon_invalid').hide();
    });
</script>
<script type="text/javascript">
    var citiesAutocomplete = [];
    var autoCompleteCityId = "";
    var autoCompleteCity = "";
    function updateCityIdOfSelectedSource() {
        var selectedValue = (jQuery("#business_city_autocomplete").data('autocomplete')).selection;
        jQuery('#business_city').val(selectedValue.data);
    }
    function fetchCitiesForAutocomplete() {
        var selectedState = jQuery('#business_state').val();
        jQuery("#cityProgress").removeClass('hidden');
        jQuery("#business_city_autocomplete_container").addClass('hidden');
        jQuery('#business_city').val(autoCompleteCityId);
        jQuery('#business_city_autocomplete').val(autoCompleteCity);
        jQuery.ajax({
            url: "{{url('/get-cities-for-front-selected-state')}}/" + selectedState,
            type: 'GET',
            dataType: 'json',
            success: function(data) {

                jQuery("#cityProgress").addClass('hidden');
                jQuery("#business_city_autocomplete_container").removeClass('hidden');
                jQuery('#business_city').val(autoCompleteCityId);
                jQuery('#business_city_autocomplete').val(autoCompleteCity);

                autoCompleteCity = "";
                autoCompleteCityId = "";

                jQuery(data).each(function(indx, ele) {
                    citiesAutocomplete.push({data: ele.id, value: ele.name});
                });

                jQuery('#business_city_autocomplete').autocomplete('destroy');
                jQuery('#business_city_autocomplete').autocomplete({
                    lookup: citiesAutocomplete,
                    onSelect: updateCityIdOfSelectedSource,
                    beforeRender: function() {
                        jQuery('#business_city').val('')
                    }
                });

            }
        });
    }

    function validationEvent()
    {
        if ($('#business_city').val() == "")
        {
            $('#select_city').show();
            return false;
        }
    }
</script>
<script>
    function addRemoveProductQuantity(id, action)
    {
    $.ajax({
    url: '{{url("/add-remove-product-quantity")}}',
            type: "get",
            dataType:'json',
            data: {
            cart_item_id: id,
                    action: action,
            },
            success: function(result) {
//            console.log(result);
                    $('#cart_count').text(result.product_count);
                    addCoupon();
                    for(var i=0; result[i]; i++)
                    {
                        $('#quantity_'+result[i].id).val(result[i].quantity);
                        $('#subtotal_'+result[i].id).text(result[i].subtotal);
                    }


            }
    });
    }

    function getFinalTotal()
    {
        var final_total = 0;
        var discount = $('#discount').text();
        var shipping = $('#shipping').text();
        var tax = $('#tax').text();
        var grand_total = $('#grand_total').text();

        discount = parseFloat(discount);
        shipping = parseFloat(shipping);
        tax = parseFloat(tax);
        grand_total = parseFloat(grand_total);

        final_total = (grand_total - discount) + tax + shipping;
        $('#final_total').text('$' + final_total);

    }

    function getSubtotalOfSpecificVendorProduct(cart_item_id, action)
    {
        $.ajax({
            url: '{{url("/get-specific-vendor-product-quantity")}}',
            type: "get",
            data: {
                cart_item_id: cart_item_id,
                action: action,
            },
            success: function(result) {
                console.log(result);
                if (action == "minus")
                {
                    var subtotal_item = $('#subtotal_item_' + result[0]).text().replace(/^\D+|\D+$/g, "");
                    var subtotal = $('#subtotal_' + result[0]).text().slice(1);

                    subtotal_item = parseInt(subtotal_item) - 1;
                    subtotal = parseFloat(subtotal) - parseFloat(result[1]);

                    $('#subtotal_item_' + result[0]).text('Subtotal (' + subtotal_item + ' items)');
                    $('#subtotal_' + result[0]).text('$' + subtotal);

                }
                else
                {
                    var subtotal_item = $('#subtotal_item_' + result[0]).text().replace(/^\D+|\D+$/g, "");
                    var subtotal = $('#subtotal_' + result[0]).text().slice(1);

                    subtotal_item = parseInt(subtotal_item) + 1;
                    subtotal = parseFloat(subtotal) + parseFloat(result[1]);

                    $('#subtotal_item_' + result[0]).text('Subtotal (' + subtotal_item + ' items)');
                    $('#subtotal_' + result[0]).text('$' + subtotal);
                }
            }
        });
    }

    function addCoupon(id) {
        var coupon_code = $('#coupon_code').val();
        var remove_coupon = '';
        if (id)
        {
            remove_coupon = id;
        }
        if (!coupon_code)
        {
        coupon_code = '';
        }
        var vendor_ids = {!! json_encode($vendor_ids) !!};
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
                console.log(result);
                if (result)
                {
                    $('#coupons').show();
                    $('#grand_total').text(result.all_vendor_subtotal.toFixed(2));
                    $('#tax').text(result.tax.toFixed(2));
                    $('#discount').text(result.all_deduct_amount.toFixed(2));
                    $('#final_total').text(result.grand_total.toFixed(2));
                    $('#shipping').text(result.shipping_cost.toFixed(2));

                    vendor_ids.forEach(function(obj, index) {
                        $('#subtotal_item_' + obj).text(result['subtotal_item_' + obj]);
                        $('#subtotal_' + obj).text('$' + result['subtotal_' + obj].toFixed(2));
                        $('#tax_' + obj).text(result['tax_' + obj].toFixed(2));
                        $('#shipping_' + obj).text(result['shipping_' + obj].toFixed(2));


                        $('#coupons_' + obj).html("");
                        $('#coupons_' + obj).show();
                        if (typeof result.coupon != "undefined")
                        {
                            for (var i = 0; i < result.coupon.code.length; i++)
                            {
                                console.log(obj);
                                if (obj == result.coupon.id[i])
                                {
                                    $('#coupons_' + obj).append('<tr><td id="vedor_coupon_' + result.coupon.id[i] + '"><strong class="blue-txt">' + result.coupon.code[i] + '</strong><br>\n\
                                                <span>' + result.coupon.offer[i] + '</span> off from ' + result.coupon.store_name[i] + ' <br>\n\
                                            </td>\n\
                                            <td id="vedor_price_' + result.coupon.id[i] + '" class="ar"><a class="checkout-remove" onclick="addCoupon(' + result.coupon.id[i] + ')" href="javascript:void[0]"><i class="fa fa-remove"></i></a><br>\n\
                                                <strong class="blue-txt">-$<span class="off-price">' + result.coupon.deduct_amount[i] + '</span></strong></td></tr>');
                                }
                                if (1 == result.coupon.id[i])
                                {
                                    $('#coupons_' + obj).append('<tr><td id="vedor_coupon_' + result.coupon.id[i] + '"><strong class="blue-txt">' + result.coupon.code[i] + '</strong><br>\n\
                                                <span>' + result.coupon.offer[i] + '</span> off from ' + result.coupon.store_name[i] + ' <br>\n\
                                            </td>\n\
                                            <td id="vedor_price_' + result.coupon.id[i] + '" class="ar"><a class="checkout-remove" onclick="addCoupon(' + result.coupon.id[i] + ')" href="javascript:void[0]"><i class="fa fa-remove"></i></a><br>\n\
                                                <strong class="blue-txt">-$<span class="off-price">' + result.admin_discount + '</span></strong></td></tr>');
                                }
//                                if (obj == result.coupon.id[i] || 1 == result.coupon.id[i])
//                                {
//                                    $('#coupons_' + obj).append('<tr><td id="vedor_coupon_' + result.coupon.id[i] + '"><strong class="blue-txt">' + result.coupon.code[i] + '</strong><br>\n\
//                                                <span>' + result.coupon.offer[i] + '</span> off from ' + result.coupon.store_name[i] + ' <br>\n\
//                                            </td>\n\
//                                            <td id="vedor_price_' + result.coupon.id[i] + '" class="ar"><a class="checkout-remove" onclick="addCoupon(' + result.coupon.id[i] + ')" href="javascript:void[0]"><i class="fa fa-remove"></i></a><br>\n\
//                                                <strong class="blue-txt">-$<span class="off-price">' + (result.coupon.deduct_amount[i]) + '</span></strong></td></tr>');
//                                }

                            }
                            
                            $('#enter_coupon').hide();
                                $('#add_coupon').show();
                        }



                    })

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
@include('includes.footer')
@endsection