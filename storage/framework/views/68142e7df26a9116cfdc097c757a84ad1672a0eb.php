<?php $__env->startSection("meta"); ?>

<title>Manage States</title>

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
					<a href="javascript:void(0)">Manage States</a>
					
				</li>
                        </ul>
    
          
           <?php if(session('update-state-status')): ?>
          <div class="alert alert-success">
                <?php echo e(session('update-state-status')); ?>

                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
          </div>
        <?php endif; ?>
        
        <?php if(session('state-status')): ?>
          <div class="alert alert-success">
                <?php echo e(session('state-status')); ?>

                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
          </div>
         <?php endif; ?>
        <div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="glyphicon glyphicon-globe"></i>Manage States
							</div>
							<div class="tools">
								<a class="collapse" href="javascript:void(0);" data-original-title="" title="">
								</a>
								<a class="config" data-toggle="modal" href="#portlet-config" data-original-title="" title="">
								</a>
								<a class="reload" href="javascript:void(0);" data-original-title="" title="">
								</a>
								<a class="remove" href="javascript:void(0);" data-original-title="" title="">
								</a>
							</div>
						</div>
                                                 <div class="portlet-body">
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<a href="<?php echo e(url('admin/states/create')); ?>" id="sample_editable_1_new" class="btn green">
											Add New <i class="fa fa-plus"></i>
											</a>
										</div>
									</div>
									
								</div>
							</div>
							<table class="table table-striped table-bordered table-hover" id="tbl_states">
							<thead>
							<tr>
								<th>
									<div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
								</th>
                                                                
                                                                  <th>Name</th>
                                                                  <th>ISO</th>
                                                                  <th>Country</th>
                                                                  <th>Action</th>
                                                                  <th>Language</th>
                                                                  <th>Delete</th>
                                                        </tr>
							</thead>
                                                        </table>
                                                         <input type="button" onclick='javascript:deleteAll("<?php echo e(url('/admin/states/delete-selected')); ?>")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">
						</div>
					</div>
	
		</div>
	</div>
<script>
$(function() {
    $('#tbl_states').DataTable({
        processing: true,
        serverSide: true,
         //bStateSave: true,
          ajax: {"url":'<?php echo e(url("/admin/states-data/list")); ?>',"complete":afterRequestComplete},
        columnDefs: [{
        "defaultContent": "-",
        "targets": "_all"
      }],
        columns: [
            {data:   "id",
              render: function ( data, type, row )
              {
                    if ( type === 'display')
                    {
                        
                          return '<div class="cust-chqs">  <p> <input class="checkboxes" type="checkbox"  id="delete'+row.id+'" name="delete'+row.id+'" value="'+row.id+'"><label for="delete'+row.id+'"></label> </p></div>';
                    }
                    return data;
              },
                 "orderable": false,
                  name: 'Action'
               },
           
           { data: 'name', name: 'name'},
           { data: 'iso_code', name: 'iso_code'},
            { data: 'country', name: 'name'},
            {data:   "Action",
              render: function ( data, type, row ) {
               
                    if ( type === 'display' ) {
                        
                        return '<a class="btn btn-sm btn-primary" href="<?php echo e(url("admin/states/update/")); ?>/'+row.id+'">Update</a>';
                    }
                    return data;
                },
                  "orderable": false,
                  name: 'Action'
                  
            },
             {data:   "Language", "orderable": false,name: 'Action'},
            {data:   "Delete",
              render: function ( data, type, row ) {
               
                    if ( type === 'display' ) {
                        
                        return '<form id="delete_state_'+row.id+'" method="post" action="<?php echo e(url("/admin/states/delete")); ?>/'+row.id+'"><?php echo e(method_field("DELETE")); ?> <?php echo csrf_field(); ?><button onclick="confirmDelete('+row.id+')" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
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
    if(confirm("Do you really want to delete this state?"))
    {
        
        $("#delete_state_"+id).submit();
    }
    return false;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>