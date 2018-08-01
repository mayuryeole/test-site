<?php $__env->startSection("meta"); ?>
    <title>Checkout</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
    <section class="semi-banner" style="background-image: url('<?php echo e(url('public/media/front/img/appoinment.jpg')); ?>');">
        <div class="check-out-details-cap">
            <div class="container">
                <div class="semi-ban-head">Order Confirmation</div>
            </div>
        </div>
    </section>
    <section class="check-out-message">
        <div class="container">
            <div class="disp-table-div">
                <div class="disp-colom-div">
                    <h3>Your order has been succesfully placed please check following link...
                        <sapn><a href="<?php echo e(url('/order/view-orders')); ?>">Click Here</a></sapn>
                    </h3>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.front-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>