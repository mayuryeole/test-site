<?php $__env->startSection("meta"); ?>

<title>Create Style</title>

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
                <a href="<?php echo e(url('/admin/product-styles')); ?>">Manage Styles</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Create Style</a>

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create A Style
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_style" id="create_style" role="form" action="" method="post" enctype="multipart/form-data" >

                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    
                                   
                                    <div class="form-group <?php if($errors->has('style_name')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Style Name<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="style_name" type="text" class="form-control" id="style_name" value="<?php echo e(old('style_name')); ?>">
                                            <?php if($errors->has('style_name')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('style_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group <?php if($errors->has('photo')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Image<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="photo" type="file" class="form-control" id="photo" value="<?php echo e(old('photo')); ?>">
                                            <img  hidden="" name="imagePreview" id="imagePreview" style="width: 50px;height: 50px" src=""/>
                                            <?php if($errors->has('photo')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('photo')); ?></strong>
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
<script type="text/javascript">
    $("#photo").on("change", function(e) {

        var flag='0';
        var fileName = e.target.files[0].name;
        var arr_file = new Array();
        arr_file = fileName.split('.');
        var file_ext = arr_file[1];
        if(file_ext=='jpg'||file_ext=='JPG'||file_ext=='jpeg'||file_ext=='JPEG'||file_ext=='png'||file_ext=='PNG'||file_ext=='mpeg'||file_ext=='MPEG'||file_ext=='img'||file_ext=='IMG'||file_ext=='bpg' ||file_ext=='GIF'||file_ext=='gif')
        {

            var files = e.target.files,

                filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                    $("#imagePreview").show();
                    $("#imagePreview").attr("src",e.target.result )
                });
                fileReader.readAsDataURL(f);
            }
        } else{
            $("#photo").val('');
            alert('Please choose valid image extension. eg : jpg | jpeg | png | img | bpg | mpeg |gif');
            return false;
        }

    });

</script>

<script>
    function setCategory($cat)
    {
        $('#category_id').val($cat);
    }

    
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>