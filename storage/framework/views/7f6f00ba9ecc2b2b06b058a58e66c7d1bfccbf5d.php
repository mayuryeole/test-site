

<?php $__env->startSection("meta"); ?>

<title>Update Newsletter</title>

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
					<a href="<?php echo e(url('admin/newsletters')); ?>">Manage Newsletters</a>
                                        <i class="fa fa-mail-forward"></i>
					
				</li>
				<li>
					<a href="javascript:void(0);">Update Newsletter</a>
					
				</li>
                        </ul>

  
    
      <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Update Newsletter
                        </div>

             </div>
             <div class="portlet-body form">
                 
                 <form class="form-horizontal"role="form" method="post" enctype="multipart/form-data">
              
                 <?php echo csrf_field(); ?>

                 <div class="form-body">
                   <div class="row">
                        <div class="col-md-12">    
                      <div class="col-md-9">  
                         <div class="form-group  <?php if($errors->has('subject')): ?> has-error <?php endif; ?>">
                          <label for="page_title" class="col-md-3 control-label">Subject<sup>*</sup></label>
                       
                            <div class="col-md-9">     
                             <input class="form-control" name="subject" value="<?php echo e(old('subject',$newsletter->subject)); ?>" />
                            <?php if($errors->has('subject')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('subject')); ?></strong>
                                    </span>
                             <?php endif; ?>
                          </div>
                       
                      </div>
                          <div class="form-group  <?php if($errors->has('nl_content')): ?> has-error <?php endif; ?>">
                          <label for="page_content" class="col-md-3 control-label">Contents<sup>*</sup></label>
                       
                            <div class="col-md-9">     
                            <textarea class="form-control" name="nl_content"><?php echo e(old('nl_content',$newsletter->content)); ?></textarea>
                           <?php if($errors->has('nl_content')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('nl_content')); ?></strong>
                                    </span>
                            <?php endif; ?>
                          </div>
                      </div>
                    <div class="form-group  <?php if($errors->has('page_status')): ?> has-error <?php endif; ?>">
                          <label for="page_status" class="col-md-3 control-label">Page Status<sup>*</sup></label>
                       
                            <div class="col-md-9">     
                                <select class='form-control' name="status" id="status">
                                    <option value="">--Select--</option>
                                    <option value="1" <?php if(old('status',$newsletter->status)=='1'): ?> selected <?php endif; ?>>Published</option>
                                    <option value="0" <?php if(old('status',$newsletter->status)=='0'): ?> selected <?php endif; ?> >UnPublished</option>
                                </select>
                               <?php if($errors->has('status')): ?>
                                    <span class="help-block">
                                        <strong class="text-danger"><?php echo e($errors->first('status')); ?></strong>
                                    </span>
                                <?php endif; ?>
        
                          </div>
                       
                      </div>
                       <div class="form-group">
                         <div class="col-md-12">
                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Update</button>  
                             <button onclick="javascript:window.history.go(-1);" type="button" class="btn btn-warning pull-right" style="margin-right: 15px;">Back</button>
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
        <style>
            .submit-btn{
                padding: 10px 0px 0px 18px;
            }
        </style>
<script src="<?php echo e(url('/vendor/unisharp/laravel-ckeditor/ckeditor.js')); ?>"></script> 
<script>
        CKEDITOR.replace( 'content' );
    </script> 
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>