
@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>Add Gift Card</title>

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
                <a href="{{url('/admin/gift-card-list')}}">Manage Gift Card</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">Add Gift Card</a>

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Add Gift Card
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="create_gift_card" id="create_gift_card" role="form" action="{{url('/admin/giftcard/create' )}}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">

                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Card Name<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="card_name" id="card-name" value="{{old('card_name')}}">
                                            @if ($errors->has('card_name'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('card_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Card Image<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input type="file" class="form-control" name="image" onchange="readURL(this);" id="image" value="{{old('image')}}">
                                            <img class="paper-image" style="display: none;margin-top: 10px" id="show_image" src="#" alt="" width="50px" height="50px"/>
                                            @if ($errors->has('image'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('image') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group" id="order_price_div">
                                        <label class="col-md-6 control-label">Minimum Price<sup>*</sup></label>

                                        <div class="col-md-6" >
                                            <input name="price" type="text" class="form-control" id="price" value="{{old('price')}}">
                                            @if ($errors->has('price'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                                        <label class="col-md-6 control-label">Description</label>
                                        <div class="col-md-6">
                                            <textarea name="description" type="text" class="form-control" id="description">{{old('description')}}</textarea>
                                            @if ($errors->has('description'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="btn_gift_card" name="btn_gift_card" class="btn btn-primary  pull-right">Create</button>
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
    .error{
        color:red;
    }
    

</style>
<script type="text/javascript">

    function readURL(input) {
        var ext = input.value.split('.').pop();
        switch (ext)
        {
            case 'jpg':
            case 'png':
            case 'jpeg':
            case 'JPG':
            case 'PNG':
            case 'JPEG':

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#show_image').css("display", "block");
                        $('#show_image').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                break;
            default:
                alert('Only this image format jpg,png,jpeg allowed !');
                input.value = '';
        }

    }
</script>
@endsection

