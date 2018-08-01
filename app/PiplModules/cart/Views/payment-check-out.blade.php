@extends('layouts.app')
@section('meta')
<title>Profile</title>
<style>
    .autocomplete-suggestions {
        background-color: #fff;
        border: 1px solid #e3e3e3;
        overflow-y: auto;
    }   
    .autocomplete-suggestion {
        background-color: #fff;
        padding: 5px;
        font-size: 14px;
    }
    .myAccount-block .controls label {
        padding-left: 15px !important;
    }
</style>
@endsection
@section('content')
@include('includes.header-login')

<section class="content">
    <div class="coming-soon-content">
        <div class="container-fluid">
            <div class="forgot-password-top">
                <div class="row">
                    <div class="col-xs-12 ac">
                        <!--<h1>Checkout</h1>-->
                    </div>
                </div>
                <div class="row EmailCart-list">
                    <div class="col-xs-12">
                        <ul class="">
                            <li class="active"><span class="glyphicon glyphicon-ok"></span>
                                <strong>Shipping</strong>
                            </li>
                            <li class="step-line active"><span></span></li>
                            <li class="active"><span>2</span>
                                <strong>Payment</strong>
                            </li>
                            <li class="step-line"><span></span></li>
                            <li><span>3</span>
                                <strong>Review and Submit</strong>
                            </li>

                        </ul>

                    </div>
                </div>
            </div>
            <div class="checkout-content">
                <div class="row">
                    
                                        
                    <div class="alert alert-danger" id="error_msg_container" style="display:none">
                        <span id="error_msg"></span>
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    </div>
                                        
                    <div class="col-xs-12 col-md-8">
                        <div class="checkout-main box-shadow">
                            <h4>payment</h4>
                            <p><a href="javascript:void(0)">Enter your billing information</a></p>
                            <form action="{{url('/review-check-out')}}" method="post" onsubmit="return validationEvent();">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <input required type="text" onkeyup="checkCard()" id="card_number" class="floatLabel" name="card_number" value="{{old('card_number',$payment?$payment->card_number:'')}}">
                                                <label for="">Card Number</label>
                                            </div>
                                            @if ($errors->has('card_number'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('card_number') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="controls"> <i class="fa fa-angle-down"></i>
                                                <select required class="floatLabel" onchange="checkCard()" name="month" id="month">
                                                    <option value=""></option>
                                                    <option value="1" @if($payment?old('month',$payment->month)==1:'') selected @endif>Jan</option>
                                                    <option value="2" @if($payment?old('month',$payment->month)==2:'') selected @endif>Feb</option>
                                                    <option value="3" @if($payment?old('month',$payment->month)==3:'') selected @endif>Mar</option>
                                                    <option value="4" @if($payment?old('month',$payment->month)==4:'') selected @endif>Apr</option>
                                                    <option value="5" @if($payment?old('month',$payment->month)==5:'') selected @endif>May</option>
                                                    <option value="6" @if($payment?old('month',$payment->month)==6:'') selected @endif>Jun</option>
                                                    <option value="7" @if($payment?old('month',$payment->month)==7:'') selected @endif>Jul</option>
                                                    <option value="8" @if($payment?old('month',$payment->month)==8:'') selected @endif>Aug</option>
                                                    <option value="9" @if($payment?old('month',$payment->month)==9:'') selected @endif>Sep</option>
                                                    <option value="10" @if($payment?old('month',$payment->month)==10:'') selected @endif>Oct</option>
                                                    <option value="11" @if($payment?old('month',$payment->month)==11:'') selected @endif>Nov</option>
                                                    <option value="12" @if($payment?old('month',$payment->month)==12:'') selected @endif>Dec</option>
                                                </select>
                                                <label for="fruit">MM</label>
                                            </div>
                                            @if ($errors->has('month'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('month') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="controls"> <i class="fa fa-angle-down"></i>
                                                <select required class="floatLabel" onchange="checkCard()" name="year" id="year">
                                                    <option @if($payment?old('year') == "":'') selected @endif value=""></option>
                                                    @for($year=date("Y");$year<=date("Y")+10;$year++)
                                                    <option @if($payment?old('year',$payment->year) == $year:'') selected
                                                             @endif value="{{$year}}">{{$year}}</option>
                                                    @endfor
                                                </select>
                                                <label for="fruit">YY</label>
                                            </div>
                                            @if ($errors->has('year'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('year') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="controls">
                                                <input required type="text" onkeyup="checkCard()" maxlength="3" id="cvv" class="floatLabel" name="cvv" value="{{$payment?$payment->cvv:''}}">
                                                <label for="">CVV</label>
                                            </div>
                                            @if ($errors->has('cvv'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('cvv') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <input required type="text" onkeyup="checkCard()" id="name" class="floatLabel" name="name" value="{{old('name',$payment?$payment->name:'')}}">
                                                <label for="">Name on Card</label>
                                            </div>
                                            @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="radio">
                                                <label>
                                                    <input checked type="radio" name="sampleRadio" id="existing" value="0" @if(old('sampleRadio')==0) selected @endif>
                                                    <span class="custom-radio"></span> Use shipping address</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="sampleRadio" class="payment-add-address" id="new" value="1" @if(old('sampleRadio')==1) selected @endif>
                                                    <span class="custom-radio"></span> New Address</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="checkout-payment-bottom" id="new_address" style="display: none">
                                    <div class="form-group">
                                        <h5>Enter your billing address</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="text" id="" class="floatLabel" name="new_first_name" value="{{old('new_first_name')}}">
                                                    <label for="">First Name</label>
                                                </div>
                                                @if ($errors->has('new_first_name'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('new_first_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="text" id="" class="floatLabel" name="new_last_name" value="{{old('new_last_name')}}">
                                                    <label for="">Last Name</label>
                                                </div>
                                                @if ($errors->has('new_last_name'))
                                                <span class="text-danger">
                                                    <strong> {{ $errors->first('new_last_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="text" id="" class="floatLabel" name="new_street" value="{{old('new_street')}}">
                                                    <label for="">Street</label>
                                                </div>
                                                @if ($errors->has('new_street'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('new_street') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input type="text" id="" class="floatLabel" name="new_apt" value="{{old('new_apt')}}">
                                                    <label for="">Apt/Suite <span>(Optional)</span></label>
                                                </div>
                                                @if ($errors->has('new_apt'))
                                                <span class="text-danger">
                                                    <strong> {{ $errors->first('new_apt') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group">
                                                <div class="controls"> <i class="fa fa-angle-down"></i>
                                                    <select class="floatLabel" required id="new_business_state" onchange="newFetchCitiesForAutocomplete()" name="new_state">
                                                        @foreach($states as $state)
                                                        <option @if(old('new_state')==$state) selected="selected" @endif value="{{$state->id}}">{{$state->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="business_state">State</label>
                                                </div>
                                                @if ($errors->has('new_state'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('new_state') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-4" id="new_business_city_autocomplete_container">
                                            <div class="form-group">
                                                <div class="form-group hidden" id="new_cityProgress">
                                                    <img src="{{url('public/media/front/images/loader.gif')}}" height="25" /> Loading Cities....
                                                </div>
                                                <div class="controls">
                                                    <input type="text" value="{{old('new_new_business_city_autocomplete')}}" id="new_business_city_autocomplete" class="floatLabel" name="new_city">
                                                    <label for="new_business_city_autocomplete" id="new_business_city_autocomplete_lable">City</label>
                                                    <input type="hidden" id="new_business_city" value="{{old('new_business_city')}}" name="new_business_city">
                                                    @if ($errors->has('new_city'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('new_city') }}</strong>
                                                    </span>
                                                    @endif
                                                    <span class="text-danger" id="new_select_city" style="display:none">
                                                        <strong>Please select valid city</strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-2">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <input id="" type="text" name="zip_code" maxlength="6" class="floatLabel" value="{{old('new_zip_code')}}">
                                                    <label for="">Zip Code</label>
                                                </div>
                                                @if ($errors->has('new_zip_code'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('new_zip_code') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group" id="new_check">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="default_address" id="" value="1">
                                            <span class="custom-checkbox"><i class="icon-check"></i></span> Make this my default shipping address</label>
                                    </div>
                                </div>

                                <!--------------------new  address---------------------------->

                                                    <input type="hidden" id="" class="floatLabel" name="first_name" value="{{old('first_name',$order?$order->first_name:'')}}">
                                                    <input type="hidden" id="" class="floatLabel" name="last_name" value="{{old('last_name',$order?$order->last_name:'')}}">
                                                    <input type="hidden" id="" class="floatLabel" name="street" value="{{old('street',$order?$order->shipping_address_1:'')}}">
                                                    <input type="hidden" id="" class="floatLabel" name="apt" value="{{old('apt',$order?$order->apartment:'')}}">
                                                    <select class="floatLabel" required id="business_state" onchange="fetchCitiesForAutocomplete()" name="state" style="display:none">
                                                        @foreach($states as $state)
                                                        <option @if($order && $state->id==$order->shipping_state) selected="selected" @endif value="{{$state->id}}">{{$state->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" value="{{old('business_city_autocomplete',$order?$order->shippingCity->name:'')}}" id="business_city_autocomplete" class="floatLabel" name="city">
                                                    <input type="hidden" id="business_city" value="{{old('business_city',$order?$order->shippingCity->id:'')}}" name="business_city">
                                                    <input id="" type="hidden" name="zip_code" maxlength="6" class="floatLabel" value="{{$order?$order->shipping_zip:''}}">
                                                    

                                <!--------------------end------------------------------------->
                                <div class="form-group btn-bottom-box" id="submit" style="display:none">
                                    <input type="submit" class="btn btn-red" value="Continue">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-4" >
                        <div class="checkout-aside box-shadow" id="result">
                            <h4>Order Summary</h4>
                            <div class="">
                                <table class="table">
                                    <tr>
                                        <td>Subtotal</td>
                                        <!--<td class="ar"><strong>$248.98</strong></td>-->
                                        <td class="ar"><strong>$<span id="order_subtotal"><span></strong></td>
                                    </tr>
<!--                                    <tr>
                                        <td class="" colspan="2">
                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td>
                                                        <form class="coupon-code-form">
                                                            <input class="form-control input-sm" type="text" placeholder="Enter Zip Code">
                                                            <input type="submit" class="btn btn-sm btn-w-b" value="Apply">
                                                        </form>
                                                    </td>
                                                    <td width="30" class="ac"><a href="#"><i class="fa fa-remove red-txt"></i></a></td>
                                                </tr>
                                            </table>


                                        </td>
                                    </tr>-->
                                    <tr>
                                        <td>Shipping <strong>to {{$order?$order->shipping_zip:''}} </strong></td>
                                        <td class="ar"><strong>$<span id="shipping"></span></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Tax</td>
                                        <td class="ar"><strong>$22.32</strong></td>
                                    </table>
                                    <table class="table tt"  id="coupons">
<!--                                        <td><strong class="blue-txt">MODERN10</strong><br>
                                            <span>10</span><span>%</span> off from Modern Times<br>


                                        </td>
                                        <td class="ar"><a class="checkout-remove" href=""><i class="fa fa-remove"></i></a><br>
                                            <strong class="blue-txt">-$<span>5.00</span></strong>
                                        </td>-->
                                    </table>
                                <table class="table tt">
                                    <tr id="enter_coupon" style="display: none">
                                        <td class="notop-border notop-padding" colspan="2">
                                            <form class="coupon-code-form">
                                                <input class="form-control input-sm" type="text" placeholder="Enter Coupon Code" id="coupon_code">
                                                <input type="button" class="btn btn-sm btn-w-b" value="Apply" id="apply_coupon" onclick="addCoupon()">
                                                <span class="text-danger" style="display: none" id="coupon_invalid">Invalid Coupon Code</span>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="notop-border notop-padding" colspan="2">
                                            <a class="apply-coupon-code" href="javascript:void(0)" id="add_coupon">+ Apply Coupon Code</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="ar"><strong>$<span id="grand_total"></span></strong></td>
                                    </tr>
                                </table>
                            </div>
                            <!--<input class="btn btn-red" type="submit" value="submit">-->
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
       var x = document.querySelectorAll(".floatLabel");
       for(var i=0;i<x.length;i++)
       {
           if(x[i].value)
           {
               var name=x[i].name;
               var select=x[i].name;
               
              var name= $('input[name='+name+']')
              name.next().addClass('floatLabel active');
              
              var select= $('select[name='+select+']')
              select.next().addClass('floatLabel active');
              
           }
       }
       
       $.ajax({
            url: '{{url("/add-remove-product-quantity")}}',
            type: "get",
            dataType:'json',
            success: function(result) {
                console.log(result);
                $('#cart_count').text(result.product_count);
                addCoupon();
//                $('#grand_total').text(result.subtotal);
            }
        });
        
        $('#add_coupon').click(function() {
        $('#enter_coupon').show();
        $('#add_coupon').hide();
        $('#coupon_code').val('');
    });
        
        checkCard();
    
    });
</script>   
<script>
    $(document).ready(function() {
        if ($('#existing').is(':checked'))
        {
            $('#existing_address').hide();
            $('#new_address').hide();
            $('#new_check').hide();
        }
        else
        {
            $('#existing_address').hide();
            $('#new_address').show();
            $('#new_check').show();
        }
        
    });

    $('#existing').click(function() {
        $('#existing_address').hide();
        $('#new_address').hide();
        $('#new_check').hide();
    });

    $('#new').click(function() {
        $('#existing_address').hide();
        $('#new_address').show();
        $('#new_check').show();
    });
    
    
</script>
<script type="text/javascript">
    var citiesAutocomplete = [];
    var autoCompleteCityId = "";
    var autoCompleteCity = "";
    function updateCityIdOfSelectedSource() {
        var selectedValue = (jQuery("#business_city_autocomplete").data('autocomplete')).selection;
        jQuery('#business_city').val(selectedValue.data);
    }
    function fetchCitiesForAutocomplete() {
        var selectedState = jQuery('#business_state').val();
        jQuery("#cityProgress").removeClass('hidden');
        jQuery("#business_city_autocomplete_container").addClass('hidden');
        jQuery('#business_city').val(autoCompleteCityId);
        jQuery('#business_city_autocomplete').val(autoCompleteCity);
        jQuery.ajax({
            url: "{{url('/get-cities-for-front-selected-state')}}/" + selectedState,
            type: 'GET',
            dataType: 'json',
            success: function(data) {

                jQuery("#cityProgress").addClass('hidden');
                jQuery("#business_city_autocomplete_container").removeClass('hidden');
                jQuery('#business_city').val(autoCompleteCityId);
                jQuery('#business_city_autocomplete').val(autoCompleteCity);

                autoCompleteCity = "";
                autoCompleteCityId = "";

                jQuery(data).each(function(indx, ele) {
                    citiesAutocomplete.push({data: ele.id, value: ele.name});
                });

                jQuery('#business_city_autocomplete').autocomplete('destroy');
                jQuery('#business_city_autocomplete').autocomplete({
                    lookup: citiesAutocomplete,
                    onSelect: updateCityIdOfSelectedSource,
                    beforeRender: function() {
                        jQuery('#business_city').val('')
                    }
                });

            }
        });
    }
</script>
<script type="text/javascript">
    var citiesAutocomplete = [];
    var autoCompleteCityId = "";
    var autoCompleteCity = "";
    function newUpdateCityIdOfSelectedSource() {
        var selectedValue = (jQuery("#new_business_city_autocomplete").data('autocomplete')).selection;
        jQuery('#new_business_city').val(selectedValue.data);
    }
    function newFetchCitiesForAutocomplete() {
        var selectedState = jQuery('#new_business_state').val();
        jQuery("#new_cityProgress").removeClass('hidden');
        jQuery("#new_business_city_autocomplete_container").addClass('hidden');
        jQuery('#new_business_city').val(autoCompleteCityId);
        jQuery('#new_business_city_autocomplete').val(autoCompleteCity);
        jQuery.ajax({
            url: "{{url('/get-cities-for-front-selected-state')}}/" + selectedState,
            type: 'GET',
            dataType: 'json',
            success: function(data) {

                jQuery("#new_cityProgress").addClass('hidden');
                jQuery("#new_business_city_autocomplete_container").removeClass('hidden');
                jQuery('#new_business_city').val(autoCompleteCityId);
                jQuery('#new_business_city_autocomplete').val(autoCompleteCity);

                autoCompleteCity = "";
                autoCompleteCityId = "";

                jQuery(data).each(function(indx, ele) {
                    citiesAutocomplete.push({data: ele.id, value: ele.name});
                });

                jQuery('#new_business_city_autocomplete').autocomplete('destroy');
                jQuery('#new_business_city_autocomplete').autocomplete({
                    lookup: citiesAutocomplete,
                    onSelect: newUpdateCityIdOfSelectedSource,
                    beforeRender: function() {
                        jQuery('#new_business_city').val('')
                    }
                });

            }
        });
    }

    function validationEvent()
    {
        if($('#existing_address').show())
        {
        if ($('#business_city').val() == "")
        {
            $('#select_city').show();
            return false;
        }
        }
        else
        {
        if ($('#new_business_city').val() == "")
        {
            $('#new_select_city').show();
            return false;
        }
        }
        
        
               
    }
    
    function addCoupon(id){
    var coupon_code = $('#coupon_code').val();
    var remove_coupon='';
    if(id)
    {
        remove_coupon=id;
    }
     if(!coupon_code)
     {
         coupon_code='';
     }
       
            $.ajax({
            url: '{{url("/add-coupon")}}',
                    type: "get",
                    dataType: "json",
                    data: {
                    coupon_code: coupon_code,
                       remove_coupon: remove_coupon,
                    },
                    success: function(result) {
                            if (result){
                        $('#coupons').show();
                        $('#order_subtotal').text(result.all_vendor_subtotal.toFixed(2));
                        $('#tax').text(result.tax.toFixed(2));
                        $('#grand_total').text(result.grand_total.toFixed(2));
                        $('#shipping').text(result.shipping_cost.toFixed(2));
                        
                       
                                $('#coupons').html("");
                              if(typeof result.coupon != "undefined")
                              {
                                  $('#coupon_invalid').hide();
                                for(var i=0;i<result.coupon.code.length;i++)    
                                {                       
                                     $('#coupons').append('<tr><td id="vedor_coupon_' + result.coupon.id[i] + '"><strong class="blue-txt">' + result.coupon.code[i] + '</strong><br>\n\
                                                <span>' + result.coupon.offer[i] + '</span> off from ' + result.coupon.store_name[i] + ' <br>\n\
                                            </td>\n\
                                            <td id="vedor_price_' + result.coupon.id[i] + '" class="ar"><a class="checkout-remove" onclick="addCoupon(' + result.coupon.id[i] + ')" href="javascript:void[0]"><i class="fa fa-remove"></i></a><br>\n\
                                                <strong class="blue-txt">-$<span class="off-price">'+(result.coupon.deduct_amount[i])+'</span></strong></td></tr>');
                                }
                                
                                $('#enter_coupon').hide();
                                $('#add_coupon').show();
                            }
                    
                        
                    
                    }
                    if(coupon_code!='' && $('#coupons').html()!='')
                    {
                        if(!result.coupon.code.includes(coupon_code))
                        {
                            $('#coupon_invalid').show();
                            $('#enter_coupon').show();
                            $('#add_coupon').hide();
                        }
                    }
                    else if(coupon_code!='' &&  $('#coupons').html()=='')
                    {
                        $('#coupon_invalid').show();
                        $('#enter_coupon').show();
                        $('#add_coupon').hide();
                    }
                    }
            });
    }
    
    function checkCard(){
        $('#submit').hide();
        var card_number= $('#card_number').val();
        var month= $('#month').val();
        var year= $('#year').val();
        var cvv= $('#cvv').val();
        var name= $('#name').val();
    if(card_number!='' && month!='' && year!='' && cvv!='' && name!='')
    {
        $.ajax({
            url: '{{url("/check-card")}}',
                    type: "get",
                    dataType: "json",
                    data: {
                    card_number: card_number,
                       month: month,
                       year: year,
                       cvv: cvv,
                       name: name,
                    },
                    success: function(result) {
//                        console.log(result);
                        if(result.res =='0')
                        {
                            $('#error_msg_container').show();
                            $('#error_msg').text(result.msg);
                        }
                        else
                        {
                            $('#submit').show();
                            $('#error_msg_container').hide();
                        }
                    }
               });
        }
    }
</script>
@include('includes.footer')
@endsection