<?php $__env->startSection("meta"); ?>
<title>Story</title>
<style>
    .tree{list-style:none;padding:0;font-size: calc(100% - 2px);}
    .tree > li > a {font-weight:bold;}
    .subtree{list-style:none;padding-left:10px;}
    .subtree li:before{content:"-";width:5px;position:relative;left:-5px;}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>
<section class="blogs-blk cms_background">
    <div class="container">
        <div class="heading-holder">
            <div class="main_heading"><span>User Stories</span></div>            
        </div>
        <div class="blog-holder blogs-second blog-detail">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-sx-12">
                    <?php if(count($posts) < 1): ?>
                    <div class="well">We didn't found any post yet.</div>
                    <?php endif; ?>

                    <?php foreach($posts as $key => $post): ?>

                    <?php if( $key > 0 ): ?> <?php endif; ?>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="blog-inf-blk clearfix">
                                <div class="blog-img">
                                    <a href="<?php echo e(url('/story/'.$post->story_url)); ?>"><img src="<?php echo e(asset('storage/app/public/story/'.$post->story_image)); ?>" /></a>
                                </div>

                                <div class="blog-info-holder">
                                    <div class="blog-uploader clearfix">
                                        <?php if($post->story_image): ?>
                                        <div class="bl-upl-img"><img src="<?php echo e(asset('storage/app/public/story/thumbnails/'.$post->story_image)); ?>" /></div>
                                        <?php endif; ?>
                                        <a href="<?php echo e(url('/story/'.$post->story_url)); ?>"><div class="bl-upl-inf"><?php echo e($post->title); ?></div></a>
                                        <div class="blog-date">
                                            <span class="time"><span><i class="fa fa-calendar"></i></span><?php echo e($post->updated_at->format('M d, Y h:i A')); ?></span>
                                        </div>
                                    </div>
                                    <div class="blog-desc">
                                        <h4><a href="javascript void(0);"><?php echo e($post->short_description); ?></a></h4>
                                        <p><?php echo $post->description; ?></p>   
                                        <a href="<?php echo e(url('/story/'.$post->story_url)); ?>">View Comments</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <?php endforeach; ?>
                     <?php echo $posts->links(); ?>
                </div>                
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.front-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>