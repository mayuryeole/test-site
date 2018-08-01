<?php $__env->startSection("meta"); ?>

<title>Manage Artist</title>

<?php $__env->stopSection(); ?>

    
<?php $__env->startSection('content'); ?>

<script>
      function changeStatus(user_id, user_status)
            {
                /* changing the user status*/
                var obj_params = new Object();
                obj_params.user_id = user_id;
                obj_params.user_status = user_status;
                if (user_status == 1)
                { 
                   
                    $("#active_div" + user_id).css('display', 'inline-block');
                    $("#active_div_block" + user_id).css('display', 'inline-block');
                    $("#blocked_div" + user_id).css('display', 'none');
                    $("#blocked_div_block" + user_id).css('display', 'none');
                    $("#inactive_div" + user_id).css('display', 'none');
                }
                jQuery.post("<?php echo e(url('admin/change_status')); ?>", obj_params, function (msg) {
                    if (msg.error == "1")
                    {
                        alert(msg.error_message);
                        $("#active_div" + user_id).css('display', 'none');
                        $("#active_div_block" + user_id).css('display', 'none');
                        $("#inactive_div" + user_id).css('display', 'block');
                    }
                    else
                    {
                        
                        /* toogling the bloked and active div of user*/
                        if (user_status == 1)
                        { 
                          
                            $("#active_div" + user_id).css('display', 'inline-block');
                            $("#active_div_block" + user_id).css('display', 'inline-block');
                            $("#blocked_div" + user_id).css('display', 'none');
                            $("#blocked_div_block" + user_id).css('display', 'none');
                            $("#inactive_div" + user_id).css('display', 'none');
                        }
                        else if(user_status == 0)
                        { 
                             $("#active_div" + user_id).css('display', 'inline-block');
                             $("#active_div_block" + user_id).css('display', 'inline-block');
                            $("#blocked_div" + user_id).css('display', 'none');
                            $("#blocked_div_block" + user_id).css('display', 'none');
                            $("#inactive_div" + user_id).css('display', 'none');
                            
                        }else{
                            $("#active_div" + user_id).css('display', 'none');
                            $("#active_div_block" + user_id).css('display', 'none');
                            $("#blocked_div" + user_id).css('display', 'inline-block');
                            $("#blocked_div_block" + user_id).css('display', 'inline-block');
                            $("#inactive_div" + user_id).css('display', 'none');
                        }
                    }

                }, "json");

            }
        
</script>
<div class="page-content-wrapper">
		<div class="page-content">
                    <!-- BEGIN PAGE BREADCRUMB -->
			<ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="<?php echo e(url('admin/dashboard')); ?>">Dashboard</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="javascript:void(0)">Artist</a>
					
				</li>
                        </ul>
    
           <?php if(session('update-user-status')): ?>
          <div class="alert alert-success">
                <?php echo e(session('update-user-status')); ?>

                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
          </div>
         <?php endif; ?>
      
        <?php if(session('delete-user-status')): ?>
            <div class="alert alert-success">
                  <?php echo e(session('delete-user-status')); ?>

                  <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            </div>
       
      <?php endif; ?>    
    
         <div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="glyphicon glyphicon-globe"></i>Manage Artist 
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
							<?php if(Auth::user()->hasPermission('create.artist')==true || Auth::user()->isSuperadmin()): ?>
                           	
                                                            <div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<a href="<?php echo e(url('admin/create-registered-artist')); ?>" id="sample_editable_1_new" class="btn green">
											Add New Artist <i class="fa fa-plus"></i>
											</a>
										</div>
									</div>
									
								</div>
                                                        <?php endif; ?>
							</div>
							<table class="table table-striped table-bordered table-hover" id="tbl_regusers">
							<thead>
							<tr>
								 <th>
									<div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                                                                 </th>
                                                                 
                                                                 
                                                                 <th>First Name</th>
                                                                 <th>Last Name</th>
                                                                 <th>number</th>
                                                                 
<!--                                                                 <th>youtube_link</th>
                                                                 <th>facebook_id</th>
                                                                 <th>instagram_id</th>
                                                                 <th>linkedin_id</th>
                                                                 <th>twitter_id</th>
                                                                 <th>services</th>
                                                                 <th>country</th>
                                                                 <th>created_at</th>-->
                                                                 <th>Update</th>
                                                                 <th>Delete</th>
                                                        </tr>
							</thead>
                                                        </table>
                                                      <input type="button" onclick='javascript:deleteAll("<?php echo e(url('/admin/delete-selected-artist')); ?>")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">
						</div>
					</div>
                </div>
         </div>
		</div>
	</div>
<script>
$(function() {
    $('#tbl_regusers').DataTable({
        processing: true,
        serverSide: true,
        //bStateSave: true,
        ajax: {"url":'<?php echo e(url("/admin/list-artist-data")); ?>',"complete":afterRequestComplete},
        columnDefs: [{
        "defaultContent": "-",
        "targets": "_all"
      }],
        columns: [
           
            {data:   "id",
              render: function ( data, type, row ) {
                
                      if ( type === 'display' ) {
                        
                         return '<div class="cust-chqs">  <p> <input class="checkboxes" type="checkbox"  id="delete'+row.user_id+'" name="delete'+row.user_id+'" value="'+row.user_id+'"><label for="delete'+row.user_id+'"></label> </p></div>';
                    }
                    return data;
                },
                  "orderable": false,
                  
               },
            
            { data: 'first_name', name: 'first_name',searchable: true},
            { data: 'last_name', name: 'last_name',searchable: true},
            { data: 'number', name: 'number',searchable: true},
//            { data: 'description', name: 'description',searchable: true},
//            { data: 'youtube_link', name: 'youtube_link'},
//            { data: 'facebook_id', name: 'facebook_id' },
//            { data: 'instagram_id', name: 'instagram_id' },
//            { data: 'linkedin_id', name: 'linkedin_id' },
//            { data: 'twitter_id', name: 'twitter_id' },
//            { data: 'services', name: 'services' },
//            { data: 'country', name: 'country' },
//            { data: 'created_at', name: 'created_at' },
       
            {data:   "Update",
              render: function ( data, type, row ) {
               
                    if ( type === 'display' ) {
                        
                        return '<a class="btn btn-sm btn-primary" href="<?php echo e(url("/admin/artist/update")); ?>/'+row.id+'">Update</a>';
                    }
                    return data;
                },
                  "orderable": false,
                  'searchable':false,
                  name: 'Action'
                  
            },
           
             
            {data:   "Delete",
              render: function ( data, type, row ) {
               
                    if ( type === 'display' ) {
                        
                        return '<form id="delete_user_'+row.id+'" method="post" action="<?php echo e(url("/admin/delete-artist")); ?>/'+row.id+'"><?php echo e(method_field("DELETE")); ?> <?php echo csrf_field(); ?><button onclick="confirmDelete('+row.id+')" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
                    }
                    return data;
                },
                  "orderable": false,
                  'searchable':false,
                  name: 'Action'
                  
            }
               
        ]
    });
});
function confirmDelete(id)
{
    if(confirm("Do you really want to delete this artist?"))
    {
        
        $("#delete_user_"+id).submit();
    }
    return false;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config("piplmodules.back-view-layout-location"), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>