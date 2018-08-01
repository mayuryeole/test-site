<?php $__env->startSection("meta"); ?>

<title>Update Category</title>

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
					<a href="<?php echo e(url('admin/blog-categories')); ?>">Manage Categories</a>
                                        <i class="fa fa-circle"></i>
					
				</li>
				<li>
					<a href="javascript:void(0);">Update Blog Category</a>
					
				</li>
                        </ul>

  
    
      <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Update Blog Category
                        </div>

             </div>
             <div class="portlet-body form">
                 <form class="form-horizontal" role="form" action="" method="post" id="update-blog-cat" name="update-blog-cat">
            
                 <?php echo csrf_field(); ?>

                 <div class="form-body">
                   <div class="row">
                        <div class="col-md-12">    
                        <div class="col-md-8">  
                         <div class="form-group">
                          <label class="col-md-6 control-label">Name<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                             <input class="form-control" name="name" value="<?php echo e(old('name',$category->name)); ?>" />
                            <?php if($errors->has('name')): ?>
                              <span class="help-block">
                                  <strong class="text-danger"><?php echo e($errors->first('name')); ?></strong>
                              </span>
                              <?php endif; ?>
                          </div>
                       
                      </div>
                        <div class="form-group">
                          <label class="col-md-6 control-label">URL<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                            <input name="slug" type="text" class="form-control" id="slug" value="<?php echo e(old('slug',$main_catgeoy_details->slug)); ?>">
                            <?php if($errors->has('slug')): ?>
                              <span class="help-block">
                                  <strong class="text-danger"><?php echo e($errors->first('slug')); ?></strong>
                              </span>
                              <?php endif; ?>
                          </div>
                       
                      </div>
                       <div class="form-group">
                          <label class="col-md-6 control-label">Parent Category</label>
                       
                            <div class="col-md-6">     
                             <select class="form-control" name="parent_id" value="<?php echo e(old('parent_id')); ?>">
                                <option value="0">No Parent</option>
                                 <?php foreach($tree as $ls_category): ?>
                                  <?php if($category->id!=$ls_category->id): ?>
                                    <option <?php if(old('parent_id',$parent_id)==$ls_category->id): ?> selected="selected" <?php endif; ?> value="<?php echo e($ls_category->id); ?>"><?php echo e($ls_category->display); ?></option>
                                <?php endif; ?>
                                    <?php endforeach; ?>
                             </select>
                                <?php if($errors->has('name')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('parent_id')); ?></strong> </span> <?php endif; ?> </div>
        
                          </div>
                       
                      </div>
                      <div class="form-group">
                         <div class="col-md-12">   
                             <button type="submit" id="submit" class="btn btn-primary  pull-right" style="margin-right: 350px;">Update</button>
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
 <?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>