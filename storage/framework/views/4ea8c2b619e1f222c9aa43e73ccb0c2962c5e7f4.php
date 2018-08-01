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
                <a href="<?php echo e(url('admin/categories-list')); ?>">Manage Categories</a>
                <i class="fa fa-circle"></i>

            </li>
            
            <li>
                <a href="javascript:void(0);">Update Sub-Category</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update Sub-Category
                </div>

            </div>
            <div class="portlet-body form">
                <!--<form class="form-horizontal" id="create-sub-sub-cat" role="form" action="" method="post" id="update-cat" >-->
<form class="form-horizontal" id="update-cat" role="form" action="" method="post" id="update-cat" >

                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Name<sup>*</sup></label>
                                        <div class="col-md-6">    
                                            <input name="name" type="text" class="form-control" id="name" value="<?php echo e(old('name',stripslashes($category->name))); ?>">
                                            <?php if($errors->has('name')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if($errors->has('description')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Description </label>
                                        <div class="col-md-6">     
                                            <textarea class="form-control" name="description" ><?php echo e(old('description',stripslashes($category->description))); ?></textarea>
                                            <?php if($errors->has('description')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if($errors->has('about_category')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">About Category </label>
                                        <div class="col-md-6">     
                                            <textarea class="form-control" name="about_category" ><?php echo e(old('about_category',stripslashes($category->about_category))); ?></textarea>
                                            <?php if($errors->has('about_category')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('about_category')); ?></strong>
                                            </span>
                                            <?php endif; ?>
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