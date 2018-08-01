@extends(config("piplmodules.back-view-layout-location"))

@section("meta")
   @php
       $media_type=Request::segment(4);


   @endphp
    <title>Manage Inventory Media</title>
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
                    <a href="{{ url('/admin/inventory-list') }}">Manage Inventory</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="javascript:void(0)">Manage Inventory Media</a>
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
                                <i class="fa fa-list"></i>Manage Inventory Media
                            </div>
                            <div class="tools">
                                <a class="collapse" href="javascript:void(0);" data-original-title="" title="">
                                </a>
                                <a class="config" data-toggle="modal" href="#portlet-config" data-original-title=""
                                   title="">
                                </a>
                                <a class="reload" href="javascript:void(0);" data-original-title="" title="">
                                </a>
                                <a class="remove" href="javascript:void(0);" data-original-title="" title="">
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-toolbar">
                            </div>
                            <table class="table table-striped table-bordered table-hover" id="list_bulk_upload">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    @if($media_type == '0')
                                    <th>Image</th>
                                    @elseif($media_type == '1')
                                    <th>Video</th>
                                    @endif
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                {{--{{ $items = $collection->forPage($_GET['page'], 5); }}--}}
                                 @if(isset($object) && count($object) >0)
                                   @foreach($object as $key=>$val)
                                <tbody>
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    {{--<td>{{ $val }}</td>--}}
                                    @if($media_type == '0')
                                        <td>{{ url('storage/app/public/bulk-upload/media-upload/images').'/'.$val }}
                                    @elseif($media_type == '1')
                                        <td>{{ url('storage/app/public/bulk-upload/media-upload/videos').'/'.$val }}
                                    @endif
                                    <td>
                                    @if($media_type == '0')
                                            <img style="height: 100px;width:100px" src="{{ url('storage/app/public/bulk-upload/media-upload/images/').'/'.$val }}"/>
                                    @elseif($media_type == '1')
                                            <video  style="height: 100px;width:100px" controls>
                                                <source  src="{{ url('storage/app/public/bulk-upload/media-upload/videos').'/'.$val }}" type="video/mp4">
                                            </video>
                                            {{--<video style="height: 100px;width: 100px" src="{{ url('storage/app/public/bulk-upload/media-upload/videos').'/'.$val }}"></video>--}}
                                    @endif
                                    </td>
                                    <td><a class="btn btn-sm btn-primary" href="{{ url('/admin/inventory/remove-product-media/') }}/{{ Request::segment(4) }}/{{ $val }}" id="{{ $key }}" type="button">Remove</a></td>
                                </tr>
                                </tbody>
                                 @endforeach
                                 @endif
                            </table>
                        </div>
                    </div>
                    <!-- END PAGE CONTENT INNER -->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    <script>
        function goToBulkMedia(id) {
            chkUrl =0;
            if(id == "see-all-videos")
            {
                chkUrl =1;
            }
            $.ajax({
                url: "{{  url('/admin/inventory/show-product-media') }}/"+chkUrl,
                type: "get",
                dataType: 'json',

                data: {
                    _token: $("[name=_token]").val()
                },
                success: function (response) {
                    console.log(response.msg); return;
                    // alert(response);
                    if (response.success == "1") {
                        //  console.log(123);
                        //  console.log(response.success);
                        // console(response.success);return;
                        $('#added-in-cart').show();
                        //  $('addT')
                        window.location.href = window.location.href;
                    }
                    else {
                        // console.log(111);
                        // console.log(response.msg);
                        // alert(response.msg);
                        // return;
                    }

                }
            });
        }
        // $(document).ready(function() {
        //     $('#list_bulk_upload').DataTable();
        // } );
    </script>

@endsection
