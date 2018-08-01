@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
    <title>View Order</title>
@endsection

@section("content")
<script>alert('122');</script>
    <section class="h-inner-banner" style="background-image:url('{{ url("public/media/front/img/inner-banner.jpg") }}');">
        <div class="container relative">
            <div class="h-caption">
                <!-- <h3 class="h-inner-heading">My Order</h3> -->
                <ul class="cust-breadcrumb">
                    <li><a href="javascript:void(0);">Home</a></li>
                    <li>>></li>
                    <li>My Order</li>
                </ul>
            </div>
        </div>
    </section>
    <section class="h-ecard-page shipping-details-block">
        <div class="container">
            <div class="card-details">
                <div class="sender-receiver-details my-orders">
                    @if(isset($order) && count($order)>0)
                    <div class="row">
                        <div class="my-order-holder">
                            <div class="my-orders-head">
                                <div class="row">
                                    <div class="col-md-8 col-sm-6">
                                        <div class="order-id-head">
                                            <h3><a href="javascript:void(0);">{{ $order->master_tracking_number }}</a></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="my-order-btns">
                                            <button type="button" class="nd-hlp"><span class="reqst-invoic"><i class="fa fa-question-circle"></i></span> Need Help ?</button>
                                            <button type="button" data-toggle="modal" data-target="#" class="nd-hlp"><span class="reqst-invoic"><i class="fa fa-map-marker"></i></span> harshads Track</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="oredr-product-inf">
                                @if(isset($order->orderItems))
                                @foreach($order->orderItems as $item)
                                    @php
                                        $orderObj = new App\PiplModules\cart\Controllers\OrderController();
                                       $currency =$orderObj->getCurrencyFromIso($order->payment_currency);
                                    @endphp
                                <div class="row">
                                    <div class="col-md-2 col-sm-2">
                                        <div class="product-order-img">
                                            <img src="{{ url('storage/app/public/product/image').'/'.$item->product->productDescription->image }}" alt="image" class="img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="product-order-dtl">
                                            <p class="pro-title order-order-descs">
                                                <a href="javascript:void(0);">
                                                    {{ $item->product->name }}
                                                </a>
                                            </p>
                                            <p class="product-ids">
                                                <span>Product Id : {{ $item->product->productDescription->sku }}</span>
                                            </p>
                                            <p class="h-colors">
                                                <span>Color : {{ $item->product_color_name }} </span>
                                            </p>
                                            <p class="h-sizes">
                                                <span>Size : {{ $item->product_size_name }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <p class="pro-title order-order-descs">
                                            {{ $currency.$item->product_amount * $item->product_quantity  }}</p>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <p class="pro-title order-order-descs">
                                            Return Requested
                                        </p>
                                        <p class="product-ids">
                                            <span>Your request for return is being processed</span>
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <div class="holder-detail-refund">
                                    <div class="refund-head-sec">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <h4> Refund status</h4>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <h4><a href="{{ url('view-order-details-front').'/'.$order->id }}" class="my-order-view">View Details</a></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="refund-bnk-detail">
                                                <p>Refund To: Bank Account</p>
                                                <p>Refund ID: 117999119</p>
                                                <p class="comp-refund"><a href="javascript:void(0);">Completed</a></p>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                            <p class="pro-title order-order-descs refn-rs"> {{ App\Helpers\Helper::getCurrencySymbol().round(\App\Helpers\Helper::getRealPrice($order->order_total),4) }}</p>
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <p class="pro-title refun-dl">₹954.0 as refund will be transferred to your
                                                Bank Account within 1 business day (Bank holidays not included).For further
                                                details, please contact your bank with reference number +91 7865432190.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="on-order">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <p class="order-txt">Ordered On <span class="on-order-dark"> {{ $order->created_at }}</span></p>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <p class="order-txt t-ordr">Order Total<span class="on-order-dark"> {{ App\Helpers\Helper::getCurrencySymbol().round(\App\Helpers\Helper::getRealPrice($order->order_total),4) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
<div class="cust-modal modal fade" id="tracking-order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="mod-head">Track Order</div>
      <div class="modal-header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button">
            <span aria-hidden="true"><img alt="close" src="http://192.168.2.26/p1116/public/media/front/img/cancel.png"></span>
        </button>
      </div>
      <div class="modal-body">
        <div class="promo-code-btn relative">       
            <input type="text" placeholder="" class="form-control">
            <div class="promo-btn"><a  href="javascript:void(0);">Apply Code </a></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection