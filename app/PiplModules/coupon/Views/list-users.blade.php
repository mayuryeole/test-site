@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

    <title>Manage users</title>

@endsection

@section('content')
    <?php
      // dd("remaining coupon count:".$rem_coupon_count);
//    $rem_coupon_count=0;
    //dd("gdfgdfg".$coupon_id);
       //     dd($user_type);
    $curr_user_type='';
    $curr_user_type=Request::segment(4);
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
                    <a href="{{url('/admin/coupons-list')}}">Manage Coupons/Promo Codes</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    Manage @if(isset($code_type) && $code_type == 0)Coupon @else Promo Code @endif Users

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
                                <i class="glyphicon glyphicon-globe"></i>Manage  @if(isset($code_type) && $code_type == 0) Coupon @else Promo Code @endif Users
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
                                    <div class="col-md-10">
                                        {{--<div class="btn-group">--}}
                                        {{--<a href="{{url('admin/create-registered-user')}}" id="sample_editable_1_new" class="btn green">--}}
                                        {{--Add New <i class="fa fa-plus"></i>--}}
                                        {{--</a>--}}
                                        {{--</div>--}}

                                        {{--<div class="btn-group" id="csv">--}}
                                        {{--<a href="{{url('admin/customeruser-show-excel')}}" id="sample_editable_2_new" class="btn green">--}}
                                        {{--Export Customer Users --}}
                                        {{--<i class="fa fa-file-o"></i>--}}
                                        {{--</a>--}}
                                        {{--</div>--}}
                                        {{--<div class="btn-group" id="csv2">--}}
                                        {{--<a href="{{url('admin/businessuser-show-excel')}}" id="sample_editable_3_new" class="btn green">--}}
                                        {{--Export Business Users --}}
                                        {{--<i class="fa fa-file-o"></i>--}}
                                        {{--</a>--}}
                                        {{--</div>--}}
                                        <select name="user" id="user">

                                            <!--<option value="0">Select Users</option>-->
                                            @if(isset($user_type) && $user_type == '3')
                                            <option value="3" @if($user_type=='3') selected @endif>All Customer Users</option>
                                            @endif
                                            @if(isset($user_type) && $user_type == '4')
                                            <option value="4"  @if($user_type=='4') selected @endif>All Business Users</option>
                                            @endif
                                        </select>

                                         <span style="padding-left: 10px">Available Code Quantity:{{ $rem_coupon_count }}</span>
                                            <input id="rem_coupon_qty" type="hidden" value="{{ $rem_coupon_count }}">

                                    </div>


                                </div>
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
                                    <th>Send</th>
                                </tr>
                                </thead>
                            </table>
                            <input type="button" onclick='javascript:sendAll("{{url('/admin/send-to-selected-user')}}")' name="delete" id="delete" value="Send To Selected" class="btn btn-danger">
                        </div>
                    </div>

                </div>
            </div>
            <section  id="loader1" style="display: none; background-image:{{url('public/media/front/img/log-bg.jpg')}};" class="loader-sec">
                <div class="container">
                    <div class="loader-caption">
                        <div class="loder-img">
                            <img alt="loader" src="{{ url('public/media/front/img/block.gif')}}">
                            <span>It will Take several minutes to complete this process...</span>
                        </div>
                    </div>
                </div>
            </section>
            <script type="text/javascript">
                function sendAll(path){
                    var count = 0;
                    var flag=0;
                    var status =0;
                    var res_cnt =0;
                   var  rem_qty = $('#rem_coupon_qty').val();
                   if(rem_qty == 0){
                       flag = 1;
                   }
                   // alert(rem_qty);return;
                    $(".checkboxes").each(function()
                    {
                        if($(this).is(":checked"))
                        {
                            count++;
                            if(count >rem_qty){
                                status=1;
                            }

                            flag=2;
                        }

                    });
                    if(flag===0)
                    {
                        alert("Please select atleast one record to send this Coupon Code");
                    }
                    else if(flag == 1){
                        alert("Sry,you do not have coupons to send");
                    }
                    else{
                        if(status == 1){
                            alert("Only "+rem_qty +" Coupons available"+","+"Please select atmost "+ rem_qty+ " Records");
                        }
                        else if(confirm("Do you really want to Send Coupon Code to Selected Users?"))
                        {
                           // alert(count);
                            $(".checkboxes").each(function()
                            {
                                $("#loader1").show();
                                if($(this).is(":checked")!='')
                                {
                                    $.ajax(
                                        {
                                            url: path+'/'+'{{ $coupon_id }}'+"/"+($(this).val()),
                                            type: 'POST',
                                            data: {},
                                            'dataType': 'json',
                                            success:function(data)
                                            {
                                                if(data.success=="1")
                                                {
                                                    res_cnt++;
                                                    $("#loader1").hide();
                                                    window.location.href = window.location.href + "?served_from=notice";
                                                }


                                            }

                                        });
                                }

                            });


                        }
                    }
                }


                function selectUser(choice)
                {

                    if (choice == 1)
                    {
                        window.location.href = "{{ url('/admin/manage-coupon-users')}}/{{ $coupon_id }}";
                    } else if (choice == 2)
                    {
                        window.location.href = "{{url('/admin/manage-coupon-users')}}/{{ $coupon_id }}/3";
                    } else{
                        window.location.href = "{{url('/admin/manage-coupon-users')}}/{{ $coupon_id }}/4";
                    }

                }
            </script>
            <script>
                $(function() {
                    @if((Request::segment(4)) != NULL)
                        pass_register_value = "{{url('/admin/list-registered-users-coupon-data')}}" + "/" + "{{ $coupon_id }}" + "/" +"{{ Request::segment(4) }}";
                    {{--@else--}}
                        {{--pass_register_value = "{{url('/admin/list-registered-users-coupon-data')}}" + "/" + "{{ $coupon_id }}";--}}
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
                            {data:   "Send",
                                render: function (data, type, row) {

                                    if (type === 'display') {

                                        return '<form id="send_to_user_' + row.user_id + '" method="post" action="{{url("/admin/send-to-user")}}/{{ $coupon_id }}/' + row.user_id + '">{{ method_field("POST") }} {!! csrf_field() !!}<button align="center" onclick="confirmToSend(' + row.user_id + ')" class="btn btn-sm btn-danger" type="button" align="center">Send</button></form>';
                                    }
                                    return data;
                                },
                                "orderable": false,
                                'searchable':true,
                                name: 'Send'

                            }

                        ]
                    });
                });
                function confirmToSend(id)
                {
                    if (confirm("Do you really want to send coupon to this user?"))
                    {
                        $("#loader1").show();
                        $("#send_to_user_" + id).submit();
                    }
                    return false;
                }
            </script>
            <script>
                setTimeout(function(){
                    var rowCount = $('#tbl_regusers tr').length;
                    if(rowCount == 1)
                    {
                        $('#csv').hide();
                        $('#csv2').hide();
                        // Hide karo
                    }else{
                        // Mat karo hide
                        $('#csv').show();
                        $('#csv2').show();
                    }
                }, 500);

            </script>
@endsection
