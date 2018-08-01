@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
    <title>Wishlist</title>
@endsection
@section('content')
<section class="h-inner-banner" style="background-image:url(/public/media/front/img/wishlist-bg.jpg);">
    <div class="container relative manage-bottm-head">
        <div class="h-caption">
            <!-- <h3 class="h-inner-heading">My Wishlist</h3> -->
            <!-- <ul class="cust-breadcrumb">
                <li><a href="javascript:void(0);">Home</a></li>
                <li>>></li>
                <li>Add To Wishlist</li>
            </ul> -->
        </div>
    </div>
</section>
<section class="cust-bread">
    <div class="container">
        <ul class="clearfix">
            <li><a href="http://parasfashions.com">Home</a></li>
            <li>My Wishlist</li>
        </ul>
    </div>
</section>
<section class="h-add-cart-page h-wishlist-page">
    <div class="container">
        <div class="row">
            <form class="add-ct-form">
                @if(isset(Auth::user()->userWishlist) && count(Auth::user()->userWishlist)>0)
                <div class="col-md-12">
                    <div class="h-share-buttons text-right clearfix">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        {{--<span class="share-wishlist-data"><a href="javascript:void(0);">Want a get a second option</a></span>--}}
                        {{--<a href="javascript:void(0);" class="h-update-cart">Share Wishlist</a>--}}
                    </div>
                    <div class="cart-table table-responsive">
                        <table>
                            <thead>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>                            
                            <th>Add to Cart</th>
                            <th>Stock</th>
                            </thead>
                            <tbody>
                            @foreach(Auth::user()->userWishlist as $wishlist)
                                @php
                                    if(!empty($wishlist->product->id))
                                   {
                                      $prodId =$wishlist->product->id;
                                    $product = \App\PiplModules\product\Models\Product::find($prodId);
                                   $cartObj = new \App\PiplModules\cart\Controllers\CartController();
                                   $product = $cartObj->getProductDiscountPrice($product);
                                   }

                                @endphp
                            <tr id="{{ $wishlist->id }}">
                                <td class="pro-thumbnail pro-remove">
                                    <a href="{{ url('/product').'/'.$product->id }}"><img @if(!empty($wishlist->productDescription->image))src="{{url('storage/app/public/product/image/'.$wishlist->productDescription->image)}}" @endif alt="product image"/></a>
                                    <span class="span-block">
                                        <button type="button" data-toggle="modal" onclick="showModal('{{$wishlist->product_id}}')"><i class="fa fa-edit"></i> Edit</button>
                                        <button type="button" href="#" id="rm-cart-tem_62" onclick="removeFromWishlist('{{$wishlist->id}}','{{$wishlist->product_id}}')"><i class="fa fa-trash"></i>Remove</button>
                                   </span>
                                </td>
                                <td class="pro-title">
                                    <a @if(!empty($product)) href="{{ url('/product').'/'.$product->id }}" @endif>@if(!empty($wishlist->product->name)){{$wishlist->product->name}} @endif</a>
                                    <div class="product-id"><span>Product Id : @if(!empty($wishlist->productDescription->sku)){{$wishlist->productDescription->sku}} @endif</span></div>
                                    <div class="h-color"><span>Color : @if(!empty($wishlist->product_color_name)){{ $wishlist->product_color_name }} @endif</span></div>
                                    <div class="h-size"><span>Size : @if(!empty($wishlist->product_size_name)){{ $wishlist->product_size_name }} @endif</span></div>
                                    <span class="span-block">
                                      <div style="display:none;color:orange" id="err-dv-prod-id-{{ $wishlist->id }}"></div>
                                    </span>
                                </td>
                                <td class="pro-price"><span class="amount">
                                        {{--{{ \App\Helpers\Helper::getCurrencySymbol().round(\App\Helpers\Helper::getRealPrice($wishlist->productDescription->price),4) }}--}}
                                        @if(isset($product->is_original) && $product->is_original == 1)
                                           {{  \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($product->discount_rate),2,'.','')  }}
                                        @elseif(isset($product->is_original) && $product->is_original == 0)
                                          {{  \App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($product->price),2,'.','') }}
                                        @elseif(isset($product->is_original) && $product->is_original == 2)
                                           <strong style="color: black">Request For Rate</strong>
                                        @endif
                                    </span></td>
                                <td class="pro-subtotal text-center">
                                    @if(isset($product->is_original) && $product->is_original != 2)
                                    <button type="button" onclick="moveToCart('{{ $wishlist->id }}')" class="h-update-cart h-center-b" value="Add to Cart"><i class="fa fa-shopping-bag"></i></button>
                                    @endif
                                </td>
                                <td class="pro-quantity">
                                    {{--<div class="stock-quantity">--}}
                                        {{--<span class="stock-qty">{{$wishlist->product_quantity}}</span>--}}
                                    {{--</div>--}}
                                    <div class="h-quantity">
                                        <button id="minus-quick-cnt-btn-{{ $wishlist->id }}" type="button" onclick="minusQuickCount(this.id)" class="h-minus-pro"><i class="icon-substract"></i></button>
                                        <input id="show-quick-product-count-{{ $wishlist->id }}" name="product_qty" type="text" class="form-control" value='{{ $wishlist->product_quantity }}' disabled />
                                        <button id="add-quick-cnt-btn-{{ $wishlist->id }}" type="button" onclick="addQuickCount(this.id)" class="h-plus-pro"><i class="icon-add"></i></button>                                        
                                        <input type="hidden" id="ip-prod-count-{{ $wishlist->id }}" name="ip_prod_count" @if(isset($wishlist) && $wishlist->product_quantity !=0)value='{{ $wishlist->product_quantity }}'@else value='1' @endif>
                                    </div>
                                    <span style="display: none;color: red" id="add-quick-minus-status-{{ $wishlist->id }}"></span>
                                </td>                                
                            </tr>
                            <input id="max-order-qty-{{ $wishlist->id }}" type="hidden" @if(!empty($wishlist->productDescription->max_order_qty)) value="{{  $wishlist->productDescription->max_order_qty }}" @endif>
                            <input id="max-qty-{{ $wishlist->id }}" type="hidden" @if(!empty($wishlist->productDescription->quantity))value="{{  $wishlist->productDescription->quantity }}" @endif>
                            <input id="user-type-{{ $wishlist->id }}" type="hidden" @if(Auth::check()) value="{{ Auth::user()->userInformation->user_type }}" @else value="" @endif>
                                <script>
                                    if('<?php echo $product->productDescription->availability; ?>' == '1')
                                    {
                                        $("#err-dv-prod-id-" + '<?php echo $wishlist->id; ?>').show();
                                        $("#err-dv-prod-id-" + '<?php echo $wishlist->id; ?>').text('This product is out of stock');
                                    }
                                </script>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                    <div class="col-md-12">
                    <h4 class="empty-cart text-center">Your Wishlist is Empty</h4>
                    </div>
                @endif
            </form>
        </div>
    </div>
</section>
    <div class="cust-modal modal fade" id="h-quick-view" data-easein="perspectiveLeftIn" tabindex="-1" role="dialog"
         aria-labelledby="costumModalLabel" aria-hidden="true">
    </div>
<div id="h-cust-modal-size" class="modal h-cust-modal open-my-custom-modal">

    <!-- Modal content -->
    <div class="modal-content">
        <button type="button" class="close h-cust-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="{{url("/public/media/front/img/cancel.png")}}" alt="close" height="20px;" width="20px;"></span>
        </button>

        <div class="size-heading"><h2>SIZE GUIDE</h2></div>
        <div class="container">
            <div class="row">
                <div class="arrow-up"></div>
                <div class="top_head">
                    <div class="col-md-4">
                        <h3>WOMEN</h3>
                    </div><!-- col-md-4 -->
                    <div class="col-md-4">
                        <h3>MEN</h3>
                    </div><!-- col-md-4 -->
                    <div class="col-md-4">
                        <h3>KIDS</h3>
                    </div><!-- col-md-4 -->
                </div><!-- top_head -->
            </div><!-- row -->

            <div class="row main_mnu">
                <ul class="nav nav-pills mnu">
                    <li><a data-toggle="pill" href="#home"><i class="fa fa-female"></i> </a></li>
                    <li><a data-toggle="pill" href="#menu1"><i class="fa fa-male"></i></a></li>
                    <li><a data-toggle="pill" href="#menu2"><i class="fa fa-child"></i></a></li>
                </ul>
            </div><!-- row -->

            <div class="row">
                <div class="size-head">
                    <div class="col-md-4">
                        <h4><a href="#"> REGULAR </a></h4>
                    </div><!-- col-md-4 -->
                    <div class="col-md-8">
                        <h4><a href="#">BIG AND TALL </a></h4>
                    </div><!-- col-md-8 -->
                </div><!-- size-head -->
            </div>

            <div class="row">
                <div class="mesurment tab-content">

                    <div id="home" class="tab-pane fade in active">
                        <div class="col-md-4">
                            <div class="left_pan">
                                <h4> HOW TO MESURE </h4>
                                <p><span class="number"><b> 1 </b></span> <span class="mwsure_head"><b> Chest </b></span> Measure across  the fullest part. </p>
                                <p><span class="number"><b> 2 </b></span> <span class="mwsure_head"><b> Waist </b></span> Measure around the natural waistline. </p>
                                <p><span class="number"><b> 3 </b></span> <span class="mwsure_head"><b> Hips </b></span> Measure at the widest  part. </p>
                                <p><span class="number"><b> 4 </b></span> <span class="mwsure_head"><b> Inside Leg </b></span> Measure from top of inside leg at the crotch to the ankle bone. </p>
                            </div><!-- left_pan -->
                            <div class="right_pan">
                                <img src="{{url("public/media/front/img/size.png")}}" alt="size image">
                            </div><!-- right_pn -->
                        </div><!-- col-md-4 -->

                        <div class="col-md-8">
                            <div class="tbl_head">
                                <span class="left_head"> <h4>INTERNATIONAL CONVERSION</h4> </span>
                                <span class="right_head"> <h4>IN CM</h4> </span>
                            </div><!-- tbl_head -->
                            <table>
                                <tr>
                                    <th>SIZE</th>
                                    <th>XSS</th>
                                    <th>XS</th>
                                    <th>S</th>
                                    <th>M</th>
                                    <th>L</th>
                                    <th>XL</th>
                                    <th>XXL</th>
                                </tr>
                                <tr>
                                    <td>UK</td>
                                    <td>32 </td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>38</td>
                                    <td>40</td>
                                    <td>42</td>
                                    <td>44-46</td>
                                </tr>
                                <tr>
                                    <td>EUROPE</td>
                                    <td>44 </td>
                                    <td>46</td>
                                    <td>48</td>
                                    <td>56</td>
                                    <td>58</td>
                                    <td>60</td>
                                    <td>62-64</td>
                                </tr>
                                <tr>
                                    <td>USA</td>
                                    <td>32 </td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>38</td>
                                    <td>40</td>
                                    <td>42</td>
                                    <td>44</td>
                                </tr>
                                <tr>
                                    <td>CANADA</td>
                                    <td>32</td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>40</td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                </tr>
                                <tr>
                                    <td>AUS/NZ</td>
                                    <td>32</td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>40</td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                </tr>
                                <tr>
                                    <td>CHEST(in)</td>
                                    <td>32</td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>40</td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                </tr>
                                <tr>
                                    <td>COLLAR(in)</td>
                                    <td>13</td>
                                    <td>14</td>
                                    <td>15</td>
                                    <td>16</td>
                                    <td>17</td>
                                    <td>18</td>
                                    <td>19</td>
                                </tr>
                            </table>
                        </div><!-- col-md-8 -->
                    </div><!-- tab_pane -->

                    <div id="menu1" class="tab-pane fade in">
                        <div class="col-md-4">
                            <div class="left_pan">
                                <h4> HOW TO MEASURE </h4>
                                <p><span class="number"><b> 1. </b></span> <span class="mwsure_head"><b> Chest </b></span> Measure across  the fullest part. </p>
                                <p><span class="number"><b> 2. </b></span> <span class="mwsure_head"><b> Waist </b></span> Measure around the natural waistline. </p>
                                <p><span class="number"><b> 3. </b></span> <span class="mwsure_head"><b> Hips </b></span> Measure at the widest  part. </p>
                                <p><span class="number"><b> 4. </b></span> <span class="mwsure_head"><b> Inside Leg </b></span> Measure from top of inside leg at the crotch to the ankle bone. </p>
                            </div><!-- left_pan -->
                            <div class="right_pan">
                                <img src="img/size.png" alt="size image">
                            </div><!-- right_pn -->
                        </div><!-- col-md-4 -->

                        <div class="col-md-8">
                            <div class="tbl_head">
                                <span class="left_head"> <h4>INTERNATIONAL CONVERSION 2</h4> </span>
                                <span class="right_head"> <h4>IN CM</h4> </span>
                            </div><!-- tbl_head -->
                            <table>
                                <tr>
                                    <th>SIZE</th>
                                    <th>XSS</th>
                                    <th>XS</th>
                                    <th>S</th>
                                    <th>M</th>
                                    <th>L</th>
                                    <th>XL</th>
                                    <th>XXL</th>
                                </tr>
                                <tr>
                                    <td>UK</td>
                                    <td>34 </td>
                                    <td>36</td>
                                    <td>38</td>
                                    <td>42</td>
                                    <td>52</td>
                                    <td>472</td>
                                    <td>80-90</td>
                                </tr>
                                <tr>
                                    <td>Europe</td>
                                    <td>52</td>
                                    <td>54</td>
                                    <td>56</td>
                                    <td>58</td>
                                    <td>60</td>
                                    <td>62</td>
                                    <td>64-66</td>
                                </tr>
                                <tr>
                                    <td>USA</td>
                                    <td>42 </td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                    <td>50</td>
                                    <td>52</td>
                                    <td>54</td>
                                </tr>
                                <tr>
                                    <td>CANADA</td>
                                    <td>30</td>
                                    <td>32</td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>38</td>
                                    <td>40</td>
                                    <td>42</td>
                                </tr>
                                <tr>
                                    <td>AUS/NZ</td>
                                    <td>32</td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>40</td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                </tr>
                                <tr>
                                    <td>CHEST(in)</td>
                                    <td>40</td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                    <td>40</td>
                                    <td>44</td>
                                    <td>46</td>
                                </tr>
                                <tr>
                                    <td>COLLAR(in)</td>
                                    <td>10</td>
                                    <td>11</td>
                                    <td>12</td>
                                    <td>13</td>
                                    <td>14</td>
                                    <td>15</td>
                                    <td>16</td>
                                </tr>
                            </table>
                        </div><!-- col-md-8 -->
                    </div><!-- tab_pane -->

                    <div id="menu2" class="tab-pane fade">

                        <div class="col-md-12">
                            <div class="tbl_head">
                                <span class="left_head"> <h4>INTERNATIONAL CONVERSION</h4> </span>
                            </div><!-- tbl_head -->
                            <table>
                                <tr>
                                    <th>SIZE</th>
                                    <th>XSS</th>
                                    <th>XS</th>
                                    <th>S</th>
                                    <th>M</th>
                                    <th>L</th>
                                    <th>XL</th>
                                    <th>XXL</th>
                                </tr>
                                <tr>
                                    <td>UK</td>
                                    <td>32 </td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>38</td>
                                    <td>40</td>
                                    <td>42</td>
                                    <td>44-46</td>
                                </tr>
                                <tr>
                                    <td>erope</td>
                                    <td>44 </td>
                                    <td>46</td>
                                    <td>48</td>
                                    <td>56</td>
                                    <td>58</td>
                                    <td>60</td>
                                    <td>62-64</td>
                                </tr>
                                <tr>
                                    <td>USA</td>
                                    <td>32 </td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>38</td>
                                    <td>40</td>
                                    <td>42</td>
                                    <td>44</td>
                                </tr>
                                <tr>
                                    <td>CANADA</td>
                                    <td>32</td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>40</td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                </tr>
                                <tr>
                                    <td>AUS/NZ</td>
                                    <td>32</td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>40</td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                </tr>
                                <tr>
                                    <td>CHEST(in)</td>
                                    <td>32</td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>40</td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                </tr>
                                <tr>
                                    <td>COLLAR(in)</td>
                                    <td>13</td>
                                    <td>14</td>
                                    <td>15</td>
                                    <td>16</td>
                                    <td>17</td>
                                    <td>18</td>
                                    <td>19</td>
                                </tr>
                            </table>
                        </div><!-- col-md-12 -->
                    </div><!-- tab_pane -->


                </div><!-- mesurment tab-content -->
            </div><!-- row -->

        </div><!-- container -->
    </div><!-- modal-content -->
</div>
<script>
    function removeFromWishlist(wishlist_id,product_id)
    {
        if (confirm("Do you want to remove this product?"))
        {
            $.ajax({
                url: '{{url( "/ajax-remove-product-from-wishlist" )}}',
                data: {'product_id': product_id},
                dataType: "json",
                success: function(response) {
                    if(response.success=='1')
                    {
                        $("#"+wishlist_id).hide();
                    }else{
                        $("#"+wishlist_id).hide();
                        console.log(response.msg);
                    }

                }
            });
        }
        return false;
    }

    function showModal(product_id)
    {
        if(product_id!="")
        {
            $.ajax({
                type:"get",
                url: javascript_site_path + 'get-product-quick-view',
                dataType:'html',
                data: {'product_id': product_id},

                success:function(res)
                {
                    $("#h-quick-view").html(res);
                    $("#h-quick-view").modal('show')
                }
            });
        }
        //$("#edit_details_"+product_id).modal('show');
    }
</script>
<script>
    function moveToCart($wishlistId)
    {
        var count = $('#show-quick-product-count-'+$wishlistId).val();
        $.ajax({
            url:"{{url('/move-product-to-cart')}}",
            type:'post',
            dataType:'json',
            data:{
                wishlistId:$wishlistId,
                count:count,
                _token: $("[name=_token]").val()
            },
            success:function(response)
            {
                if(response.success == "1"){

                    console.log(response.msg);
                    $("#"+$wishlistId).hide();
                    window.location.href=window.location.href
                }
                else{
                    $("#"+$wishlistId).hide();
                    console.log(response.msg);
                }
            }

        });
    }
</script>
<script>
    var res = "";
    function addQuickCount(id){
        cnt = id.split('-').pop();
        //console.log(cnt);return;
        // alert(user);return;
        var maxOrderQty = $('#max-order-qty-'+cnt).val();
        //console.log(maxOrderQty);
        var qty = $('#max-qty-'+cnt).val();
        //console.log(qty);
        var user = $('#user-type-'+cnt).val();
        //console.log(user);

        $('#add-quick-minus-status-'+cnt).html('');
        $('#minus-quick-cnt-btn-'+cnt).removeAttr('disabled');
        var value = $('#show-quick-product-count-'+cnt).val();
        value =parseInt(value)+1;
        console.log(value);
        if(user != 4){
            if(value > maxOrderQty || value > qty ){
                $('#add-quick-minus-status-'+cnt).show();
                if(value > maxOrderQty){
                    res = "You can only order max "+maxOrderQty+" products";
                    $('#add-quick-minus-status-'+cnt).html(res);
                    $('#add-quick-cnt-btn-'+cnt).attr('disabled','disabled');
                }
                else if(value > qty){
                    res = "Only "+ qty +" products are available in stock";
                    $('#add-quick-minus-status-'+cnt).html(res);
                    $('#add-quick-cnt-btn-'+cnt).attr('disabled','disabled');
                }
            }
            else{
                $('#show-quick-product-count-'+cnt).val(value);
                $('#ip-prod-count-'+cnt).val(value);
            }
        }
        else{
            $('#add-quick-minus-status-'+cnt).show();

            if(value > qty){
                res = "Only "+ qty +" products are available in stock";
                $('#add-quick-minus-status-'+cnt).html(res);
                $('#add-quick-cnt-btn-'+cnt).attr('disabled','disabled');
            }
            else{
                $('#show-quick-product-count-'+cnt).val(value);
                $('#ip-prod-count-'+cnt).val(value);
            }

        }
    }
    function minusQuickCount(id){
        var cnt = id.split('-').pop();
        //console.log(cnt);return;
        $('#add-quick-minus-status-'+cnt).html('');
        $('#add-quick-cnt-btn-'+cnt).removeAttr('disabled');
        var value = $('#show-quick-product-count-'+cnt).val();
        value =parseInt(value);
        if(value > 1){
            value -=1;
        }
        else{
            $('#add-minus-quick-status-'+cnt).show();
            $('#minus-quick-cnt-btn-'+cnt).attr('disabled','disabled');
        }
        $('#show-quick-product-count-'+cnt).val(value);
        $('#ip-prod-count-'+cnt).val(value);
    }
</script>
@endsection