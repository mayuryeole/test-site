

<?php $__env->startSection("meta"); ?>
    <title>Show Orders</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
    <section class="h-inner-banner" style="background-image:url('<?php echo e(url("public/media/front/img/inner-banner.jpg")); ?>');">
        <div class="container relative manage-bottm-head">
            <div class="h-caption">
                <!--<h3 class="h-inner-heading">My Order</h3>-->
                <!-- <ul class="cust-breadcrumb">
                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li>>></li>
                    <li>My Order</li>
                </ul> -->
            </div>
        </div>
    </section>
    <section class="cust-bread">
        <div class="container">
            <ul class="clearfix">
                <li><a href="http://parasfashions.com">Home</a></li>
                <li>My Order</li>
            </ul>
        </div>
    </section>
    <section class="h-ecard-page shipping-details-block h-my-order">
        <div class="container">
            <div class="card-details">
                <div class="sender-receiver-details my-orders">
                    <?php if(isset($all_orders) &&  count($all_orders)>0): ?>
                    <?php foreach($all_orders as $order): ?>
                    <div class="row">
                        <div class="my-order-holder">
                            <div class="my-orders-head relative">
                                <div class="row">
                                    <div class="col-md-8 col-sm-6 col-xs-6">
                                        <div class="order-id-head">
                                            <h3><a href="javascript:void(0);"><?php if(!empty($order->master_tracking_number)): ?><?php echo e($order->master_tracking_number); ?> <?php endif; ?></a></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-6 manage-resp-middle">
                                        <div class="my-order-btns">
                                            <a style="color: black;text-decoration: none" type="button" href="<?php echo e(url('contact-us')); ?>" class="nd-hlp"><span class="reqst-invoic"><i class="fa fa-question-circle"></i></span> Need Help ?</a>
                                            <?php /*<button data-toggle="modal" data-target="#tracking-order" type="button" class="nd-hlp"><span class="reqst-invoic"><i class="fa fa-map-marker"></i></span> Track</button>*/ ?>
                                            <a style="color: black;text-decoration: none" <?php if(!empty($order->master_tracking_number)): ?> href="<?php echo e(url('/fedex/track-order').'/'.$order->master_tracking_number); ?>" <?php endif; ?> type="button" class="nd-hlp"><span class="reqst-invoic"><i class="fa fa-map-marker"></i></span> Track</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="oredr-product-inf">
                                <?php if(isset($order->orderItems)): ?>
                                    <?php foreach($order->orderItems as $item): ?>
                                        <?php 
                                            $orderObj = new App\PiplModules\cart\Controllers\OrderController();
                                           $currency =$orderObj->getCurrencyFromIso($order->payment_currency);
                                         ?>
                                        <div class="row">
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <div class="product-order-img">
                                                    <img <?php if(!empty($item->product->productDescription->image)): ?> src="<?php echo e(url('storage/app/public/product/image').'/'.$item->product->productDescription->image); ?>" <?php endif; ?> alt="image" class="img-responsive">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <div class="product-order-dtl">
                                                    <p class="pro-title order-order-descs">
                                                        <a href="javascript:void(0);">
                                                            <?php if(!empty($item->product->name)): ?><?php echo e($item->product->name); ?> <?php endif; ?>
                                                        </a>
                                                    </p>
                                                    <p class="product-ids">
                                                        <span>Product Id : <?php if(!empty($item->product->productDescription->sku)): ?><?php echo e($item->product->productDescription->sku); ?> <?php endif; ?></span>
                                                    </p>
                                                    <p class="h-colors">
                                                        <span>Color : <?php if(!empty($item->product_color_name)): ?><?php echo e($item->product_color_name); ?> <?php endif; ?></span>
                                                    </p>
                                                    <p class="h-sizes">
                                                        <span>Size : <?php if(!empty($item->product_size_name)): ?><?php echo e($item->product_size_name); ?> <?php endif; ?></span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-sm-2 col-xs-6">
                                                <p class="pro-title order-order-descs">
                                                    <?php echo e(App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($item->product_amount * $item->product_quantity),2,'.','')); ?></p>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-6">
                                                <p class="pro-title order-order-descs">
                                                    Return Requested
                                                </p>
                                                <p class="product-ids">
                                                    <span>Your request for return is being processed</span>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div class="holder-detail-refund">
                                    <div class="refund-head-sec">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <h4> Refund status</h4>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <h4><a href="<?php echo e(url('view-order-details-front').'/'.$order->id); ?>" class="my-order-view">View Details</a></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="refund-bnk-detail">
                                                <p>Refund To: Bank Account</p>
                                                <p>Refund ID: 117999119</p>
                                                <p class="comp-refund"><a href="javascript:void(0);">Completed</a></p>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <p class="pro-title order-order-descs refn-rs"> <?php echo e(App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($order->order_total),2,'.','')); ?></p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <p class="pro-title refun-dl">₹954.0 as refund will be transferred to your
                                                Bank Account within 1 business day (Bank holidays not included).For further
                                                details, please contact your bank with reference number +91 7865432190.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="on-order">
                                <div class="row mar-lr-15">
                                    <div class="col-md-6 col-sm-6">
                                        <p class="order-txt">Ordered On <span class="on-order-dark"> <?php echo e($order->created_at); ?></span></p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 ">
                                        <p class="order-txt t-ordr">Order Total<span class="on-order-dark"> <?php echo e(App\Helpers\Helper::getCurrencySymbol().number_format(\App\Helpers\Helper::getRealPrice($order->order_total),2,'.','')); ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<!-- Modal -->
<div class="cust-modal modal fade" id="tracking-order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <h3>Track Order</h3>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          <form enctype="multipart/form-data" method="post"
                action="<?php echo e(url('fedex/track-order')); ?>" role="form" name="track_order_form"
                id="track-order-form">
              <?php echo csrf_field(); ?>

        <div class="promo-code-btn relative">       
            <input name="tracking_id" type="text" placeholder="Enter Tracking Id" class="form-control">
            <input  class="promo-btn track-od-btn" type="submit" value="Track Order" class="form-control">
            <?php /*<div ><a style="text-decoration: none">Track Order</a></div>*/ ?>
        </div>
          </form>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.front-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>