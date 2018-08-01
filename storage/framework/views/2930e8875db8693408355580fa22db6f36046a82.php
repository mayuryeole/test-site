<?php $__env->startSection('content'); ?>
    <section class="h-inner-banner" style="background-image:url('<?php echo e(url('public/media/front/img/inner-banner.jpg')); ?>');">
        <div class="container relative manage-bottm-head">
            <div class="h-caption">
                <!-- <h3 class="h-inner-heading">Gift E-Vouchers</h3> -->
                <!-- <ul class="cust-breadcrumb">
                    <li><a href="javascript:void(0);">Home</a></li>
                    <li>>></li>
                    <li>E Gift Card</li>
                </ul> -->
            </div>
        </div>
    </section>
    <section class="cust-bread">
        <div class="container">
            <ul class="clearfix">
                <li><a href="http://parasfashions.com">Home</a></li>
                <li>Gift E-Vouchers</li>
            </ul>
        </div>
    </section>
    <section class="h-ecard-page manage-gift-cards">
        <div class="container">
            <?php if(session('purchase-status')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('purchase-status')); ?>

                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
            <?php endif; ?>
            <div class="h-card-inner">
                <h3>Paras Fashion Experiences Gift Card</h3>
                <p>Gift these E Vouchers to your loved ones .A wonderful way to Celebrate life's special moments or in that case any emotional moments when your heart fills with sudden touching gestures and goes out all to gift to special occasions or people in your life  but you are stuck and doubtful with their likes .....So here comes the easiest solution - our E voucher services ....especially made and easily customizable to meet your needs....</p>
                <p>Gift these E Vouchers making it easier for you and for your special ones. Our Gift E vouchers gives you full flexibility . You have the comfort of buying them easily online even at the last 
                moment and send directly in emails..These will cater to  " those moments which were suddenly remembered "  or even those moments which were planned  in advance such as Engagement , sangeet or marriage ceremony  without even going anywhere  , you will require only access to our website ...so anytime, anywhere , any amount you want you get the benefits of full flexibly at your finger  tips.
                </p>
            </div>
            <div class="card-product-image clearfix">
                <div class="card-pro-img">
                    <img <?php if(isset($giftCard) && count($giftCard)>0): ?>src="<?php echo e(url('storage/app/public/gift_card_image').'/'.$giftCard->image); ?>" <?php endif; ?> alt="image"/>
                </div>
                <div class="card-accordion-info">
                    <div class="panel-group" id="accordion" role="tablist">
                        <div class="panel panel-default">
                            <div class="panel-heading relative">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#one" aria-expanded="true">
                                    Description
                                    <span><i class="fa fa-minus"></i></span>
                                </a>
                            </div>
                            <div id="one" class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body">
                                    <?php if(isset($giftCard) && count($giftCard)>0): ?>
                                    <p><?php echo e($giftCard->description); ?></p>
                                     <?php else: ?>
                                        <p>Description not available</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading relative">
                                <a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#two" aria-expanded="true">
                                    Redemption Details
                                    <span><i class="fa fa-minus"></i></span>
                                </a>
                            </div>
                            <div id="two" class="panel-collapse collapse" role="tabpanel">
                                <div class="panel-body">
                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.</p>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading relative">
                                <a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#three" aria-expanded="true">
                                    Terms & Conditions
                                    <span><i class="fa fa-minus"></i></span>
                                </a>
                            </div>
                            <div id="three" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <form id="purchase-gift-card-form" name="purchase_gift_card" action="<?php echo e(url('/indipay/request')); ?>" role="form" method="post" enctype="multipart/form-data">
            <div class="card-details">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" id="min-purchase-amt" name="min_purchase_amt" value="<?php echo e($giftCard->price); ?>">
                <input type="hidden" id="ip-gift-card-id" name="gift_card_id" value="<?php echo e($giftCard->id); ?>">
                <h3 class="card-title"><span>Enter Gift Card details</span></h3>
                <div class="gift-amount">
                    <div class="gift-amt">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="h-title">Value of Card <sup style="color: red">*</sup>:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="amount" name="amount" type="text" class="form-control" placeholder=" minimum purchase amount <?php echo e($giftCard->price); ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gift-amt">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="h-title">Receiver Email Id<sup style="color: red">*</sup>:</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input name="email" id="receiver-email" type="email" class="form-control" placeholder="Enter Email Id:"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="gift-amt">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-6 text-center">
                                        <button type="submit" class="pay-now">Pay Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>
    <?php /*<script>*/ ?>
       <?php /*var amt = $('#amount').val();*/ ?>
       <?php /*var email = $('#receiver-email').val();*/ ?>
            <?php /*function chkMinPurchaseAmt(){*/ ?>
                <?php /*if(amt !='' && email !=''){*/ ?>
                    <?php /**/ ?>
                    <?php /*return true;*/ ?>
                <?php /*}*/ ?>
                <?php /*return false;*/ ?>
            <?php /*}*/ ?>
    <?php /*</script>*/ ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>