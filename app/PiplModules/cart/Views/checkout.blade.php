@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
    <title>Checkout</title>
@endsection
@section("content")
    <!---------------------------------------------------------All Cart Page--------------------------------------->
<section class="h-inner-banner" style="background-image:{{ url('public/media/front/img/inner-banner.jpg') }}">
        <div class="container relative">
            <div class="h-caption">
                <h3 class="h-inner-heading">Shipping Details</h3>
                <ul class="cust-breadcrumb">
                    <li><a href="javascript:void(0);">Home</a></li>
                    <li>>></li>
                    <li>Shipping Details</li>
                </ul>
            </div>
        </div>
</section>
<section class="h-ecard-page shipping-details-block">
        <div class="container-fluid">
            <div class="card-details">
                <h3 class="card-title"><span>Shipping Details Form</span></h3>
                <div class="sender-receiver-details">
                    <div class="row">
                        <div class="col-md-7">
                            @if(!\Auth::guest())
                            <div class="adderss_wrapper">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-head">
                                            <h5>Delivery Address:</h5>
                                            <a class="edit-addrs" href="javascript:void(0);" title="Delivery">
                                                <span>Edit Address</span>
                                            </a>
                                        </div>
                                        <div class="inner-address">
                                            <p class="buyer_name">Mr. David John</p>
                                            <p class="buyer_addrss">Hadapsar Pune-28,</p>
                                            <p class="buyer_city">Pune, Maharashtra 411028</p>
                                            <p class="buyer_country">India</p>
                                            <p class="buyer_phone">Phone Number: 9087654321</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-head">
                                            <h5>Delivery Option:</h5>
                                            <a class="edit-addrs" href="javascript:void(0);" title="Delivery">
                                                <span>Choose Another</span>
                                            </a>
                                        </div>
                                        <div class="inner-address">
                                            <p class="inter-del">India and International Delivery: <i class="fa fa-rupee"></i> 6.99</p>
                                            <p class="form-del-caption">(India up to 7 working days and International
                                                5-14 working days)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <form id="shipping-details-form" name="shipping-details-form" role="form" action="{{ url('proceed-shipping-details') }}" method="post" enctype="multipart/form-data" class="form-sender">
                                {!! csrf_field() !!}
                                <input type="hidden" id="ip_cart_id" name="ip_cart_id" @if(isset($cart) && count($cart)>0) value="{{ $cart->id }}" @endif>
                                <div class="form-head"><h5>Enter a Delivery Address:</h5></div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">Title :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-sel">
                                            <select id="name_initial" name="name_initial" class="form-control">
                                                <option value="">Please Select</option>
                                                <option  value="mr">Mr.</option>
                                                <option  value="mrs">Mrs.</option>
                                                <option  value="miss">Miss.</option>
                                                <option  value="ms">Ms.</option>
                                                <option  value="dr">Dr.</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">First Name :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input type="text" name="first_name" class="form-control" placeholder="First Name *"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">Last Name :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input type="text" name="last_name" class="form-control" placeholder="Last Name *" value="{{ old('first_name') }}"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">Email :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input id="email" type="email" name="email" class="form-control" placeholder="Email *"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">Confirm Email :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input type="email" name="confirm_email" class="form-control" placeholder="hancy@panacetek.com *"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <div class="h-cust-input">
                                            <div class="form-group categories-details-filter">
                                                <label class="custom-checkbox">I'd like to receive exclusive discounts and news from PARAS FASHIONS by email and post<input name="exclusive_discount" type="checkbox"><span class="checkmark"></span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">Country :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-sel">
                                            <select class="form-control" id="country" name="country">
                                                <option name="country" value="" label="Please Select" class="select-option" value="">Please Select</option>
                                                <option value="AL"  label="Albania" class="select-option" value="Albania">Albania</option>
                                                <option value="DZ"  label="Algeria" class="select-option" value="Albania">Algeria</option>
                                                <option value="AS"  label="American Samoa" class="select-option" value="Albania">American Samoa</option>
                                                <option value="AD"  label="Andorra" class="select-option" value="Albania">Andorra</option>
                                                <option value="AO"  label="Angola" class="select-option" value="Albania">Angola</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">House Number and Street :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input type="text" name="house_no" class="form-control" placeholder="House Number and Street *"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">Address Line 2 (optional) :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input type="text" name="address_line" class="form-control" placeholder="Address Line 2 (optional) *"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">City :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input type="text" name="city" class="form-control" placeholder="City *"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">State/Province :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <div class="h-cust-sel">
                                                <select class="form-control" id="region" name="region">
                                                    <option value=""  label="Please Select" class="select-option" value="">Please Select</option>
                                                    <option value="AL"  label="Albania" class="select-option" value="Maharashtra">Maharashtra</option>
                                                    <option value="DZ"  label="Algeria" class="select-option" value="Gujrat">Gujrat</option>
                                                    <option value="AS" label="American Samoa" class="select-option" value="MP">MP</option>
                                                    <option value="AD"  label="Andorra" class="select-option" value="UP">UP</option>
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
                                            <input type="text" name="postal_code" class="form-control" placeholder="Postal Code (optional) *"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label class="shipping-label">Phone Number :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="h-cust-input">
                                            <input type="tel" name="telephone" class="form-control" placeholder="Mobile No *"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <div class="h-cust-input">
                                            <div class="form-group categories-details-filter">
                                                <label class="custom-checkbox">Use this address for billing<input name="billing_address" type="checkbox"><span class="checkmark"></span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <div style="margin-left: 400px" class="h-cust-input">
                                            <input type="submit" class="h-update-cart" value="Add to Cart">
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="col-md-5">
                            <form class="form-sender">
                                <div class="form-head clearfix"><h5>Order Summary:</h5></div>
                                @if(isset($cart) && count($cart)>0)
                                    @foreach ($cart->cartItems as $items)
                                <div class="checkout-mini-cart clearfix">
                                @if(isset($items->product->productDescription->image) && $items->product->productDescription->image!='')
                            	<span class="mini-cart-span min-cart-image">
                                	<img style="width: 50px;height: 50px" src="{{ url('storage/app/public/product/image').'/'.$items->product->productDescription->image  }}" alt="image"/>
                                </span>
                                @endif
                                <span class="mini-cart-span mini-cart-content">
                                	<p class="min-pro-name"><span>Product Name:</span>&nbsp;&nbsp;@if(isset($items->product->name) && $items->product->name!=''){{ $items->product->name }} @else product name @endif </p>
                                    @if(isset($items->product_color_name) && $items->product_color_name!='')
                                    <p><span>Color:</span>&nbsp;&nbsp;{{ $items->product_color_name }}</p>
                                    @endif
                                    @if(isset($items->product->size) && $items->product->size!='')
                                    <p><span>UK Size:</span>&nbsp;&nbsp;{{ $items->product->size }}</p>
                                    @endif
                                    @if(isset($items->product_quantity) && $items->product_quantity!='')
                                    <p><span>Quantity:</span>&nbsp;&nbsp;@if(isset($items->product_quantity) && $items->product_quantity!=''){{ $items->product_quantity }} @else 0 @endif</p>
                                    @endif
                                </span>
                                <span class="mini-cart-span min-cart-price carts-price">
                                	<p><i class="fa fa-rupee"></i>&nbsp;&nbsp;{{ $items->product->productDescription->price * $items->product_quantity  }}</p>
                                </span>
                                </div>
                                  @endforeach
                                @endif
                                <div class="min-cart-total">
                                    <div class="select_paument_method">
                                        <div class="h-sel-pay-method clearfix">
                                            {{--<div class="col-md-6">--}}
                                                {{--<label class="h-title">Have a promo code?</label>--}}
                                                {{--<div class="h-promo-code">--}}
                                                    {{--<input type="text" class="form-control" placeholder="Enter Promo Code"/>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-6 text-right">--}}
                                                {{--<label class="h-title text-right">Payable Amount:</label>--}}
                                                {{--<div class="h-promo-code">--}}
                                                    {{--<span><i class="fa fa-rupee"></i>{{ $totalAmount }}</span>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            <div class="col-md-12 text-center clearfix" style="margin-top:10px;">
                                                <label class="pull-left">Order Total</label>
                                                <label class="pull-right"><i class="fa fa-rupee">{{ $totalAmount }}</i></label>
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
</section>
            {{--<div class="select_paument_method shipping-cart">--}}
                {{--<!--<a href="javascript:void(0);">Proceed</a>-->--}}
                {{--<input type="button" class="h-update-cart" value="All Add to Cart">--}}
            {{--</div>--}}
        {{--</div>--}}
    <!---------------------------------------------------------End All product category page----------------------------------->
@endsection