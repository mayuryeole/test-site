@extends('layouts.app')

@section('meta')
<title>Book Appointment</title>
@endsection
<?php
$problem_categories=  \App\PiplModules\category\Models\Category::all();

?>
<section class="account-setting dash-cms-cust">
    <div class="container">
        <div class="choose_experts">
            <div class="row">
                <div class="col-md-12">
                    <div class="experts-head text-center">
                        <h3>Book Your Appointment</h3>
                        <p>
                           Select expert advisor according to your problem. 
                        </p>
                    </div>
                </div>
            </div>
            <!------------------------------Search Select Experts------------------------------>

            <div class="row">
                <div class="search-ex">
                    <div class="col-md-5 col-sm-5">
                        <div class="sear-exp-head">
                            <h3>SELECT FROM OUR TOP EXPERTS</h3>
                        </div>
                    </div>
<!--                    <div class="col-md-7 col-sm-7">
                        <div class="search-exp">
                            <input type="text" class="sear-ex" placeholder="Search Experts from List">
                            <span class="sp-ex"><i class="fa fa-search se-ex search-exp" aria-hidden="true"></i></span>
                        </div>
                    </div>-->
                </div>
            </div>
            <!------------------------------Select Experts------------------------------>
<!--            <div class="col-md-3 col-sm-3">
                <div class="form-group">
                    <select class=" form-control service-ed search-pblm service-edit" id="expertis" name="expertise" onchange="search()">
                        <option value=""  selected="">Search your expertise</option>   
                   @foreach($problem_categories as $cat)
                     <option value="{{$cat->id}}"  @if(isset($request->expertise) && $request->expertise == $cat->id) selected @endif>{{$cat->name}}</option>
                   @endforeach

               </select>

                </div>
            </div>-->
             <div class="col-md-4 col-sm-4">
                <div class="search-exp">
                    <input type="text" id="search-state" value="@if(isset($request->state)){{$request->state}}@endif" class="sear-ex" placeholder="Search Experts from State" onkeyup="search()">
                    <span class="sp-ex search-exp"><i class="fa fa-search se-ex" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="search-exp">
                    <input type="text" id="city" value="@if(isset($request->city)){{$request->city}}@endif" class="sear-ex" placeholder="Search Experts from City" onkeyup="search()">
                    <span class="sp-ex search-exp"><i class="fa fa-search se-ex" aria-hidden="true"></i></span>
                </div>
            </div>
           
       
            <div class="col-md-4 col-sm-4">
                <div class="search-exp">
                    <input type="text" name='zipcode' id="zipcode" @if(isset($request->zipcode)) value="{{$request->zipcode}}" @endif class="sear-ex"  placeholder="Search Experts from Zipcode" onkeyup="search()">
                    <span class="sp-ex search-exp"><i class="fa fa-search se-ex" aria-hidden="true"></i></span>
                </div>
            </div>
            
            <div class="row" id='main_div'>
                <div class="expert-slider">
                    <div class="col-md-12">
                        <div id="experts">
                           
                            @if(isset($all_expert_list) && count($all_expert_list)>0)
                            @foreach($all_expert_list as $expert)
                            @if($expert!='')
                            <a href="{{url('appointment/mode-of-contact/'.base64_encode($expert->user_id))}}">
                            <div class="item" >
                                <div class="in-ex text-center">
                                    <div class="exp_item_img">
                                        
                                        <center>
                                            @if(isset($expert->profile_picture)&& $expert->profile_picture!='')
                                            <img src="{{url('public/media/front/img/user/'.$expert->user_id.'/'.$expert->profile_picture)}}" alt="image" class="img-responsive ex-img">
                                            @else
                                             @if($expert->gender=='1')
                                             <img src="{{ url('public/media/front/img/male-user.png') }}" alt="image" class="img-responsive ex-img">
                                             @else
                                             <img src="{{ url('public/media/front/img/woman-avatar.png') }}" alt="image" class="img-responsive ex-img">
                                             @endif
                                            @endif 
                                        </center>
                                    </div>
                                    <div class="ex-name">
                                        <p>{{$expert->first_name}}</p>
                                        <p class="ex">

                                            @if(isset($expert->Expertise)&& count($expert->Expertise)>0)

                                            @foreach($expert->Expertise as $expert_cat)
                                            {{$expert_cat->categoryName->name}}
                                            @endforeach
                                            @endif  

                                        </p>
                                    </div>
                                    <div class="ex-rate">
                                        
                                            <?php

                                            $k = 0;
                                            $is_flot = false;
                                            $arr_rat = explode('.', $expert->avg_rating);
                                            if (count($arr_rat) == 1) {
                                                $arr_rat[1] = '0';
                                            }
                                            if ($arr_rat[0] != "") {
                                                if ($arr_rat[1] != '0') {
                                                    $is_flot = "true";
                                                }
                                                for ($ii = 0; $ii < $arr_rat[0]; $ii++) {
                                                    ?>
                                                    <img  src="{{url('public/media/front/img/star-on.png')}}"/>
                                                    <?php
                                                    $k++;
                                                }
                                                if ($is_flot) {
                                                    ?>
                                                    <img  src="{{url('public/media/front/img/star-half.png')}}"/>
                                                    <?php
                                                }
                                                if ($is_flot) {
                                                    $s = $arr_rat[0] + 1;
                                                } else {
                                                    $s = $arr_rat[0];
                                                }
                                                if ($s < 5) {
                                                    for ($j = $s; $j < 5; $j++) {
                                                        ?>
                                                        <img  src="{{url('public/media/front/img/star-off.png')}}"/>
                                                        <?php
                                                        $s++;
                                                    }
                                                }
                                            }

                                        ?>
                                    
                                    </div>
                                    <div class="last-act">
                                        <p>{{$expert->last_login}}</p>
                                    </div>
                                    <div class="check-experts">
                                        <span class="chec-ex">
                                            <!--<a id="select-expert" href="{{url('appointment/mode-of-contact/'.base64_encode($expert->user_id))}}">-->
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            <!--</a>-->
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </a>    
                            @endif
                            @endforeach
                           @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="no-record" @if(isset($all_expert_list) && count($all_expert_list)>0) style="display: none;" @endif >
                <div class="col-md-12">
                   <div class="no-rec-found"> 
                      <p>No Record Found</p>
                  </div>
                </div>
            </div>

        </div>
    </div>
</section>


@section('footer')
<script>
//    $(document).ready(function(){
//       search(); 
//    });
    
    function search()
    {
        var data = {'city': $("#city").val(), state:$("#search-state").val(), zipcode:$("#zipcode").val(), 'category':$("#expertis").val()}
        $.ajax({
            url: '{{url( "/ajax-search-user-from-city" )}}',
            data: data,
            dataType: "html",
            success: function(res) {

                if(res!='No Record Found')
                {
                    $('#main_div').empty();  
                    $('#main_div').html(res); 
                    $("#no-record").hide();
//                    $("#experts").html("");
//                    $.each(res, function(index, value) {
//                        var static_html = $("#experts_footer").html();
//                        $("#experts").append(static_html.replace("replace-1",javascript_site_path+'public/media/front/img/user/'+value.user_id+'/'+value.profile_picture).replace("replace-2",value.first_name));
//                    
//                        });
                } else {
                    $('#main_div').empty();
                    $("#no-record").show();
                }
        }
        });
    }

    function searchFromState(value)
    {
        $.ajax({
            url: '{{url( "/ajax-search-user-from-state" )}}',
            data: {'state': value},
            dataType: "html",
            success: function(res) {
                  if(res!='No Record Found')
                {
                    $('#main_div').empty();  
                    $('#main_div').html(res); 
                    $("#no-record").hide();

                } else {
                    $('#main_div').empty();
                    $("#no-record").show();
                }
              
            }
        });
    }
    
    function searchFromCategory(value)
    {
       
        $.ajax({
            url: '{{url( "/ajax-search-user-from-category" )}}',
            data: {'category': value},
            dataType: "html",
            success: function(res) {
                   if(res!='No Record Found')
                {
                    $('#main_div').empty();  
                    $('#main_div').html(res); 
                    $("#no-record").hide();

                } else {
                    $('#main_div').empty();
                    $("#no-record").show();
                }
             
            }
        });
    }
    
    function searchFromZipcode(value)
    {
        $.ajax({
            url: '{{url( "/ajax-search-user-from-zipcode" )}}',
            data: {'zipcode': value},
            dataType: "html",
            success: function(res) {
                  if(res!='No Record Found')
                {
                    $('#main_div').empty();  
                    $('#main_div').html(res); 
                    $("#no-record").hide();

                } else {
                    $('#main_div').empty();
                    $("#no-record").show();
                }
            }
        });
    }
    
    function searchFilter(value)
    {
        
        $.ajax({
            url: '{{url( "/search-flter-all" )}}',
            data: {'zipcode': value},
            dataType: "html",
            success: function(res) {
                  if(res!='No Record Found')
                {
                    $('#main_div').empty();  
                    $('#main_div').html(res); 
                    $("#no-record").hide();

                } else {
                    $('#main_div').empty();
                    $("#no-record").show();
                }
            }
        });
    }
   
   
   
   @if(isset($request->city))
   
//   searchFromCity("pune");
   @endif
   
   
   @if(isset($request->expertise))
    search('{{$request->expertise}}');
   @endif
   
   

</script>    
@endsection('footer')