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
                            <li class="active"><span>1</span>
                                <strong>Shipping</strong>
                            </li>
                            <li class="step-line"><span></span></li>
                            <li><span>2</span>
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
                    <div class="col-xs-12 col-md-8">
                        <div class="checkout-main box-shadow">
                            <h4>shipping address</h4>
                            <p><a href="javascript:void(0)">Enter your shipping address</a></p>
                            <form action="{{url('/payment-check-out')}}" method="post" onsubmit="return validationEvent();">
                                {!! csrf_field() !!}
                                <input type="hidden" name="address_id" value="{{$address?$address->id:''}}">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="text" id="" class="floatLabel" name="first_name" value="{{old('first_name',$address?$address->first_name:'')}}">
                                                <label for="">First Name</label>
                                            </div>
                                            @if ($errors->has('first_name'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="text" id="" class="floatLabel" name="last_name" value="{{old('last_name',$address?$address->last_name:'')}}">
                                                <label for="">Last Name</label>
                                            </div>
                                            @if ($errors->has('last_name'))
                                            <span class="text-danger">
                                                <strong> {{ $errors->first('last_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="text" id="" class="floatLabel" name="street" value="{{old('street',$address?$address->street:'')}}">
                                                <label for="">Street</label>
                                            </div>
                                            @if ($errors->has('street'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('street') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <input type="text" id="" class="floatLabel" name="apt" value="{{old('apt',$address?$address->apartment:'')}}">
                                                <label for="">Apt/Suite <span>(Optional)</span></label>
                                            </div>
                                            @if ($errors->has('apt'))
                                            <span class="text-danger">
                                                <strong> {{ $errors->first('apt') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="controls"> <i class="fa fa-angle-down"></i>
                                                <select class="floatLabel" required id="business_state" onchange="fetchCitiesForAutocomplete()" name="state">
                                                    @foreach($states as $state)
                                                    <option @if($address && $state->id==$address->user_state) selected="selected" @endif value="{{$state->id}}">{{$state->name}}</option>
                                                    @endforeach
                                                </select>
                                                <label for="business_state">State</label>
                                            </div>
                                            @if ($errors->has('state'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('state') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-5" id="business_city_autocomplete_container">
                                        <div class="form-group">
                                            <div class="form-group hidden" id="cityProgress">
                                                <img src="{{url('public/media/front/images/loader.gif')}}" height="25" /> Loading Cities....
                                            </div>
                                            <div class="controls">
                                                <input type="text" value="{{old('business_city_autocomplete',$address?$address->city->name:'')}}" id="business_city_autocomplete" class="floatLabel" name="city">
                                                <label for="business_city_autocomplete" id="business_city_autocomplete_lable">City</label>
                                                <input type="hidden" id="business_city" value="{{old('business_city',$address?$address->city->id:'')}}" name="business_city">
                                                @if ($errors->has('city'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                                @endif
                                                <span class="text-danger" id="select_city" style="display:none">
                                                    <strong>Please select valid city</strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <div class="controls">
                                                <input id="" type="text" name="zip_code" maxlength="6" class="floatLabel" value="{{$address?$address->zipcode:''}}">
                                                <label for="">Zip Code</label>
                                            </div>
                                            @if ($errors->has('zip_code'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('zip_code') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="default_address" id="" value="1" @if($address?$address->default_address==1:'') checked @endif>
                                                   <span class="custom-checkbox"><i class="icon-check"></i></span> Make this my default shipping address</label>
                                    </div>
                                </div>
                                <div class="form-group btn-bottom-box">
                                    <input type="submit" class="btn btn-red" value="continue">
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
<!--                                    <tr>
                                        <td>Shipping <strong>to {{$address?$address->zipcode:''}} </strong></td>
                                        <td class="ar"><strong>$<span id="shipping_cost">{{$address?'30.00':'00.0'}}</span></strong></td>
                                    </tr>-->
                                    <tr>
                                        <td>Shipping</td>
                                        <td class="ar"><strong>$<span id="shipping"></span></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Tax</td>
                                        <td class="ar"><strong>$22.32</strong></td>
                                    </tr>
                                    </table>
                                <table class="table tt"  id="coupons">
                                    <!--<tr id="coupons" style="display: none">-->
<!--                                        <td><strong class="blue-txt">MODERN10</strong><br>
                                            <span>10</span><span>%</span> off from Modern Times<br>


                                        </td>
                                        <td class="ar"><a class="checkout-remove" href=""><i class="fa fa-remove"></i></a><br>
                                            <strong class="blue-txt">-$<span>5.00</span></strong>
                                        </td>-->
                                    <!--</tr>-->
                                    </table>
                                <table class="table tt">
                                    <tr id="enter_coupon" style="display: none">
                                        <td class="notop-border notop-padding" colspan="2">
                                            <form class="coupon-code-form">
                                                <input class="form-control input-sm" type="text" placeholder="Enter Coupon Code" id="coupon_code">
                                                <input type="button" class="btn btn-sm btn-w-b" value="Apply" id="apply_coupon"  onclick="addCoupon()">
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
    });
    
    $('#add_coupon').click(function() {
        $('#enter_coupon').show();
        $('#add_coupon').hide();
        $('#coupon_code').val('');
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

    function validationEvent()
    {
        if ($('#business_city').val() == "")
        {
            $('#select_city').show();
            return false;
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
                        $('#shipping').text(result.shipping_cost.toFixed(2));
                        $('#tax').text(result.tax.toFixed(2));
                        $('#grand_total').text(result.grand_total.toFixed(2));
                        
                         $('#coupons').html("");
                              if(typeof result.coupon != "undefined")
                              {
                                  $('#coupon_invalid').hide();
                                for(var i=0;i<result.coupon.code.length;i++)    
                                {                       
                                     $('#coupons').append('<tr><td id="vedor_coupon_' + result.coupon.id[i] + '"><strong class="blue-txt">' + result.coupon.code[i] + '</strong><br>\n\
                                                <span>' + result.coupon.offer[i] + '</span> off from ' + result.coupon.store_name[i] + ' <br>\n\
                                            </td>\n\
                                            <td id="vedor_price_' + result.coupon.id[i] + '" class="ar"><a class="checkout-remove" onclick="addCoupon(' + result.coupon.id[i] + ')" href="javascript:void[0]" title="remove"><i class="fa fa-remove"></i></a><br>\n\
                                                <strong class="blue-txt">-$<span class="off-price">'+result.coupon.deduct_amount[i]+'</span></strong></td></tr>');
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
</script>
@include('includes.footer')
@endsection
