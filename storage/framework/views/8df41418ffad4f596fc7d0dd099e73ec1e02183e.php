<?php $__env->startSection("meta"); ?>

<title>Manage Gallery</title>

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
                <a href="javascript:void(0)">Manage Gallery</a>

            </li>
        </ul>
        <?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list"></i>Manage Gallery
                        </div>
                        <div class="tools">
                            <a class="collapse" href="javascript:;" data-original-title="" title="">
                            </a>
                            <a class="config" data-toggle="modal" href="#portlet-config" data-original-title="" title="">
                            </a>
                            <a class="reload" href="javascript:;" data-original-title="" title="">
                            </a>
                            <a class="remove" href="javascript:;" data-original-title="" title="">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <?php if(Auth::user()->hasPermission('create.gallery')==true || Auth::user()->isSuperadmin()): ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="<?php echo e(url('/admin/gallery/create')); ?>" id="sample_editable_1_new" class="btn green">
                                            Add New <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <?php endif; ?>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="list_categories">
                            <thead>
                                <tr>
                                    <th>
                            <div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                            </th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Manage Images</th>
                            <th>Manage Videos</th>
                            <th>Update</th>
                            <th>Delete</th>
                            </tr>
                            </thead>
                        </table>
                        <input type="button" onclick='javascript:deleteAll("<?php echo e(url('/admin/gallery-delete-selected')); ?>")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">  
                    </div>
                </div>



                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <script>
                $(function() {
                $('#list_categories').DataTable({
                processing: true,
                        serverSide: true,
                        //bStateSave: true,
                        ajax: {"url":'<?php echo e(url("/admin/gallery-list-data")); ?>', "complete":afterRequestComplete},
                        columnDefs: [{
                        "defaultContent": "-",
                                "targets": "_all",
                        }],
                        columns: [
                        {data:   "id",
                                render: function (data, type, row) {

                                if (type === 'display') {

                                return '<div class="cust-chqs">  <p> <input class="checkboxes" type="checkbox"  id="delete' + row.id + '" name="delete' + row.id + '" value="' + row.id + '"><label for="delete' + row.id + '"></label> </p></div>';
                                }
                                return data;
                                },
                                "orderable": false,
                        },
                        { data: 'id', name: 'id'},
                        { data: 'name', name: 'name'},
                        <?php /*{data:   "Sub Category",*/ ?>
                                <?php /*render: function (data, type, row) {*/ ?>

                                <?php /*if (type === 'display') {*/ ?>

                                <?php /*return '<a  class="btn btn-sm btn-primary" href="<?php echo e(url("/admin/sub-gallery-list")); ?>/' + row.id + '">Sub Gallery</a>';*/ ?>
                                <?php /*}*/ ?>
                                <?php /*return data;*/ ?>
                                <?php /*},*/ ?>
                                <?php /*"orderable": false,*/ ?>
                                <?php /*name: 'Sub Category'*/ ?>

                        <?php /*},*/ ?>
                        {data:   "Images",
                                render: function (data, type, row) {

                                if (type === 'display') {

                                return '<a  class="btn btn-sm btn-primary" href="<?php echo e(url("/admin/gallery/manage-images")); ?>/' + row.id + '">Manage Images</a>';
                                }
                                return data;
                                },
                                "orderable": false,
                                name: 'Sub Category'

                        },
                           {data:   "Videos",
                                render: function (data, type, row) {

                                if (type === 'display') {

                                return '<a  class="btn btn-sm btn-primary" href="<?php echo e(url("/admin/gallery/manage-videos")); ?>/' + row.id + '">Manage Videos</a>';
                                }
                                return data;
                                },
                                "orderable": false,
                                name: 'Sub Category'

                        },
                        {data:   "Update",
                                render: function (data, type, row) {

                                if (type === 'display') {

                                return '<a  class="btn btn-sm btn-primary" href="<?php echo e(url("/admin/gallery")); ?>/' + row.id + '">Update</a>';
                                }
                                return data;
                                },
                                "orderable": false,
                                name: 'Update'

                        },
                        {data:   "Delete",
                                render: function (data, type, row) {

                                if (type === 'display') {

                                return '<form id="category_delete_' + row.id + '"  method="post" action="<?php echo e(url("/admin/gallery/delete/")); ?>/' + row.id + '"><?php echo e(method_field("DELETE")); ?> <?php echo csrf_field(); ?><button onclick="confirmDelete(' + row.id + ');" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
                                }
                                return data;
                                },
                                "orderable": false,
                                name: 'Delete'
                        }
                        ]
                });
                        });
                function confirmDelete(id)
                        {
                        if (confirm("Do you really want to delete this gallery?"))
                        {
                        $("#category_delete_" + id).submit();
                        }
                        return false;
                                }
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>