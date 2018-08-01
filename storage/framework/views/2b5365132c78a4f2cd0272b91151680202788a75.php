<?php $__env->startSection("meta"); ?>

<title>Manage Story Posts</title>

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
                <a href="javascript:void(0)">Manage Story Posts</a>

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
                            <i class="fa fa-list"></i>Manage Story Posts
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
                             <?php if(Auth::user()->hasPermission('create.story')==true || Auth::user()->isSuperadmin()): ?>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="<?php echo e(url('/admin/story-post/create')); ?>" id="sample_editable_1_new" class="btn green">
                                            Add New <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                
                            </div>
                             <?php endif; ?>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="list_blogs">
                            <thead>
                                <tr>
                                    <th class="table-checkbox">
                                        <input type="checkbox" class="group-checkable" id="select_all_delete" data-set="#list_blogs .checkboxes"/>
                                    </th>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Short Description</th>
                                    <!--<th>Category</th>-->
                                    <!--<th>Language</th>-->
                                    <th>Date</th>
                                    <th>Update</th>
                                    <!--<th>View Comments</th>-->
                                    <th>Delete</th>
                                </tr>
                            </thead>
                        </table>
                        <input type="button" onclick='javascript:deleteAll("<?php echo e(url('/admin/story-post/delete-selected')); ?>")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">
                    </div>
                </div>



                <!-- END PAGE CONTENT INNER -->
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <script>
        $(function() {
        $('#list_blogs').DataTable({
        processing: true,
                serverSide: true,
                //bStateSave: true,
                ajax: {"url":'<?php echo e(url("/admin/story-data")); ?>', "complete":afterRequestComplete},
                columnDefs: [{
                "defaultContent": "-",
                        "targets": "_all"
                }],
                columns: [
                {data:   "id",
                        render: function (data, type, row) {

                        if (type === 'display') {

                        return '<div class="checkers"> <span><input class="checkboxes" type="checkbox"  name="delete' + row.id + '" value="' + row.id + '"></span></div>';
                        }
                        return data;
                        },
                        "orderable": false,
                },
                { data: 'id', name: 'id'},
                { data: 'title', name: 'title'},
                { data: 'short_description', name: 'short_description'},
//                { data: 'category', name: 'category'},
                        //           {data: 'Language', name: 'Language'},
                        { data: 'created_at', name: 'created_at' },
                {data:   "Update",
                        render: function (data, type, row)
                        {

                        if (type === 'display') {

                        return '<a  class="btn btn-sm btn-primary" href="<?php echo e(url("/admin/story-post/")); ?>/' + row.id + '">Update</a>';
                        }
                        return data;
                        },
                        "orderable": false,
                        name: 'Update'

                },
                /*{data:   "View",
                        render: function (data, type, row)
                        {

                        if (type === 'display') {

                        return '<a  class="btn btn-sm btn-primary" href="<?php echo e(url("/admin/story-post-comments")); ?>/' + row.id + '">View Comments</a>';
                        }
                        return data;
                        },
                        "orderable": false,
                        name: 'Update'
                },*/
                {data:   "Delete",
                        render: function (data, type, row) {

                        if (type === 'display') {

                        return '<form id="blog_delete_' + row.id + '"  method="post" action="<?php echo e(url("/admin/story-post/delete")); ?>/' + row.id + '"><?php echo e(method_field("DELETE")); ?> <?php echo csrf_field(); ?><button onclick="confirmDelete(' + row.id + ');" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
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
        if (confirm("Do you really want to delete this story?"))
        {
        $("#blog_delete_" + id).submit();
        }
        return false;
        }
    </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>