<?php $__env->startSection("meta"); ?>
<title>Update Blog Post</title>
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
					<a href="<?php echo e(url('admin/blog')); ?>">Manage Blogs</a>
                                        <i class="fa fa-circle"></i>
					
				</li>
				<li>
					<a href="javascript:void(0);">Update Blog</a>
					
				</li>
                        </ul>

  
    
      <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Update Blog
                        </div>

             </div>
             <div class="portlet-body form">
                 <form class="form-horizontal" name="update_blog" id="update_blog" role="form" action="" method="post" enctype="multipart/form-data">
            
                 <?php echo csrf_field(); ?>

                 <div class="form-body">
                   <div class="row">
                        <div class="col-md-12">    
                        <div class="col-md-8">  
                         <div class="form-group <?php if($errors->has('title')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">Title<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                              <input class="form-control" name="title" value="<?php echo e(old('title',$post->title)); ?>" />
                               <?php if($errors->has('title')): ?> 
                                    <span class="help-block"> 
                                        <strong class="text-danger"><?php echo e($errors->first('title')); ?></strong> 
                                    </span>
                               <?php endif; ?>
                          </div>
                       
                      </div>
                       <div class="form-group <?php if($errors->has('short_description')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">Short Description <sup>*</sup></label>
                          <?php if($errors->has('question')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('short_description')); ?></strong>
                                    </span>
                             <?php endif; ?>
                            <div class="col-md-6">     
                                <textarea class="form-control" name="short_description" ><?php echo e(old('short_description',$post->short_description)); ?></textarea>
                            <?php if($errors->has('short_description')): ?>
                              <span class="help-block">
                                  <strong class="text-danger"><?php echo e($errors->first('short_description')); ?></strong>
                              </span>
                              <?php endif; ?>
                          </div>
                       
                      </div>
                     <div class="form-group <?php if($errors->has('url')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">URL<sup>*</sup></label>
                            <div class="col-md-6">     
                              <input class="form-control" name="url" value="<?php echo e(old('url',$ori_post->post_url)); ?>" />
                               <?php if($errors->has('url')): ?> 
                                    <span class="help-block"> 
                                        <strong class="text-danger"><?php echo e($errors->first('url')); ?></strong> 
                                    </span>
                               <?php endif; ?>
                          </div>
                       
                      </div>         
                   <?php if(count($tree)>0 && empty($locale)): ?>
                     <div class="form-group <?php if($errors->has('category')): ?> has-error <?php endif; ?>">
                        <label for="category" class="col-md-6 control-label">Select Category </label>
                      <div class="col-md-6">     
                        <select name="category" class="form-control">
                           <option value="0">No Category</option>
                                    <?php foreach($tree as $ls_category): ?>
                                    <option <?php if(old('category',$category)==$ls_category->id): ?> selected="selected" <?php endif; ?> value="<?php echo e($ls_category->id); ?>"><?php echo e($ls_category->display); ?></option>
                                    <?php endforeach; ?>
                        </select>
                            <?php if($errors->has('category')): ?>
                                <span class="help-block">
                                    <strong class="text-danger"><?php echo e($errors->first('category')); ?></strong>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?> 
                        
                        <div class="form-group <?php if($errors->has('photo')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">Image<sup>*</sup></label>
                            <div class="col-md-6">
                              <div class="<?php if(!empty($ori_post->post_image)): ?> input-group <?php endif; ?>"> <?php if(!empty($ori_post->post_image)): ?><span class="input-group-addon" id="basic-addon3"><img src="<?php echo e(asset('storage/app/public/blog/thumbnails/'.$ori_post->post_image)); ?>" height="20" style="cursor:pointer" onclick="window.open('<?php echo e(asset('storage/app/public/blog/'.$ori_post->post_image)); ?>','Image','width=200,height=200,left=('+screen.width-200+'),top=('+screen.height-200+')')" /></span><?php endif; ?>
                                <input type="file" class="form-control" name="photo" />
                                  <?php if(!empty($ori_post->post_image)): ?><span class="input-group-addon"><a href="javascript:void(0)" title="Remove Photo" type="button" onclick="if(confirm('Are you sure to remove photo for this post?')){window.open('<?php echo e(url('admin/blog-post/remove-photo/'.$ori_post->id)); ?>','removePhoto','width=50,height=50');}"><i class="fa fa-remove text-danger"></i></a></span><?php endif; ?> </div>
                                    <?php if($errors->has('photo')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('photo')); ?></strong> </span> <?php endif; ?> </div>
                
                          </div>
                       
                       <div class="form-group <?php if($errors->has('allow_comments')): ?> has-error <?php endif; ?>">
                           <label class="col-md-6 control-label">Allow comments?<sup>*</sup></label>
                            <div class="col-md-6">     
                               <label class="radio-inline"><input type="radio" name="allow_comments" value="1" <?php if(old('allow_comments',$ori_post->allow_comments)=='1'): ?> checked="checked" <?php endif; ?> required>Yes</label> <label class="radio-inline"><input type="radio" name="allow_comments" value="0"  <?php if(old('allow_comments',$ori_post->allow_comments)=='0'): ?> checked="checked" <?php endif; ?>>No</label>
                               <?php if($errors->has('allow_comments')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('allow_comments')); ?></strong> </span> <?php endif; ?> 
                          </div>
                       
                      </div> 
                     <div class="form-group <?php if($errors->has('allow_attachments_in_comments')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">Allow attachments in comments?</label>
                            <div class="col-md-6">     
                               <label class="radio-inline"><input type="radio" name="allow_attachments_in_comments" value="1" <?php if(old('allow_attachments_in_comments',$ori_post->allow_attachments_in_comments)=='1'): ?> checked="checked" <?php endif; ?>>Yes</label> <label class="radio-inline"><input type="radio" name="allow_attachments_in_comments" value="0"  <?php if(old('allow_attachments_in_comments',$ori_post->allow_attachments_in_comments)=='0'): ?> checked="checked" <?php endif; ?>>No</label>
                               <?php if($errors->has('allow_attachments_in_comments')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('allow_attachments_in_comments')); ?></strong> </span> <?php endif; ?> 
                          </div>
                       
                      </div> 
                     <div class="form-group <?php if($errors->has('post_status')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">Publish Status<sup>*</sup></label>
                            <div class="col-md-6">     
                             <label class="radio-inline"><input type="radio" name="post_status" value="1" <?php if(old('post_status',$ori_post->post_status)=='1'): ?> checked="checked" <?php endif; ?> required>Published</label> <label class="radio-inline"><input type="radio" name="post_status" value="0"  <?php if(old('post_status',$ori_post->post_status)=='0'): ?> checked="checked" <?php endif; ?>>Not Published</label>
                             <?php if($errors->has('post_status')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('post_status')); ?></strong> </span> <?php endif; ?> 
                          </div>
                       
                      </div> 
                     <div class="form-group <?php if($errors->has('tags')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">Tags</label>
                            <div class="col-md-6">
                               <input type="text" id="tags" class="form-control" name="tags" value="<?php echo e(old('tags',$post_tags)); ?>"  />
                                 <?php if($errors->has('tags')): ?>
                                        <span class="help-block">
                                            <strong class="text-danger"><?php echo e($errors->first('tags')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                          </div>
                       
                      </div> 
                      <div class="form-group <?php if($errors->has('seo_title')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">SEO Title<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                                <input class="form-control" name="seo_title" value="<?php echo e(old('seo_title',$post->seo_title)); ?>" />
                                <?php if($errors->has('seo_title')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('seo_title')); ?></strong> </span> <?php endif; ?>
                          </div>
                       
                      </div>
                    <div class="form-group <?php if($errors->has('seo_keywords')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">SEO Keyword<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                                <input class="form-control" name="seo_keywords" value="<?php echo e(old('seo_keywords',$post->seo_keywords)); ?>" />
                                <?php if($errors->has('seo_keywords')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('seo_keywords')); ?></strong> </span> <?php endif; ?>
                          </div>
                       
                      </div>
                     <div class="form-group <?php if($errors->has('seo_description')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">SEO Description<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                                <input class="form-control" name="seo_description" value="<?php echo e(old('seo_description',$post->seo_description)); ?>" />
                                <?php if($errors->has('seo_description')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('seo_description')); ?></strong> </span> <?php endif; ?>
                          </div>
                       
                      </div>
                     
                      <div class="form-group <?php if($errors->has('attachments')): ?> has-error <?php endif; ?>">
                          <label class="col-md-6 control-label">Attachments</label>
                            <div class="col-md-6">
                                 <input type="file" class="form-control" multiple="multiple" name="attachments[]" />
                                 <?php if($errors->has('attachments')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('attachments')); ?></strong> </span> <?php endif; ?> </div>
                                
                      <?php if(count($ori_post->post_attachments)): ?>
                         <div class="form-group">
                          <label class="col-md-6 control-label"></label>
                           
                                  <div class="col-md-6">
                                    <div class="panel panel-default" style='margin: 10px 0px'>
                                      <div class="panel-heading">Attachment(s)</div>
                                      <div class="panel-body">
                                        <ul class="list-unstyled">
                                          <?php foreach($ori_post->post_attachments as $key=>$attachment): ?>
                                          <li><a target="new" href="<?php echo e(asset('storageasset/blog/'.$attachment['original_name'])); ?>"><i class="fa fa-download"></i> <?php echo e($attachment['display_name']); ?></a> <a href="javascript:void(0);" onclick="if(confirm('Are you sure to remove attachment?')){window.open('<?php echo e(url('admin/blog-post/remove-attachment/'.$ori_post->id.'/'.$key)); ?>','removeAttachment','width=50,height=50');}" title="Remove this attachment" target="new"><i class="fa fa-remove text-danger"></i></a></li>
                                          <?php endforeach; ?>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                               
                          </div>
                         
                      <?php endif; ?>
                       </div>

                       <div class="form-group <?php if($errors->has('description')): ?> has-error <?php endif; ?>">
                           <label class="col-md-6 control-label">Description<sup>*</sup></label>
                         <div class="col-md-6">   
                             <textarea class="form-control" name="description" id="description" maxlength="300" minlength="50"><?php echo e(old('description',$post->description)); ?></textarea>
                              <?php if($errors->has('description')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong> </span> <?php endif; ?>
                         </div>
                    </div>
                    
                      <div class="form-group">
                         <div class="col-md-12">   
                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Update</button>
                         </div>
                          
                      </div>
                       </div> 
                  </div>
                </div>
              </div>
            <!--</div>-->
             </form>
        </div>
    </div>
    </div>
    </div>
    <script type="text/javascript">
    $("#photo").on("change", function(e) {

        var flag='0';
        var fileName = e.target.files[0].name;
        var arr_file = new Array();
        arr_file = fileName.split('.');
        var file_ext = arr_file[1];
        if(file_ext=='jpg'||file_ext=='JPG'||file_ext=='jpeg'||file_ext=='JPEG'||file_ext=='png'||file_ext=='PNG'|| file_ext=='GIF'||file_ext=='gif')
        {

            var files = e.target.files,

                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i];
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                    $("#imagePreview").show();
                    $("#imagePreview").attr("src",e.target.result );



                });
                fileReader.readAsDataURL(f);
            }
        } else{
            $("#photo").val('');
            alert('Please choose valid image extension. eg : jpg | jpeg | png |gif');
            return false;
        }

    });

</script>
   <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<!--  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
  <script src="<?php echo e(url('/vendor/unisharp/laravel-ckeditor/ckeditor.js')); ?>"></script> 
<script>
        CKEDITOR.replace( 'description' );
    </script>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>