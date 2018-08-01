<?php $__env->startSection("meta"); ?>
    <title>Rivaah story</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
    <?php if(isset($gal_details) && count($gal_details)>0): ?>
    <section class="our-story-banner sem-details-banner" style="background-image:url('<?php echo e(url("public/media/front/img/paras-story-banner.jpg")); ?>');">
        <div class="paras-pos-absu paras-ban-cap">
            <div class="dis_table">
                <div class="disp_tabcell width50">
                    <div class="paras_maxWid">
                        <h1><span><?php if(!empty($gal_details->name)): ?><?php echo e($gal_details->name); ?> <?php endif; ?></span> Fashions Details</h1>
                        <div class="paras-step"></div>
                    </div>
                </div>
                <div class="dis_tabcell wid50 vis_hid"></div>
            </div>
        </div>
    </section>
    <section class="history-semi-details">
        <div class="container">
            <div class="par-semi-details clearfix">
                <div class="semi-left-img pull-left">
                    <img src="<?php echo e(url('storage/app/public/rivaah/images').'/'.$gal_img_details->image); ?>">
                </div>
                <div class="semi-details">
                    <h4>The <?php if(!empty($gal_details->name)): ?><?php echo e($gal_details->name); ?> <?php endif; ?> Bride</h4>
                    <div class="semi-description">
                        <p> <?php echo e(stripslashes($gal_details->description)); ?></p>
                      </div>
                    <div class="view-more">
                        <a href="<?php echo e(url('rivaah-story-details').'/'. $gal_img_details->id); ?>">view Product List</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.front-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>