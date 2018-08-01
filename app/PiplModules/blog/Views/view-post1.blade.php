@extends(config("piplmodules.front-view-layout-location"))


@section('meta')
<title>Blog Details</title>
@endsection
@section('content')

<!-------------------------------middle section------------------------>
<section class="cms">
    <div class="cms-banner" style="background-image:url(images/contactus-banner.jpg)">
      <p>Blog Details </p>
  </div>

  <div class="cms-main">
   <div class="container">
      <div class="cms-outer  blogdetailouter clearfix">
       <div class="blogdetailmain">
           <div class="blogdetail-banner">

           @if(isset($detail))
            @if($detail->post_image=="")
            <img src="{{ URL::to('/storage/app/public') }}/blog/default_blog.png">
            @endif
            @if($detail->post_image!="")
            <img src="{{ URL::to('/storage/app/public') }}/blog/{{ $detail->post_image }}">
            @endif

            <span class="posted-on">{{date('d M,Y',strtotime($detail->created_at))}}</span>
            @endif
        </div>
        <div class="reviblog">
           <ul>

               <li>
                   <a href="javascript:void"><i class=" fa fa-comment"></i></span>{{$cnt_comm}}</a>
               </li>
           </ul>
       </div>
       <div class="innerblogdetailhead">
        <a href="javascript:void(0)"><h1> @if(isset($detail)){{$detail->title}}@endif</h1></a>

    </div>
    <div class="bloddetailcon">

        <p> @if(isset($detail)){{strip_tags($detail->description)}}@endif</p>
   </div>
   <div class="blogdetailcommentbox">
    @if(isset($comments) && count($comments)>0)
    @foreach($comments as $v)
    <div class="blogcommentmain">
       <div class="media">
           <div class="media-left">
               <div class="blogdtailmedleft">
                   <a href="javascript:void(0)">
                    <img src="{{ asset('public/media/front/images/user.png') }}">
                   </a>
                    </div>
           </div>
           <div class="media-body">
               <div class="blogdetailmidright">
                   @if(isset($v->commentUser))
                   <h4>{{$v->commentUser->userInformation->first_name." ".$v->commentUser->userInformation->last_name}}</h4>
                   <div class="time">{{$v->created_at->diffForHumans()}}</div>
                    @endif
                   <p>
                           @if($v->comment)

                       {{$v->comment}}
                          @endif

                   </p>
                </div>
           </div>
       </div>
   </div>
   @endforeach
   @endif

</div>

<div class="postcomment">
   <div class="comment-head">
       Post Your Comment
   </div>
   <form class="form-horizontal" role="form" action="{{url('/blog-details')}}/{{$post_id}}" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
    <div class="postcommentform">

        <div class="form-group {{ $errors->has('comment') ? ' has-error' : '' }}">
           <textarea id="comment" class="form-control" name="comment" placeholder="Enter Your Comment"></textarea>
           <input type="hidden" value="{{$post_id}}" name="post_id">
           @if ($errors->has('comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                @endif
       </div>
       <div class="form-group">
           <div class="postcommentbut">
               <ul>
                   <li>
                       <button type="submit" class="btn btn-main">Post</button>
                   </li>
                   <li>
                       <button onclick="cancel()" type="button" class="btn btn-main">Reset</button>
                   </li>
               </ul>
           </div>
       </div>
   </div>
</form>

</div>
</div>
</div>
</div>
</div>
</section>
<script>
    function cancel()
    {
        $('#comment').val("");
    }
</script>
@include('regions.footer')
@endsection
@section('footer')
{{--<script src="{{ asset('website_assets/js/customize/home.js') }}" type="text/javascript"></script>--}}
@endsection

</body>
</html>