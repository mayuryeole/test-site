@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
<title>Frequently Asked Questions</title>
@endsection

@section("content")


<section class="cms-header" style="background-image:url(public/media/front/img/bg_cms_1.jpg);">
	<div class="container">
    	<div class="cms-caption">
            <div class="cms-ban-heading">
                FAQ'S
            </div>
            <div class="cms-ban-breadcrumbs">
               	<ul>
                	<li><a href="javascript:void(0);">Home</a></li>
                    <li><span>>></span></li>
                    <li class="active">Faq's</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!---------------------------------------------------------TERMS & CONDITIONS---------------------------------------------->
<section class="terms_condition_block">
	<div class="container">
    	<div class="row">
        	<div class="faqs_block">
                <div class="panel-group" id="accordion" role="tablist">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#faq_one">
                                <span><i class="fa fa-plus"></i></span> What is Lorem Ipsum?
                            </a>
                        </div>
                        <div id="faq_one" class="panel-collapse collapse" role="tabpanel">
                            <div class="panel-body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                 <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#faq_two">
                                <span><i class="fa fa-plus"></i></span> What is Lorem Ipsum?
                            </a>
                        </div>
                        <div id="faq_two" class="panel-collapse collapse" role="tabpanel">
                            <div class="panel-body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                 <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#faq_three">
                                <span><i class="fa fa-plus"></i></span> What is Lorem Ipsum?
                            </a>
                        </div>
                        <div id="faq_three" class="panel-collapse collapse" role="tabpanel">
                            <div class="panel-body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                 <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            </div>
                        </div>
                    </div>
              	</div>  
            </div>
        </div>
    </div>
</section>
@endsection
