<?php $__env->startSection("meta"); ?>

<title>Manage Appointment</title>

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
					<a href="javascript:void(0)">Manage Appointment</a>
					
				</li>
                        </ul>
    
          
           <?php if(session('msg-success')): ?>
          <div class="alert alert-danger">
                <?php echo e(session('msg-success')); ?>

                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
          </div>
        <?php endif; ?>
        
        
        <?php if(session('msg-error')): ?>
          <div class="alert alert-danger">
                <?php echo e(session('msg-error')); ?>

                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
          </div>
        <?php endif; ?>
        
       
        <div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="glyphicon glyphicon-globe"></i>Manage Appointment
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
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<a href="<?php echo e(url('get-appointment/availabily')); ?>" id="sample_editable_1_new" class="btn green">
											Add Your Available Dates <i class="fa fa-plus"></i>
											</a>
										</div>
									</div>
									
								</div>
							</div>
							<table class="table table-striped table-bordered table-hover" id="tblcities">
							<thead>
							<tr>
                                                                    <th>
									<div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                                                                    </th>
                                                                    <th>Customer</th>
                                                                    <th>Service Provider</th>
                                                                    <th>Date</th>
                                                                    <th>Action</th>
                                                                    <th>Status</th>
                                                                    <th>View</th>
                                                                    
                                                                    
                                                        </tr>
                                                       
							</thead>
                                                        </table>
                                                        <!--<input type="button" onclick='javascript:deleteAll("<?php echo e(url('admin/contact-mode/delete-selected')); ?>")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">-->
						</div>
					</div>
	
		</div>
	</div>
                </div>
</div>
<script>
$(function() {
    $('#tblcities').DataTable({
        processing: true,
        serverSide: true,
         //bStateSave: true,
        ajax: {"url":'<?php echo e(url("/admin/manage-appointment-data")); ?>',"complete":afterRequestComplete},
        columnDefs: [{
        "defaultContent": "-",
        "targets": "_all"
      }],
        columns: [
           
            {data:   "id",
              render: function ( data, type, row ) {
                
                    if ( type === 'display' ) {
                        
                          return '<div class="cust-chqs">  <p> <input class="checkboxes" type="checkbox"  id="delete'+row.id+'" name="delete'+row.id+'" value="'+row.id+'"><label for="delete'+row.id+'"></label> </p></div>';
                    }
                    return data;
                },
                  "orderable": false,
                  
               },
           { data: 'customer_id', name: 'customer_id'},
           { data: 'expert_id', name: 'expert_id'},
           { data: 'appointment_datetime', name: 'appointment_datetime'},
           { data: 'Action', name: 'Action'},
//           {data:   "Action",
//              
//                  "orderable": false,
//                  name: 'Action'
//                  
//            },
           { data: 'status', name: 'status'},
          
            {data:   "View",
              render: function ( data, type, row ) {
               
                    if ( type === 'display' ) {
                        
                        return '<a class="btn btn-sm btn-primary" href="<?php echo e(url("admin/manage-appointments/view-detail")); ?>/'+row.id+'">View Detail</a>';
                    }
                    return data;
                },
                  "orderable": false,
                  name: 'Action'
                  
            },
          
         
               
        ]
    });
});
function confirmDelete(id)
{
    if(confirm("Do you really want to delete this Contact mode?"))
    {
        
        $("#delete_mode_"+id).submit();
    }
    return false;
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>