@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Create Category</title>

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
                <a href="{{url('admin/categories-list')}}">Manage Categories</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Create Category</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create A Category
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create-cat" id="create-cat" role="form" action="" method="post" >

                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Name<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="name" type="text" class="form-control" id="name" value="{{old('name')}}">
                                            @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <form>
                                                
                                                <input type='hidden' name='parent_id' id='parent_id' value="0">
                                            </form>
                                        </div>

                                        <div class="form-group @if ($errors->has('description')) has-error @endif">
                                            <label class="col-md-6 control-label">Description </label>
                                            <div class="col-md-6">     
                                                <textarea class="form-control" name="description" >{{old('description')}}</textarea>
                                                @if ($errors->has('description'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label class="col-md-6 control-label">Select Attributes<sup>*</sup></label>
                                            <div>
                                                <input id="select_all"  type="checkbox" onclick="toggle(this);" />&nbsp;&nbsp;Select all
                                            </div>

                                            @if(count($all_attributes) != 0)
                                            @foreach($all_attributes as $key=>$value)
                                            <div class="col-md-6 ">
                                                <div class="checks">
                                                    <input type="checkbox" class="attr-check-box"  onclick="check_box1(this.id);" id="{{ $value->id}}" name="attribute[]" value="{{  $value->id }}" title="{{ $value->name }}" @if(isset($arr) && count($arr)>0 && in_array($value->name,$arr)== true) checked="checked" disabled="disabled" @endif>&nbsp;&nbsp;{{ $value->name }}
                                                </div>
                                            </div>
                                            @endforeach
                                            @if ($errors->has('attribute'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('attribute') }}</strong>
                                            </span>
                                            @endif
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">   
                                                <button type="submit" id="submit" class="btn btn-primary  pull-right">Create</button>
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
</div>
<style>
    .submit-btn{
        padding: 10px 0px 0px 18px;
    }
</style>

<script>
    function toggle(source) {
        // var checkboxes = document.querySelectorAll('input[type="checkbox"]');
       // alert(source.id);return;
        var checkboxes =$('input[type=checkbox]').not(":disabled");

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i] != source)
                checkboxes[i].checked = source.checked;
        }
    }

    function check_box1(id)
    {
       var name = $('#'+id).attr('title');
        $('input[type="checkbox"]').click(function() {

            if ($(this).prop("checked") == false) {

                $('#select_all').attr('checked', false);

            }
        });
    }

</script>
@endsection