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
                <a href="javascript:void(0);">Create Sub-Category</a>

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Create Sub-Category
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" id="create-sub-sub-cat" role="form" action="" method="post" >

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
                                    <div class="form-group">
                                        
                                        @if(count($all_category) != 0)
                                        <label class="col-md-6 control-label">Parent Category<sup>*</sup></label>
                                        <div class="col-md-6">  
                                            
                                            <select class="form-control" id="category" name="category" >
                                                <option value="">Select Parent Category</option>
                                                <option value="{{$all_category->id}}" name="category">{{$all_category->name}}</option>
                                                       
                                      
                                            </select>
                                            <b><span class="text-danger" id='show_msg' name='show_msg' hidden="">Please select parent category</span></b>
                                        </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="form-group">
                                            <form>
                                                <input type='hidden' name='parent_id' id='parent_id' value="{{$all_category->id}}">
                                                <input type="hidden" name="parent_name" id="parent_name" value="{{$all_category->name}}">
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
                                            <div class="col-md-12">   
                                                <button type="submit" id="submit" onclick="setParentCategory()" class="btn btn-primary  pull-right">Create</button>
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
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
    function setParentCategory()
    {   
       var parent=$("#category").val();
        if(parent==""){
            $("#show_msg").show();
//            alert("Please select parent category");
            return false;
        }
       
    }
    

</script>
@endsection