<?php $__env->startSection("meta"); ?>

<title>Create Product</title>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php /*<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/style.css">*/ ?>
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/flexselect.css" media="screen">
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/color-product.css" media="screen">


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="<?php echo e(url('admin/products-list/?stock=&category=')); ?>">Manage Products</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Create Product</a>

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create A Product
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_product" id="create_product" role="form" action="" method="post" enctype="multipart/form-data" >
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Select Category<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <?php /*  //  onchange="getCatAttrVal(this.value)" */ ?>
                                            <select class="form-control flexselect" id="category" name="category">
                                                <option value="">Select Category</option>
                                                 <?php foreach($tree as $ls_category): ?>
                                 <option <?php if(old('parent_id')==$ls_category->id): ?> selected="selected" <?php endif; ?> value="<?php echo e($ls_category->id); ?>"><?php echo e($ls_category->display); ?></option>
                                 <?php endforeach; ?>
                                            </select>
                                            <input type='hidden' name='category_id' id='category_id'>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group <?php if($errors->has('product_name')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Product Name<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="product_name" type="text" class="form-control" id="product_name" value="<?php echo e(old('product_name')); ?>">
                                            <?php if($errors->has('product_name')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('product_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if($errors->has('product_sku')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">SKU<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input name="product_sku" type="text" class="form-control" id="product_sku" value="<?php echo e(old('product_sku')); ?>">
                                            <?php if($errors->has('product_sku')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('product_sku')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group <?php if($errors->has('photo')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Image<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="photo" type="file" class="form-control" id="photo" value="<?php echo e(old('photo')); ?>">
                                            <img style="display: none;width: 50px;height: 50px" id="imagePreview"/>
                                            <?php if($errors->has('photo')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('photo')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group <?php if($errors->has('product_clip')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Video<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="product_clip" type="file" class="form-control" id="product_clip" value="<?php echo e(old('product_clip')); ?>">
                                            <span style="color: white;font-weight:bolder;display: none" class="btn-vdo-mar" id="fileLen"></span>
                                            <?php if($errors->has('product_clip')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('product_clip')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if(isset($countries) && count($countries)>0): ?>
                                        <div class="form-group">
                                            <label class="col-md-6 control-label">Country</label>
                                            <div class="col-md-6">
                                                <div class="h-color-select">
                                                    <select id="product-country" multiple="multiple" class="productCountrySelect" name="productCountry[]">

                                                        <?php foreach($countries as $country): ?>
                                                            <option value="<?php echo e($country->id); ?>" name="color"><?php echo e($country->trans->name); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if($errors->has('color')): ?>
                                                <div class="control-label" >

                                                    <label class="help-block ">
                                                        <strong class="text-danger"><?php echo e($errors->first('color')); ?></strong>
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(isset($rivaah_gal) && count($rivaah_gal)>0): ?>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Rivaah</label>
                                        <div class="col-md-6">
                                            <select id="rivaah" multiple="multiple" class="rivaahSelect" name="rivaah[]">
                                                <?php foreach($rivaah_gal as $gal): ?>
                                                <option value="<?php echo e($gal->name); ?>" name="rivaah"><?php echo e($gal->name); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if($errors->has('rivaah')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('rivaah')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(isset($colors) && count($colors)>0): ?>
                                        <div class="form-group">
                                            <label class="col-md-6 control-label">Product Color<sup>*</sup></label>
                                            <div class="col-md-6">
                                                <div class="h-color-select">
                                                    <select id="product-color" class="productColorSelect" name="productColor[]">

                                                        <?php foreach($colors as $color): ?>
                                                            <option value="<?php echo e($color->name); ?>" name="color"><?php echo e($color->name); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if($errors->has('color')): ?>
                                                <div class="control-label" >

                                                    <label class="help-block ">
                                                        <strong class="text-danger"><?php echo e($errors->first('color')); ?></strong>
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(isset($colors) && count($colors)>0): ?>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Multiple Colors</label>
                                           <div class="col-md-6">
                                           	<div class="h-color-select">
                                               <select id="color" multiple="multiple" class="colorSelect" name="color[]">
                                                  
                                                   <?php foreach($colors as $color): ?>
                                                        <option value="<?php echo e($color->name); ?>" name="color"><?php echo e($color->name); ?></option>
                                                   <?php endforeach; ?>
                                               </select>
                                            </div>
                                        </div>
                                        <?php if($errors->has('color')): ?>
                                        <div class="control-label" >
                                           
                                                <label class="help-block ">
                                                    <strong class="text-danger"><?php echo e($errors->first('color')); ?></strong>
                                                </label>
                                        </div>
                                         <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="form-group <?php if($errors->has('price')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Price<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="price" type="text" class="form-control" id="price" value="1" value="<?php echo e(old('price')); ?>">
                                            <?php if($errors->has('price')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('price')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group <?php if($errors->has('quantity')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Product Quantity<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="quantity" type="text" class="form-control" id="quantity" value="1" min="1">
                                            <?php if($errors->has('quantity')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('quantity')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group <?php if($errors->has('order_quantity')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label"> Max Order Quantity<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input name="order_quantity" type="text" class="form-control" id="order_quantity" value="1" min="1" onkeyup="checkQuantity(this.value)">
                                            <?php if($errors->has('order_quantity')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('order_quantity')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php /*<div class="form-group">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Product Size</label>*/ ?>
                                        <?php /*<div class="col-md-6">*/ ?>
                                            <?php /*<select class="form-control" id="product_size" name="product_size">*/ ?>
                                                <?php /*<option value="">Select Size</option>*/ ?>
                                            <?php /*</select>*/ ?>
                                        <?php /*</div>*/ ?>
                                    <?php /*</div>*/ ?>
                                    
                                    <div class="form-group <?php if($errors->has('is_featured')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Is Featured?<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="is_featured" value="1">Yes</label> 
                                            <label class="radio-inline"><input type="radio" name="is_featured" value="0" checked>No</label><br />
                                         
                                        </div>
                                                           <?php if($errors->has('is_featured')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('is_featured')); ?></strong> </span> <?php endif; ?> 
                            
                                    </div> 
                                    <div class="form-group <?php if($errors->has('status')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Status?<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="status" value="1">Enable</label> 
                                            <label class="radio-inline"><input type="radio" name="status" value="0" checked >Disable</label>
                                            <?php if($errors->has('status')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('status')); ?></strong> </span> <?php endif; ?> 
                                        </div>

                                    </div> 
                                    
                                    <div class="form-group <?php if($errors->has('is_available')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Availability<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="is_available" value="1">Out of Stock</label> 
                                            <label class="radio-inline"><input type="radio" name="is_available" value="0" checked >In Stock</label>
                                            <?php if($errors->has('is_available')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('is_available')); ?></strong> </span> <?php endif; ?> 
                                        </div>
                                        
                                    </div> 
                                    
                                    <div class="form-group <?php if($errors->has('pre_order')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Pre-Order<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="pre_order" onchange="addLaunchedDate(this)"  value="1" >Yes</label> 
                                            <label class="radio-inline"><input type="radio" name="pre_order" onchange="addLaunchedDate(this)"   value="0" checked>No</label>
                                            <?php if($errors->has('pre_order')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('pre_order')); ?></strong> </span> <?php endif; ?> 
                                        </div>

                                    </div> 
                                    
                                    <div id="add_date" hidden="" class="form-group <?php if($errors->has('launched_date')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Product Launched Date<sup>*</sup></label>
                                        <?php /*<div class="col-md-6"> */ ?>
                                            <?php /*<input name="launched_date" type="text" hidden="" class="form-control" id="launched_date" value="<?php echo e(old('launched_date')); ?>">*/ ?>
                                                <?php /*<?php if($errors->has('launched_date')): ?>*/ ?>

                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('launched_date')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                        <div class='input-group date' id='datepicker1'>
                                            <input type='text' id='launched_date' hidden="" name="launched_date" class="form-control" value="<?php echo e(old('launched_date')); ?>" />
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                                            </span>
                                            <?php if($errors->has('launched_date')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('launched_date')); ?></strong>
                                                </span>
                                            <?php endif; ?>

                                        </div>



                                    </div>
                                    
                                    <div class="form-group <?php if($errors->has('occasion')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Occasion</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="occasion" name="occasion">
                                                <option value="">Select Occasion</option>
                                                <?php if(count($occasion)>0): ?>
                                                <?php foreach($occasion as $o): ?>
                                                <option value="<?php echo e($o->id); ?>"><?php echo e($o->name); ?></option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Hide Product</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="hide_product" name="hide_product">
                                                <option value="3">Select User Type</option>
                                                <option value="0">Hide from Customer/Guest User</option>
                                                <option value="1">Hide from Business/Guest User</option>
                                                <option value="2">Hide from Both</option>
                                            </select>     
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Hide Product Price</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="hide_product_price" name="hide_product_price">
                                                <option value="3">Select User Type</option>
                                                <option value="0">Hide from Customer/Guest User</option>
                                                <option value="1">Hide from Business/Guest User</option>
                                                <option value="2">Hide from Both</option>
                                            </select>   
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group <?php if($errors->has('style')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Style</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="occasion" name="style" id="style">
                                                <option value="">Select Style</option>
                                                <?php if(count($style)>0): ?>
                                                <?php foreach($style as $s): ?>
                                                <option value="<?php echo e($s->id); ?>"><?php echo e($s->name); ?></option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group <?php if($errors->has('collection_style')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Collection Style</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="occasion" name="collection_style" id="collection_style">
                                                <option value="">Select Collection Style</option>
                                                 <?php if(count($collection_style)>0): ?>
                                                <?php foreach($collection_style as $c): ?>
                                                <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <?php /*<div class="form-group <?php if($errors->has('short_description')): ?> has-error <?php endif; ?>">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Short Description<sup>*</sup></label>*/ ?>
                                        <?php /*<div class="col-md-6">     */ ?>
                                            <?php /*<input name="short_description" type="text" class="form-control" id="short_description" value="<?php echo e(old('short_description')); ?>">*/ ?>
                                            <?php /*<?php if($errors->has('short_description')): ?>*/ ?>
                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('short_description')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                    <?php /*</div>*/ ?>

                                    <div class="form-group <?php if($errors->has('description')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Description<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <textarea name="description" type="text" class="form-control" id="description" value="<?php echo e(old('description')); ?>"></textarea>
                                            <?php if($errors->has('description')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <div class="col-md-12">   
                                            <input type="submit" class="btn btn-primary pull-right" onclick="appendErrorMsgProduct()" value="Create">
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
    $(function(){
        var d = new Date();

        $("#datepicker1").datetimepicker({
            format:"yyyy/mm/dd HH:ii:ss",
            startDate:d
        });
    });


</script>
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
                var f = files[i];
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                    var file = e.target;
                    $("#imagePreview").show();
                    $("#imagePreview").attr("src",e.target.result );



                });
                fileReader.readAsDataURL(f);
            }
        } else{
            $("#photo").val('');
            alert('Please choose valid image extension. eg : jpg | jpeg | png |gif');
            return false;
        }

    });

</script>
<script>
    $("#product_clip").change(function(e){

        $("#fileLen").show();
        var file = e.target.files.length;
        var files= e.target.files;
        gbl_count = e.target.files.length;
            for(var i =0; i<gbl_count; i++){
                var f = files[i];

                var file_ext = f.name.split('.').pop();
                console.log(file_ext);
                if(file_ext=='mp4' || file_ext=='mp3' || file_ext=='m4v'|| file_ext=='mpg' || file_ext=='avi' || file_ext=='fly' || file_ext=='wmv' || file_ext=='webm' || file_ext=='ogg')
                {
                    return true;
                }
                else{
                    $("#product_clip").val('');
                    alert('Please upload valid videos. eg : mp4 | mp3 | m4v | mpg |avi | fly | wmv | webm | ogg');
                    return false;
                }
            }
    });



</script>

<script>
    function setCategory($cat)
    {
        $('#category_id').val($cat);
    }

    function addLaunchedDate(status) {

        if ($(status).val() == '1') {
            $("#add_date").show();
//            $("#percentage_txt").val('');
//            $("#percentage").hide();
        }
        else if ($(status).val() == '0') {
            
                $("#add_date").hide();
            
        }
        else{
            $("#add_date").hide();
        }
    }
$(function () {

            $('.colorSelect').multiselect({
                    includeSelectAllOption: true,
                    noneSelectedText: 'Select Multiple Product color'
                });

            $('.rivaahSelect').multiselect({
                includeSelectAllOption: true,
                noneSelectedText: 'Select Product Rivaah'
            });
            $('.productColorSelect').multiselect({
                includeSelectAllOption: true,
                multiple: false,
                noneSelectedText: 'Select Product color'
            });

            $('.productCountrySelect').multiselect({
                includeSelectAllOption: true,
                noneSelectedText: 'Select Multiple Countries'
            });
        });
        $(".productColorSelect").change(function ()
        {
            $('.colorSelect').siblings('div.btn-group').find( "li input[value='" + $(this).val() +"']").attr('disabled',true);
        });


        function checkQuantity(value){
//            alert(value);
            var max_order=parseInt($("#quantity").val());
            var value=parseInt(value);
//            alert(max_order);
                if(value!=""){
            if(max_order< value){
                $("#order_quantity").val("");
                alert("Please enter Max Order Quantity less than or equal to Product Quantity");
            }
        }
        }
        jQuery(document).ready(function() {
            $("select .flexselect").flexselect();
        });
</script>
<script>
    function getCatAttrVal(id) {

        $.ajax({
            url: '<?php echo e(url('/get-category-size-values')); ?>',
            type: "post",
            dataType: 'json',
            data: {
                category_id: id
            },
            success: function (response) {
                console.log(response);
                var select_value = '<option value="">Select Size</option>';
                if (response) {
                    for (var i = 0; i < response.length; i++) {

                        select_value += '<option value="' + response[i] + '">' + response[i] + '</option>';
                    }
                }
                $('#product_size').html(select_value);


            }
        });
    }
</script>
<style>
    .dropdown-menu label.radio input[type=radio]{
        visibility: hidden;
    }
    .dropdown-menu label.radio{
        padding-left:10px;
    }
</style>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/public/media/backend/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/public/media/backend/js/flexselect.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/public/media/backend/js/liquidmetal.js"></script>
<script type="text/javascript" src="<?php echo e(url('/')); ?>/public/media/backend/js/color-product.js"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>