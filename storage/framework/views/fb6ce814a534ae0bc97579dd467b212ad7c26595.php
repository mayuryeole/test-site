<?php $__env->startSection("meta"); ?>
<title>Update Product</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/flexselect.css" media="screen">
<link rel="stylesheet" href="<?php echo e(url('/')); ?>/public/media/backend/css/color-product.css" media="screen">

<?php /*<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>*/ ?>

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
                <a href="javascript:void(0);">Update Product</a>

            </li>
        </ul>


        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update Product
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="update_product" id="update_product" role="form" action="" method="post" enctype="multipart/form-data" >
                    <?php echo csrf_field(); ?>

                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Select Category</label>
                                        <div class="col-md-6">  
                                            <select class="form-control flexselect" id="category" name="category" onclick="setCategory(this.value)">
                                                <option value="">Select Category</option>
                                                <?php if(isset($tree) && count($tree)>0): ?>
                                                 <?php foreach($tree as $ls_category): ?>
                                    <option <?php if(old('category',$product_description->category_id)==$ls_category->id): ?> selected="selected" <?php endif; ?> value="<?php echo e($ls_category->id); ?>"><?php echo e($ls_category->display); ?></option>
                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                         </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Name</label>

                                        <div class="col-md-6">
                                            <input name="product_old_name" type="hidden" class="form-control" id="product_old_name" value="<?php echo e($product->name); ?>" />
                                            <input name="product_name" type="text" class="form-control" id="product_name" value="<?php echo e($product->name); ?>" />
                                            <?php if($errors->has('product_name')): ?>

                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('product_name')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">SKU</label>

                                        <div class="col-md-6">
                                            <input name="product_sku" type="text" class="form-control" id="product_sku" value="<?php echo e($product_description->sku); ?>" />
                                            <?php if($errors->has('product_sku')): ?>

                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('product_sku')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label class="col-md-6 control-label">Image</label>

                                        <div class="col-md-6">   
                                        <div class="<?php if(!empty($product_description->image)): ?> input-group <?php endif; ?>">
                                            <?php if(!empty($product_description->image)): ?><span class="input-group-addon" id="basic-addon3">
                                                <img src="<?php echo e(asset('storage/app/public/product/image/thumbnail/'.$product_description->image)); ?>" height="20" style="cursor:pointer" onclick="window.open('<?php echo e(asset('storage/app/public/product/image/thumbnail'.$product_description->image)); ?>','Image','width=200,height=200,left=('+screen.width-200+'),top=('+screen.height-200+')')" />
                                            </span><?php endif; ?>

                                            <input name="photo" type="file" class="form-control" id="photo" value="<?php echo e($product_description->image); ?>"/>
                                            <?php if($errors->has('photo')): ?>

                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('photo')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-6 control-label">Video</label>

                                        <div class="col-md-6">
                                            <input name="product_clip" type="file" class="form-control" id="product_clip" value="<?php echo e($product_description->video); ?>" >
                                            <?php if(!empty($product_description->video)): ?>
                                                <span class="input-group-addon" id="basic-addon3"><?php echo e($product_description->video); ?></span>
                                            <?php endif; ?>
                                            <span style="color: white;font-weight:bolder;display: none" class="btn-vdo-mar" id="fileLen"></span>
                                            <?php if($errors->has('product_clip')): ?>

                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('product_clip')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if(isset($countries) && count($countries)>0): ?>
                                        <div class="form-group <?php if($errors->has('productCountry')): ?> has-error <?php endif; ?>">
                                            <label class="col-md-6 control-label">Country</label>
                                            <div class="col-md-6">
                                                <select id="product-country" multiple="multiple" name="productCountry[]">

                                                    <?php foreach($countries as $country): ?>
                                                        <option value="<?php echo e($country->id); ?>" name="productCountry" <?php if(isset($product_country) && in_array($country->id,$product_country) == true): ?> selected <?php endif; ?>><?php echo e($country->trans->name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?php /*<input type="button" id="btnSelected" value="Get Selected" />*/ ?>
                                                <?php if($errors->has('productCountry')): ?>
                                                    <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('productCountry')); ?></strong>
                                            </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(isset($rivaah_gal) && count($rivaah_gal)>0): ?>
                                        <div class="form-group <?php if($errors->has('rivaah')): ?> has-error <?php endif; ?>">
                                            <label class="col-md-6 control-label">Rivaah</label>
                                            <div class="col-md-6">
                                                <select id="rivaah" multiple="multiple" name="rivaah[]">
                                                    <?php foreach($rivaah_gal as $gal): ?>
                                                        <option value="<?php echo e($gal->name); ?>" name="rivaah" <?php if(isset($rivaah_product) && in_array($gal->id,$rivaah_product) == true): ?> selected <?php endif; ?> ><?php echo e($gal->name); ?></option>
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
                                        <div class="form-group <?php if($errors->has('productColor')): ?> has-error <?php endif; ?>">
                                            <label class="col-md-6 control-label">Product Color</label>
                                            <div class="col-md-6">
                                                <div class="h-color-select">
                                                <select id="productColor" name="productColor[]">

                                                    <?php foreach($colors as $color): ?>
                                                        <option value="<?php echo e($color->name); ?>" name="productColor" <?php if(isset($product_description->color) &&  $product_description->color == $color->name): ?> selected <?php endif; ?>><?php echo e($color->name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                                <?php if($errors->has('productColor')): ?>
                                                    <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('productColor')); ?></strong>
                                            </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(isset($colors) && count($colors)>0): ?>
                                    <div class="form-group <?php if($errors->has('color')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Multiple Colors</label>
                                        <div class="col-md-6"> 
                                            <div class="h-color-select">  
                                             <select id="color" multiple="multiple" name="color[]">

                                                 <?php foreach($colors as $color): ?>
                                                     <option value="<?php echo e($color->name); ?>" name="color" <?php if(isset($product_color) && in_array($color->name,$product_color) == true): ?> selected <?php endif; ?>><?php echo e($color->name); ?></option>
                                                 <?php endforeach; ?>
                                             </select>
                                         </div>
                                            <?php /*<input type="button" id="btnSelected" value="Get Selected" />*/ ?>
                                            <?php if($errors->has('color')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('color')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>


                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Price</label>
                                        <div class="col-md-6">     
                                            <input name="price" type="text" min="1" class="form-control" id="price" value="<?php echo e($product_description->price); ?>">
                                            <?php if($errors->has('price')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('price')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Quantity</label>
                                        <div class="col-md-6">     
                                            <input name="quantity" type="text" class="form-control" id="quantity" value="<?php echo e($product_description->quantity); ?>">
                                            <?php if($errors->has('quantity')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('quantity')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Max Order Quantity</label>
                                        <div class="col-md-6">
                                            <input name="order_quantity" type="text" class="form-control" id="order_quantity" value="<?php echo e($product_description->max_order_qty); ?>">
                                            <?php if($errors->has('quantity')): ?>
                                                <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('order_quantity')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Is Featured?</label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="is_featured" value="1" <?php if($product_description->is_featured == "1"): ?> checked <?php endif; ?> >Yes</label>
                                            <label class="radio-inline"><input type="radio" name="is_featured" value="0" <?php if($product_description->is_featured == "0"): ?> checked <?php endif; ?> >No</label>
                                            <?php if($errors->has('is_featured')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('is_featured')); ?></strong> </span> <?php endif; ?> 
                                        </div>

                                    </div> 
                                    <div class="form-group ">
                                        <label class="col-md-6 control-label">Status?</label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="status" value="1" <?php if($product_description->status == "1"): ?> checked <?php endif; ?> >Enable</label>
                                            <label class="radio-inline"><input type="radio" name="status" value="0" <?php if($product_description->status == "0"): ?> checked <?php endif; ?> >Disable</label>
                                            <?php if($errors->has('status')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('status')); ?></strong> </span> <?php endif; ?> 
                                        </div>

                                    </div> 
                                    
                                    <div class="form-group ">
                                        <label class="col-md-6 control-label">Availability</label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="is_available" value="1" <?php if($product_description->availability == "1"): ?> checked <?php endif; ?> >Out Of Stock</label>
                                            <label class="radio-inline"><input type="radio" name="is_available" value="0" <?php if($product_description->availability == "0"): ?> checked <?php endif; ?> >In Stock</label>
                                            <?php if($errors->has('is_available')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('is_available')); ?></strong> </span> <?php endif; ?> 
                                        </div>

                                    </div> 
                                    
                                    <div class="form-group ">
                                        <label class="col-md-6 control-label">Pre-Order</label>
                                        <div class="col-md-6">     
                                            <label class="radio-inline"><input type="radio" name="pre_order" onchange="addLaunchedDate(this)" value="1" <?php if($product_description->pre_order == "1"): ?> checked <?php endif; ?> >Yes</label>
                                            <label class="radio-inline"><input type="radio" name="pre_order" onchange="addLaunchedDate(this)"  value="0" <?php if($product_description->pre_order == "0"): ?> checked <?php endif; ?> >No</label>
                                            <?php if($errors->has('pre_order')): ?> <span class="help-block"> <strong class="text-danger"><?php echo e($errors->first('pre_order')); ?></strong> </span> <?php endif; ?> 
                                        </div>

                                    </div> 
                                    <div id="add_date" hidden="" class="form-group <?php if($errors->has('launched_date')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Product Launched Date</label>
                                        <?php /*<div class="col-md-6"> */ ?>
                                            <?php /*<input name="launched_date" type="text" hidden="" class="form-control" id="launched_date" value="<?php echo e($product_description->launched_date); ?>">*/ ?>
                                                <?php /*<?php if($errors->has('launched_date')): ?>*/ ?>

                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('launched_date')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                        <div class='input-group date' id='datepicker1'>
                                            <input type='text' id='launched_date'  hidden="" name="launched_date" class="form-control" value="<?php echo e($product_description->launched_date); ?>" />
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
                                            <select class="form-control" id="occasion" name="occasion" onclick="setOccasion(this.value)">
                                                <option value="">Select Occasion</option>
                                                
                                                  <?php if(count($occasion)>0): ?>
                                                  <?php foreach($occasion as $key=>$o): ?>
                                                 
                                                <option value="<?php echo e($o->id); ?>" <?php if(isset($product_occasion->occasion_id) && $product_occasion->occasion_id==$o->id): ?> selected="selected"  <?php endif; ?>><?php echo e($o->name); ?></option>
                                                <?php endforeach; ?>
                                                <?php else: ?>
                                                <option value="">Select Occasion</option>
                                                
                                                <?php endif; ?>
                                            </select>
                                            <input type="hidden" name="occasion_id" id="occasion_id">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Hide Product</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="hide_product" name="hide_product">
                                                <option value="3" <?php if(isset($product_description->hide_product) && $product_description->hide_product==3): ?> selected="selected" <?php endif; ?>>Select User Type</option>
                                                <option value="0" <?php if(isset($product_description->hide_product) && $product_description->hide_product==0): ?> selected="selected" <?php endif; ?> >Hide from Customer/Guest User</option>
                                                <option value="1" <?php if(isset($product_description->hide_product) && $product_description->hide_product==1): ?> selected="selected" <?php endif; ?>>Hide from Business/Guest User</option>
                                                <option value="2" <?php if(isset($product_description->hide_product) && $product_description->hide_product==2): ?> selected="selected" <?php endif; ?>>Hide from Both</option>
                                            </select>     
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Hide Product Price</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="hide_product_price" name="hide_product_price">
                                                <option value="3" <?php if(isset($product_description->hide_product) && $product_description->hide_product==3): ?> selected="selected" <?php endif; ?>>Select User Type</option>
                                                <option value="0" <?php if(isset($product_description->hide_product_price) && $product_description->hide_product_price==0): ?> selected="selected" <?php endif; ?> >Hide from Customer/Guest User</option>
                                                <option value="1" <?php if(isset($product_description->hide_product_price) && $product_description->hide_product_price==1): ?> selected="selected" <?php endif; ?>>Hide from Business/Guest User</option>
                                                <option value="2" <?php if(isset($product_description->hide_product_price) && $product_description->hide_product_price==2): ?> selected="selected" <?php endif; ?>>Hide from Both</option>
                                            </select>   
                                        </div>
                                    </div>
                                    
                                    <div class="form-group <?php if($errors->has('style')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Style</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="occasion" name="style" id="style" onclick="setStyle(this.value)">
                                                <option>Select Style</option>
                                                <?php foreach($style as $s): ?>
                                                <option value="<?php echo e($s->id); ?>" <?php if(isset($product_style->style_id) && $product_style->style_id==$s->id): ?> selected="selected" <?php endif; ?> ><?php echo e($s->name); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <input type="hidden" name="style_id" id="style_id">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group <?php if($errors->has('collection_style')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Collection Style</label>
                                        <div class="col-md-6">  
                                            <select class="form-control" id="occasion" name="collection_style" id="collection_style" onclick="setCollectionStyle(this.value)">
                                                <?php if(count($collection_style)>0): ?>
                                                <option>Select Collection Style</option>
                                                <?php foreach($collection_style as $c): ?>
                                                <option value="<?php echo e($c->id); ?>" <?php if(isset($product_collection_style->collection_style_id) && $product_collection_style->collection_style_id==$c->id): ?> selected="selected" <?php endif; ?>><?php echo e($c->name); ?></option>
                                                <?php endforeach; ?>
                                                <?php else: ?>
                                                   <option value="">Select Collection Style</option>
                                                <?php endif; ?>
                                            </select>
                                            <input type="hidden" name="collection_id" id="collection_id">
                                        </div>
                                    </div>

                                    <?php /*<div class="form-group <?php if($errors->has('short_description')): ?> has-error <?php endif; ?>">*/ ?>
                                        <?php /*<label class="col-md-6 control-label">Short Description</label>*/ ?>
                                        <?php /*<div class="col-md-6">     */ ?>
                                            <?php /*<input name="short_description" type="text" class="form-control" id="short_description" value="<?php echo e($product_description->short_description); ?>">*/ ?>
                                            <?php /*<?php if($errors->has('short_description')): ?>*/ ?>
                                            <?php /*<span class="help-block">*/ ?>
                                                <?php /*<strong class="text-danger"><?php echo e($errors->first('short_description')); ?></strong>*/ ?>
                                            <?php /*</span>*/ ?>
                                            <?php /*<?php endif; ?>*/ ?>
                                        <?php /*</div>*/ ?>
                                    <?php /*</div>*/ ?>

                                    <div class="form-group <?php if($errors->has('description')): ?> has-error <?php endif; ?>">
                                        <label class="col-md-6 control-label">Description</label>
                                        <div class="col-md-6">     
                                            <textarea name="description" type="text" class="form-control" id="description"><?php echo e($product_description->description); ?></textarea>
                                            <?php if($errors->has('description')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('description')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="submit" class="btn btn-primary  pull-right" onclick="appendErrorMsgProduct()">Update</button>
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
    $("#photo").on("change", function(e)
    {
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
            if(file_ext=='mp4' || file_ext=='mp3' || file_ext=='m4v' || file_ext=='mpg' || file_ext=='avi' || file_ext=='fly'|| file_ext=='wmv' || file_ext=='webm' || file_ext=='ogg')
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
    function setCategory(cat)
    {
        $('#category_id').val(cat);
    }
    
    function setOccasion(occ)
    {
        $('#occasion_id').val(cat);
    }
    
    function setStyle(style)
    {
        $('#style_id').val(style);
    }
    function setCollectionStyle(cstyle)
    {
        $('#collection_id').val(cstyle);
    }

    
    
    function addLaunchedDate(status) {

        if ($(status).val() == '1') {
            $("#add_date").show();
//            $("#percentage_txt").val('');
//            $("#percentage").hide();
        }
        else if ($(status).val() == '0') {
            {
                $("#add_date").hide();
            }
        }
        else{
            $("#add_date").hide();
        }
    }

    jQuery(document).ready(function() {
  $("select .flexselect").flexselect();
});
$(function () {
            $('#color').multiselect({
                includeSelectAllOption: true
            });
                $('#rivaah').multiselect({
                    includeSelectAllOption: true
            });
            $('#productColor').multiselect({
                includeSelectAllOption: true
            });
            $('#product-country').multiselect({
                includeSelectAllOption: true
            });

           $("#productColor").change(function ()
             {
                 $('#color').siblings('div.btn-group').find( "li input[value='" + $(this).val() +"']").attr('disabled',true);
             });
            // $('#btnSelected').click(function () {
            //     var selected = $("#color option:selected");
            //     var message = "";
            //     selected.each(function () {
            //         message += $(this).text() + " " + $(this).val() + "\n";
            //     });
            //     alert(message);
            // });
        });
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