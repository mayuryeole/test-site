@extends(config("piplmodules.back-view-layout-location"))
@section("meta")
<title>Update Rating </title>

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
                <a href="{{url('admin/rating-list')}}">Manage Review and Rating</a>
                <i class="fa fa-circle"></i>

            </li>
            <li>
                <a href="">Update Review and Rating</a>
            </li>
        </ul>
      

        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Edit Review and Rating
                </div>

            </div>
            <div class="portlet-body form">
                <form role="form" class="form-horizontal"  method="post" id="update-rating" >
                    {!! csrf_field() !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">    
                                  <div class="col-md-8">
                                  
                                      <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }}">
                                        <label class="col-md-6 control-label rate-label">Existing Rating<sup style='color:red;'>*</sup> </label>
                                        <div class="col-md-6">    
                                               <div class="stars-images">
                                                <?php
                                                        
                                                        if (count($rating) > 0) {
                                                            $k = 0;
                                                            $is_flot = false;
                                                            $arr_rat = explode('.', $rating[0]['rating']);
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
                                                        } else {
                                                            for ($ss = 0; $ss < 5; $ss++) {
                                                                ?>
                                                                <img  src="{{url('public/media/front/img/star-off.png')}}"/>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">   
                                           
                                                <div class="form-group @if ($errors->has('rating')) has-error @endif">
                                                    <label class="col-md-6 control-label rate-label">Rating</label>

                                                    <div class="col-md-6">     
                                                        <div  data-score id="rating" >

                                                            @if ($errors->has('rating'))
                                                            <span class="help-block">
                                                                <strong class="text-danger">{{ $errors->first('rating') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                        </div>
                                        </div>
                                         <div class="col-md-12">    
                                           
                                                <div class="form-group @if ($errors->has('rating')) has-error @endif">
                                                    <label class="col-md-6 control-label rate-label">Reviews<sup>*</sup></label>

                                                    <div class="col-md-6">     
                                                        <textarea class="form-control"  id="review" name="review" placeholder="Write Your Review Here" >{{$rating[0]['review']}}</textarea>
                                                        @if ($errors->has('review'))
                                                        <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('review') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <input type="hidden"  class="form-control company" id="rating_id" name="rating_id" value="{{$rating[0]['id']}}">
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
                        </div>
                    </form>
                    </div>

                
            </div>
        </div>
    </div>



@endsection
