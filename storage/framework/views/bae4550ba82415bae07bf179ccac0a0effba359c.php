<?php $__env->startSection("meta"); ?>

<title>Update Content Page Info</title>

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
					<a href="<?php echo e(url('admin/content-pages/list')); ?>">Manage Content Pages</a>
                                        <i class="fa fa-circle"></i>
					
				</li>
				<li>
					<a href="javascript:void(0);">Update Content Page</a>
					
				</li>
                        </ul>
      <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Update Content Page
                        </div>

             </div>
             <div class="portlet-body form">
                <form class="form-horizontal" role="form"  method="post" >
            
                 <?php echo csrf_field(); ?>

                 <div class="form-body">
                   <div class="row">
                        <div class="col-md-12">    
                      <div class="col-md-9">  
                         <div class="form-group  <?php if($errors->has('page_title')): ?> has-error <?php endif; ?>">
                          <label for="page_title" class="col-md-3 control-label">Name<sup>*</sup></label>
                       
                            <div class="col-md-9">     
                             <input class="form-control" name="page_title" value="<?php echo e(old('page_title',$page_information->page_title)); ?>" />
                            <?php if($errors->has('page_title')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('page_title')); ?></strong>
                                    </span>
                             <?php endif; ?>
                          </div>
                       
                      </div>
                          <div class="form-group  <?php if($errors->has('page_content')): ?> has-error <?php endif; ?>">
                          <label for="page_content" class="col-md-3 control-label">Page Contents<sup>*</sup></label>
                       
                            <div class="col-md-9">     
                            <textarea class="form-control" name="page_content"><?php echo e(old('page_content',$page_information->page_content)); ?></textarea>
                           <?php if($errors->has('page_content')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('page_content')); ?></strong>
                                    </span>
                            <?php endif; ?>
                          </div>
                       
                      </div>
                          <div class="form-group  <?php if($errors->has('page_alias')): ?> has-error <?php endif; ?>">
                          <label for="page_alias" class="col-md-3 control-label">Page Alias<sup>*</sup></label>
                       
                            <div class="col-md-9">     
                                <input class="form-control" readonly="true" name="page_alias" value="<?php echo e(old('page_alias',$page->page_alias)); ?>" />
                                (Please don't change this)
                               <?php if($errors->has('page_alias')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('page_alias')); ?></strong>
                                    </span>
                                <?php endif; ?>
        
                          </div>
                       
                      </div>
                    <div class="form-group  <?php if($errors->has('page_status')): ?> has-error <?php endif; ?>">
                          <label for="page_status" class="col-md-3 control-label">Page Status<sup>*</sup></label>
                       
                            <div class="col-md-9">     
                                <select class='form-control' name="page_status" id="page_status">
                                    <option value="">--Select--</option>
                                    <option value="1" <?php if($page->page_status=='1'): ?> selected <?php endif; ?>>Published</option>
                                    <option value="0"  <?php if($page->page_status=='0'): ?> selected <?php endif; ?>>UnPublished</option>
                                </select>
                               <?php if($errors->has('page_status')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('page_status')); ?></strong>
                                    </span>
                                <?php endif; ?>
        
                          </div>
                       
                      </div>
                       
                     <div class="form-group  <?php if($errors->has('page_seo_title')): ?> has-error <?php endif; ?>">
                          <label for="page_alias" class="col-md-3 control-label">Page SEO Title <sup>*</sup></label>
                            <div class="col-md-9">     
                               <input class="form-control" name="page_seo_title" value="<?php echo e(old('page_seo_title',$page_information->page_seo_title)); ?>" />
                               <?php if($errors->has('page_seo_title')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('page_seo_title')); ?></strong>
                                    </span>
                                <?php endif; ?>
        
                          </div>
                      </div>
                      <div class="form-group  <?php if($errors->has('page_meta_keywords')): ?> has-error <?php endif; ?>">
                          <label for="page_alias" class="col-md-3 control-label">Page Meta Keywords<sup>*</sup></label>
                       
                            <div class="col-md-9">     
                            <textarea class="form-control" name="page_meta_keywords" ><?php echo e(old('page_meta_keywords',$page_information->page_meta_keywords)); ?></textarea>
                               <?php if($errors->has('page_meta_keywords')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('page_meta_keywords')); ?></strong>
                                    </span>
                                <?php endif; ?>
        
                          </div>
                       
                      </div>
                          <div class="form-group  <?php if($errors->has('page_meta_keywords')): ?> has-error <?php endif; ?>">
                          <label for="page_alias" class="col-md-3 control-label">Page Meta Descriptions<sup>*</sup></label>
                       
                            <div class="col-md-9">     
                           <textarea class="form-control" name="page_meta_descriptions" ><?php echo e(old('page_meta_descriptions',$page_information->page_meta_descriptions)); ?></textarea>
                               <?php if($errors->has('page_meta_descriptions')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('page_meta_descriptions')); ?></strong>
                                    </span>
                                <?php endif; ?>
        
                          </div>
                       
                      </div>
                  <div class="form-group">
                         <div class="col-md-12">   
                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Update Content Page</button>
                         </div>
                  </div>
  
 </div>
              </div>
            </div>
                
             </div>
    
            </form>
        </div>
    </div>
    </div>
    </div>
   <script src="<?php echo e(url('/vendor/unisharp/laravel-ckeditor/ckeditor.js')); ?>"></script> 
<script>
        CKEDITOR.replace( 'page_content' );
    </script>  
 <?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>