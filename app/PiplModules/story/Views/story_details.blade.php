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

<section class="cms-header" style="background-image:url(img/bg_cms_1.jpg);">
	<div class="container">
    	<div class="cms-caption">
            <div class="cms-ban-heading">
                Blogs
            </div>
            <div class="cms-ban-breadcrumbs">
               	<ul>
                	<li><a href="javascript:void(0);">Home</a></li>
                    <li><span>>></span></li>
                    <li class="active">Blogs</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="blogs-blk">
	<div class="container">
    	<div class="heading-holder">
            <!--<div class="sub-heading">Categories</div>-->
            <div class="main_heading">Blogs Details</div>
        </div>
        <div class="blog-holder blogs-second blog-detail">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-sx-12">
                	<div class="row">
                    	<div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="blog-inf-blk clearfix">
                                <div class="blog-img">
                                    <a href="javascript:void(0);"><img src="img/5.jpg" alt="blog image"/></a>
                                </div>
                                <div class="blog-info-holder">
                                	<div class="blog-uploader clearfix">
                                        <div class="bl-upl-img"><img src="img/profiler-img.png" alt="img"/></div>
                                        <div class="bl-upl-inf">Name Here</div>
                                        <div class="blog-date">
                                            <span class="date"><span><i class="fa fa-calendar"></i></span>13 June 2017</span>
                                            <span class="time"><span><i class="fa fa-clock-o"></i></span>01:05 PM</span>
                                            <p class="comment-section"><span ><i class="fa fa-comment"></i></span> <span class="comment-count">10</span> <span>Comments</span></p>                                    
                                        </div>
                                    </div>
                                    <div class="blog-desc">
                                        <h4><a href="javascript(0);">What is Lorem Ipsum?</a></h4>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>                
            </div>
            <div class="comment-sec-person">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="comment-person-list">
                            <div class="blog-uploader clearfix">
                                <div class="bl-upl-img"><img src="img/profiler-img.png" alt="img"/></div>
                                <div class="bl-upl-inf">Name Here</div>
                                <div class="blog-date">
                                    <span class="date"><span><i class="fa fa-calendar"></i></span>13 June 2017</span>
                                    <span class="time"><span><i class="fa fa-clock-o"></i></span>01:05 PM</span>                                   
                                </div>
                            </div>
                            <div class="person-comment">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            	<div class="col-md-12 col-sm-12 col-xs-12">
                	<div class="comment-blk">
                    	<form class="form-comment">
                        	<div class="form-group">
                            	<label>Name: </label>
                            	<input type="text" class="form-control" placeholder="Enter Your Name Here"/>
                            </div>
                            <div class="form-group">
                            	<label>Comment: </label>
                            	<textarea type="text" class="form-control" placeholder="Enter Your Comment Here"> </textarea>
                            </div>
                            <div class="comment-btn">
                            	<button type="button" class="btn btn-submit">Post A Comment</button>
                                <button type="button" class="btn btn-submit">Back</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection