@extends(config("piplmodules.front-view-layout-location"))

@section("meta")

<title>View Product</title>

@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" role="form" action="" method="post" >

                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8" style="border: 1px solid;">  
                                    <div class="form-group @if ($errors->has('photo')) has-error @endif">
                                        <div class="col-md-1">
                                            <div class="@if(!empty($product_image->images)) input-group @endif"> 
                                                @if(!empty($product_image->images))<span class="input-group-addon" id="basic-addon3">
                                                    <img src="{{asset('storageasset/product/thumbnail/'.$product_image->images)}}" height="70" style="cursor:pointer" onclick="window.open('{{asset('storageasset/product/'.$product_image->images)}}', 'Image', 'width=200,height=200,left=(' + screen.width - 200 + '),top=(' + screen.height - 200 + ')')" /></span>
                                                @endif
                                            </div>
                                            @if ($errors->has('photo')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('photo') }}</strong> </span> 
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                                        <div class="col-md-6">     
                                            <tr name="name" class="form-control" id="name">{{stripslashes($product->name)}}</tr>
                                            <!--<input name="name" type="text" class="form-control" id="name" value="{{old('name',stripslashes($product->name))}}" />-->
                                            @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group @if ($errors->has('color')) has-error @endif">
                                        <div class="col-md-6">    
                                            <tr name="color" type="text" class="form-control" id="name">{{stripslashes($product_desciption->color)}}</tr>
                                            <!--<input name="color" type="text" class="form-control" id="name" value="{{old('color',stripslashes($product_desciption->color))}}">-->
                                            @if ($errors->has('color'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('color') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">    
                                            <tr name="size" type="text" class="form-control" id="size">{{stripslashes($product_desciption->size)}}</tr>
                                            <!--<input name="size" type="text" class="form-control" id="size" value="{{old('size',stripslashes($product_desciption->size))}}">-->
                                            @if ($errors->has('size'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('size') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">   
                                            <tr name="price" type="text" class="form-control" id="price">{{stripslashes($product_desciption->price)}}</tr>
                                            <!--<input name="price" type="text" class="form-control" id="price" value="{{old('price',stripslashes($product_desciption->price))}}">-->
                                            @if ($errors->has('price'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">     
                                            <tr name="tags" type="text" class="form-control" id="name">{{stripslashes($product_desciption->tags)}}</tr>
                                            <!--<input name="tags" type="text" class="form-control" id="name" value="{{old('tags',stripslashes($product_desciption->tags))}}">-->
                                            @if ($errors->has('tags'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('tags') }}</strong>
                                            </span>
                                            @endif
                                        </div>
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