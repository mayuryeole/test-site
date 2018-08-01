@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
<title>Frequently Asked Questions</title>
@endsection

@section("content")


<!--<section class="cms-header" style="background-image:url({{ url('/') }}/public/media/front/img/bg_cms_1.jpg);">
    <div class="container">
        <div class="cms-caption">
            <div class="cms-ban-heading">
                FAQ'S
            </div>
            <div class="cms-ban-breadcrumbs">
               	<ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><span>>></span></li>
                    <li class="active">Faq's</li>
                </ul>
            </div>
        </div>
    </div>
</section>-->
<!---------------------------------------------------------TERMS & CONDITIONS---------------------------------------------->
<section class="terms_condition_block cms_faq_background">
    <div class="container">
		<div class="heading-holder">
            <div class="main_heading"><span>Faq's</span></div>            
        </div>
        <div class="row">
            <div class="faqs_block">
                <div class="panel-group" id="accordion" role="tablist">
                    @if(count($faqs)>0)
                    @foreach($faqs as $faq)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#faq_{{ $faq->id }}">
                                <span><i class="fa fa-plus"></i></span> {{$faq->question}}
                            </a>
                        </div>
                        <div id="faq_{{ $faq->id }}" class="panel-collapse collapse" role="tabpanel">
                            <div class="panel-body">
                                <p>{!! $faq->answer !!}</p>
                            </div>
                        </div>
                    </div>

                    @endforeach

                    @else
                    <div class="row">
                        <div class="faqs_block">
                            <div class="panel-group" id="accordion" role="tablist">
                                <div class="panel panel-default">
                                    <div class="panel-body" role="tab">
                                        <h4 style="text-align: center"> Sorry, No data found</h4>
                                    </div>
                                </div></div>    
                        </div>
                    </div>     
                    @endif
                </div>  
            </div>
        </div>
    </div>
</section>
@endsection
