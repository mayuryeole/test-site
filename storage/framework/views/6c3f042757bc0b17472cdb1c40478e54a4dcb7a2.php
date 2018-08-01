<?php $__env->startSection("meta"); ?>

    <title>View Order Product Details</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE BREADCRUMB -->
            <ul class="page-breadcrumb breadcrumb">
                <li>
                    <a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="<?php echo e(url('admin/orders')); ?>">Manage Orders</a>
                    <i class="fa fa-circle"></i>

                </li>
                <li>
                    <a href="javascript:void(0);">View Order Product Details</a>

                </li>
            </ul>
            <?php if(session('status')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('status')); ?>

                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
            <?php endif; ?>

            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>View Order Product Details
                    </div>
                    <div style="padding-left: 50px" class="caption">
                        <a href="<?php echo e(route('htmltopdfview',['download'=>'pdf','order'=>$order->id])); ?>">PDF</a>
                    </div>
                    <div style="padding-left: 50px" class="caption">
                        <a href="<?php echo e(url('/order/get-order-label').'/'.$order->id); ?>">GENERATE LABEL</a>
                    </div>
                </div>
                <div class="portlet-body form my-frm-div">
                    <div class="form-body">
                        <?php if(isset($order_items) && count($order_items)>0): ?>
                            <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group  clearfix <?php if($errors->has('title')): ?> has-error <?php endif; ?>">
                                            <div class="s-prod-list-table table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 30%; text-align: left;">Product Name</th>
                                                            <th style="width: 20%; text-align: center;">Weight</th>
                                                            <th style="width: 20%; text-align: center;">Quantity</th>
                                                            <th style="text-align: right; width: 30%; text-align: right;">Price</th>
                                                        </tr>
                                                    </thead>
                                                    <?php foreach($order_items as $o): ?>
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align: left;">
                                                                <div class="s-div">
                                                                    <?php if(isset($o->product->name) && $o->product->name!=""): ?>
                                                                        <?php echo e($o->product->name); ?>

                                                                    <?php else: ?>
                                                                        -
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                            <td style="text-align: left;">
                                                                <div class="s-div">
                                                                    <?php if(isset($o->product->weight) && $o->product->weight!=""): ?>
                                                                        <?php echo e($o->product->weight); ?>

                                                                    <?php else: ?>
                                                                        -
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <div class="s-div">
                                                                    <?php if(isset($o->product_quantity) && $o->product_quantity!=""): ?>
                                                                        <?php echo e($o->product_quantity); ?>

                                                                    <?php else: ?>
                                                                        -
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <div class="s-div" style="text-align: right;">
                                                                    <?php if(isset($o->product->productDescription->price) && $o->product->productDescription->price!=""): ?>
                                                                        <?php echo e($o->product->productDescription->price); ?>

                                                                    <?php else: ?>
                                                                        -
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <?php endforeach; ?>
                                                    <tfoot>

                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="s-div" style="text-align:right">
                                                                    <span class="s-head-left">TOTAL AMOUNT</span>
                                                                </div>
                                                            </td>
                                                            <td colspan="1">
                                                                <div class="s-div" style="text-align:right">
                                                                    <?php if(isset($order->order_subtotal) && $order->order_subtotal!=''): ?>
                                                                    <span class="s-count-right"><?php echo e($order->order_subtotal); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="s-count-right">0.00</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="s-div" style="text-align:right">
                                                                    <span class="s-head-left">ESTIMATED SHIPPING COST</span>
                                                                </div>
                                                            </td>
                                                            <td colspan="1">
                                                                <div class="s-div" style="text-align:right">
                                                                    <?php if(isset($order->order_shipping_cost) && $order->order_shipping_cost!=''): ?>
                                                                        <span class="s-count-right"><?php echo e($order->order_shipping_cost); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="s-count-right">0.00</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="s-div" style="text-align:right">
                                                                    <span class="s-head-left">COUPON AMOUNT</span>
                                                                </div>
                                                            </td>
                                                            <td colspan="1">
                                                                <div class="s-div" style="text-align:right">
                                                                    <?php if(isset($order->coupon_amount) && $order->coupon_amount!=''): ?>
                                                                        <span class="s-count-right"><?php echo e($order->coupon_amount); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="s-count-right">0.00</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="s-div" style="text-align:right">
                                                                    <span class="s-head-left">PROMO CODE AMOUNT</span>
                                                                </div>
                                                            </td>
                                                            <td colspan="1">
                                                                <div class="s-div" style="text-align:right">
                                                                    <?php if(isset($order->promo_amount) && $order->promo_amount!=''): ?>
                                                                        <span class="s-count-right"><?php echo e($order->promo_amount); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="s-count-right">0.00</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="s-div" style="text-align:right">
                                                                    <span class="s-head-left">GIFT CARD AMOUNT</span>
                                                                </div>
                                                            </td>
                                                            <td colspan="1">
                                                                <div class="s-div" style="text-align:right">
                                                                    <?php if(isset($order->gift_card_amount) && $order->gift_card_amount!=''): ?>
                                                                        <span class="s-count-right"><?php echo e($order->gift_card_amount); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="s-count-right">0.00</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php /*<tr>*/ ?>
                                                            <?php /*<td colspan="2">*/ ?>
                                                                <?php /*<div class="s-div" style="text-align:right">*/ ?>
                                                                    <?php /*<span class="s-head-left">REFFER POINTS AMOUNT</span>*/ ?>
                                                                <?php /*</div>*/ ?>
                                                            <?php /*</td>*/ ?>
                                                            <?php /*<td colspan="2">*/ ?>
                                                                <?php /*<div class="s-div" style="text-align:right">*/ ?>
                                                                    <?php /*<span class="s-count-right">0.00</span>*/ ?>
                                                                <?php /*</div>*/ ?>
                                                            <?php /*</td>*/ ?>
                                                        <?php /*</tr>*/ ?>
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="s-div" style="text-align:right">
                                                                    <span class="s-head-left">PACKAGING COST</span>
                                                                </div>
                                                            </td>
                                                            <td colspan="1">
                                                                <div class="s-div" style="text-align:right">
                                                                    <?php if((isset($order->box_amount) && $order->paper_amount!='') || (isset($order->box_amount) && $order->paper_amount!='')): ?>
                                                                    <span class="s-count-right"><?php echo e(floatval($order->box_amount) + floatval($order->paper_amount)); ?></span>
                                                                    <?php else: ?>
                                                                    <span class="s-count-right">0.00</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="s-div" style="text-align:right">
                                                                    <span class="s-head-left">DISPLAY COST</span>
                                                                </div>
                                                            </td>
                                                            <td colspan="1">
                                                                <div class="s-div" style="text-align:right">
                                                                    <?php if(isset($order->display_amount) && $order->display_amount!=''): ?>
                                                                        <span class="s-count-right"><?php echo e($order->display_amount); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="s-count-right">0.00</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="s-div" style="text-align:right">
                                                                    <span class="s-head-left">TOTAL TAXES</span>
                                                                </div>
                                                            </td>
                                                            <td colspan="1">
                                                                <div class="s-div" style="text-align:right">
                                                                    <?php if(isset($order->order_tax) && $order->order_tax!=''): ?>
                                                                        <span class="s-count-right"><?php echo e($order->order_tax); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="s-count-right">0.00</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">
                                                                <div class="s-div" style="text-align:right">
                                                                    <span class="s-head-left">TOTAL SAVINGS</span>
                                                                </div>
                                                            </td>
                                                            <td colspan="1">
                                                                <div class="s-div" style="text-align:right">
                                                                    <?php if(isset($order->order_discount) && $order->order_discount!=''): ?>
                                                                        <span class="s-count-right"><?php echo e($order->order_discount); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="s-count-right">0.00</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr><tr>
                                                            <td colspan="3">
                                                                <div class="s-div" style="text-align:right">
                                                                    <span class="s-head-left">Grand Total</span>
                                                                </div>
                                                            </td>
                                                            <td colspan="1">
                                                                <div class="s-div" style="text-align:right">
                                                                    <?php if(isset($order->order_total) && $order->order_total!=''): ?>
                                                                        <span class="s-count-right"><?php echo e($order->order_total); ?></span>
                                                                    <?php else: ?>
                                                                        <span class="s-count-right">0.00</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>