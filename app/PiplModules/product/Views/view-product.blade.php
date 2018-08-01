@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>View Product</title>

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
                <a href="{{url('admin/products-list')}}">Manage Products</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="javascript:void(0);">View Product</a>

            </li>
        </ul>



        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> View Product
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form" action="" method="post" >

                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  

                                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                                        <label class="col-md-6 control-label">Name<sup>*</sup></label>

                                        <div class="col-md-6">     
                                            <input name="name" type="text" class="form-control" id="name" value="{{old('name',stripslashes($product->name))}}" />
                                            @if ($errors->has('name'))

                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('photo')) has-error @endif">
                                        <label class="col-md-6 control-label">Image<sup>*</sup></label>
                                        @foreach($product_image as $img) 
                                        <div class="col-md-1">
                                            <div class="@if(!empty($img->images)) input-group @endif"> 
                                                @if(!empty($img->images))<span class="input-group-addon" id="basic-addon3">
                                                    <img src="{{asset('storageasset/product/thumbnail/'.$img->images)}}" height="50" style="cursor:pointer" onclick="window.open('{{asset('storageasset/product/'.$img->images)}}', 'Image', 'width=200,height=200,left=(' + screen.width - 200 + '),top=(' + screen.height - 200 + ')')" /></span>
                                                @endif
                                            </div>
                                            @if ($errors->has('photo')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('photo') }}</strong> </span> 
                                            @endif 
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group @if ($errors->has('color')) has-error @endif">
                                        <label class="col-md-6 control-label">Color<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="color" type="text" class="form-control" id="name" value="{{old('color',stripslashes($pd->color))}}">
                                            @if ($errors->has('color'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('color') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Size<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="size" type="text" class="form-control" id="size" value="{{old('size',stripslashes($pd->size))}}">
                                            @if ($errors->has('size'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('size') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Price<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="price" type="text" class="form-control" id="price" value="{{old('price',stripslashes($pd->price))}}">
                                            @if ($errors->has('price'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Tags<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="tags" type="text" class="form-control" id="name" value="{{old('tags',stripslashes($pd->tags))}}">
                                            @if ($errors->has('tags'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('tags') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">User<sup>*</sup></label>
                                        <div class="col-md-6">     
                                            <input name="first_name" type="text" class="form-control" id="first_name" value="{{old('first_name',stripslashes($user->first_name))}}">
                                            @if ($errors->has('first_name'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('first_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="submit" id="submit" onclick="window.history.go( - 1); return false;" class="btn btn-primary  pull-right">Back</button>
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
@endsection