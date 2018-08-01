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
            
<!--            <li>
                <a href="<?php echo e(url('admin/subcategories-list')."/".$cat_id); ?>" onclick="goBack()">Manage Sub Categories</a>
                <i class="fa fa-circle"></i>

            </li>-->
            <li>
                <a href="javascript:void(0);">Manage Sub_sub Categories</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create Sub-Sub-Category
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" id="create-sub-sub-cat" role="form" action="" method="post" >

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
                                        
                                        <?php if(count($all_category) != 0): ?>
                                        <label class="col-md-6 control-label">Parent Category<sup>*</sup></label>
                                        <div class="col-md-6">  
                                            
                                            <select class="form-control" id="category" name="category" >
                                                <option value="">Select Parent Category</option>
                                                <option value="<?php echo e($all_category->id); ?>" name="category"><?php echo e($all_category->name); ?></option>
                                                       </select>
                                            <span style="font-size:14px;" class="text-danger" id='show_msg' name='show_msg' hidden="">Please select parent category</span>
                           
                                        </div>
                                        
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <form>
                                                <input type='hidden' name='parent_id' id='parent_id' value="<?php echo e($all_category->id); ?>">
                                                <input type="hidden" name="parent_name" id="parent_name" value="<?php echo e($all_category->name); ?>">
                                       
                                            </form>
                                        </div>

                                        <div class="form-group <?php if($errors->has('description')): ?> has-error <?php endif; ?>">
                                            <label class="col-md-6 control-label">Description </label>
                                            <div class="col-md-6">     
                                                <textarea class="form-control" name="description" ><?php echo e(old('description')); ?></textarea>
                                                <?php if($errors->has('description')): ?>
                                                <span class="help-block">
                                                    <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong>
                                                </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">   
                                                <button type="submit" onclick="setParentCategory()" name="submit-value" id="submit-value" class="btn btn-primary  pull-right">Create</button>
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
    function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
//$(document).ready(function(){
    function setParentCategory()
    {
//        alert(1);
////         alert((parent==""));
//        if(parent==""){
//            $("#show_msg").show();
////            alert("Please select parent category");
//               return false; 
//        }
//        else if(parent!=""){
//            $("#show_msg").hide();
//        $('#parent_id').val(parent);
//    }
//        $('#parent_id').val(parent);
//    alert(1);
    var parent=$("#category").val();
        if(parent==""){
            $("#show_msg").show();
//            alert("Please select parent category");
            return false;
        }
    }
//});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>