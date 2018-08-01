<!---------------------------------------------------------FOOTER SEC START------------------------------------------------>
<footer class="my_footer">
    <div class="container">
        <div class="custom_footer">
            <ul class="clearfix">
                <li>
                    <div class="footer_holder">
                        <h3 class="footer_heading">DOWNLOAD THE APP</h3>
                        <div class="footer_containt">
                            <div class="app_download_holder clearfix">
                                <div class="app_img"><img src="{{url("public/media/front/img/36.png")}}" alt="google_app"></div>
                                <div class="barcode_img"><img src="{{url("public/media/front/img/38.png")}}" alt="google_app"></div>
                            </div>
                            <div class="app_download_holder clearfix">
                                <div class="app_img"><img src="{{url("public/media/front/img/37.png")}}" alt="google_app"></div>
                                <div class="barcode_img"><img src="{{url("public/media/front/img/38.png")}}" alt="google_app"></div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="footer_holder">
                        <h3 class="footer_heading">USEFUL LINKS</h3>
                        <div class="footer_containt">
                            <ul class="footer-first">
                                <li><a href="{{ url('/contact-us') }}">Contact us</a></li>
                                <li><a href="{{url('/faqs')}}">FAQ</a></li>
                                <li><a href="{{url('/blog')}}">Blog</a></li>

                                            
                                <li><a href="javascript:void(0);" class="bulk_purchase">Track Order</a></li>
                                <li><a href="javascript:void(0);" class="bulk_purchase">Bulk Purchase</a></li>

                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="footer_holder">
                        <h3 class="footer_heading">Information</h3>
                        <div class="footer_containt">
                            <ul class="footer-first">
                                <?php
                                $all_pages = App\PiplModules\contentpage\Models\ContentPage::translatedIn(\App::getLocale())->get();
                                if (count($all_pages) > 0 && isset($all_pages)) {
                                    foreach ($all_pages as $pages) {
                                        if ($pages->page_status == 1) {
                                            ?>
                                            <li><a  href="{{url("/".$pages->page_alias)}}"><?php echo $pages->page_title; ?></a></li>
                                            <?php
                                        }
                                    }
                                }
                                ?>

                            </ul>

                        </div>
                    </div>
                </li>
                <li>
                    <div class="footer_holder">
                        <h3 class="footer_heading">Registered Office</h3>
                        <div class="footer_containt">
                            <p><span class="paras-identity">Chawla’s International</span> Unit No 20/21 , Eastern Plaza, Daftary Road , Malad (East), Mumbai – 400097.  MH, India</p>
                            <p>Email – <a href="mailto:info@chawlasinternational.com">Info@chawlasinternational.com</a><a href="mailto:support@parasfashions.com">support@parasfashions.com </a></p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="footer_holder">
                        <h3 class="footer_heading">STORE LOCATER</h3>
                        <div class="footer_containt">
                            <div class="footer_map">
                                <img src="{{url("public/media/front/img/39.jpg")}}" alt="map"/>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="newsletter_block">
            <div class="newsletter clearfix">
                <div class="join_newsletter pull-left">
                    <h4>Join Our Newsletter</h4>
                    <p>
                        Stay Connected to Get Exclusive Offers & Updates...
                    </p>
                </div>
                <div class="newsletter_email pull-right">
                    <input style="color: white" id="subscriber-email" name="subscriber_email" type="email" class="form-control" placeholder="email@example.com"/>
                    <span class="submit_button"><a onclick="subscribeNews()"><i class="fa fa-paper-plane-o"></i></a></span>
                    <span style="color: orange;font-size: 12px" id="sub-email-msg"></span>
                </div>
            </div>
            <div class="currancy_tab">
                <div class="input-group-btn dropup">
                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       @if(Session::has('universal_currency'))
                        @if(Session::get('universal_currency')=="INR")
                        <img src="{{url('/')}}/public/media/front/img/india.png"> INR 
                        @elseif(Session::get('universal_currency')=="CAD")
                        <img src="{{url('/')}}/public/media/front/img/cad.jpg">CAD
                        @elseif(Session::get('universal_currency')=="USD")
                        <img src="{{url('/')}}/public/media/front/img/usd.jpg">USD
                        @elseif(Session::get('universal_currency')=="EUR")
                        <img src="{{url('/')}}/public/media/front/flags/european_union.gif">Euro
                        @elseif(Session::get('universal_currency')=="GBP")
                        <img src="{{url('/')}}/public/media/front/flags/united_kingdom.gif">GBP
                        @endif
                    @endif 
                    <span class="icon"><i class="fa fa-angle-up"></i></span>
                    </button>
                    <ul class="dropdown-menu mCustomScrollbar">
                        <li><a href="{{ url('/change-global-currency').'/'.'INR' }}"><img src="{{url('/')}}/public/media/front/img/india.png"> INR</a></li>
                        <li><a href="{{ url('/change-global-currency').'/'.'CAD' }}"><img src="{{url('/')}}/public/media/front/img/cad.jpg"> CAD</a></li>
                        <li><a href="{{ url('/change-global-currency').'/'.'USD' }}"><img src="{{url('/')}}/public/media/front/img/usd.jpg"> USD</a></li>
                        <li><a href="{{ url('/change-global-currency').'/'.'EUR' }}"><img src="{{url('/')}}/public/media/front/flags/european_union.gif"> Euro</a></li>
                        <li><a href="{{ url('/change-global-currency').'/'.'GBP' }}"><img src="{{url('/')}}/public/media/front/flags/united_kingdom.gif"> GBP</a></li>
                    </ul>
                </div><!-- /btn-group -->
            </div>
        </div>
    </div>
    <div class="bottom_footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="copyright">&copy; 2018 Parasfashions | All rights reserved</div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <ul class="client_logo clearfix text-right">
                        <li><a href="javascript:void(0);"><img src="{{url('/')}}/public/media/front/img/dhl_logo.png" alt="logo"/></a></li>
                        <li><a href="javascript:void(0);"><img src="{{url('/')}}/public/media/front/img/fedex.png" alt="logo" /></a></li>
                        <li><a href="javascript:void(0);"><img src="{{url('/')}}/public/media/front/img/quick-heal.png" alt="logo"/></a></li>
                        <li><a href="javascript:void(0);"><img src="{{url('/')}}/public/media/front/img/Layer-68.png" alt="logo"/></a></li>
                        <li><a href="javascript:void(0);"><img src="{{url('/')}}/public/media/front/img/master_card.png" alt="logo" /></a></li>
                        <li><a href="javascript:void(0);"><img src="{{url('/')}}/public/media/front/img/ssl.png" alt="logo" width="30px;"/></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    function subscribeNews() {
//        alert(123);
//        return;
       var  subEmail = $('#subscriber-email').val();
//       alert(subEmail);
        if(subEmail != ''){
            $.ajax({
                url: '{{  url('/newsletter/subscribe') }}',
                type: "post",
                dataType: 'json',
                data: {
                    email: subEmail,
                    _token:"{{ csrf_token() }}"
                },
                success: function (response) {
                   // console.log(response);return;
                    if (response.success == "1") {
                        $('#sub-email-msg').text(response.msg);
                        //  console.log(123);
                        //  console.log(response.success);
                        // console(response.success);return;
                        //$('#added-in-cart').show();
                        //  $('
                    }
                    else {
                        if(response.msg == "The email has already been taken.")
                        {
                            $('#sub-email-msg').text("You have already subscribed to our newsletter");
                        }
                        else{
                            $('#sub-email-msg').text(response.msg);
                        }

                    }

                }
            });
        }
        else{
            $('#sub-email-msg').text("Please enter your email id");
        }
    }
</script>