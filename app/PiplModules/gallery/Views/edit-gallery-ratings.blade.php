@extends(config("piplmodules.back-view-layout-location"))
@section("meta")
<title>Update Gallery Rating</title>
@endsection
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <ul class="page-breadcrumb breadcrumb hide">
            <li>
                <a href="{{url('admin/dashboard')}}">Home</a><i class="fa fa-circle"></i>
            </li>
            <li class="active">
                Dashboard
            </li>
        </ul>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('/admin/list-galry-ratings')}}">Manage Gallery Rating</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="javascript:void(0);">Update Gallery Rating</a>
            </li>
        </ul>
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Update Gallery Rating</span>
                            </div>
                        </div>
                        @if (session('profile-updated'))
                        <div class="alert alert-success">
                            {{ session('profile-updated') }}
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        </div>
                        @endif
                        @if (session('password-update-fail'))
                        <div class="alert alert-danger">
                            {{ session('password-update-fail') }}
                        </div>
                        @endif
                        <div class="portlet-body">
                            <div class="tab-content">
                                <form name="update_entry" enctype="multipart/form-data"  id="update_entry" role="form" method="post" action="{{ url('/admin/update-gal-rating/'.$info->id)}}">
                                    {!! csrf_field() !!}
                                     <input  id="galry_rat" type="hidden" value="{{ $info->rating }}">
                                    <div class="form-group">
                                        <label class="control-label">Rating <sup style='color:red;'>*</sup></label>
                                        <div id="avg-ratng"></div>
                                        <input  id="ratng-val" name="rating" type="hidden">
                                    </div>
                                     <div class="form-group">
                                         <input  id="galry_id" type="hidden" name="galID" value="{{ $info->gallery_id }}">
                                     </div>
                                    <div class="margiv-top-10">
                                        <input type="submit" class="btn green-haze" value="Save Changes">
                                        <a href="{{url('/admin/list-gal-ratings')}}" class="btn default">
                                            Cancel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function () {
 var $rat = $("#galry_rat").val();
    
    $("#avg-ratng").rateYo({
    rating    :  $rat,   
    spacing   : "5px",
    starWidth : "30px",
    readOnly: false
//    multiColor: {
// 
////      "startColor": "#FF0000", //RED
////      "endColor"  : "#F39C12"  //GREEN
//    }
  });
  $("#avg-ratng").rateYo("option", "onSet", function (rating) {
     // alert(rating);return;
          $("#ratng-val").attr("value",rating);
       //   alert($("ratng-val").val());
       });
  // Getter
//var ratedFill = $("#rateYo").rateYo("option", "ratedFill"); //returns "#E74C3C"
 
// Setter
//if($rat > 0){
//$("#avg-ratng").rateYo("option", "rating", $rat); //returns a jQuery Element
//}

});

</script>
@endsection