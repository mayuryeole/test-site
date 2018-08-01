@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
<title>Contact Us</title>
@endsection

@section("content")
<script>
    function resetform() {
        document.getElementById("myform").reset();
    }

</script>
<!--CMS HEADER HERE-->
<!--<section class="cms-header" style="background-image:url({{ url('/') }}/public/media/front/img/bg_cms_1.jpg);">
    <div class="container">
        <div class="cms-caption">
            <div class="cms-ban-heading">
                Contact Us
            </div>
            <div class="cms-ban-breadcrumbs">
               	<ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><span>>></span></li>
                    <li class="active">Contact Us</li>
                </ul>
            </div>
        </div>
    </div>
</section>-->

<section class="contact-form cms_about_us_background">
    <div class="container">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        </div>
        @endif
        <div class="heading-holder">
            <div class="main_heading"><span>GET IN TOUCH</span></div>
        </div>
        <div class="row">
            <div class="contact-frm-hold clearfix">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="con-info">
                        <h3>OUR OFFICE</h3>
                        <p><span class="paras-identity">Chawla’s International</span></p> 
                        <p>Unit No 20/21 , Eastern Plaza,</p> <p>Daftary Road , Malad (East),</p> <p>Mumbai - 400097.  MH, India</p>
                        <!-- <h3>OUR OFFICE</h3>
                        <p class="mgt-text"><strong>Chawlas International</strong></p>
                        <p>Unit No - 20 & 21, Eastern Plaza,</p>
                        <p><strong>{{ GlobalValues::get('address') }}</strong></p> <p>{{ GlobalValues::get('street')}},</p>
                        <p>{{GlobalValues::get('city')}},
                        {{ GlobalValues::get('zip-code')}}</p> -->
                        



                        <h3>Call us today</h3>
                        <p><span>Phone :</span> {{ GlobalValues::get('phone-no') }}</p>


                        <h3>Email Us Now</h3>
                        <p><a href="javascript:void(0);">{{ GlobalValues::get('contact-email') }}</a></p>


                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="con-info con-form">
                        <h3>Send message to us</h3>
                        <form  id="myform" method="post" enctype="multipart/form-data" name="myform">
                            {!! csrf_field() !!}
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group cont-form @if ($errors->has('name')) has-error @endif">
                                        <input id="name" name="name" class="form-control clear-txt" placeholder="Your Name"   value="{{old('name',$user_data['name'])}}" />
                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group cont-form @if ($errors->has('email')) has-error @endif">
                                        <input type="email" id="email" class="form-control clear-txt" name="email" placeholder="Your Email" value="{{old('email',$user_data['email'])}}" />
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group cont-form @if ($errors->has('phone')) has-error @endif">
                                        <input type="tel" class="form-control clear-txt" id="phone" placeholder="Your Mobile" name="phone" value="{{old('phone')}}" />
                                        @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if(count($contact_categories) > 0)
                                    <div class="form-group cont-form @if ($errors->has('category')) has-error @endif">
                                        <select name="category" class="form-control">
                                            <option value="">Select Enquiry Type</option>
                                            @foreach($contact_categories as $category)
                                            <option @if(old('category')==$category->id) selected="selected" @endif value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('category'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('category') }}</strong>
                                        </span>
                                        @endif

                                    </div>

                                    @endif
                                </div>     
                                <div class="col-md-12">
                                    <div class="form-group cont-form @if ($errors->has('subject')) has-error @endif">
                                        <input type="text" class="form-control clear-txt" id="subject" name="subject" value="{{old('subject')}}" placeholder="Subject "/>
                                        @if ($errors->has('subject'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('subject') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">


                                    <div class="form-group @if ($errors->has('message')) has-error @endif">
                                        <textarea  class="form-control clear-txt" id="message" name="message" placeholder="Message">{{old('message')}}</textarea>
                                        @if ($errors->has('message'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('message') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-send cont-form-btn ">Send</button>
                                        <button id="clearAll" onclick="resetform()" type="button" class="btn btn-send cont-form-btn">Clear</button>
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

<section class="contact-map">
    <div class="map">
        <!--<iframe src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu-916DdpKAjTmJNIgngS6HL_kDIKU0aU&callback=myMap" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>-->

        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d121059.0344739699!2d72.857452!3d19.180874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1496743732962" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
</section>

@endsection