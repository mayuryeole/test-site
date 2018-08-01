@extends(config("piplmodules.front-view-layout-location"))

@section('meta')
<title>{{$page_information->page_title}}</title>
<meta name="keywords" content="{{$page_information->page_meta_keywords}}" />
<meta name="description" content="{{$page_information->page_meta_descriptions}}" />
@endsection

@section("content")
<!--CMS Header Here-->
<!--<section class="cms-header" style="background-image:url(public/media/front/img/bg_cms_1.jpg);">
	<div class="container">
    	<div class="cms-caption">
            <div class="cms-ban-heading">
                {{$page_information->page_title}}
            </div>
            <div class="cms-ban-breadcrumbs">
               	<ul>
                	<li><a href="{{ url('/')}}">Home</a></li>
                    <li><span>>></span></li>
                    <li class="active">{{$page_information->page_title}}</li>
                </ul>
            </div>
        </div>
    </div>
</section>-->


<section class="terms_condition_blk return_policy_blk cms_background">
	<div class="container">
            <div class="heading-holder">
                <div class="main_heading"><span>{{$page_information->page_title}}</span></div>
            </div>
    	
            <div class="terms_condition_start">
                <div class="row">
                    <div class="col-md-12">
                        <div class="categories-type clearfix">                   

                            <div class="about-info-blk">

                                <div class="cms-description">
                               {!! $page_information->page_content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
</section>

@endsection