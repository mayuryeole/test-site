@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Update Rooms</title>

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
                <a href="{{url('admin/rooms-list')}}">Manage Rooms</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Update Rooms</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Update Rooms
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data" >

                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <div>
                                        <div class="form-group">
                                            <form>
                                                <input type='hidden' name='parent_id' id='parent_id'>
                                            </form>
                                        </div>
                                        <div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Owner Name</label>
                                            <div class="col-md-12">     
                                                <input name="name" type="text" readonly class="form-control" id="name" value="{{ $rooms->first_name }} {{  $rooms->last_name  }} ">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Room Name<sup>*</sup></label>
                                            <div class="col-md-12">     
                                                <input name="room_name" type="text" class="form-control" id="room_name" value="{{old('room_name',stripslashes($rooms->room_name))}}">
                                                <input name="old_room_name" type="hidden" value="{{ $rooms->room_name }}">
                                                @if ($errors->has('room_name'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('room_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Theme Type</label>
                                            <div class="col-md-12">     
                                                <select class="form-control" name="theme_type" id='theme_type'>                                                
                                                    <option value="">--- No room Selected --</option>
                                                    @if(isset($all_categories) && count($all_categories)>0)
                                                    @foreach($all_categories as $category)
                                                    <option value="{{ $category->id }}"  <?php if (($rooms->room_type == $category->id) && isset($rooms->room_type)) { ?> selected="true" <?php } ?> > {{ $category->name }}  </option>                                                        
                                                    @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('theme_type'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('theme_type') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group @if ($errors->has('room_desc')) has-error @endif">
                                            <label for="room_desc" >Room Description<sup>*</sup>
                                            </label>
                                            <textarea class="form-control" name="room_desc">{{old('room_desc',stripslashes($rooms->room_desc))}}</textarea>

                                            @if ($errors->has('room_desc'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('room_desc') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="name">Status</label>
                                            <div class="col-md-12">     
                                                <select class="form-control" name="status" id='status'>                                                
                                                   <option value='0' <?php if (($rooms->room_open == '0') && isset($rooms->room_open)) { ?> selected="true" <?php } ?>    >-- Closed --</option>
                                                   <option value='1' <?php if (($rooms->room_open == '1') && isset($rooms->room_open)) { ?> selected="true" <?php } ?>  >-- Open --</option>
                                                   <option value='-1' <?php if (($rooms->room_open == '-1') && isset($rooms->room_open)) { ?> selected="true" <?php } ?> >-- Reject --</option>                            
                                                </select>
                                                @if ($errors->has('status'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('status') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">   
                                                <button type="submit" id="submit" class="btn btn-primary  pull-right">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>   
            </div>
        </div>
    </div>
    <style>
        .submit-btn{
            padding: 10px 0px 0px 18px;
        }
    </style>

    <script>
        function setParentCategory($parent)
        {
            $('#parent_id').val($parent);
        }
    </script>
    @endsection