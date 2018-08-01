<?php $__env->startSection("meta"); ?>

<title>Create Category</title>

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
					<a href="javascript:void(0);">Create Blog Category</a>
					
				</li>
                        </ul>

  
    
      <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
             <div class="portlet-title">
                        <div class="caption">
                                <i class="fa fa-gift"></i> Create A Category
                        </div>

             </div>
             <div class="portlet-body form">
                 <form class="form-horizontal" role="form" action="" method="post" id="create-blog-cat">
            
                 <?php echo csrf_field(); ?>

                 <div class="form-body">
                   <div class="row">
                        <div class="col-md-12">    
                        <div class="col-md-8">  
                         <div class="form-group">
                          <label class="col-md-6 control-label">Name<sup>*</sup></label>
                       
                            <div class="col-md-6">     
                            <input name="name" type="text" class="form-control" id="name" value="<?php echo e(old('name')); ?>">
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
                            <input name="slug" type="text" class="form-control" id="slug" value="<?php echo e(old('slug')); ?>">
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
                                <option value=""> No Parent</option>
                                 <?php foreach($tree as $ls_category): ?>
                                 <option <?php if(old('parent_id')==$ls_category->id): ?> selected="selected" <?php endif; ?> value="<?php echo e($ls_category->id); ?>"><?php echo e($ls_category->display); ?></option>
                                 <?php endforeach; ?>
                             </select>
                                <?php if($errors->has('name')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('parent_id')); ?></strong> </span> <?php endif; ?> </div>
        
                          </div>
                       
                      <div class="form-group">
                         <div class="col-md-12">   
                            <button type="submit" id="submit" class="btn btn-primary  pull-right">Create</button>
                         </div>
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
 <?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>