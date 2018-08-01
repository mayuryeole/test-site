@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
<title>Blog</title>
<style>
    .tree{list-style:none;padding:0;font-size: calc(100% - 2px);}
    .tree > li > a {font-weight:bold;}
    .subtree{list-style:none;padding-left:10px;}
    .subtree li:before{content:"-";width:5px;position:relative;left:-5px;}
</style>
@endsection

@section("content")
<section class="blogs-blk cms_blog_background">
    <div class="container">
        <div class="heading-holder">
            <div class="main_heading"><span>Blogs</span></div>            
        </div>
        <div class="blog-holder blogs-second blog-detail">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-sx-12">
                    @if(count($posts) < 1)
                    <div class="well">We didn't found any post yet.</div>
                    @endif

                    @foreach($posts as $key => $post)

                    @if( $key > 0 ) @endif
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="blog-inf-blk clearfix">
                                <div class="blog-img">
                                    <a href="javascript:void(0);"><img src="public/media/front/img/5.jpg" alt="blog image"/></a>
                                </div>

                                <div class="blog-info-holder">
                                    <div class="blog-uploader clearfix">
                                        @if($post->post_image)
                                        <div class="bl-upl-img"><img src="{{asset('storage/app/public/blog/thumbnails/'.$post->post_image)}}" /></div>
                                        @endif
                                        <a href="{{ url('/blog/'.$post->post_url) }}"><div class="bl-upl-inf">{{ $post->title }}</div></a>
                                        <div class="blog-date">
                                            <span class="time"><span><i class="fa fa-calendar"></i></span>{{ $post->updated_at->format('M d, Y h:i A')}}</span>
                                        </div>
                                    </div>
                                    <div class="blog-desc">
                                        <h4><a href="javascript void(0);">{{ $post->short_description }}</a></h4>
                                        <p>{!! $post->description !!}</p>   
                                        <a href="{{ url('/blog/'.$post->post_url) }}">View Comments</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>                        
                    </div>
                    @endforeach
                    <?php echo $posts->links(); ?>
                </div>                
            </div>
        </div>
    </div>
</section>
@endsection