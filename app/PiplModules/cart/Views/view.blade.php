@extends('layouts.app')
@section('meta')
<title>Profile</title>
@endsection
@section('content')
@if(Auth::user() && Auth::user()->userInformation->user_type=='2')
    @include('includes.header-login')
 @else
    @include('include.header')
 @endif
<section class="content">
    <div class="coming-soon-content">
        <div class="container-fluid">
            <div class="forgot-password-top">
                <div class="row">
                    <div class="col-xs-12 ac">
                        <h1>Shopping Cart</h1>
                    </div>
                </div>

            </div>
            <div class="checkout-content">
                <div class="row">
                    @if(isset($cart) && count($cart)>0)
                    <div class="col-xs-12 col-md-12">
                        <div class="box-shadow checkout-03-bottom">
                            <div class="checkout-03-bottom-title">
                                <div class="row">

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-5 col-md-5">
                                                <h5>Item</h5>
                                            </div>
                                            <div class="col-xs-12 col-sm-3 col-md-3">
                                                <h5>Quantity</h5>
                                            </div>
                                            <div class="col-xs-12 col-sm-2 col-md-2">
                                                <h5>Total</h5>
                                            </div>
                                            <div class="col-xs-12 col-sm-2 col-md-2 ar">
                                                <h5>Remove</h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{--<input type="hidden" value="{{$order_subtotal=0}}">--}}
                            {{--@if($vendor_ids && $cart && $cart->cartItems)--}}
                            {{--@foreach($vendor_ids as $vendor_id)--}}
                            {{--<input type="hidden" value="{{$specific_subtotal=0}}">--}}
                            {{--<input type="hidden" value="{{$vendor=0}}">--}}
                            <div class="checkout-03-bottom-line">

                                <div class="row">

                                    <div class="col-xs-12 col-sm-12">
                                        {{--<div class="row">--}}
                                            {{--<div class="col-xs-12">--}}
                                                {{--<h6>--}}
                                                    {{--@foreach($cart->cartItems as $cart_item)--}}
                                                    {{--@if($cart_item->product->created_by==$vendor_id && $vendor==0)--}}
                                                    {{--<input type="hidden" value="{{$vendor=1}}">--}}
                                                    {{--<img src="@if($cart_item->product->vendor->storeLogo) {{url('/storage/app/public/vendor-store-logo/'.$cart_item->product->vendor->id.'/'.$cart_item->product->vendor->storeLogo->store_logo)}} @else {{url('/public/media/front/images/no-image.png')}} @endif"> {{$cart_item->product->vendor->store_name}}--}}
                                                    {{--@endif--}}
                                                    {{--@endforeach--}}
                                                {{--</h6>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        @foreach($cart->cartItems as $cart_item)
                                        {{--@if($cart_item->product->created_by==$vendor_id)--}}
                                        <div class="row checkout-03-bottom-line-in">
                                            <div class="col-xs-12 col-sm-5 col-md-5">
                                                <h5 class="clears"><span>
                                                        <img style="width: 120px;height: 150px; float: left; padding-bottom: 10px" src="{{url('/storage/app/public/product/image/'.$cart_item->product->productDescription->image)}}">
                                                    </span><span style="width:10px;"></span>
                                                    <span style="float: right;" class="image_desp_here">{{$cart_item->product->name}}<br/>
                                                    <span style="float: right; margin-top:10px;" id="main_price_{{$cart_item->id}}">${{$cart_item->productPrice($cart_item->product_id)}}</span>
                                                    </span>
                                                </h5>
                                                <div class="item-details-action">
                                                    <a class=" add-to-wishlist" href="javascript:void(0);" title="Add this item to wishlist">
                                                        <i class="icon-wishlist"></i>
                                                        <span>Add to Wish List</span>
                                                    </a>
                                                </div>
                                                <button type="button" data-toggle="modal" onclick="showQuickView('{{ $cart_item->product_id }}')">Edit</button>

                                            </div>
                                            <div class="col-xs-6 mob-padding-right-0 col-sm-3 col-md-3">
                                                <div class="form-group">
                                                    {{--<div class="wan-spinner wan-spinner-1">--}}
                                                        {{--<a href="javascript:void(0)" class="minus" id="min_{{$cart_item->id}}" onclick="addRemoveProductQuantity(this.id.slice(4),'min')">-</a>--}}
                                                        {{--<input name="product_quantity" class="form-control input-sm" type="text" value="{{$cart_item->product_quantity}}" id="quantity_{{$cart_item->id}}" onchange="calSubtotal(this.id)">--}}
                                                        {{--<a href="javascript:void(0)" class="plus" id="add_{{$cart_item->id}}" onclick="addRemoveProductQuantity(this.id.slice(4),'add')">+</a>--}}
                                                    {{--</div>--}}

                                                </div>
                                            </div>

                                            <div class="col-xs-4 mob-ac col-sm-2 col-md-2">
                                                <p><strong>$<span id="subtotal_{{$cart_item->id}}">{{$cart_item->productPrice($cart_item->product_id) * $cart_item->product_quantity}}</span></strong></p>
                                            </div>
                                            <div class="col-xs-2 col-sm-2 col-md-2 ar">
                                                <h4 class="remove-h4"><a href="javascript:void(0)" id="{{$cart_item->id}}" onclick="removeCartItem(this.id)" title="remove cart item"><i class="fa fa-remove"></i></a></h4>
                                            </div>
                                            {{--<input type="hidden" value="{{$order_subtotal=$order_subtotal + ($cart_item->productPrice($cart_item->product_id) * $cart_item->product_quantity)}}">--}}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                {{--<input type="hidden" value="{{$specific_subtotal=$specific_subtotal+$order_subtotal}}" id="specific_subtotal_{{$vendor_id}}">--}}
                            </div>
                            {{--@endforeach--}}
                            {{--@else--}}
                            {{--<label class="alert alert-info col-md-12">No product(s) added yet!</label>--}}
                            {{--@endif--}}
                            </div>
                        </div>
                        @endif
                        {{--<div class="col-xs-12 col-md-4">--}}
                        {{--<div class="checkout-aside box-shadow">--}}
                            {{--<h4>Order Summary</h4>--}}
                            {{--<div class="">--}}
                                {{--<table class="table">--}}
                                    {{--<tr>--}}
                                        {{--<td>Subtotal</td>--}}
                                        {{--<td class="ar"><strong><span id="order_subtotal">{{$order_subtotal?'$'.$order_subtotal:''}}</span></strong></td>--}}
                                    {{--</tr>--}}
                                    {{--<tr style="display: none" id="enter_zip">--}}
                                         {{--<td class="" colspan="2">--}}
                                            {{--<table cellpadding="0" cellspacing="0" width="100%">--}}
                                                {{--<tr>--}}
                                                    {{--<td>--}}
                                                        {{--<form class="coupon-code-form">--}}
                                                            {{--<input class="form-control input-sm" type="text" placeholder="Enter Zip Code" name="zipcode" id="zipcode">--}}
                                                            {{--<input type="button" class="btn btn-sm btn-w-b" value="Apply" id="submit_zip">--}}
                                                        {{--</form>--}}
                                                    {{--</td>--}}
                                                    {{--<td width="30" class="ac"><a href="#"><i class="fa fa-remove red-txt"></i></a></td>--}}
                                                {{--</tr>--}}
                                            {{--</table>--}}


                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td>Shipping</td>--}}
                                        {{--<td class="ar"><strong><span id="shipping"></span></strong></td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td>Tax</td>--}}
                                        {{--<td class="ar"><strong><span id="tax"></span></strong></td>--}}
                                    {{--</tr>--}}
                                    {{--</table>--}}
                                    {{--<table class="table tt"  id="coupons">--}}
                                    {{----}}
                                    {{--</table>--}}
                                    {{--<table class="table tt">--}}
                                    {{--<tr id="enter_coupon" style="display: none">--}}
                                        {{--<td class="notop-border notop-padding" colspan="2">--}}
                                            {{--<form class="coupon-code-form">--}}
                                                {{--<input class="form-control input-sm" type="text" placeholder="Enter Coupon Code" id="coupon_code">--}}
                                                {{--<input type="button" class="btn btn-sm btn-w-b" value="Apply" id="apply_coupon" onclick="addCoupon()">--}}
                                                {{--<span class="text-danger" style="display: none" id="coupon_invalid">Invalid Coupon Code</span>--}}
                                            {{--</form>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td class="notop-border notop-padding" colspan="2">--}}
                                            {{--<a class="apply-coupon-code" href="javascript:void(0)" id="add_coupon">+ Apply Coupon Code</a>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td>Total</td>--}}
                                        {{--<td class="ar"><strong><span id="grand_total">{{$order_subtotal?'$'.$order_subtotal:''}}</span></strong></td>--}}
                                    {{--</tr>--}}
                                {{--</table>--}}
                            {{--</div>--}}
                            {{--<a class="btn btn-red" href="@if($vendor_ids && $cart && $cart->cartItems) {{url('/shipping-check-out')}} @else javascript::void(0) @endif"  onclick="return saveForm()">submit</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>


        </div>
    </div>
</section>
<div class="cust-modal manage-modal modal fade" id="h-quick-view">

</div>
@include('include.footer')
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
    function addRemoveProductQuantity(id, action)
    {
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
                //console.log(result);
                $('#cart_count').text(result.product_count);
                //addCoupon();
                for(var i=0; result[i]; i++)
                {
                    $('#quantity_'+result[i].id).val(result[i].quantity);
                    $('#show-product-count_'+result[i].id).text(result[i].subtotal);
                }
                window.location.href = window.location.href;

            }

        });
    }
</script>
{{--<script>--}}
    {{--function addRemoveProductQuantity(id, action)--}}
    {{--{--}}
        {{--$.ajax({--}}
            {{--url: '{{url("/add-remove-product-quantity")}}',--}}
            {{--type: "get",--}}
            {{--dataType:'json',--}}
            {{--data: {--}}
                {{--cart_item_id: id,--}}
                {{--action: action--}}
            {{--},--}}
            {{--success: function(result) {--}}
                {{--//            console.log(result);--}}
                {{--$('#cart_count').text(result.product_count);--}}
                {{--//addCoupon();--}}
                {{--for(var i=0; result[i]; i++)--}}
                {{--{--}}
                    {{--$('#quantity_'+result[i].id).val(result[i].quantity);--}}
                    {{--$('#subtotal_'+result[i].id).text(result[i].subtotal);--}}
                {{--}--}}


            {{--}--}}
        {{--});--}}
    {{--}--}}
{{--</script>--}}
<script>
    $(document).ready(function() {
        
        addCoupon();
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
            $.ajax({
            url: '{{url("/remove-cart-item")}}',
                    type: "get",
                    data: {
                    cart_item_id: id
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
@endsection