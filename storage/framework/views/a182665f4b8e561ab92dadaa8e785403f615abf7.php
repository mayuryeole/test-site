<?php $__env->startSection('meta'); ?>
    <title>Profile</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="h-inner-banner" style="background-image:url('<?php echo e(url("public/media/front/img/inner-banner.jpg")); ?>');">
        <div class="container relative">
            <div class="h-caption">
                <h3 class="h-inner-heading">My Order</h3>
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
                    <?php if(isset($order) && count($order)>0): ?>
                    <div class="row">
                        <div class="my-order-holder">
                            <div class="my-orders-head">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="order-id-head">
                                            <h3><a href="javascript:void(0);"><?php echo e($order->payment_tracking_id); ?></a></h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="my-order-btns">
                                            <button type="button" class="nd-hlp"><span class="reqst-invoic"><i class="fa fa-question-circle"></i></span> Need Help ?</button>
                                            <button type="button" class="nd-hlp"><span class="reqst-invoic"><i class="fa fa-map-marker"></i></span> Track</button>
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
                                    <div class="col-md-2">
                                        <div class="product-order-img">
                                            <img src="<?php echo e(url('storage/app/public/product/image').'/'.$item->product->productDescription->image); ?>" alt="image" class="img-responsive">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="product-order-dtl">
                                            <p class="pro-title order-order-descs">
                                                <a href="javascript:void(0);">
                                                    <?php echo e($item->product->name); ?>

                                                </a>
                                            </p>
                                            <p class="product-ids">
                                                <span>Product Id : <?php echo e($item->product->productDescription->sku); ?></span>
                                            </p>
                                            <p class="h-colors">
                                                <span>Color : <?php echo e($item->product_color_name); ?> </span>
                                            </p>
                                            <p class="h-sizes">
                                                <span>Size : <?php echo e($item->product_size_name); ?></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="pro-title order-order-descs">
                                            <?php echo e($currency.$item->product_amount * $item->product_quantity); ?></p>
                                    </div>
                                    <div class="col-md-4">
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
                                            <div class="col-md-6">
                                                <h4> Refund status</h4>
                                            </div>
                                            <div class="col-md-6">
                                                <h4><a href="<?php echo e(url('view-order-details-front').'/'.$order->id); ?>" class="my-order-view">View Details</a></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="refund-bnk-detail">
                                                <p>Refund To: Bank Account</p>
                                                <p>Refund ID: 117999119</p>
                                                <p class="comp-refund"><a href="javascript:void(0);">Completed</a></p>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="pro-title order-order-descs refn-rs"> <?php echo e(App\Helpers\Helper::getCurrencySymbol().round(\App\Helpers\Helper::getRealPrice($order->order_total),4)); ?></p>
                                        </div>
                                        <div class="col-md-4">
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
                                    <div class="col-md-6">
                                        <p class="order-txt">Ordered On <span class="on-order-dark"> <?php echo e($order->created_at); ?></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="order-txt t-ordr">Order Total<span class="on-order-dark"> <?php echo e(App\Helpers\Helper::getCurrencySymbol().round(\App\Helpers\Helper::getRealPrice($order->order_total),4)); ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>