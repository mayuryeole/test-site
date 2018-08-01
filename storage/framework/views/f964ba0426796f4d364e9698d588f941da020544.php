<?php $__env->startSection('content'); ?>
    <section class="product-listing-blk h-product-listing-blk product-gift-card-list">
        <div class="container">
            <div class="product-list-grid">
                <?php if(isset($giftCards) && count($giftCards)>0): ?>
                <ul class="product-list row">
                     <?php foreach($giftCards as $card): ?>
                    <li class="col-md-4 col-sm-6 col-xs-12">
                        <div class="product-item-wrapper">
                                <div class="product-item clearfix">
                                    <div class="product-thumbnail">
                                        <a href="<?php echo e(url('/gift-card').'/'. $card->id); ?>">
                                          <img src="<?php echo e(url('storage/app/public/gift_card_image').'/'.$card->image); ?>" alt="product image"/>
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <div class="h-product-info-blk clearfix">
                                            <h3 class="pull-left">
                                                <span class="title"><a href="<?php echo e(url('/gift-card').'/'. $card->id); ?>"><?php echo e($card->name); ?></a></span>
                                                <?php /*<span class="prod-description"><?php echo e($card->description); ?></span>*/ ?>
                                            </h3>
                                            <div class="prod-price pull-right"><?php echo e(\App\Helpers\Helper::getCurrencySymbol().round(App\Helpers\Helper::getRealPrice($card->price),4)); ?></div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>