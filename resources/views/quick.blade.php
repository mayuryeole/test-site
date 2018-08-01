@php
    //dd($ajaxProduct[0]['product_color_images']);
         if(isset($cartItem) && $cartItem !=''){
          $cart = \App\PiplModules\cart\Models\Cart::where('id',$cartItem->cart_id)->first();
         }
      $userType='';
       if (Auth::check()) {

              $userType = \Auth::user()->userInformation->user_type;
          }
@endphp
@php $imgCnt=0; @endphp
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img
                            src="{{ url('public/media/front/img/cancel.png') }}" alt="close"></span></button>
        </div>
        @if(isset($cart)&& count($cart)>0)
            <form id="update-cart-modal" action="{{ url('update-product-to-cart-form') }}" method="post" type="form">
                <input type="hidden" id="ip-cart-id" @if(isset($cart) && count($cart)>0) value="{{ $cart->id }}" @endif>
                <input type="hidden" id="ip-cart-item-id"
                       @if(isset($cartItem) && count($cartItem)>0) value="{{ $cartItem->id }}" @endif >
                @else
                    <form id="add-to-cart-modal" action="{{ url('add-product-to-cart-form') }}" method="post"
                          type="form" onsubmit=" return validateForm()">
                        @endif
                        {!!  csrf_field() !!}
                        <input type="hidden" id="id-product-id" name="product_id" value=" {{ $ajaxProduct[0]['id'] }}">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <div class="gal-img">
                                        <div class="cust-detail-slide">
                                            <div id="carousel" class="carousel slide propertySlider"
                                                 data-ride="carousel">
                                                <div class="carousel-inner">
                                                    {{--@if(!empty($ajaxProduct[0]['image']))--}}
                                                    {{--<div @if(!empty($ajaxProduct[0]['product_color'])) id="dv-car-col-img-id-{{ trim($ajaxProduct[0]['product_color']) }}" @endif class="item active car-col-img-dv">--}}
                                                    {{--<img src="{{ url('storage/app/public/product/image/') }}/{{$ajaxProduct[0]['image']}}">--}}
                                                    {{--<div class="zoom-icon">--}}
                                                    {{--<a href="{{ url('storage/app/public/product/image/') }}/{{$ajaxProduct[0]['image']}}" class="swipebox" title="Product View">--}}
                                                    {{--<i class="fa fa-arrows-alt"></i>--}}
                                                    {{--</a>--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--@endif--}}
                                                    @php $actCnt =0; @endphp
                                                    @php $actCnt1 =0; @endphp
                                                    @if(isset($ajaxProduct[$actCnt]['product_color_images']) && count($ajaxProduct[$actCnt]['product_color_images'])>0)
                                                        @foreach($ajaxProduct[$actCnt]['product_color_images'] as $c)
                                                            @if(isset($c) && count($c)>0)
                                                                @foreach($c as $cImgs)
                                                                    @if(!empty($cImgs))
                                                                        <div id="dv-car-col-img-id-{{ $cImgs->product_image_id.'-'.$actCnt1 }}"
                                                                             class="item all-car-col-img-dv car-col-img-dv-{{ $cImgs->product_image_id }} @if($actCnt1 == 0) active @endif ">
                                                                            <img src="{{ url('storage/app/public/product/product_images/') }}/{{ $cImgs->image  }}">
                                                                            <div class="zoom-icon">
                                                                                <a href="{{ url('storage/app/public/product/product_images/') }}/{{ $cImgs->image }}"
                                                                                   class="swipebox"
                                                                                   title="Product View">
                                                                                    <i class="fa fa-arrows-alt"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        @php $actCnt1 ++; @endphp
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            @php $actCnt++; @endphp
                                                        @endforeach
                                                    @else
                                                        @if(!empty($ajaxProduct[0]['image']))
                                                            <div @if(!empty($ajaxProduct[0]['product_color'])) id="dv-car-col-img-id-{{ trim($ajaxProduct[0]['product_color']) }}"
                                                                 @endif class="item active car-col-img-dv">
                                                                <img src="{{ url('storage/app/public/product/image/') }}/{{$ajaxProduct[0]['image']}}">
                                                                <div class="zoom-icon">
                                                                    <a href="{{ url('storage/app/public/product/image/') }}/{{$ajaxProduct[0]['image']}}"
                                                                       class="swipebox" title="Product View">
                                                                        <i class="fa fa-arrows-alt"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <div id="thumbcarousel" class="carousel slide propertySliderThumb"
                                                     data-interval="false">
                                                    <div class="carousel-inner">
                                                        <div class="item active">
                                                            {{--@if(!empty($ajaxProduct[0]['image']))--}}
                                                            {{--<div data-target="#carousel" data-slide-to="{{ $imgCnt }}" class="thumb"><img src="{{ url('storage/app/public/product/image') }}/{{ $ajaxProduct[0]['image']  }}"></div>--}}
                                                            {{--@php $imgCnt++; @endphp--}}
                                                            {{--@endif--}}
                                                            {{--@if(isset($ajaxProduct[0]['product_color_images']) && count($ajaxProduct[0]['product_color_images'])>0)--}}
                                                            {{--@foreach($ajaxProduct[0]['product_color_images'] as $c)--}}
                                                            {{--@if(isset($c->image) && !empty($c->image))--}}
                                                            {{--<div data-target="#carousel" data-slide-to="{{ $imgCnt }}" class="thumb"><img src="{{ url('storage/app/public/product/product_images') }}/{{ $c->image  }}"></div>--}}
                                                            {{--@php $imgCnt++; @endphp--}}
                                                            {{--@endif--}}
                                                            {{--@endforeach--}}
                                                            {{--@endif--}}
                                                            @php $actCnt =0; @endphp
                                                            @php $actCnt1 =0; @endphp
                                                            @if(isset($ajaxProduct[$actCnt]['product_color_images']) && count($ajaxProduct[$actCnt]['product_color_images'])>0)
                                                                @foreach($ajaxProduct[$actCnt]['product_color_images'] as $c)
                                                                    @if(isset($c) && count($c)>0)
                                                                        @foreach($c as $cImgs)
                                                                            @if(!empty($cImgs))
                                                                                <div onclick="changeviewImg(this.id)"
                                                                                     @if($actCnt > 0) style="display:none;"
                                                                                     @endif id="t-col-img-{{ $cImgs->product_image_id.'-'.$actCnt1 }}"
                                                                                     data-target="#carousel"
                                                                                     data-slide-to="{{ $actCnt1 }}"
                                                                                     class="thumb t-col-img-{{ $cImgs->product_image_id }} all-t-col-img">
                                                                                    <img src="{{ url('storage/app/public/product/product_images') }}/{{ $cImgs->image  }}">
                                                                                </div>
                                                                                @php $actCnt1 ++; @endphp
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                    @php $actCnt++; @endphp
                                                                @endforeach
                                                            @else
                                                                @php $imgCnt=0; @endphp
                                                                @if(!empty($ajaxProduct[0]['image']))
                                                                    <div data-target="#carousel"
                                                                         data-slide-to="{{ $imgCnt }}" class="thumb">
                                                                        <img src="{{ url('storage/app/public/product/image') }}/{{ $ajaxProduct[0]['image']  }}">
                                                                    </div>
                                                                    @php $imgCnt++; @endphp
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div id="pre-nxt-caro" style="display: none">
                                                        <a class="left carousel-control" href="#thumbcarousel"
                                                           role="button" data-slide="prev">
                                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                                        </a>
                                                        <a class="right carousel-control" href="#thumbcarousel"
                                                           role="button" data-slide="next">
                                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-7 col-xs-12"><br>
                                    <div class="h-product-details">
                                        <div class="h-product-heading"><h2
                                                    class="h-section-title">{{ $ajaxProduct[0]['name'] }}</h2></div>
                                        <div class="h-product-rating">
                                            <span><i class="fa fa-star-o"></i></span>
                                            <span><i class="fa fa-star-o"></i></span>
                                            <span><i class="fa fa-star-o"></i></span>
                                            <span><i class="fa fa-star-o"></i></span>
                                            <span><i class="fa fa-star-o"></i></span>
                                            <div class="h-product-review">Be the first to review this product</div>
                                        </div>
                                        <div class="h-price">
                                            @if($ajaxProduct[0]['is_original'] == 1)
                                                <b id="prod-dis-rate"> {{ $ajaxProduct[0]['discount_rate'] }}</b>
                                                <b id="prod-price"> {!! $ajaxProduct[0]['price'] !!} </b>
                                                <b id="prod-dis-per"> {{ $ajaxProduct[0]['discount_percent'] }}</b>
                                                <input type="hidden" id="price"
                                                       value="{{ $ajaxProduct[0]['discount_rate'] }}">
                                            @elseif($ajaxProduct[0]['is_original'] == 0)
                                                <b id="prod-dis-rate"> {{ $ajaxProduct[0]['price'] }} </b>
                                            @elseif($ajaxProduct[0]['is_original'] == 2)
                                                <b id="prod-dis-rate"> Request For Rate </b>
                                            @endif
                                        </div>
                                        <div class="h-product-availability">
                                            <ul class="h-stock-detail">
                                                <a href="{{ url('product').'/'. $ajaxProduct[0]['id'] }}">See full
                                                    product details</a>
                                                <li>
                                                    <span class="h-prod-status">Available:</span>
                                                    @if($ajaxProduct[0]['availability'] == 1)
                                                        <span class="h-red">
                                            
                                            <input type="hidden" name="available" id="available" value="1">

                                                            {{ "Out Of Stock" }}
											</span>
                                                    @else
                                                        <span class="h-green">
                                        
                                            <input type="hidden" name="available" id="available" value="0">

                                                            {{ "In Stock" }}
											</span>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="h-product-description">
                                            <p>{{ $ajaxProduct[0]['long_description'] }}</p>
                                        </div>
                                        <div class="product-options">
                                            @php $prodColCnt=0;  @endphp
                                            @if(!empty($ajaxProduct[0]['product_images']))
                                                <div class="color-optn font-2">
                                                    <label> <span class="option"> Color </span> <span
                                                                class="red-color"></span></label>
                                                    <ul class="list-unstyled">
                                                        @if(isset($ajaxProduct[0]['product_images']) && count($ajaxProduct[0]['product_images'])>0)
                                                            @foreach($ajaxProduct[0]['product_images'] as $c)
                                                                @if(!empty($c->color))
                                                                    <li class="pro-color-apply @if($prodColCnt==0) active @endif">
                                                                        <img id="color-{{ $c->id }}"
                                                                             title="{{ strtolower($c->color) }}"
                                                                             onclick="changeColor(this.id)"
                                                                             src="{{ url('public/media/front/color/'.strtolower($c->color).'.jpg')}}"
                                                                             alt="{{ strtolower($c->color) }}"></li>
                                                                @endif
                                                                @php $prodColCnt++;  @endphp
                                                                <script>
                                                                    $('#color-name').val('@php echo strtolower($c->color); @endphp');
                                                                </script>
                                                            @endforeach
                                                            <label style="margin-top: 10px;display: none">Product Color:<span
                                                                        id="currentColor"
                                                                        style="display: inline;padding-left: 5px"></span></label>
                                                        @else
                                                            @if(isset($ajaxProduct[0]['product_color']) && $ajaxProduct[0]['product_color']!='')
                                                            <li class="pro-color-apply"><img id="color-{{ $ajaxProduct[0]['id'] }}" title="{{ strtolower($ajaxProduct[0]['product_color']) }}" onclick="changeColor(this.id)" src="{{ url('public/media/front/color/'.strtolower($ajaxProduct[0]['product_color']).'.jpg')}}" alt="{{ strtolower($ajaxProduct[0]['product_color']) }}"></li>
                                                            @endif
                                                        @endif
                                                        <input id="color-name" name="color_name" type="hidden"/>
                                                    </ul>
                                                </div>
                                            @endif

                                            @if(isset($ajaxProduct['attribute_name']) && count($ajaxProduct['attribute_name'])>0)

                                                <div class="size-optn font-2">

                                                    <label> <span style="display: none" id="spn-size-lbl"
                                                                  class="option"> SIZE OPTIONS </span> </label>
                                                    <a href="#" data-target="#h-cust-modal-size" data-toggle="modal">SIZE
                                                        GUIDE</a>
                                                    <ul class="list-inline">

                                                        <?php $chkSize = 0; for($i = 0;$i < count($ajaxProduct['attribute_name']);$i++){ ?>

                                                        <?php  if($ajaxProduct['attribute_name'][$i] == 'Size') { $chkSize++; ?>
                                                        <?php   if(!empty($ajaxProduct['attribute_value'][$i])) { ?>
                                                        <li class="pro-size-apply"><span class="eff" id="size-{{ $i }}"
                                                                                         onclick="changeSizeProperties(this.id)"
                                                                                         rel="{{ $ajaxProduct['attribute_value'][$i] }}"
                                                                                         title="Select Size:{{ $ajaxProduct['attribute_value'][$i] }}">{{ $ajaxProduct['attribute_value'][$i] }}</span>
                                                        </li>
                                                        <?php } ?>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                    <input id="size-name" name="size_name" type="hidden"/>
                                                    <input id="chk-size" value="{{ $chkSize }}" type="hidden"/>
                                                </div>
                                            @endif
                                            <div style="display: none;color: orange;" id="error-msg"></div>
                                        </div>
                                        <div class="h-product-buttons quick-view-counter clearfix">
                                            <div class="h-quantity">
                                                <button id="minus-quick-cnt-btn" type="button"
                                                        onclick="minusQuickCount()" class="h-minus-pro"><i
                                                            class="icon-substract"></i></button>
                                                <input id="show-quick-product-count" name="product_qty" type="text"
                                                       class="form-control"
                                                       @if(isset($cartItem) && $cartItem->product_quantity !=0)value='{{ $cartItem->product_quantity }}'
                                                       @else value='1' @endif disabled/>
                                                <button id="add-quick-cnt-btn" type="button" onclick="addQuickCount()"
                                                        class="h-plus-pro"><i class="icon-add"></i></button>

                                                <input type="hidden" id="ip-prod-count" name="ip_prod_count"
                                                       @if(isset($cartItem) && $cartItem->product_quantity !=0)value='{{ $cartItem->product_quantity }}'
                                                       @else value='1' @endif>
                                            </div>
                                            <div class="h-add-cart-h text-center">
                                                @if($ajaxProduct[0]['is_original'] != 2)
                                                    @if(isset($cartItem) && count($cartItem)>0)

                                                        <button id="update-in-cart" class="add-cart" type="submit"><i
                                                                    class="fa fa-shopping-bag"></i> Buy Now</button>
                                                    @else
                                                        <button id="add-in-cart" class="add-cart" type="submit"><i
                                                                    class="fa fa-shopping-bag"></i> Buy Now</button>
                                                    @endif
                                                    @if(Auth::check())
                                                        <button id="add-wishlist-{{ $ajaxProduct[0]['id'] }}"
                                                                data-toggle="modal"
                                                                onclick="addToWishlist('{{ $ajaxProduct[0]['id'] }}')"
                                                                type="button" class="add-cart-data"><i
                                                                    class="fa fa-heart"></i> Wishlist
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div style="display: none;color: orange" id="add-quick-minus-status"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input id="max-order-qty" type="hidden" value="{{  $ajaxProduct[0]['max_order_qty'] }}">
                        <input id="max-qty" type="hidden" value="{{  $ajaxProduct[0]['quantity'] }}">
                        <input id="user-type" type="hidden" value="{{  $userType }}">
                    </form>
            </form>
    </div>
</div>
<script>
    $(function () {
        if ($("#chk-size").val() > "0") {
            $("#spn-size-lbl").show();
        }
    });
</script>
<script>
    function updateQuickToCart(id) {   //alert(id);return;
        var quantity = 0;
        var countId = id.split('_').pop();
        //alert(countId);return;
        var prod = $('#' + id).attr('rel');
        var product_id = prod;
        quantity = $('#show-quick-product-count_' + countId).val();
        //alert(quantity);return;
        $.ajax({
            url: '{{  url('/update-product-to-cart') }}',
            type: "get",
            dataType: 'json',
            data: {
                product_id: product_id,
                quantity: quantity
            },
            success: function (response) {
                if (response.success == "1") {
                    console.log(response.msg);
                    return;
                    window.location.href = window.location.href;
                }
                else {
                    console.log(response.msg);
                    return;
                }

            }
        });
    }

</script>
<script>
    function changeviewImg(id) {
        var arr = id.split('-');
        var imgId = arr[3];
        $('.car-col-img-dv-' + imgId).removeClass('active');
        $('.car-col-img-dv-' + imgId).hide();
        $('#dv-car-col-img-id-' + imgId + '-' + arr[4]).show();
        $('#dv-car-col-img-id-' + imgId + '-' + arr[4]).addClass('active');
    }

    function changeColor(id) {
        var colImgId = id.split('-').pop();
        $('.pro-color-apply').removeClass('active');
        var color = $('#' + id).attr('title');
        // $('.car-col-img-dv-'+colImgId).hide();
        var elements = document.getElementsByClassName('car-col-img-dv-' + colImgId);
        var requiredElement = elements[0];
        $('.all-car-col-img-dv').removeClass('active');
        $('.all-car-col-img-dv').hide();
        $('#' + requiredElement.id).show();
        $('#' + requiredElement.id).addClass('active');

        $('.all-t-col-img').hide();
        $('.t-col-img-' + colImgId).show();
        $('#color-name').val(color);
        $('#' + id).parent().addClass('active');
    }
</script>
<script>
    function addQuickToCart(id) {
        var quantity = 1;
        var prod = $('#' + id).attr('rel');
        var product_id = prod;
        $.ajax({
            url: '{{  url('/add-product-to-cart') }}',
            type: "get",
            dataType: 'json',
            data: {
                product_id: product_id,
                quantity: quantity
            },
            success: function (response) {
                if (response.success == "1") {
                    window.location.href = window.location.href;
                }
                else {
                    alert(response.msg);
                    return;
                }

            }
        });
    }

</script>
<script>
    var totalAmt = 0;
    var status = 0;
    var prodId = 0;

    function addRemoveProductQuantity(id, action) {
        // status =0;
        totalAmt = 0;
        //alert(id + "@@@@" + action);return;
        var cartItemId = id.split('_').pop();
        if (isNaN(cartItemId)) {
            prodId = $('#' + cartItemId).attr('rel');
        }
        else {
            prodId = $('#' + id).attr('rel');
        }
        // alert(prodId);return;
        $.ajax({
            url: '{{url("/add-remove-product-quantity")}}',
            type: "get",
            dataType: 'json',
            data: {
                cart_item_id: cartItemId,
                action: action,
                product_id: prodId
            },
            success: function (result) {
                console.log(result.msg);
                if (isNaN(cartItemId)) {
                    $('#add-quick-minus-status').hide();

                }
                else {
                    $('#add-quick-minus-status_' + cartItemId).hide();
                }
                // $('#add-minus-status_'+cartItemId).hide();

                // console.log(result.msg['1'].id);
                // console.log(JSON.stringify(result.msg));return;
                //            console.log(result.msg);return;
                if (result.success == 1) {
                    //var jsonObj =JSON.stringify(result.msg);

                    //alert(jsonObj);return;
                    $('#cart_count').text(result.msg['product_count']);
                    //addCoupon();
                    for (var i = 0; result.msg[i]; i++) {
                        if (isNaN(cartItemId)) {
                            $('#show-quick-product-count').val(result.msg[i].quantity);
                        }
                        else {
                            $('#show-quick-product-count_' + result.msg[i].id).val(result.msg[i].quantity);
                        }
                        // $('#show-quick-product-count_'+result.msg[i].id).val(result.msg[i].quantity);
                        //  $('#subtotal_'+result.msg[i].id).html(result.msg[i].subtotal);
                        //totalAmt +=result.msg[i].subtotal;
                    }

                    if (isNaN(cartItemId)) {
                        window.location.href = window.location.href;
                    }
                    // $('#all-sub-total').html(totalAmt);
                    //$('#all-total').html(totalAmt);

                    //window.location.href = window.location.href;
                }
                else {
                    if (isNaN(cartItemId)) {
                        console.log(result.msg);
                        $('#add-quick-minus-status').show();
                        $('#add-quick-minus-status').html(result.msg);
                    }
                    else {
                        console.log(result.msg);
                        $('#add-quick-minus-status_' + cartItemId).show();
                        $('#add-quick-minus-status_' + cartItemId).html(result.msg);
                    }

                }

            }

        });
    }
</script>
<script>
    var maxOrderQty = $('#max-order-qty').val();
    var qty = $('#max-qty').val();
    var res = "";
    var user = $('#user-type').val();

    function addQuickCount() {

        // alert(user);return;
        $('#add-quick-minus-status').html('');
        $('#minus-quick-cnt-btn').removeAttr('disabled');
        var value = $('#show-quick-product-count').val();
        value = parseInt(value) + 1;
        if (user != 4) {
            if (value > maxOrderQty || value > qty) {
                $('#add-quick-minus-status').show();
                if (value > maxOrderQty) {
                    res = "You can only order max " + maxOrderQty + " products";
                    $('#add-quick-minus-status').html(res);
                    $('#add-quick-cnt-btn').attr('disabled', 'disabled');
                }
                else if (value > qty) {
                    res = "Only " + qty + " products are available in stock";
                    $('#add-quick-minus-status').html(res);
                    $('#add-quick-cnt-btn').attr('disabled', 'disabled');
                }
            }
            else {
                $('#show-quick-product-count').val(value);
                $('#ip-prod-count').val(value);
            }
        }
        else {
            $('#add-quick-minus-status').show();
            if (value > qty) {
                res = "Only " + qty + " products are available in stock";
                $('#add-quick-minus-status').html(res);
                $('#add-quick-cnt-btn').attr('disabled', 'disabled');
            }
            else {
                $('#show-quick-product-count').val(value);
                $('#ip-prod-count').val(value);
            }

        }


    }

    function minusQuickCount() {
        $('#add-quick-minus-status').html('');
        $('#add-quick-cnt-btn').removeAttr('disabled');
        var value = $('#show-quick-product-count').val();
        value = parseInt(value);
        if (value > 1) {
            value -= 1;
        }
        else {
            $('#add-minus-quick-status').show();
            $('#minus-quick-cnt-btn').attr('disabled', 'disabled');
        }
        $('#show-quick-product-count').val(value);
        $('#ip-prod-count').val(value);
    }
</script>
<script>
    function changeSizeProperties(id) {

        $('.pro-size-apply').removeClass('active');
        var size = $('#' + id).attr('rel');
        $('#size-name').val(size);
        $('#' + id).parent().addClass('active');
    }

    function validateForm() {
//        alert($('#size-name').val());
        var chkSize = $('#chk-size').val();
        var size = $('#size-name').val();
        var color = $('#color-name').val();
        var available = $("#available").val();
//             alert(color);
        if (available == "1") {
            $('#error-msg').show();
            $('#error-msg').text('Sorry!! Product is out of stock');
            return false;
        }
        else if (available == "0") {
            if (chkSize > "0") {
                if (size != '' && color != '') {
                    return true;
                }
                else if (size == '' && color == '') {
                    $('#error-msg').show();
                    $('#error-msg').text('Please select product color and size');

                    return false;
                }
                else if (size != '' && color == '') {
                    $('#error-msg').show();
                    $('#error-msg').text('Please select product color');

                    return false;
                }
                else if (size == '' && color != '') {
                    $('#error-msg').show();
                    $('#error-msg').text('Please select product size');
                    return false;
                }
                else {
                    return true;
                }
            }
            else {
                if (color == '') {
                    $('#error-msg').show();
                    $('#error-msg').text('Please select product color');
                    return false;
                }
                else {
                    return true;
                }

            }
        }

    }

    function addToWishlist(product_id) {
//        alert($("#price").val());
//        alert($("#prod-dis-rate").val());
        var chkSize = $('#chk-size').val();
        var size = $('#size-name').val();
        var color = $('#color-name').val();
        var available = $("#available").val();
//             alert(prod_price);
        if (available == "1") {
            $('#error-msg').show();
            $('#error-msg').text('Sorry!! Product is out of stock');
            return false;
        }
        else if (available == "0") {
            if (chkSize > "0") {
                if (size == '' && color == '') {
                    $('#error-msg').show();
                    $('#error-msg').text('Please select product color and size');

                    return false;
                }
                else if (size != '' && color == '') {
                    $('#error-msg').show();
                    $('#error-msg').text('Please select product color');

                    return false;
                }
                else if (size == '' && color != '') {
                    $('#error-msg').show();
                    $('#error-msg').text('Please select product size');
                    return false;
                }
                else {
                    $.ajax({
                        url: '{{url( "/ajax-add-product-in-wishlist")}}',
                        data: {'product_id': product_id, 'color': color, 'size': size},
                        dataType: "json",
                        type: "get",
                        success: function (res) {
                            if (res.msg == 'Deleted From Wishlist') {
                                $("#add-wishlist-" + product_id).removeClass('active');
                            } else if (res.msg == 'Added In Wishlist') {
                                $("#add-wishlist-" + product_id).addClass('active');
                                window.location.href = window.location.href;
                            }

                        }
                    });
                }
            }
            else {
                if (color == '') {
                    $('#error-msg').show();
                    $('#error-msg').text('Please select product color');
                    return false;
                }
                else {
                    $.ajax({
                        url: '{{url( "/ajax-add-product-in-wishlist")}}',
                        data: {
                            'product_id': product_id,
                            'color': color,
                            'size': size
                        },
                        dataType: "json",
                        type: "get",
                        success: function (res) {
                            if (res.msg == 'Deleted From Wishlist') {
                                $("#add-wishlist-" + product_id).removeClass('active');
                            } else if (res.msg == 'Added In Wishlist') {
                                $("#add-wishlist-" + product_id).addClass('active');
                            }

                        }
                    });
                }
            }
        }
    }

</script>
<script>
    $(function () {
        if ('@php echo $imgCnt @endphp' > 0) {
            $('#pre-nxt-caro').show();
        }
    });
</script>
<style>
    .change-size-border {
        border: black solid 2px;
    }

    span.h-red {
        color: #CC0D00;
        text-transform: capitalize;
    }


</style>