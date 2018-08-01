<?php $__env->startSection("meta"); ?>
<title>Manage Global Settings</title>
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
					<a href="javascript:void(0);">Manage Global settings</a>
					
				</li>
                        </ul>
                <?php if(session('global-setting-status')): ?>
                  <div class="alert alert-success">
                        <?php echo e(session('global-setting-status')); ?>

                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                  </div>
            <?php endif; ?>
             <?php if(session('update-setting-status')): ?>
             <div class="alert alert-success">
                       <?php echo e(session('update-setting-status')); ?>

                       <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
          </div>
          <?php endif; ?>
            <div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="glyphicon glyphicon-cog"></i>Manage Global settings
							</div>
							
						</div>
                                                <div class="portlet-body">
							
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							<tr>
                                                                <th>Name</th>
                                                                <th>Value</th>
                                                                <th>Updated At</th>
                                                                <th>Action</th>
                                                        </tr>
							</thead>
                                                        </table>

						</div>
					</div>
	
				
			
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END CONTENT -->
</div>

    <script>
$(function() {
    $('#sample_1').DataTable({
        processing: true,
        serverSide: true,
         //bStateSave: true,
        ajax: '<?php echo e(url("/admin/global-settings-data")); ?>',
        columnDefs: [{
        "defaultContent": "-",
        "targets": "_all"
      }],
        columns: [
           
           { data: 'name', name: 'name'},
           {data:   "value",name:'value'},
            { data: 'updated_at', name: 'updated_at' },
            {data:   "Action",
              render: function ( data, type, row ) {
               
                    if ( type === 'display' ) {
                        
                        return '<a class="btn btn-sm btn-primary" href="<?php echo e(url("admin/update-global-setting")); ?>/'+row.id+'">Update</a>';
                    }
                    return data;
                },
                  "orderable": false,
                  name: 'Action'
                  
            }
             
             
               
        ]
    });
});
function confirmDelete()
{
    if(confirm("Do you really want to delete this role?"))
    {
        $("#delete_role").submit();
    }
    return false;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>