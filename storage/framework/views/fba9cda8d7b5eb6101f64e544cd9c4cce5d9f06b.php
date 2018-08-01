<?php $__env->startSection("meta"); ?>
    <title>Rivaah story</title>
    <?php   $cnt=0;  ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
    <section class="our-story-banner">
        <img src="<?php echo e(url('public/media/front/img/paras-story-banner.jpg')); ?>" alt="banner image"/>
        <div class="paras-pos-absu paras-ban-cap">
            <div class="dis_table">
                <div class="disp_tabcell width50">
                    <div class="paras_maxWid">
                        <?php if(isset($rivaah_gal->name) && $rivaah_gal->name!=''): ?>
                        <h1><?php echo e($rivaah_gal->name); ?></h1>
                        <?php else: ?>
                        <h1>Rivaah Gallery Name</h1>
                        <?php endif; ?>
                        <div class="paras-step"></div>
                        <div class="paras-ban-desp">
                        <?php if(isset($rivaah_gal->description) && $rivaah_gal->description!=''): ?>
                                <p id="see-less">
                                    <?php if(isset($rivaah_gal->description) && strlen($rivaah_gal->description)>150): ?>
                                        <?php echo e(stripslashes(substr($rivaah_gal->description,0,200))); ?>

                                    <?php elseif(isset($rivaah_gal->description) && strlen($rivaah_gal->description)<150): ?>
                                        <?php echo e(stripslashes($rivaah_gal->description)); ?>

                                    <?php endif; ?>
                                </p>

                        </div>
                        <?php endif; ?>
                        <?php if(isset($rivaah_gal_img) && count($rivaah_gal_img)>0): ?>
                        <div class="view-more">
                            <a href="<?php echo e(url('rivaah-story-semi-details').'/'. $rivaah_gal_img->id); ?>">view more</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="dis_tabcell wid50 vis_hid"></div>
            </div>
        </div>
    </section>
    <?php if(isset($all_rivaah_gal_img) && count($all_rivaah_gal_img)>0): ?>
     <?php foreach($all_rivaah_gal_img as $img): ?>
         <?php  $cnt++;
          $gallery = \App\PiplModules\rivaah\Models\RivaahGallery::where('id',$img->rivaah_gallery_id)->first();
          ?>
    <section class="history-details">
        <div class="container">
            <?php if($cnt % 2 == 0): ?>
                <div id="dv-story-holder-<?php echo e($gallery->id); ?>-0" class="view-story-here">
                    <div  class="table-cell story-content width50">
                        <h4><?php echo e($gallery->name); ?></h4>
                        <p id="see-less_<?php echo e($gallery->id); ?>">
                            <?php if(isset($gallery->description) && strlen($gallery->description)>150): ?>
                                <?php echo e(stripslashes(substr($gallery->description,0,150))); ?>

                                <?php else: ?>
                                <?php echo e(stripslashes($gallery->description)); ?>

                            <?php endif; ?>
                        </p>
                        <div class="view-more">
                            <a href="<?php echo e(url('rivaah-story-semi-details').'/'. $img->id); ?>">view more</a>
                        </div>
                    </div>
                    <div class="table-cell story-image width50">
                        <img src="<?php echo e(url('storage/app/public/rivaah/images/').'/'.$img->image); ?>" alt="story image"/>
                    </div>
                </div>
            <?php else: ?>
                <div id="dv-story-holder-<?php echo e($gallery->id); ?>-1" class="view-story-here">
                    <div class="table-cell story-image width50">
                        <img src="<?php echo e(url('storage/app/public/rivaah/images/').'/'.$img->image); ?>" alt="story image"/>
                    </div>
                    <div class="table-cell story-content width50">
                        <h4><?php echo e($gallery->name); ?></h4>
                        <p id="see-less_<?php echo e($gallery->id); ?>">
                            <?php if(isset($gallery->description) && strlen($gallery->description)>150): ?>
                                <?php echo e(stripslashes(substr($gallery->description,0,150))); ?>

                            <?php else: ?>
                                <?php echo e(stripslashes($gallery->description)); ?>

                            <?php endif; ?>
                        </p>
                        <p id="see-more_<?php echo e($gallery->id); ?>" style="display: none;" >

                            <?php echo e(stripslashes($gallery->description)); ?><a id="see-more-anchor_<?php echo e($gallery->id); ?>" href="javascript:void(0);" onclick="replaceDown(this.id)">See less</a>

                        </p>
                        <div  class="view-more">
                            <a href="<?php echo e(url('rivaah-story-semi-details').'/'. $img->id); ?>">view more</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endforeach; ?>
   <div style="text-align:right;margin-right:10%"> <?php echo $all_rivaah_gal_img->render(); ?></div>
    <?php endif; ?>
    <script>
        var cnt;
        function replaceUp(id)
        {
            cnt = id.split('_').pop();
            if(id == "see-less-anchor")
            {
                $("#see-more").show();
                $("#see-less").hide();
            }
            else{
                $("#see-more_"+cnt).show();
                $("#see-less_"+cnt).hide();
            }

        }
        function replaceDown(id)
        {
            cnt = id.split('_').pop();
            if(id == "see-more-anchor"){
                $("#see-more").hide();
                $("#see-less").show();
            }
            else{
                $("#see-more_"+cnt).hide();
                $("#see-less_"+cnt).show();
            }

        }
    </script>
    <script>
        // $(function(){
        //     var len =$('.view-story-here').length;
        //      for(var i =0; i<len;i++)
        //      {
        //         var elid = $('.view-story-here:eq('+ i +')').attr('id');
        //         var cnt = elid.split('-').pop();
        //         if(cnt == 1)
        //         {
        //             $('#'+elid).children('.story-content').insertAfter('.story-img');
        //         }
        //      }
        //     // $('.view-story-here').forEach(function(element) {
        //     //     console.log(element.id);
        //     // });
        // });
        // $('.view-story-here:eq(1)').attr('id').split('-').pop();

        jQuery(window).resize(function()
        {
            if (jQuery(window).width() <= 767)
            {
                var len =$('.view-story-here').length;
                for(var i =0; i<len;i++)
                    {
                        var elid = $('.view-story-here:eq('+ i +')').attr('id');
                        var cnt = elid.split('-').pop();
                        if(cnt == 0)
                        {
                            var content =$('#'+ elid).children('.story-content');
                            var image =$('#'+ elid).children('.story-image');
                            $(content).insertAfter(image);
                        }
                    }
                }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.front-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>