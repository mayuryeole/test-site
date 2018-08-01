@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
    <title>View Order Details</title>
@endsection

@section("content")
    <section class="h-inner-banner" style="background-image:url('{{ url("public/media/front/img/inner-banner.jpg") }}');">
        <div class="container relative">
            <div class="h-caption">
                <!-- <h3 class="h-inner-heading">Order Details</h3> -->
                <ul class="cust-breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>>></li>
                    <li>Order Details</li>
                </ul>
            </div>
        </div>
    </section>
    @if(isset($order) && count($order)>0)
        @php
            $orderObj = new App\PiplModules\cart\Controllers\OrderController();
           $currency =$orderObj->getCurrencyFromIso($order->payment_currency);
        @endphp
    <section class="h-ecard-page shipping-details-block">
        <div class="container">
            <div class="card-details order-order-detail">
                <div class="sender-receiver-details">
                    <div class="row">
                        <div class="col-md-9 col-sm-9 ">
                            <div class="address_wrapper">
                                <div class="row">
                                    <div class="col-md-5 col-sm-6">
                                        <div class="form-head">
                                            <h5>Order Details:</h5>
                                        </div>
                                        <div class="inner-address">
                                            <div class="row">
                                                <div class="col-md-4 col-sm-5 col-xs-5">
                                                    <p class="order-order-id">
                                                        Order ID:
                                                    </p>
                                                </div>
                                                <div class="col-md-8 col-sm-7 col-xs-7">
                                                    <p class="order-order-info">
                                                        @if(!empty($order->id)){{ $order->id }} @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-4 col-sm-5 col-xs-5">
                                                    <p class="order-order-id">
                                                        Order Date:
                                                    </p>
                                                </div>
                                                <div class="col-md-8 col-sm-7 col-xs-7">
                                                    <p class="order-order-info">
                                                      @if(!empty($order->created_at))  {{ $order->created_at }} @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-4 col-sm-5 col-xs-5">
                                                    <p class="order-order-id">
                                                        Total Amount:
                                                    </p>
                                                </div>
                                                <div class="col-md-8 col-sm-7 col-xs-7">
                                                    <p class="order-order-info">
                                                       @if(!empty($order->order_total)) {{ App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($order->order_total),2,'.','') }} @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-6">
                                        <div class="form-head">
                                            <h5>Address:</h5>
                                        </div>
                                        <div class="inner-address">
                                            <p class="order-add">@if(!empty($order->shipping_address1)) {{ $order->shipping_address1 }} @endif @if(!empty($order->shipping_city)){{','.$order->shipping_city }} @endif @if(!empty($order->shipping_state)){{ ','.$order->shipping_state}}@endif @if(!empty($order->shipping_country)) {{','.$order->shipping_country}} @endif @if(!empty($order->shipping_zip)){{ '('.$order->shipping_zip.')' }} @endif</p>
                                            <p><span class="order-phone">Phone:</span>@if(!empty($order->shipping_telephone)) {{ $order->shipping_telephone }} @endif</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="form-head">
                                <h5>Manage Order:</h5>
                            </div>
                            <div class="inner-address">
                                <p class="need-help"><a href="{{ route('htmltopdfview',['download'=>'pdf','order'=>$order->id]) }}"><span class="request-invoice"><i class="fa fa-file-pdf-o"></i></span>Invoice</a></p>
                                <p class="need-help"><a href="{{ url('contact-us') }}"><span class="request-invoice"><i class="fa fa-question-circle"></i></span> Need Help ?</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-details order-order-detail">
                <div class="sender-receiver-details">
                    <div class="row">
                        <div class="col-md-9 col-sm-9">
                            <div class="address_wrapper">
                                <div class="row">
                                    <div class="col-md-5 col-sm-4">
                                        <div class="inner-address">
                                            @if(isset($order->items))
                                             @foreach($order->items as $item)
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p class="order-order-item">
                                                        <img @if(!empty($item->product->productDescription->image)) src="{{ storage_path('public/product/image').$item->product->productDescription->image }}" @endif alt="image" class="img-responsive">
                                                    </p>
                                                </div>
                                                <div class="col-md-9">
                                                    <p class="pro-title order-order-desc">
                                                        <a href="http://parasfashions.com/product/75">@if(!empty($item->product->name)){{ $item->product->name }} @endif</a>
                                                    </p>
                                                    <p class="product-id">
                                                        <span>Product Id : @if(!empty($item->produc_id)){{ $item->produc_id }} @endif</span>
                                                    </p>
                                                    <p class="h-color">
                                                        <span>Color : @if(!empty($item->product->product_color_name)){{ $item->product->product_color_name }} @endif</span>
                                                    </p>
                                                    <p class="h-size">
                                                        <span>Size : @if(!empty($item->product->product_size_name)){{ $item->product->product_size_name }}@endif</span>
                                                    </p>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-8">
                                        <div class="order-status">
                                            <ul class="status-order">
                                                <li class="order-inner-status active">
                                                    <a href="javascript:void(0);">
                                                        <span>Ordered</span>
                                                        <span class="dot-circle"></span></a>
                                                </li>
                                                <li class="order-inner-status active">
                                                    <a href="javascript:void(0);">
                                                        <span>Packed</span>
                                                        <span class="dot-circle"></span></a>
                                                </li>
                                                <li class="order-inner-status ">
                                                    <a href="javascript:void(0);">
                                                        <span>Shipped</span>
                                                        <span class="dot-circle"></span></a>
                                                </li>
                                                <li class="order-inner-status ">
                                                    <a href="javascript:void(0);">
                                                        <span>Delivered</span>
                                                        <span class="dot-circle"></span></a>
                                                </li>
                                                <li class="order-inner-status ">
                                                    <a href="javascript:void(0);">
                                                        <span>Refunded</span>
                                                        <span class="dot-circle after-none"></span></a>
                                                </li>
                                            </ul>
                                            <div class="order-status-info">
                                                <div class="status-info-in" id="order-start">
                                                    <span>Your Order has been placed.</span>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                            <div class="order-time">
                                                                <p>Mon, 5th Mar <span class="order-full-time">5:30 am</span></p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                            <div class="order-status-complete">
                                                                <p>Seller has processed your order.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="appro-pay">
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <div class="order-time">
                                                                    <p>Mon, 5th Mar <span class="order-full-time">5:30 am</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <div class="order-status-complete">
                                                                    <p>Payment approved.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="inner-address">
                                <p class="need-help-rs">{{ App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($order->order_total),2,'.','') }}</p>
                                <p class="need-help"><a href="{{ url('contact-us') }}"><span class="request-invoice"><i class="fa fa-question-circle"></i></span> Need Help ?</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="refund-accept">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>REFUND ACCEPTED :<span class="refund-acc">   Lorem Ipsum is simply Lorem dummy text of the Lorem printing  Lorem Ipsum is simply Lorem dummy text of the Lorem printing .</span></h5>
                            </div>
                        </div>
                    </div>
                    <div class="order-price-total">
                        <div class="row">
                            <div class="col-md-12">
                                <h3><span class="price-total">Total</span> {{ App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($order->order_total),2,'.','') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection