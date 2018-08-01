<?php $__env->startSection("meta"); ?>

<title>Update Email Template</title>

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
					<a href="<?php echo e(url('admin/email-templates/list')); ?>">Manage Email Templates</a>
                                        <i class="fa fa-circle"></i>
					
				</li>
				<li>
					<a href="javascript:void(0);">Update Email Template</a>
					
				</li>
                        </ul>

  
    
      <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Update Email Template
                        </div>

             </div>
             <div class="portlet-body form">
                <form class="form-horizontal" name="frm_emailtemplate_update" id="frm_emailtemplate_update" role="form"  method="post" >
            
                 <?php echo csrf_field(); ?>

                 <div class="form-body">
                   <div class="row">
                        <div class="col-md-12">    
                      <div class="col-md-9">  
                       <div class="form-group  <?php if($errors->has('subject')): ?> has-error <?php endif; ?>">
                          <label for="subject" class="col-md-3 control-label">Subject<sup>*</sup></label>
                       
                            <div class="col-md-9">     
                            <input class="form-control" name="subject" value="<?php echo e(old('subject',$template_info->subject)); ?>" />
                            <?php if($errors->has('subject')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('subject')); ?></strong>
                                    </span>
                             <?php endif; ?>
                          </div>
                       
                      </div>
                         <div class="form-group  <?php if($errors->has('html_content')): ?> has-error <?php endif; ?>">
                          <label for="html_content" class="col-md-3 control-label">Content <sup>*</sup></label>
                       
                            <div class="col-md-9">     
                           <textarea class="form-control" id="html_content" name="html_content"><?php echo e(old('html_content',$template_info->html_content)); ?></textarea>
                            <?php if($errors->has('html_content')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('html_content')); ?></strong>
                                    </span>
                             <?php endif; ?>
                          </div>
                       
                      </div>
                           <div class="form-group  <?php if($errors->has('subject')): ?> has-error <?php endif; ?>">
                          <label for="subject" class="col-md-3 control-label">Keywords</label>
                       
                            <div class="col-md-9">
                            <select class="form-control"  onchange="jQuery('#keyword-preview').text(jQuery(this).val())">
                                <?php $keyword_list = explode(",",$template_info->template_keywords) ?>
                                 <option value="">Select Keyword</option>
                                 <?php foreach($keyword_list as $keyword): ?>
                                 <option><?php echo $keyword; ?></option>
                                 <?php endforeach; ?>
                            </select>
                            <br />
                            <div id="keyword-preview"></div>
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
    
            </form>
        </div>
    </div>
    </div>
    </div>
   <script src="<?php echo e(url('/vendor/unisharp/laravel-ckeditor/ckeditor.js')); ?>"></script> 
<script>
        CKEDITOR.replace( 'html_content' );
    </script>  
 <?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>