@extends('layouts.app')
@section('meta')
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
            
          </div>
          <div class="checkout-content">
              <div class="row" id="invoice">
              <div class="col-xs-12 col-md-10 col-md-offset-1">
                <div class="checkout-main checkout-04-main">
                  <h1>Thank you for your order!</h1>
                  <div class="row checkout-04-top-line">                  
                    <div class="col-xs-6">
                      <h4>Order Confirmation</h4>
                    </div>
                    <div class="col-xs-6 ar">
                        <p><a href="javascript:void(0)" onclick="printInvoice()"><strong class="red-txt">PRINT THIS PAGE</strong></a></p>
                    </div>
                  </div>
                  
                  <div class="box-shadow checkout-04-wrap checkout-04-top">
                    <div class="row">
                  	  <div class="col-xs-12 col-sm-4">
                        <table>
                          <tr>
                            <td width="60"><strong>Name</strong></td>
                            <td>{{$order->first_name}} {{$order->last_name}}</td>
                          </tr>
                          <tr>
                            <td><strong>Phone</strong></td>
                            <td>323 837 9484</td>
                          </tr>
                          <tr>
                            <td><strong>Email</strong></td>
                            <td>{{Auth::user()->email}}</td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-xs-12 col-sm-4">
                        <p><strong>Billing Address</strong>
                        {{$order->billing_name}}<br>
                        {{$order->billing_address_1}}<br>
                        {{$order->billingCity->name}} {{$order->billingState->name}} {{$order->billing_zip}}
                        </p>
                      </div>
                      <div class="col-xs-12 col-sm-4">
                        <p><strong>Shipping Address</strong>
                        {{$order->first_name}} {{$order->last_name}}<br>
                        {{$order->shipping_address_1}}<br>
                        {{$order->shippingCity->name}} {{$order->shippingState->name}} {{$order->shipping_zip}}
                        </p>
                      </div>
                    </div>
                  </div>
                  @foreach($order->orderVendor as $order_vendor)
                  <div class="box-shadow  checkout-04-wrap checkout-04-bottom">
                    <div class="row">
                      <div class="col-xs-12 col-sm-8">
                        <p>Purchased from <strong>{{$order_vendor->vendorName($order_vendor->vendor_id)}}</strong> on <strong>{{Carbon\Carbon::parse($order_vendor->created_at)->format('F d Y')}}</strong></p>
                      </div>
                      <div class="col-xs-12 col-sm-4 ar">
                        <p><strong>Order Number</strong> {{$order_vendor->id}}</p>
                      </div>
                    </div>
                    
                    <div class="checkout-04-line-top">
                    <div class="row">
                      <div class="col-xs-12 col-sm-3">
                        <h6>Product</h6>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <h6>Price</h6>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <h6>Size</h6>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <h6>Qty</h6>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <h6>Shipping</h6>
                      </div>
                      <div class="col-xs-12 col-sm-1 ar">
                        <h6>Subtotal</h6>
                      </div>
                    </div>
                    </div>
                      <input type="hidden" value="{{$subtotal=0}}">
                      @foreach($order_vendor->orderItems as $order_item)
                    <div class="checkout-04-line">
                    <div class="row">
                      <div class="col-xs-12 col-sm-3">
                        <p><strong class="upp">{{$order_item->product->name}}</strong><br>
						Stone Delicious IPA</p>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <p><strong><span class="mob-inline-show">Price: </span> ${{$order_item->productPrice($order_item->product->id)}}</strong></p>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <p><strong><span class="mob-inline-show">Size: </span>{{$order_item->product->size->name}} Pack</strong></p>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <p><strong><span class="mob-inline-show">Qty: </span>{{$order_item->product_quantity}}</strong></p>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                          <p><strong><span class="mob-inline-show">Shipping: </span>$<span class="shipping">{{$order_vendor->shipping}}</strong></p>
                      </div>
                      <div class="col-xs-12 col-sm-1 ar">
                        <p><strong><span class="mob-inline-show">Subtotal: </span>${{$order_item->productPrice($order_item->product->id) * $order_item->product_quantity}}</strong></p>
                        <input type="hidden" value="{{$subtotal+= $order_item->productPrice($order_item->product->id) * $order_item->product_quantity}}">
                      </div>
                    </div>
                    </div>
                      @endforeach
<!--                    <div class="checkout-04-line">
                    <div class="row">
                      <div class="col-xs-12 col-sm-3">
                        <p><strong class="upp">Stone Brewery</strong><br>
						Stone Delicious IPA</p>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <p><strong><span class="mob-inline-show">Price: </span> $24.99</strong></p>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <p><strong><span class="mob-inline-show">Size: </span>12 Pack</strong></p>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <p><strong><span class="mob-inline-show">Qty: </span>2</strong></p>
                      </div>
                      <div class="col-xs-12 col-sm-2">
                        <p><strong><span class="mob-inline-show">Shipping: </span>$10.00</strong></p>
                      </div>
                      <div class="col-xs-12 col-sm-1 ar">
                        <p><strong><span class="mob-inline-show">Subtotal: </span>$10.00</strong></p>
                      </div>
                    </div>
                    </div>-->
                    
                    <div class="checkout-04-line-bottom">
                      <div class="row">
                        <div class="col-xs-12 col-sm-6 col-sm-offset-6 col-md-4 col-md-4 col-md-offset-8">
                          <table>
                            <tr>
                              <td>Sub-Total</td>
                              <td class="ar"><strong>${{$subtotal}}</strong></td>
                            </tr>
                            <tr>
                              <td>Discount(s)</td>
                            <span style="display: none">
                                {{$deduct_amount=0}}
                                @foreach($order_vendor->orderCoupon as $order_coupon)
                                
                                  {{$deduct_amount += $order_coupon->deduct_amount}}  
                                
                                @endforeach
                            </span>
                              <td class="ar"><strong class="blue-txt">-${{$deduct_amount}}</strong></td>
                            </tr>
                            <tr>
                              <td>Shipping & Handling</td>
                              <td class="ar"><strong>${{$order->order_shipping_cost}}</strong></td>
                            </tr>
                            <tr>
                              <td>Tax</td>
                              <td class="ar"><strong>${{$order->order_tax}}</strong></td>
                            </tr>
                            <tr>
                              <td>Grand Total</td>
                              <td class="ar"><strong>${{$subtotal + $order->order_tax + $order->order_shipping_cost- $deduct_amount}}</strong></td>
                            </tr>
                          </table>
                        </div>
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
  </section>
@include('includes.footer')
@endsection
@section('footer')
<script>
    function printInvoice()
    {
        window.print($('#invoice').html());
    }
    </script>
@endsection