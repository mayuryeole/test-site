<?php $__env->startSection("meta"); ?>
    <title>Update Product Attributes</title>
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
                    <a href="<?php echo e(url('admin/products-list/?stock=&category=')); ?>">Manage Product</a>
                    <i class="fa fa-circle"></i>

                </li>
                <li>
                    <a href="<?php echo e(url('/admin/manage-product-attributes/'.$product_id)); ?>">Manage Product Attributes</a>
                    <i class="fa fa-circle"></i>

                </li>
                <li>
                    <a href="javascript:void(0);">Update Product Attributes</a>

                </li>
            </ul>
            <?php if(session('status')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('status')); ?>

                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                </div>
        <?php endif; ?>

        <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> Update Product Attributes
                    </div>

                </div>
                <div class="portlet-body form">
                    <form class="" name="update_product_attributes" id="update_product_attributes" role="form" action=""
                          method="post">

                        <?php echo csrf_field(); ?>


                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <?php if($errors->has('value')): ?>
                                            <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('value')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                        <?php /*</div>*/ ?>
                                        <?php /*</div>*/ ?>
                                            <?php  $cnt=0  ?>
                                        <?php if(isset($attribute) && count($attribute)>0): ?>

                                            <?php foreach($attribute as $attr): ?>
                                                <div style="margin-top:10px"
                                                     class="input-group control-group after-add-more">

                                                    <input <?php if(!empty($attr->id)): ?>id="<?php echo e($attr->id); ?>" <?php endif; ?> type="text" name="value[]"
                                                           class="form-control" placeholder="Enter Name Here"
                                                           <?php if(isset($attr->value) && $attr->value!=''): ?> value="<?php echo e($attr->value); ?>" <?php endif; ?>>
                                                    <?php if($cnt >0): ?>
                                                    <div class="input-group-btn">

                                                        <button class="btn btn-danger remove" type="button"><i
                                                                    class="glyphicon glyphicon-remove"></i> Remove
                                                        </button>

                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if($errors->has('value')): ?>
                                                        <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('value')); ?></strong>
                                            </span>
                                                    <?php endif; ?>
                                                </div>
                                                    <?php  $cnt++;  ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div style="margin-top:10px"
                                                 class="input-group control-group after-add-more">

                                                <input type="text" name="value[]" class="form-control"
                                                       placeholder="Enter Name Here">
                                                <?php if($errors->has('value')): ?>
                                                    <span class="help-block">
                                                <strong class="text-danger"><?php echo e($errors->first('value')); ?></strong>
                                            </span>
                                                <?php endif; ?>
                                            </div>

                                        <?php endif; ?>
                                            <div id="append-here">
                                            </div>
                                            <?php if(!in_array($attr_name->attribute_id,$exclude_arr)): ?>
                                            <div class="input-group-btn">

                                                <button class="btn btn-success add-more" type="button"><i
                                                            class="glyphicon glyphicon-plus"></i> Add
                                                </button>

                                            </div>
                                            <?php endif; ?>
                                        <input type='hidden' name='attribute_id' value="<?php echo e($attr_name->attribute_id); ?>">
                                        <input type='hidden' name='product_id' value="<?php echo e($product_id); ?>">

                                        <div class="form-group" style="margin-top:10px">
                                            <div class="col-md-12">
                                                <button type="submit" id="submit" class="btn btn-primary  pull-right">
                                                    Update Product Attributes
                                                </button>
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
    <div style="margin-top:10px" class="input-group control-group after-add-more" id="append-id">

        <div class="form-group control-group input-group" style="margin-top:10px">

            <input type="text" name="value[]" class="form-control" placeholder="Enter Name Here">

            <div class="input-group-btn">

                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove
                </button>

            </div>

        </div>

    </div>

    <style>
        .submit-btn {
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

        function check_box1(s) {
            $('input[type="checkbox"]').click(function () {

                if ($(this).prop("checked") == false) {

                    $('#select_all').attr('checked', false);

                }
            });
        }

    </script>
    <script>
        function setCategory($cat) {
            $('#category_id').val($cat);
        }


    </script>
    <script type="text/javascript">
        $cnt = 0;
        $(document).ready(function () {
            $("#append-id").hide();
            $(".add-more").click(function () {
                var html = $("#append-id").html();
                //$(".after-add-more").last().after(html);
                $("#append-here").append(html);
            });


            $("body").on("click", ".remove", function () {

                $(this).parents(".control-group").remove();

            });


        });


    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>