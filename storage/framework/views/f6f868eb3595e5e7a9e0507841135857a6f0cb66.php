<?php $__env->startSection("meta"); ?>

<title>Manage Roles</title>

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
                <a href="<?php echo e(url('admin/manage-roles')); ?>">Manage Roles</a>

            </li>
        </ul>
        <?php if(session('update-role-status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('update-role-status')); ?>

            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        <?php endif; ?>
        <?php if(session('role-status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('role-status')); ?>

            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        <?php endif; ?>

        <?php if(session('set-permission-status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('set-permission-status')); ?>

            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        <?php endif; ?>

        <?php if(session('delete-role-status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('delete-role-status')); ?>

            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-check"></i>Manage Roles
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
                            <?php if(Auth::user()->hasPermission('create.roles')==true || Auth::user()->isSuperadmin()): ?>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="<?php echo e(url('admin/roles/create')); ?>" id="sample_editable_1_new" class="btn green">
                                            Add New <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <?php endif; ?>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="tbl_role">
                            <thead>
                                <tr>
                                    <th>
                            <div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                            </th>
                            <th>Role</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Created On</th>
                            <th>Last Updated On</th>
                            <th></th>
                            <th style="text-align: center;">Action</th>
                            <th></th>
                            </tr>
                            </thead>

                        </table>

                        <input type="button" onclick='javascript:deleteAll("<?php echo e(url('/admin/delete-role-select-all')); ?>")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">


                    </div>
                </div>



                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <script>
                $(function() {
                $('#tbl_role').DataTable({
                processing: true,
                        serverSide: true,
                        //bStateSave: true,
                        ajax: {"url":'<?php echo e(url("/admin/manage-roles-data")); ?>', "complete":afterRequestComplete},
                        columnDefs: [{
                        "defaultContent": "-",
                                "targets": "_all"
                        }],
                        columns: [
                        {data:   "Select All",
                                render: function (data, type, row) {

                                if (row.slug != 'registered.user' && row.slug != 'subadminuser')
                                {
                                if (type === 'display') {

                                return '<div class="cust-chqs">  <p><input type="checkbox" class="checkboxes" id="delete' + row.id + '" name="delete' + row.id + '" value="' + row.id + '"><label for="delete' + row.id + '"></label>  </p></div>';
                                }
                                return data;
                                } else{

                                return "";
                                }
                                },
                                "orderable": false,
                                name: 'id'
                        },
                        { data: 'name', name: 'role.name'},
                        { data: 'slug', name: 'slug' },
                        { data: 'description', name: 'role.description' },
                        { data: 'created_at', name: 'role.created_at' },
                        { data: 'updated_at', name: 'updated_at' },
                        {data:   "Update",
                                render: function (data, type, row) {

                                if (type === 'display') {

                                return '<a  class="btn btn-sm btn-primary" href="<?php echo e(url("/admin/update-role")); ?>/' + row.id + '">Update</a>';
                                }
                                return data;
                                },
                                "orderable": false,
                                name: 'Update'

                        },
                        {data:   "Set Permission",
                                render: function (data, type, row) {

                                if (type === 'display') {

                                return '<a  class="btn btn-sm btn-warning" href="<?php echo e(url("/admin/roles/permissions")); ?>/' + row.id + '">Set Permission</a>';
                                }
                                return data;
                                },
                                "orderable": false,
                                name: 'Set Permission'

                        },
                        {data:   "Delete",
                                render: function (data, type, row) {
                                if (row.slug != 'registered.user' && row.slug != 'admin' && row.slug != 'subadminuser')
                                {
                                if (type === 'display') {

                                return '<form id="delete_role_' + row.id + '"  method="post" action="<?php echo e(url("/admin/delete-role")); ?>/' + row.id + '"><?php echo e(method_field("DELETE")); ?> <?php echo csrf_field(); ?><button onclick="confirmDelete(' + row.id + ');" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
                                }
                                return data;
                                } else{
                                return "";
                                }},
                                "orderable": false,
                                name: 'Delete'

                        }


                        ]
                });
                });
                function confirmDelete(id)
                {
                if (confirm("Do you really want to delete this role?"))
                {
                $("#delete_role_" + id).submit();
                }
                return false;
                }



    </script>
    <?php $__env->stopSection(); ?>


<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>