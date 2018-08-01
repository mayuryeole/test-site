@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Manage Review and Rating</title>

@endsection

@section('content')
<div class="page-content-wrapper">
		<div class="page-content">

                    <!-- BEGIN PAGE BREADCRUMB -->
                    <ul class="page-breadcrumb breadcrumb">
				<li>
					<a href="{{url('admin/dashboard')}}">Dashboard</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="javascript:void(0)">Manage Review and Rating</a>
					
				</li>
                        </ul>
                     @if (session('status'))
                         <div class="alert alert-success">
                              {{ session('status') }}
                              <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                          </div>
                     @endif
                    <div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-list"></i>Manage Review and Rating
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
							
							<table class="table table-striped table-bordered table-hover" id="list-categories">
							<thead>
							<tr>
								<th>
									<div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                                                                </th>
                                                               
                                                                
                                                                <th>From Name</th>
                                                                <th>To Name</th>
                                                                <th>Rating</th>
                                                                <th>Review</th>
                                                                <th>Status</th>
                                                                <th>Update</th>
                                                                <th>Delete</th>
                                                               

                                                        </tr>
							</thead>
                                                        </table>
                                                          <input type="button" onclick='javascript:deleteAll("{{url('/admin/delete-selected-rating')}}")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">
						</div>
					</div>
	
				
			
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<script>
$(function() {
    $('#list-categories').DataTable({
        processing: true,
        serverSide: true,
         //bStateSave: true,
        ajax: {"url":'{{url("/admin/list-rating-data")}}',"complete":afterRequestComplete},
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
           { data: 'from_id', name: 'from_id'},
           { data: 'to_id', name: 'to_id'},
           {data: "rating",
                                render: function(data, type, row, meta) {
                                var str = ""
                                        for (var i = 0; i < data.length; i++) {
                                str += '<img src="{{url("public/media/front/img")}}/' + data[i] + '">';
                                }
                                return str;
                                },
                                "orderable": false,
                                name: 'rating'

                        },
//           { data: 'name', name: 'name'},
              {data:   "review",name: 'review'},
           {data: 'status',
                                render: function(data, type, row) {
                                if (data === 'Active') {
                                return '<a  class="btn btn-sm btn-primary" href="{{url("/admin/rating/change-status")}}/' + row.id + '">Active</a>';
                                } else{
                                return '<a  class="btn btn-sm btn-danger" href="{{url("/admin/rating/change-status")}}/' + row.id + '">InActive</a>';
                                }
                                return data;
                                },
                                "orderable": true,
                                name: 'status'},
          
            @if (Auth::user()-> hasPermission('update.user-ratings') == true || Auth::user()->isSuperadmin())                   
            {data:   "Update",
              render: function ( data, type, row ) 
              {
               
                    if ( type === 'display' ) {
                        
                        return '<a  class="btn btn-sm btn-primary" href="{{url("/admin/update-rating")}}/'+row.id+'">Update</a>';
                    }
                    return data;
                },
                  "orderable": false,
                  name: 'Update'
                  
            },
            @endif
             @if (Auth::user()-> hasPermission('delete.registered-users') == true || Auth::user()->isSuperadmin())
             {data:   "Delete",
              render: function ( data, type, row ) {
               
                    if ( type === 'display' ) {
                        
                        return '<form id="category_delete_'+row.id+'"  method="post" action="{{url("/admin/delete-rating/")}}/'+row.id+'">{{ method_field("DELETE") }} {!! csrf_field() !!}<button onclick="confirmDelete('+row.id+');" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
                    }
                    return data;
                },
                  "orderable": false,
                  name: 'Delete'
                  
            }
            @endif
             
               
        ]
    });
});
function confirmDelete(id)
{
    if(confirm("Do you really want to delete this Assesment?"))
    {
        $("#category_delete_"+id).submit();
    }
    return false;
    }
</script>
@endsection
