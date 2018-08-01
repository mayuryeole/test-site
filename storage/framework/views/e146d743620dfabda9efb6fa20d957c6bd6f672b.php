<?php $__env->startSection("meta"); ?>

<title>Create Gallery</title>

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
                <a href="<?php echo e(url('admin/gallery-list')); ?>">Manage Gallery</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Create Gallery</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create A Gallery
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" id="create_gallery" role="form" action="" method="post" enctype="multipart/form-data" >

                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <!--                                    <div class="form-group">
                                                                            <label class="col-md-6 control-label">Select Category</label>
                                                                            <div class="col-md-6">  
                                                                                <select class="form-control" id="category" name="category" onclick="setParentCategory(this.value)">
                                                                                    <option value="0">...None selected...</option>
                                                                                    <?php foreach($all_category as $key=>$val): ?>
                                    <?php
//                                                $cat = App\PiplModules\category\Models\CategoryTranslation::where('category_id', $val->id)->first();
                                    ?>
                                                                                    <option value="<?php echo e($val->id); ?>" name="category"><?php echo e($val->name); ?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                                
                                                                            </div>
                                                                        </div>-->
                                    <div>
                                        <div class="form-group">
                                            <form>
                                                <input type='hidden' name='parent_id' id='parent_id'>
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12"> 
                                            	<label for="name">Name<sup>*</sup></label>    
                                                <input name="name" type="text" class="form-control" id="name" value="<?php echo e(old('name')); ?>">
                                                <?php if($errors->has('name')): ?>
                                                <span class="help-block">
                                                    <strong class="text-danger"><?php echo e($errors->first('name')); ?></strong>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-group <?php if($errors->has('description')): ?> has-error <?php endif; ?>">
                                        	<div class="col-md-12">
                                                <label for="description" >Description <sup>*</sup></label>
                                                <textarea class="form-control" name="description"><?php echo e(old('description')); ?></textarea>
    
                                                <?php if($errors->has('description')): ?>
                                                <span class="help-block">
                                                    <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong>
                                                </span>
                                                <?php endif; ?>
                                            </div>
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
    <style>
        .submit-btn{
            padding: 10px 0px 0px 18px;
        }
    </style>

    <script>
        function setParentCategory($parent)
        {
            $('#parent_id').val($parent);
        }
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>