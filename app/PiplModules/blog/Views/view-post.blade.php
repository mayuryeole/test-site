@extends(config("piplmodules.front-view-layout-location"))
 
@section('meta')
<title>{{$page_information->seo_title}}</title>
<meta name="keywords" content="{{$page_information->seo_keywords}}" />
<meta name="description" content="{{$page_information->seo_description}}" />
@endsection

@section("content")
<section class="blogs-blk cms_background">
    <div class="container">
        <div class="heading-holder">
            <div class="main_heading"><span>Blog Details</span></div>            
        </div>
        <div class="blog-holder blogs-second blog-detail">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-sx-12">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="blog-inf-blk clearfix">
                                <div class="blog-info-holder">
                                    <div class="blog-uploader clearfix">
                                        @if($page->post_image)
                                        <div class="bl-upl-img"><img src="{{asset('storageasset/blog/'.$page->post_image)}}" /></div>
                                        @endif
                                        <div class="bl-upl-inf">{{$page_information->title}}</div>

                                    </div>
                                    <div class="blog-desc">
                                        <p>{!! $page_information->description !!}</p>                                     
                                    </div>
                                      
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>                
            </div>
        </div>
        
        <div class="row">
             @if(isset($page_information->post) && $page_information->post->allow_comments==1)
       
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="comment-blk">
                    <form class="form-comment" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="form-group @if ($errors->has('comment')) has-error @endif"">
                            <label class="enter_comment">Comment: </label>
                            <textarea type="text" name="comment" class="form-control" placeholder="Enter Your Comment Here"> </textarea>
                            @if ($errors->has('comment'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('comment') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="comment-btn">
                            <button type="submit" class="btn btn-submit comment-btn">Post A Comment</button>
                            <a href="{{url('/blog')}}"><button type="button" class="btn btn-submit comment-btn">Back</button></a>
                        </div>
                    </form>
                </div>
            </div>
             @endif
             @if(isset($page_information->post) && $page_information->post->allow_comments==1)
       
            <div class="col-md-6 col-sm-6 col-xs-12">
            	<div class="comment-lists ">
                	<label class="enter_comment">View Comment: </label>
                    <div class="comment-lis mCustomScrollbar">
                    	<ul class="cooment">
                            @if(count($comments)>0)
                             @foreach($page->comments()->get() as $comment)
       						
                        	<li>
                              <div class="media media-bg">
                                  @if($page->post_image)
                                    <div class="media-left">
                                      <img src="{{asset('storageasset/blog/'.$page->post_image)}}" class="media-object mediad-imgs" 
                                      style="width:60px" >
                                    </div>
                                  @endif
                                    <div class="media-body comment-p">
                                    	<div class="like-reply">
                                            <div class="like">
                                                <span><i class="fa fa-thumbs-o-up c-like"></i>@if(isset($comment->created_at) && $comment->created_at!=""){{$comment->created_at->format('M d \a\t h:i a')}}@endif</span>
                                            </div>
                                        </div>
                                      <h4 class="media-heading">Posted By: @if(isset($comment->commentUser->userInformation->first_name) && $comment->commentUser->userInformation->first_name!=""){{ $comment->commentUser->userInformation->first_name}} @endif</h4>
                                      <p>Comment: @if(isset($comment->comment) && $comment->comment!=""){{$comment->comment}} @endif</p>
                                       
                                    </div>
                            </div>
                       	 </li>
                          @endforeach
                          
                          @else
                          <li>
                              <div class="media media-bg">
                                        <marquee><span>No comments available,You can post here!! </span></marquee>
                     
                            </div>
                          </li>
                          @endif
                          
                       </ul>
                    </div>
				</div>
            </div>
             @endif
        </div>
      
        

       
    </div>
</section>
@endsection