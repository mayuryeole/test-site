<?php $__env->startSection("meta"); ?>

<title>Update Style</title>

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
                <a href="<?php echo e(url('/admin/product-occasion')); ?>">Manage Occasion</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Update Occasion</a>

            </li>
        </ul>


        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update Occasion
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="update_product_occasion" id="update_product_occasion" role="form" action="" method="post" >

                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Occasion</label>

                                        <div class="col-md-6">     
                                            <input name="occasion_name" type="text" class="form-control" id="occasion_name" value="<?php echo e($occasion->name); ?>" />
                                            <?php if($errors->has('occasion_name')): ?>

                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('occasion_name')); ?></strong>
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
<script>
    function setCategory($cat)
    {
        $('#category_id').val($cat);
    }

    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>