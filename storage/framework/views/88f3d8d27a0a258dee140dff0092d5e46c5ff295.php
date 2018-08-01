<?php $__env->startSection("meta"); ?>

<title>Manage Gallery Images</title>

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
                <a href="<?php echo e(url('admin/rivaah-galleries-list')); ?>">Manage Rivaah</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Manage Rivaah Images</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Manage Rivaah Images
                </div>

            </div>
            <style>
                .my_form .col-md-8 .form-group .form-control {
                    box-shadow: none;
                    height: auto;
                }
                .my_img_listing > li {
                    float:left;
                    list-style-type: none;
                    width: 20%;
                    padding: 5px;
                    margin-bottom: 15px; 
                }
                .my_img_holder{
                    position: relative;
                    border: 4px solid #e5e5e5;
                }
                span.close_btn {
                    background-color:#00C0EF;
                    color: #ffffff;
                    display: inline-block;
                    padding: 5px;
                    position: absolute;
                    right: 0;
                    top: 0;
                    cursor: pointer;
                    margin-left:15px;
                }
                .my_img_listing {
                    padding: 0;
                }
                .my_img_holder > img {
                    height: 150px;
                    width: 100%;
                }
                .my_cust_btn {
                    margin-left: 15px;
                }
            </style>
            <div class="portlet-body form">
                <form  id="manage-img-form" class="form-horizontal" onsubmit="return frmSub()" role="form" action="" method="post" enctype="multipart/form-data" >

                    <?php echo csrf_field(); ?>

                    <div class="form-body my_form">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8"> 
                                    <div>
                                        <div class="form-group">
                                         
                                                <input type='hidden' name='gallery_id' id='gallery_id' value="<?php echo e($gallery_id); ?>">
                                           
                                        </div>
                                        <div>
                                        </div>
                                        <div class="form-group <?php if($errors->has('images')): ?> has-error <?php endif; ?>">
                                            <label for="images" >Upload Images
                                                <sup>*</sup>
                                            </label>
                                            
                                            <input id="input-img" class="form-control" name="images[]" multiple="multiple"  type="file" value="<?php echo e(old('images')); ?>"  accept="image/*" />
                                           
                                            <span style="color: black; font-weight:bolder;" class="btn-vdo-mar" id="fileLen"></span>
                                            <?php if($errors->has('images')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('images')); ?></strong>
                                            </span>
                                            <?php endif; ?>
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
                        <div class="my_image_blk">
                            <div class="row">
                                <?php if(count($all_media) > 0): ?>
                                <div class="col-sm-12">

                                    <ul class="my_img_listing clearfix">
                                        <?php foreach($all_media as $media): ?>
                                        <li>
                                            <div id="hide_img_<?php echo e($media->id); ?>">
                                                <div class="my_img_holder">

                                                    <img src="<?php echo e(url('storage/app/public/rivaah/images/thumbnails/')); ?>/<?php echo e($media->image); ?>">
                                                    <span class="close_btn"><img src="<?php echo e(asset('/')); ?>public/media/backend/images/remove-icon-small.png"  onclick="deleteImages(<?php echo e($media->id); ?>)"></span> 
                                                </div>
                                            </div>

                                        </li>  
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php echo $all_media->render(); ?>


                                </div>
                                <?php endif; ?>
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
    <script type="text/javascript">
        var gbl_count = 0;
        
        function frmSub(){
            if(gbl_count==0){
                alert("You Must Select Atleast "+ 1+" file to Upload");
                return false;
            }
            return true;
        }
    </script>
    <script>
        $(function(){

            $("#input-img").change(function(e){
                $("#fileLen").show();
                var files= e.target.files;
                gbl_count = e.target.files.length;

                if(gbl_count == 0){
                    alert('Make sure you select image file upto 5mb.');
                    return false;
                }

                for(var i =0; i<gbl_count; i++){
                        var f = files[i];
                       // alert(24);
                        var file_ext = f.name.split('.').pop();
                        if(file_ext=='jpg'||file_ext=='jpeg'||file_ext=='png'||file_ext=='gif')
                        {

                            if(f.size > 5000000){
                                gbl_count=0;
                                alert('Please upload image upto 5mb size');
                                //e.target.files = null;
                                var el = document.getElementById("manage-img-form");
                                el.reset();
                                return false;
                            }
                        }
                        else{

                            alert('Please upload valid photos. eg : jpg | jpeg | png | gif');
                            return false;
                        }
                    }


            });

        });

</script>

    <script>
                function setParentCategory($parent)
                {
                $('#parent_id').val($parent);
                }
    </script>
    <script>
        function deleteImages(id)
        {
        if (confirm("Do you really want to delete this image?"))
        {
        hide_img = "#hide_img_" + id;
                $.ajax({
                url:"<?php echo e(url('/admin/rivaah/deletedImages/delete-image')); ?>/" + id,
                        method:'get',
                        dataType:'json',
                        success:function(data)
                        {
                        if (data.success == 1)
                        {
                        $(hide_img).hide();
                        window.location.href = window.location.href
                        } else{
                        alert(data.msg);
                        }
                        }

                });
        } else{
        return false;
        }
//        return false;
        }
    </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>