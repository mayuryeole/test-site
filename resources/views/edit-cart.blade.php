@php
    $cart = \App\PiplModules\cart\Models\Cart::where('id',$cartItem->cart_id)->first();
@endphp
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="{{ url('public/media/front/img/cancel.png') }}" alt="close"></span></button>
        </div>
        {{--<form id="update-cart-modal" action="{{ url('update-product-to-cart') }}" method="post" type="form">--}}
        {{--{!!  //csrf_field() !!}--}}
        <input type="hidden" id="ip-cart-id" @if(isset($cart) && count($cart)>0) value="{{ $cart->id }}" @endif>
        <input type="hidden" id="ip-cart-item-id" @if(isset($cartItem) && count($cartItem)>0) value="{{ $cartItem->id }}" @endif >
        <div class="modal-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="gal-img">
                        <div class="cust-detail-slide">
                            <div id="carousel" class="carousel slide propertySlider" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <img src="{{ url('storage/app/public/product/image/') }}/{{$ajaxProduct[0]['image']}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="h-product-details">
                        <div class="h-product-heading"><h2 class="h-section-title">{{ $ajaxProduct[0]['name'] }}</h2></div>
                        <div class="h-product-rating">
                            <span><i class="fa fa-star"></i></span>
                            <span><i class="fa fa-star"></i></span>
                            <span><i class="fa fa-star"></i></span>
                            <span><i class="fa fa-star"></i></span>
                            <span><i class="fa fa-star"></i></span>
                            <div class="h-product-review">Be the first to review this product</div>
                        </div>
                        <div class="h-price">
                            @if($ajaxProduct[0]['is_original'] == 1)
                                <b> {{ $ajaxProduct[0]['discount_rate'] }}</b>
                                <b>${!! $ajaxProduct[0]['price'] !!} </b>
                                <b> {{ $ajaxProduct[0]['discount_percent'] }}</b>
                            @else
                                <b> ${{ $ajaxProduct[0]['price'] }} </b>
                            @endif
                        </div>
                        <div class="h-product-availability">
                            <ul class="h-stock-detail">
                                <!-- <li>
                                    <i class="fa fa-stack-exchange"></i>
                                    <span>Only 15 Left</span>
                                </li> -->
                                <li>
                                    <span class="h-prod-status">Available:</span>
                                    <span class="h-green">
                                            @if($ajaxProduct[0]['availability'] == 1)
                                            {{ "Out Of Stock" }}
                                        @else
                                            {{ "In Stock" }}
                                        @endif
                                        </span>
                                </li>
                            </ul>
                        </div>
                        <div class="h-product-description">
                            <p>{{ $ajaxProduct[0]['long_description'] }}</p>
                        </div>
                        <div class="product-options">
                            @if(isset($ajaxProduct[0]['colors']))
                                <div class="color-optn font-2">
                                    <label> <span class="option"> Color </span> <span class="red-color"></span></label>
                                    <ul class="list-unstyled">
                                        @if(isset($ajaxProduct[0]['colors']))
                                            @foreach($ajaxProduct[0]['colors'] as $c)
                                                {{--<p style="">{{$c->color}} </p>--}}
                                                @if(isset($c->color) && $c->color!=null)
                                                    <li><img title="{{ $c->color }}" id="{{ $c->color }}" rel="{{ $cartItem->id }}" onclick="changeColor(this.id)" src="{{ url('public/media/front/color/'.$c->color.'.jpg')}}" alt=""></li>
                                                @endif
                                            @endforeach
                                            <label style="margin-top: 10px;display: inline-block">Product Color:<span id="currentColor" style="display: inline;padding-left: 5px">@if(isset($cartItem->product_color_name) && $cartItem->product_color_name!=''){{ $cartItem->product_color_name }}@endif</span></label>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            @if(isset($ajaxProduct['attribute_name']))
                                <div class="size-optn font-2">
                                    <label> <span class="option"> SIZE OPTIONS </span> </label>
                                    <ul class="list-inline">
                                        <?php
                                        for($i=0;$i<count($ajaxProduct['attribute_name']);$i++){
                                        ?>
                                        @if($ajaxProduct['attribute_name'][$i] == 'gross weight')
                                            <p style=""> {{ $ajaxProduct['attribute_name'][$i] }} : {{ $ajaxProduct['attribute_value'][$i] }}</p>
                                        @endif
                                        <?php }
                                        ?>
                                    </ul>
                                </div>
                            @endif

                        </div>
                        <div class="h-product-buttons clearfix">
                            <div class="h-quantity">
                                <button id="minus-quick-cnt-btn_{{ $cartItem->id }}" type="button" onclick="addQuickRemoveProductQuantity(this.id,'min')" class="h-minus-pro"></button>
                                <input id="show-quick-product-count_{{ $cartItem->id }}" name="product_qty" type="text" class="form-control" @if(isset($cartItem) && $cartItem->product_quantity !=0)value='{{ $cartItem->product_quantity }}'@endif disabled />
                                <button id="add-quick-cnt-btn_{{ $cartItem->id }}" type="button" onclick="addQuickRemoveProductQuantity(this.id,'add')" class="h-plus-pro"></button>
                                <span style="display: none;color: red" id="add-quick-minus-status_{{ $cartItem->id }}"></span>
                                {{--@if(isset($cartItem) && count($cartItem)>0)--}}
                                {{--<a href="javascript:void(0)" class="icon-substract" id="min_{{$cartItem->id}}">-</a>--}}
                                {{--<input name="product_quantity" class="form-control input-sm" type="text" value="{{$cartItem->product_quantity}}" id="quantity_{{$cartItem->id}}">--}}
                                {{--<a href="javascript:void(0)" class="icon-add" id="add_{{$cartItem->id}}">+</a>--}}
                                {{--@elseif--}}
                            </div>
                            <div class="h-add-cart">
                                <button href="{{ url('/cart') }}" data-dismiss="modal" id="add-in-cart" rel="{{ $ajaxProduct[0]['id'] }}" class="h-cart-btn" type="button">Go to Cart </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--</form>--}}
    </div>
</div>
<script>
    function addQuickToCart(id)
    {   var quantity = 1;
        var prod = $('#'+id).attr('rel');
        var product_id = prod;
        $.ajax({
            url: '{{  url('/add-product-to-cart') }}',
            type: "get",
            dataType: 'json',
            data: {
                product_id: product_id,
                quantity: quantity
            },
            success: function(response) {
                if (response.success == "1")
                {
                    window.location.href = window.location.href;
                }
                else{
                    alert(response.msg);return;
                }

            }
        });
    }

</script>
<script>
    function changeColor(id) {
        var  cartItemId=$("#"+id).attr('rel');
        var color = id;

        $.ajax({
            url: '{{url("/change-cart-product-color")}}',
            type: "get",
            dataType:'json',
            data: {
                cart_item_id: cartItemId,
                color:color
            },
            success: function(result) {
                if(result.success == 1){
                    $('#currentColor').html(color);
                }
                else{
                    alert(result.msg);return;
                }

            }

        });

    }
</script>
{{--<script>--}}
{{--function updateQuickToCart(id)--}}
{{--{   var quantity = 1;--}}
{{--var prod = $('#'+id).attr('rel');--}}
{{--var product_id = prod;--}}
{{--$.ajax({--}}
{{--url: '{{  url('/add-product-to-cart') }}',--}}
{{--type: "get",--}}
{{--dataType: 'json',--}}
{{--data: {--}}
{{--product_id: product_id,--}}
{{--quantity: quantity--}}
{{--},--}}
{{--success: function(response) {--}}
{{--if (response.success == "1")--}}
{{--{--}}
{{--window.location.href = window.location.href;--}}
{{--}--}}
{{--else{--}}
{{--alert(response.msg);return;--}}
{{--}--}}

{{--}--}}
{{--});--}}
{{--}--}}

{{--</script>--}}
<script>
    //  var totalAmt=new Object();
    function addQuickRemoveProductQuantity(id, action)
    {
        //alert(id + "@@@@" + action);return;
        cartItemId = id.split('_').pop();
        $.ajax({
            url: '{{url("/add-remove-product-quantity")}}',
            type: "get",
            dataType:'json',
            data: {
                cart_item_id: cartItemId,
                action: action
            },
            // success: function(result) {
            //     //console.log(result);
            //    //totalAmt=result;
            //     $('#cart_count').text(result.product_count);
            //     //addCoupon();
            //     for(var i=0; result[i]; i++)
            //      {
            //
            //         $('#show-quick-product-count_'+result[i].id).val(result[i].quantity);
            //         $('#show-quick-product-count_'+result[i].id).text(result[i].subtotal);
            //      }
            //    // window.location.href = window.location.href;
            //    // console.log(totalAmt);
            //
            // }
            success: function(result) {

                // console.log(result.msg['1'].id);
                // console.log(JSON.stringify(result.msg));return;
                //            console.log(result.msg);return;
                if(result.success == 1){
                    $('#add-quick-minus-status_'+cartItemId).hide();
                    //var jsonObj =JSON.stringify(result.msg);

                    //alert(jsonObj);return;
                    $('#cart_count').text(result.msg['product_count']);
                    //addCoupon();
                    for(var i=0; result.msg[i]; i++)
                    {
                        $('#show-quick-product-count_'+result.msg[i].id).val(result.msg[i].quantity);
                        $('#show-quick-product-count_'+result.msg[i].id).html(result.msg[i].subtotal);
                        $('#show-product-count_'+result.msg[i].id).val(result.msg[i].quantity);
                        $('#show-product-count_'+result.msg[i].id).html(result.msg[i].subtotal);
                        totalAmt +=result.msg[i].subtotal;
                    }
                    // $('#all-sub-total').html(totalAmt);
                    // $('#all-total').html(totalAmt);

                    // window.location.href = window.location.href;
                }
                else{
                    $('#add-quick-minus-status_'+cartItemId).show();
                    $('#add-quick-minus-status_'+cartItemId).html(result.msg);
                }

            }

        });
    }
</script>