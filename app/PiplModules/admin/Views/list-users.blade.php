@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Manage users</title>

@endsection


@section('content')
<?php
    $curr_user_type='';
    $curr_user_type=Request::segment(3);
?>
<script>
function changeVerifyStatus(user_id, verify_status){
        /* changing the user status*/
        
     $("#loader1").show();   
    var obj_params = new Object();
            obj_params.user_id = user_id;
            obj_params.verify_status = verify_status;
    jQuery.post("{{url('/admin/change_verify_status')}}", obj_params, function (msg) 
    {
    if (msg.error == "1")
    {   $("#loader1").hide();
            alert(msg.message);
    }
    else
    {
        window.location.href =  window.location.href;
    }

    }, "json");
    }
</script>
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
    jQuery.post("{{url('admin/change_status')}}", obj_params, function (msg) {
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
    else if (user_status == 0)
    {
    $("#active_div" + user_id).css('display', 'inline-block');
            $("#active_div_block" + user_id).css('display', 'inline-block');
            $("#blocked_div" + user_id).css('display', 'none');
            $("#blocked_div_block" + user_id).css('display', 'none');
            $("#inactive_div" + user_id).css('display', 'none');
    } else{
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
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:void(0)">Manage users</a>

            </li>
        </ul>

        @if (session('update-user-status'))
        <div class="alert alert-success">
            {{ session('update-user-status') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        @endif

        @if (session('delete-user-status'))
        <div class="alert alert-success">
            {{ session('delete-user-status') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>

        @endif    
            
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="glyphicon glyphicon-globe"></i>Manage users
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
                            @if(Auth::user()->hasPermission('create.register-users')==true || Auth::user()->isSuperadmin())
                           
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="btn-group">
                                        <a href="{{url('admin/create-registered-user')}}" id="sample_editable_add_new" class="btn green">
                                            Add New <i class="fa fa-plus"></i>
                                        </a>
                                    </div>

                                    <div class="btn-group" id="customer-csv">
                                        <a href="{{url('admin/customeruser-show-excel')}}" id="sample_editable_create_customer_csv" class="btn green">
                                            Export Customer Users 
                                            <i class="fa fa-file-o"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group" id="business-csv">
                                        <a href="{{url('admin/businessuser-show-excel')}}" id="sample_editable_create_business_csv" class="btn green">
                                            Export Business Users 
                                            <i class="fa fa-file-o"></i>
                                        </a>
                                    </div>
                                    <select name="user" id="user" onchange="selectUser(this.value)">
                                        
                                        <!--<option value="0">Select Users</option>-->
                                        <option value="1" @if($curr_user_type=='1') selected @endif>All Users</option>
                                        <option value="2"  @if($curr_user_type=='3') selected @endif>All Customer Users</option>
                                        <option value="3" @if($curr_user_type=='4') selected @endif>All Business Users</option>
                                    </select>
                                </div>
                                

                            </div>
                            @endif
                        </div>
                         @if (session('update-user-status1'))
        <div class="alert alert-danger">
            {{ session('update-user-status1') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        @endif
                        <table class="table table-striped table-bordered table-hover" id="tbl_regusers">
                            <thead>
                                <tr>
                                    <th>
                            <div class="cust-chqs">  <p><input type="checkbox" id="select_all_delete" ><label for="select_all_delete"></label>  </p></div>
                            </th>

                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Verify</th>
                            @if(Request::segment(3)=='4')
                            <th>User Category</th>
                            @endif                
                            <th>Registered On</th>
                            <th>Update</th>
                            <th>Delete</th>
                            </tr>
                            </thead>
                        </table>
                        <input type="button" onclick='javascript:deleteAll("{{url('/admin/delete-selected-user')}}")' name="delete" id="delete" value="Delete Selected" class="btn btn-danger">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
    <section  id="loader1" style="display: none; background-image:url(public/media/front/img/log-bg.jpg);" class="loader-sec">
    <div class="container">
        <div class="loader-caption">
            <div class="loder-img">
                <img alt="loader" src="{{ url('public/media/front/img/block.gif')}}">
            </div>
        </div>
    </div>
</section>
        <script>
                            function selectUser(choice)
                            {
                                
                            if (choice == 1)
                            { 
                            window.location.href = "{{ url('/admin/manage-users')}}";
                            } else if (choice == 2)
                            { 
                            window.location.href = '{{url("/admin/manage-users")}}/3';
                            } else{ 
                            window.location.href = '{{url("/admin/manage-users")}}/4';
                            }

                            }
        </script>
        <script>
                    $(function() {
                    @if((Request::segment(3)) != NULL)
                            pass_register_value = "{{url('/admin/list-registered-users-data')}}" + "/" + "{{ Request::segment(3) }}";
                            @else
                            pass_register_value = "{{url('/admin/list-registered-users-data')}}";
                            @endif

                            $('#tbl_regusers').DataTable({
                            processing: true,
                            serverSide: true,
                            //bStateSave: true,
                            ajax: {"url":pass_register_value, "complete":afterRequestComplete},
                            columnDefs: [{
                            "defaultContent": "-",
                                    "targets": "_all"
                            }],
                            columns: [
                            {data:   "id",
                                    render: function (data, type, row) {

                                    if (type === 'display') {

                                    return '<div class="cust-chqs">  <p> <input class="checkboxes" type="checkbox"  id="delete' + row.user_id + '" name="delete' + row.user_id + '" value="' + row.user_id + '"><label for="delete' + row.user_id + '"></label> </p></div>';
                                    }
                                    return data;
                                    },
                                    "orderable": false,
                                     'searchable':true,
                            },
                            { data: 'first_name', name: 'first_name'},
                            { data: 'last_name', name: 'last_name'},
                            { data: 'email', name: 'user.email'},
                            { data: 'status', name: 'user.user_status', 'searchable':false},
                            { data: 'verified', name: 'user.verified'},
                            @if(Request::segment(3)=='4')
                            { data: 'user_category', name: 'user_category'},
                            @endif
                            { data: 'created_at', name: 'user.created_at' },
                            {data:   "Update",
                                    render: function (data, type, row) {

                                    if (type === 'display') {

                                    return '<a class="btn btn-sm btn-primary" href="{{url("admin/update-registered-user/")}}/' + row.user_id + '">Update</a>';
                                    }
                                    return data;
                                    },
                                    "orderable": false,
                                    'searchable':true,
                                    name: 'Action'

                            },
                            {data:   "Delete",
                                    render: function (data, type, row) {

                                    if (type === 'display') {

                                    return '<form id="delete_user_' + row.user_id + '" method="post" action="{{url("/admin/delete-user")}}/' + row.user_id + '">{{ method_field("DELETE") }} {!! csrf_field() !!}<button onclick="confirmDelete(' + row.user_id + ')" class="btn btn-sm btn-danger" type="button">Delete</button></form>';
                                    }
                                    return data;
                                    },
                                    "orderable": false,
                                    'searchable':true,
                                    name: 'Action'

                            }

                            ]
                    });
                    });
                            function confirmDelete(id)
                            {
                            if (confirm("Do you really want to delete this user?"))
                            {

                            $("#delete_user_" + id).submit();
                            }
                            return false;
                            }
        </script>
        <script>
//                    setTimeout(function(){
//                   var rowCount = $('#tbl_regusers tr').length;
//                   if(rowCount == 1)
//                   {
//                       $('#csv').hide();
//                       $('#csv2').hide();
//                       // Hide karo
//                   }else{
//                        // Mat karo hide
//                        $('#csv').show();
//                       $('#csv2').show();
//                   }
//                    }, 500);

setTimeout(function(){
                   var rowCount = $('#tbl_regusers tr').length;
//                   alert(rowCount);
                   if(rowCount == 1)
                   {
                       $('#customer-csv').hide();
                       $('#business-csv').hide();
                       // Hide karo
                   }else{
                        // Mat karo hide
                        $('#customer-csv').show();
                       $('#business-csv').show();
                   }
                    }, 5000);

        </script>   
        @endsection
