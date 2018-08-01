@extends(config("piplmodules.back-view-layout-location"))
@section("meta")

<title>Give Category Discount</title>

@endsection


@section('content')
<link rel="stylesheet" href="{{url('/')}}/public/media/backend/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{{url('/')}}/public/media/backend/css/jquery-ui.css')}}">
<script src="{{url('/')}}/public/media/backend/js/jquery-ui.js')}}"></script>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('/admin/categories-list')}}">Manage Category</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:void(0);">Give Discount</a>

            </li>
        </ul>

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Give Discount
                </div>

            </div>
            <div class="portlet-body form">
                <form class="form-horizontal" name="give_category_discount" id="give_category_discount" role="form" action="" method="post" enctype="multipart/form-data" >
                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                <div class="col-md-8">  
                                    <input id="product-id" type="hidden" name="product_id" value="{{$product_id}}">
                                    
                                    {{--<div class="form-group @if ($errors->has('discount_type')) has-error @endif">--}}
                                        {{--<label class="col-md-6 control-label">Discount Type<sup>*</sup></label>--}}
                                        {{--<div class="col-md-6">     --}}
                                            {{--<select class="form-control" name="discount_type">--}}
                                                {{--<option value="" @if(isset($product->discount_type) && $product->discount_type!="") selected='selected'@endif>@if(isset($product->discount_type) && $product->discount_type!="" && $product->discount_type!="0")Price @elseif(isset($product->discount_type) && $product->discount_type!="" && $product->discount_type!="1") Percent @else Select Discount Type @endif</option>--}}
                                                {{--<option value="price">Price</option>--}}
                                                {{--<option value="percent">Percent</option>--}}
                                                    {{----}}
                                            {{--</select>--}}
                                            {{--@if ($errors->has('discount_type')) <span class="help-block"> <strong class="text-danger">{{ $errors->first('discount_type') }}</strong> </span> @endif --}}
                            {{----}}
                                        {{--</div>--}}
                             {{----}}
                                    {{--</div>--}}
                                {{----}}
                                    {{--<div class="form-group @if ($errors->has('discount_price')) has-error @endif">--}}
                                        {{--<label class="col-md-6 control-label">Discount<sup>*</sup></label>--}}
                                        {{--<div class="col-md-6">     --}}
                                            {{--<input name="discount_price" type="text" class="form-control" id="discount_price" value="@if(isset($product->discount_price) && $product->discount_price!=''){{$product->discount_price}} @elseif(isset($product->discount_percent) && $product->discount_percent!='') {{$product->discount_percent}} @else {{old('discount_price')}} @endif">--}}
                                            {{--@if ($errors->has('discount_price'))--}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('discount_price') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group @if ($errors->has('discount_type')) has-error @endif">--}}
                                        {{--<label class="col-md-6 control-label">Discount Type<sup>*</sup></label>--}}

                                        {{--<div class="col-md-6 cust-radio">--}}
                                            {{--<ul style="list-style-type: none;">--}}
                                                {{--<li>--}}
                                                    {{--<label style="padding-right: 50px"><input name="radioChange" type="radio" class="form-control"  @if($product->discount_type == "0") checked @endif onchange="hideShowTextbox(this)" value="Amount">Amount</label>--}}

                                                    {{--<label><input name="radioChange" type="radio" class="form-control" @if($product->discount_type == "1") checked @endif  onchange="hideShowTextbox(this)" value="Percentage">Percentage</label>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                            {{--@if ($errors->has('amount'))--}}
                                                {{--<span class="help-block">--}}
                                            {{--<strong class="text-danger">{{ $errors->first('amount') }}</strong>--}}
                                        {{--</span>--}}
                                            {{--@endif--}}
                                            {{--@if ($errors->has('Percentage'))--}}
                                                {{--<span class="help-block">--}}
                                            {{--<strong class="text-danger">{{ $errors->first('Percentage') }}</strong>--}}
                                        {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}

                                    {{--</div>--}}
                                    <div class="form-group" id="discount-type">
                                        <label class="col-md-6 control-label">Discount Type</label>
                                        <div class="col-md-6">
                                            <div class="percent-icon">
                                                <input name="discount_type" disabled="disabled" id="discount_type" type="text" class="form-control" value="Percentage">
                                            </div>
                                            @if ($errors->has('discount_type'))
                                                <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('discount_type') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group" id="percentage">
                                        <label class="col-md-6 control-label">Percentage<sup>*</sup></label>
                                        <div class="col-md-6">
                                            <div class="percent-icon">
                                                <input name="percentage" id="percentage_txt" type="text" class="form-control" value="{{$product->discount_percent }}">
                                            </div>
                                            @if ($errors->has('order_quantity'))
                                                <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('order_quantity') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                    {{--<div class="form-group" id="amount" style="display: none;">--}}
                                        {{--<label class="col-md-6 control-label">Amount<sup>*</sup></label>--}}

                                        {{--<div class="col-md-6">--}}
                                            {{--<input name="amount" type="text" class="form-control"  id="amount_txt" value="{{$product->discount_price }}">--}}
                                            {{--@if ($errors->has('amount'))--}}
                                                {{--<span class="help-block">--}}
                                            {{--<strong class="text-danger">{{ $errors->first('amount') }}</strong>--}}
                                        {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}

                                    {{--</div>--}}






                                    <div class="form-group @if ($errors->has('max_quantity')) has-error @endif">
                                        <label class="col-md-6 control-label">Maximum Quantity<sup>*</sup></label>
                                        <div class="col-md-6"> 
                                            @if(isset($product->max_quantity) && $product->max_quantity!="")
                                            <input name="max_quantity" type="text" class="form-control" id="max_quantity" @if($product->max_quantity)>0) value="{{$product->max_quantity}} @else {{ 0 }} @endif">
                                           @else
                                            <input name="max_quantity" type="text" class="form-control" id="max_quantity" value="{{old('max_quantity',0)}}">
                                            @endif
                                            @if ($errors->has('max_quantity'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('max_quantity') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group @if ($errors->has('discount_valid_from')) has-error @endif">
                                        <label class="col-md-6 control-label">Discount Valid From<sup>*</sup></label>
                                        {{--<div class="col-md-6"> --}}
                                            {{--@if(isset($product->discount_valid_from) && $product->discount_valid_from!="")--}}
                                            {{--<input name="discount_valid_from" type="text" class="form-control" id="discount_valid_from" value="{{$product->discount_valid_from}}">--}}
                                           {{--@else--}}
                                            {{--<input name="discount_valid_from" type="text" class="form-control" id="discount_valid_from" value="{{old('discount_valid_from')}}">--}}
                                            {{--@endif--}}
                                            {{--@if ($errors->has('discount_valid_from'))--}}
                                            {{----}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('discount_valid_from') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                        <div class="col-md-6">
                                        <div class='input-group date' id='datepicker1'>
                                            @if(isset($product->discount_valid_from) && $product->discount_valid_from!="")
                                                <input type='text' id='discount_valid_from' name="discount_valid_from" class="form-control" value="{{$product->discount_valid_from}}" />
                                            @else
                                                <input name="discount_valid_from" type="text" class="form-control" id="discount_valid_from" value="{{old('discount_valid_from')}}">
                                            @endif
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                                            </span>
                                            @if ($errors->has('discount_valid_from'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('discount_valid_from') }}</strong>
                                                </span>
                                            @endif

                                        </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group @if ($errors->has('discount_valid_to')) has-error @endif">
                                        <label class="col-md-6 control-label">Discount Valid To<sup>*</sup></label>
                                        {{--<div class="col-md-6"> --}}
                                            {{--@if(isset($product->discount_valid_to) && $product->discount_valid_to!="")--}}
                                            {{--<input name="discount_valid_to" type="text" class="form-control" id="discount_valid_to" value="{{$product->discount_valid_to}}">--}}
                                           {{--@else--}}
                                            {{--<input name="discount_valid_to" type="text" class="form-control" id="discount_valid_to" value="{{old('discount_valid_to')}}">--}}
                                            {{--@endif--}}
                                                {{--@if ($errors->has('discount_valid_to'))--}}

                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('discount_valid_to') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                        <div class="col-md-6">
                                        <div class='input-group date' id='datepicker2'>
                                            @if(isset($product->discount_valid_to) && $product->discount_valid_to!="")
                                                <input type='text' id='discount_valid_to' name="discount_valid_to" class="form-control" value="{{$product->discount_valid_to}}" />
                                            @else
                                                <input name="discount_valid_to" type="text" class="form-control" id="discount_valid_to" value="{{old('discount_valid_to')}}">
                                            @endif
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                                            </span>
                                            @if ($errors->has('discount_valid_to'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('discount_valid_to') }}</strong>
                                                </span>
                                            @endif

                                        </div>
                                        </div>

                                    </div>
                                    
{{--<!--                                    <div class="form-group @if ($errors->has('max_quantity')) has-error @endif">--}}
                                        {{--<label class="col-md-6 control-label">Maximum Quantity<sup>*</sup></label>--}}
                                        {{--<div class="col-md-6"> --}}
                                            {{--@if(isset($product->max_quantity) && $product->max_quantity!="")--}}
                                            {{--<input name="max_quantity" type="number" min="0" class="form-control" id="max_quantity" value="{{$product->max_quantity}}">--}}
                                           {{--@else--}}
                                            {{--<input name="max_quantity" type="number" min="0" class="form-control" id="max_quantity" value="{{old('max_quantity')}}">--}}
                                            {{--@endif--}}
                                            {{--@if ($errors->has('max_quantity'))--}}
                                            {{--<span class="help-block">--}}
                                                {{--<strong class="text-danger">{{ $errors->first('max_quantity') }}</strong>--}}
                                            {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>-->--}}
                                    
                                        <div class="form-group">
                                        <div class="col-md-12">   
                                            <button type="button" id="rm-submit" class="btn btn-primary  pull-right" onclick="rmDiscount()">Remove Discount</button>
                                            <button type="submit" id="submit" class="btn btn-primary  pull-left" onclick="appendErrorMsgDiscount()" style="margin-left:360px;">Add Discount</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <input  id="ip-token" type="hidden" name="_token" value="{{ csrf_token() }}">
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
<script type="text/javascript">
    jQuery(document).ready(function() {

        @if($product->discount_type == '0') $("#amount").show(); @endif
        @if($product->discount_type == '1') $("#percentage").show(); @endif

    });

    function hideShowTextbox(t) {

        if ($(t).val() == 'Amount') {
            $("#amount").show();
            $("#percentage_txt").val('');
            $("#percentage").hide();
        }
        if ($(t).val() == 'Percentage') {
            {
                $("#percentage").show();
                $("#amount_txt").val('');
                $("#amount").hide();
            }
        }
    }

</script>
<script>
    $(function(){
        var d = new Date();

        $("#datepicker1").datetimepicker({
            format:"yyyy/mm/dd hh:ii:ss",
            startDate:d
        });
        $("#datepicker2").datetimepicker({
            format:"yyyy/mm/dd hh:ii:ss",
            startDate:d
        });
    });

</script>

<script>
    // $("#discount_valid_from").datepicker({
    //     minDate: "dateToday",
    //     numberOfMonths: 1,
    //     dateFormat: 'yy-m-d',
    //     onClose: function(selected) {
    //         $("#discount_valid_to").datepicker("option", "minDate", selected);
    //     }
    //
    // });
    // $("#discount_valid_to").datepicker({
    //     minDate: $("#old_dispatch_date_picker").val(),
    //     numberOfMonths: 1,
    //     dateFormat: 'yy-m-d',
    //     onClose: function(selected) {
    //         $("#discount_valid_from").datepicker("option", "maxDate", selected);
    //     }
    //
    // });

    function setCategory($cat)
    {
        $('#category_id').val($cat);
    }

    
</script>
<script>

    var catId = $('#product-id').val();

    function rmDiscount(){
        if (confirm("Do you really want to remove this discount?"))
        {
            $.ajax({
                url: '{{  url('/admin/remove-category-discount') }}',
                type: "post",
                dataType: 'json',
                data: {
                    cat_id: catId,
                    _token : $('ip-token').val()
                },
                success: function(response) {
                    if (response.success == "1")
                    {
                        window.location.href = window.location.href;
                    }
                    else{
                        alert(response.msg);return;
                    }

                }
            });
        }
        return false;
    }

</script>
<script type="text/javascript" src="{{url('/')}}/public/media/backend/js/bootstrap-datetimepicker.min.js">
</script>
@endsection