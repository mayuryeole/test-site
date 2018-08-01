 
<?php $__env->startSection('meta'); ?>
<title><?php echo e($page_information->seo_title); ?></title>
<meta name="keywords" content="<?php echo e($page_information->seo_keywords); ?>" />
<meta name="description" content="<?php echo e($page_information->seo_description); ?>" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection("content"); ?>
<section class="blogs-blk cms_background">
    <div class="container">
        <div class="heading-holder">
            <div class="main_heading"><span>Story Details</span></div>            
        </div>
        <div class="blog-holder blogs-second blog-detail">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-sx-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="blog-inf-blk clearfix">
                                <div class="blog-info-holder">
                                    <div class="blog-uploader clearfix">
                                        <?php if($page->story_image): ?>
                                        <div class="bl-upl-img"><img src="<?php echo e(asset('storage/app/public/story/'.$page->story_image)); ?>" /></div>
                                        <?php endif; ?>
                                        <div class="bl-upl-inf"><?php echo e($page_information->title); ?></div>

                                    </div>
                                    <div class="blog-desc">
                                        <p><?php echo $page_information->description; ?></p>                                     
                                    </div>
                                    <br>
                                    <?php if(isset($page->story_attachments) && count($page->story_attachments)>0): ?>
                                    
                                    <div class="blog-attachment">
                                        <p class="bl-upl-inf">Attachments:</p>
                                        <div class="story-img-block">
                                            <div class="story-slider owl-carousel">
                                                <?php foreach($page->story_attachments as $p): ?>
                                                <div class="item">
                                                    <div class="story-img-holder">
                                                        <img src="<?php echo e(url("storage/app/public/story/attachments/".$p['original_name'])); ?>">
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
<!--                                                <?php foreach($page->story_attachments as $p): ?>

                                                <a href="<?php echo e(url("storage/app/public/story/attachments/".$p['original_name'])); ?>" target="blank"> <?php echo e($p["display_name"]); ?>

                                                    <img style="width:50px;height:50px;" src='<?php echo e(url("storage/app/public/blog/attachments/".$p['original_name'])); ?>'>
                                                </a>

                                                  <?php endforeach; ?>-->
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>                
            </div>
        </div>
        
        <div class="row">
             <?php if(isset($page_information->post) && $page_information->post->allow_comments==1): ?>
             <?php if(isset(\Auth::user()->id)): ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="comment-blk">
                    <form class="form-comment" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="form-group <?php if($errors->has('comment')): ?> has-error <?php endif; ?>"">
                            <label class="enter_comment">Comment: </label>
                            <textarea type="text" name="comment" class="form-control" placeholder="Enter Your Comment Here"> </textarea>
                            <?php if($errors->has('comment')): ?>
                            <span class="help-block">
                                <strong class="text-danger"><?php echo e($errors->first('comment')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                        <?php if($page_information->post->allow_attachments_in_comments==1): ?>
                        <div class="form-group <?php if($errors->has('attachments')): ?> has-error <?php endif; ?>"">
                            <label class="enter_comment">Select Images: </label>
                            <input  type="file" name="attachments[]" class="form-control" accept="image/*"  multiple="" > 
                            <?php if($errors->has('attachments')): ?>
                            <span class="help-block">
                                <strong class="text-danger"><?php echo e($errors->first('attachments')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <div class="comment-btn">
                            <button type="submit" class="btn btn-submit comment-btn">Post A Comment</button>
                            <a href="<?php echo e(url('/get-all-user-stories/user-story')); ?>"><button type="button" class="btn btn-submit comment-btn">Back</button></a>
                        </div>
                    </form>
                </div>
            </div>
             <?php endif; ?>
             <?php endif; ?>
             <?php if(isset($page_information->post) && $page_information->post->allow_comments==1): ?>
       
            <div class="col-md-6 col-sm-6 col-xs-12">
            	<div class="comment-lists ">
                	<label class="enter_comment">View Comment: </label>
                    <div class="comment-lis mCustomScrollbar">
                    	<ul class="cooment">
                            <?php if(count($comments)>0): ?>
                             <?php foreach($page->comments()->get() as $comment): ?>
       						
                        	<li>
                              <div class="media media-bg">
                                  <?php if($page->story_image): ?>
                                    <div class="media-left">
                                      <img src="<?php echo e(asset('storage/app/public/story/'.$page->story_image)); ?>" class="media-object mediad-imgs" 
                                      style="width:60px" >
                                    </div>
                                  <?php endif; ?>
                                    <div class="media-body comment-p">
                                    	<div class="like-reply">
                                            <div class="like">
                                                <span><i class="fa fa-thumbs-o-up c-like"></i><?php if(isset($comment->created_at) && $comment->created_at!=""): ?><?php echo e($comment->created_at->format('M d \a\t h:i a')); ?><?php endif; ?></span>
                                            </div>
                                        </div>
                                      <h4 class="media-heading">Posted By: <?php if(isset($comment->commentUser->userInformation->first_name) && $comment->commentUser->userInformation->first_name!=""): ?><?php echo e($comment->commentUser->userInformation->first_name); ?> <?php endif; ?></h4>
                                      <p>Comment: <?php if(isset($comment->comment) && $comment->comment!=""): ?><?php echo e($comment->comment); ?> <?php endif; ?></p>
                                       
                                    </div>
                                  <?php if(isset($comment->comment_attachments) && count($comment->comment_attachments)>0): ?>
                                  <div class="comment-attachment">                                      </p>
Attachments:
                                      <p style="font-size: 14px;">
                                      <?php foreach($comment->comment_attachments as $c): ?>
                                     
                                      <a class="" href="<?php echo e(asset('storage/app/public/story/comment_attachment/'.$c["original_name"])); ?>" target="blank"><?php echo e($c["display_name"]); ?></a>
                                       <br>    
                                      <?php endforeach; ?>
                                                                                </p>

                                      </div>
            
                                  <?php endif; ?>
                            </div>
                       	 </li>
                          <?php endforeach; ?>
                          
                          <?php else: ?>
                          <li>
                              <div class="media media-bg">
                                        <marquee><span>No comments available,You can post here!! </span></marquee>
                     
                            </div>
                          </li>
                          <?php endif; ?>
                          
                       </ul>
                    </div>
				</div>
            </div>
             <?php endif; ?>
        </div>
      
        

       
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.front-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>