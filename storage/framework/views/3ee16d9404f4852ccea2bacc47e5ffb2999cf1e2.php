<?php 
    if(isset($cartItem) && $cartItem !=''){
     $cart = \App\PiplModules\cart\Models\Cart::where('id',$cartItem->cart_id)->first();
    }
 $userType='';
  if (Auth::check()) {

         $userType = \Auth::user()->userInformation->user_type;
     }
 ?>
<style>
    .pro-color-bg{
        border: black 2px solid;
    }
</style>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="<?php echo e(url('public/media/front/img/cancel.png')); ?>" alt="close"></span></button>
        </div>
        <?php if(isset($cart)&& count($cart)>0): ?>
            <form id="update-cart-modal" action="<?php echo e(url('update-product-to-cart-form')); ?>" method="post" type="form">
                <input type="hidden" id="ip-cart-id" <?php if(isset($cart) && count($cart)>0): ?> value="<?php echo e($cart->id); ?>" <?php endif; ?>>
                <input type="hidden" id="ip-cart-item-id" <?php if(isset($cartItem) && count($cartItem)>0): ?> value="<?php echo e($cartItem->id); ?>" <?php endif; ?> >
                <?php else: ?>
                    <form id="add-to-cart-modal" action="<?php echo e(url('add-product-to-cart-form')); ?>" method="post" type="form" onsubmit=" return validateForm()">
                        <?php endif; ?>
                        <?php echo csrf_field(); ?>

                        <input type="hidden" id="id-product-id" name="product_id" value=" <?php echo e($ajaxProduct[0]['id']); ?>">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="gal-img">
                                        <div class="cust-detail-slide">
                                            <div id="carousel" class="carousel slide propertySlider" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    <div class="item active">
                                                        <img src="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>">
                                                        <div class="zoom-icon">
                                                            <a href="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>" class="swipebox" title="Product View">
                                                                <i class="fa fa-arrows-alt"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <?php if(isset($ajaxProduct[0]['product_images'])): ?>
                                                        <?php foreach($ajaxProduct[0]['product_images'] as $c): ?>
                                                            <div class="item">
                                                                <img src="<?php echo e(url('storage/app/public/product/product_images/')); ?>/<?php echo e($c->images); ?>">
                                                                <div class="zoom-icon">
                                                                    <a href="<?php echo e(url('storage/app/public/product/product_images/')); ?>/<?php echo e($c->images); ?>" class="swipebox" title="Product View">
                                                                        <i class="fa fa-arrows-alt"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    <?php /*<div class="item">*/ ?>
                                                    <?php /*<img src="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>">*/ ?>
                                                    <?php /*<div class="zoom-icon">*/ ?>
                                                    <?php /*<a href="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>" class="swipebox" title="Product View">*/ ?>
                                                    <?php /*<i class="fa fa-arrows-alt"></i>*/ ?>
                                                    <?php /*</a>*/ ?>
                                                    <?php /*</div>*/ ?>
                                                    <?php /*</div>*/ ?>
                                                    <?php /*<div class="item">*/ ?>
                                                    <?php /*<img src="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>">*/ ?>
                                                    <?php /*<div class="zoom-icon">*/ ?>
                                                    <?php /*<a href="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>" class="swipebox" title="Product View">*/ ?>
                                                    <?php /*<i class="fa fa-arrows-alt"></i>*/ ?>
                                                    <?php /*</a>*/ ?>
                                                    <?php /*</div>*/ ?>
                                                    <?php /*</div>*/ ?>
                                                    <?php /*<div class="item">*/ ?>
                                                    <?php /*<img src="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>">*/ ?>
                                                    <?php /*<div class="zoom-icon">*/ ?>
                                                    <?php /*<a href="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>" class="swipebox" title="Product View">*/ ?>
                                                    <?php /*<i class="fa fa-arrows-alt"></i>*/ ?>
                                                    <?php /*</a>*/ ?>
                                                    <?php /*</div>*/ ?>
                                                    <?php /*</div>*/ ?>
                                                </div>
                                            </div>
                                            <div class="clearfix">
                                                <div id="thumbcarousel" class="carousel slide propertySliderThumb" data-interval="false">
                                                    <div class="carousel-inner">
                                                        <div class="item active">
                                                            <?php if(isset($ajaxProduct[0]['product_images'])): ?>
                                                                <?php  $imgCnt =0;  ?>
                                                                <?php foreach($ajaxProduct[0]['product_images'] as $c): ?>
                                                                    <div data-target="#carousel" data-slide-to="<?php echo e($imgCnt); ?>" class="thumb"><img src="<?php echo e(url('storage/app/public/product/product_images/')); ?>/<?php echo e($c->images); ?>"></div>
                                                                    <?php  $imgCnt++;  ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                            <?php /*<div data-target="#carousel" data-slide-to="1" class="thumb"><img src="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>"></div>*/ ?>
                                                            <?php /*<div data-target="#carousel" data-slide-to="2" class="thumb"><img src="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>"></div>*/ ?>
                                                            <?php /*<div data-target="#carousel" data-slide-to="3" class="thumb"><img src="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>"></div>*/ ?>
                                                            <?php /*<div data-target="#carousel" data-slide-to="4" class="thumb"><img src="<?php echo e(url('storage/app/public/product/image/')); ?>/<?php echo e($ajaxProduct[0]['image']); ?>"></div>*/ ?>
                                                        </div>
                                                        <?php /*<div class="item">*/ ?>
                                                        <?php /*<div data-target="#carousel" data-slide-to="5" class="thumb"><img src="img/slid-2.jpg"></div>*/ ?>
                                                        <?php /*<div data-target="#carousel" data-slide-to="6" class="thumb"><img src="img/slid-1.jpg"></div>*/ ?>
                                                        <?php /*<div data-target="#carousel" data-slide-to="7" class="thumb"><img src="img/slid-2.jpg"></div>*/ ?>
                                                        <?php /*<div data-target="#carousel" data-slide-to="8" class="thumb"><img src="img/slid-1.jpg"></div>*/ ?>
                                                        <?php /*<div data-target="#carousel" data-slide-to="9" class="thumb"><img src="img/slid-2.jpg"></div>*/ ?>
                                                        <?php /*</div>*/ ?>
                                                    </div>
                                                    <a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
                                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                                    </a>
                                                    <a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
                                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="h-product-details">
                                        <div class="h-product-heading"><h2 class="h-section-title"><?php echo e($ajaxProduct[0]['name']); ?></h2></div>
                                        <div class="h-product-rating">
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <span><i class="fa fa-star"></i></span>
                                            <div class="h-product-review">Be the first to review this product</div>
                                        </div>
                                        <div class="h-price">
                                            <?php if($ajaxProduct[0]['is_original'] == 1): ?>
                                                <b> <?php echo e($ajaxProduct[0]['discount_rate']); ?></b>
                                                <b> <?php echo e($ajaxProduct[0]['price']); ?> </b>
                                                <b> <?php echo e($ajaxProduct[0]['discount_percent']); ?></b>
                                            <?php /*<?php else: ?>*/ ?>
                                                <?php /*<b> <?php echo e($ajaxProduct[0]['price']); ?> </b>*/ ?>
                                            <?php elseif($ajaxProduct[0]['is_original'] == 0): ?>
                                                <b> <?php echo e($ajaxProduct[0]['price']); ?> </b>
                                            <?php elseif($ajaxProduct[0]['is_original'] == 2): ?>
                                                <b> Request For Rate </b>
                                            <?php endif; ?>
                                        </div>
                                        <div class="h-product-availability">
                                            <ul class="h-stock-detail">
                                                <!-- <li>
                                                    <i class="fa fa-stack-exchange"></i>
                                                    <span>Only 15 Left</span>
                                                </li> -->
                                                <a href="<?php echo e(url('product').'/'.$ajaxProduct[0]['id']); ?>">See full product details</a>
                                                <li>
                                                    <span class="h-prod-status">Available:</span>
                                                    <span class="h-green">
                                            <?php if($ajaxProduct[0]['availability'] == 1): ?>
                                                            <?php echo e("Out Of Stock"); ?>

                                                        <?php else: ?>
                                                            <?php echo e("In Stock"); ?>

                                                        <?php endif; ?>
                                        </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="h-product-description">
                                            <p><?php echo e($ajaxProduct[0]['long_description']); ?></p>
                                        </div>
                                        <div class="product-options">
                                            <?php if(isset($ajaxProduct[0]['colors'])): ?>
                                                <div class="color-optn font-2">
                                                    <label> <span class="option"> Color </span> <span class="red-color"></span></label>
                                                    <ul class="list-unstyled">
                                                        <?php if(isset($ajaxProduct[0]['colors'])): ?>
                                                            <?php foreach($ajaxProduct[0]['colors'] as $c): ?>
                                                                <?php /*<p style=""><?php echo e($c->color); ?> </p>*/ ?>
                                                                <?php if(isset($c->color) && $c->color!=null): ?>
                                                                    <li class="pro-color-apply"><img id="color-<?php echo e($c->id); ?>" title="<?php echo e(strtolower($c->color)); ?>" onclick="changeColor(this.id)" src="<?php echo e(url('public/media/front/color/'.strtolower($c->color).'.jpg')); ?>" alt="<?php echo e(strtolower($c->color)); ?>" <?php if(isset($ajaxProduct[0]['product_color']) && $ajaxProduct[0]['product_color']== strtolower($c->color)): ?> class="pro-color-bg"  <?php endif; ?>></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                            <label style="margin-top: 10px;display: none">Product Color:<span id="currentColor" style="display: inline;padding-left: 5px"></span></label>
                                                            <input id="color-name" name="color_name" type="hidden"/>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>

                                                <?php if(isset($ajaxProduct['attribute_name'])): ?>

                                                    <div class="size-optn font-2">

                                                        <label> <span class="option"> SIZE OPTIONS </span> </label>
                                                        <a href="#" data-target="#h-cust-modal-size" data-toggle="modal">SIZE GUIDE</a>
                                                        <ul class="list-inline">

                                                            <?php  for($i=0;$i<count($ajaxProduct['attribute_name']);$i++){ ?>

                                                            <?php  if($ajaxProduct['attribute_name'][$i] == 'Size') { ?>

                                                            <li class="pro-size-apply"><span class="eff" id="size-<?php echo e($i); ?>" onclick="changeSizeProperties(this.id)" rel="<?php echo e($ajaxProduct['attribute_value'][$i]); ?>" title="Select Size:<?php echo e($ajaxProduct['attribute_value'][$i]); ?>"><?php echo e($ajaxProduct['attribute_value'][$i]); ?></span></li>
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </ul>
                                                        <input id="size-name" name="size_name" type="hidden"/>
                                                    </div>

                                                <?php endif; ?>

                                        </div>
                                        <div class="h-product-buttons quick-view-counter clearfix">
                                            <div class="h-quantity">
                                                <button id="minus-quick-cnt-btn" type="button" onclick="minusQuickCount()" class="h-minus-pro"><i class="icon-substract"></i></button>
                                                <input id="show-quick-product-count" name="product_qty" type="text" class="form-control" <?php if(isset($cartItem) && $cartItem->product_quantity !=0): ?>value='<?php echo e($cartItem->product_quantity); ?>'<?php else: ?> value='1' <?php endif; ?> disabled />
                                                <button id="add-quick-cnt-btn" type="button" onclick="addQuickCount()" class="h-plus-pro"><i class="icon-add"></i></button>
                                                <span style="display: none;color: red" id="add-quick-minus-status"></span>
                                                <input type="hidden" id="ip-prod-count" name="ip_prod_count" <?php if(isset($cartItem) && $cartItem->product_quantity !=0): ?>value='<?php echo e($cartItem->product_quantity); ?>'<?php else: ?> value='1' <?php endif; ?>>
                                            </div>
                                            <div class="h-add-cart">
                                                <?php if(isset($cartItem) && count($cartItem)>0): ?>
                                                    <button id="update-in-cart" class="add-cart" type="submit"><i class="fa fa-shopping-bag"></i></button>
                                                <?php else: ?>
                                                    <span style="display: none" id="error-msg"></span>
                                                    <button id="add-in-cart" class="add-cart" type="submit"><i class="fa fa-shopping-bag"></i></button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input id="max-order-qty" type="hidden" value="<?php echo e($ajaxProduct[0]['max_order_qty']); ?>">
                        <input id="max-qty" type="hidden" value="<?php echo e($ajaxProduct[0]['quantity']); ?>">
                        <input id="user-type" type="hidden" value="<?php echo e($userType); ?>">
                    </form>
            </form>
    </div>
</div>

<script>
    function updateQuickToCart(id)
    {   //alert(id);return;
        var quantity = 0;
        var countId = id.split('_').pop();
        //alert(countId);return;
        var prod = $('#'+id).attr('rel');
        var product_id = prod;
        quantity = $('#show-quick-product-count_'+countId).val();
        //alert(quantity);return;
        $.ajax({
            url: '<?php echo e(url('/update-product-to-cart')); ?>',
            type: "get",
            dataType: 'json',
            data: {
                product_id: product_id,
                quantity: quantity
            },
            success: function(response) {
                if (response.success == "1")
                {
                    console.log(response.msg);return;
                    window.location.href = window.location.href;
                }
                else{
                    console.log(response.msg);return;
                }

            }
        });
    }

</script>
<script>
    function changeColor(id) {
        $('.pro-color-apply').removeClass('pro-color-bg');
        $('#'+id).addClass('pro-color-bg');

        // alert(id);return;
        // var  cartItemId=$("#"+id).attr('rel');
        var color = $('#'+id).attr('title');
        $('#currentColor').html(color);
        $('#color-name').val(color);

        <?php /*$.ajax({*/ ?>
        <?php /*url: '<?php echo e(url("/change-cart-product-color")); ?>',*/ ?>
        <?php /*type: "get",*/ ?>
        <?php /*dataType:'json',*/ ?>
        <?php /*data: {*/ ?>
        <?php /*cart_item_id: cartItemId,*/ ?>
        <?php /*color:color*/ ?>
        <?php /*},*/ ?>
        <?php /*success: function(result) {*/ ?>
        <?php /*if(result.success == 1){*/ ?>

        <?php /*}*/ ?>
        <?php /*else{*/ ?>
        <?php /*alert(result.msg);return;*/ ?>
        <?php /*}*/ ?>

        <?php /*}*/ ?>

        <?php /*});*/ ?>

    }
</script>
<script>
    function addQuickToCart(id)
    {   var quantity = 1;
        var prod = $('#'+id).attr('rel');
        var product_id = prod;
        $.ajax({
            url: '<?php echo e(url('/add-product-to-cart')); ?>',
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
    var totalAmt =0;
    var  status =0;
    var prodId=0;
    function addRemoveProductQuantity(id, action)
    {
        // status =0;
        totalAmt =0;
        //alert(id + "@@@@" + action);return;
        var  cartItemId = id.split('_').pop();
        if(isNaN(cartItemId)){
            prodId =  $('#'+cartItemId).attr('rel');
        }
        else{
            prodId= $('#'+id).attr('rel');
        }
        // alert(prodId);return;
        $.ajax({
            url: '<?php echo e(url("/add-remove-product-quantity")); ?>',
            type: "get",
            dataType:'json',
            data: {
                cart_item_id: cartItemId,
                action: action,
                product_id:prodId
            },
            success: function(result) {
                console.log(result.msg);
                if(isNaN(cartItemId)){
                    $('#add-quick-minus-status').hide();

                }
                else{
                    $('#add-quick-minus-status_'+cartItemId).hide();
                }
                // $('#add-minus-status_'+cartItemId).hide();

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
                        if(isNaN(cartItemId)){
                            $('#show-quick-product-count').val(result.msg[i].quantity);
                        }
                        else{
                            $('#show-quick-product-count_'+result.msg[i].id).val(result.msg[i].quantity);
                        }
                        // $('#show-quick-product-count_'+result.msg[i].id).val(result.msg[i].quantity);
                        //  $('#subtotal_'+result.msg[i].id).html(result.msg[i].subtotal);
                        //totalAmt +=result.msg[i].subtotal;
                    }

                    if(isNaN(cartItemId)){
                        window.location.href = window.location.href;
                    }
                    // $('#all-sub-total').html(totalAmt);
                    //$('#all-total').html(totalAmt);

                    //window.location.href = window.location.href;
                }
                else{
                    if(isNaN(cartItemId)){
                        console.log(result.msg);
                        $('#add-quick-minus-status').show();
                        $('#add-quick-minus-status').html(result.msg);
                    }
                    else{
                        console.log(result.msg);
                        $('#add-quick-minus-status_'+cartItemId).show();
                        $('#add-quick-minus-status_'+cartItemId).html(result.msg);
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
    function addQuickCount(){

        // alert(user);return;
        $('#add-quick-minus-status').html('');
        $('#minus-quick-cnt-btn').removeAttr('disabled');
        var value = $('#show-quick-product-count').val();
        value =parseInt(value)+1;
        if(user != 4){
            if(value > maxOrderQty || value > qty ){
                $('#add-quick-minus-status').show();
                if(value > maxOrderQty){
                    res = "You can only order max "+maxOrderQty+" products";
                    $('#add-quick-minus-status').html(res);
                    $('#add-quick-cnt-btn').attr('disabled','disabled');
                }
                else if(value > qty){
                    res = "Only "+ qty +" products are available in stock";
                    $('#add-quick-minus-status').html(res);
                    $('#add-quick-cnt-btn').attr('disabled','disabled');
                }
            }
            else{
                $('#show-quick-product-count').val(value);
                $('#ip-prod-count').val(value);
            }
        }
        else{
            $('#add-quick-minus-status').show();
            if(value > qty){
                res = "Only "+ qty +" products are available in stock";
                $('#add-quick-minus-status').html(res);
                $('#add-quick-cnt-btn').attr('disabled','disabled');
            }
            else{
                $('#show-quick-product-count').val(value);
                $('#ip-prod-count').val(value);
            }

        }


    }
    function minusQuickCount(){
        $('#add-quick-minus-status').html('');
        $('#add-quick-cnt-btn').removeAttr('disabled');
        var value = $('#show-quick-product-count').val();
        value =parseInt(value);
        if(value > 1){
            value -=1;
        }
        else{
            $('#add-minus-quick-status').show();
            $('#minus-quick-cnt-btn').attr('disabled','disabled');
        }
        $('#show-quick-product-count').val(value);
        $('#ip-prod-count').val(value);
    }
</script>
<script>
    function changeSizeProperties(id) {

        $('.pro-size-apply').removeClass('active');
        var size = $('#'+id).attr('rel');
        // console.log(size);return;
        // console.log(color);return;
        // $('#color-name').html(color);
        $('#size-name').val(size);
        $('#'+id).parent().addClass('active');
        //  $("#"+id).toggleClass('change-size-border');
        // alert(sizeName);return;
    }
    function  validateForm() {

        var size = $('#size-name').val();
        var color = $('#color-name').val();

        if(size != '' && color != ''){
            return true;
        }
        else{
            $('#error-msg').show();
            $('#error-msg').text('Please select product color and size');

            return false;
        }
    }

</script>
<style>
    .change-size-border{
        border: black solid 2px;
    }
</style>