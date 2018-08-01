<?php
$segments = Request::segment(2);
$segment_prameter = '';
$segment_value = '';
switch ($segments) {
    case 'manage-roles':
        $segment_prameter = 'role';
        $segment_value = 'global';
        break;

    case 'update-role':
        $segment_prameter = 'role';
        $segment_value = 'global';
        break;

    case 'roles':
        $segment_prameter = 'role';
        $segment_value = 'global';
        break;

    case 'global-settings':
        $segment_prameter = 'globalsetting';
        $segment_value = 'global';
        break;

    case 'update-global-setting':
        $segment_prameter = 'globalsetting';
        $segment_value = 'global';
        break;

    case 'countries':
        $segment_prameter = 'countries';
        $segment_value = 'global';
        break;

    case 'countries':
        $segment_prameter = 'countries';
        $segment_value = 'global';
        break;

    case 'states':
        $segment_prameter = 'states';
        $segment_value = 'global';
        break;

    case 'cities':
        $segment_prameter = 'cities';
        $segment_value = 'global';
        break;

    case 'admin-users':
        $segment_prameter = 'admin-users';
        $segment_value = 'user';
        break;

    case 'create-registered-user':
        $segment_prameter = 'register-user';
        $segment_value = 'user';
        break;

    case 'create-user':
        $segment_prameter = 'admin-users';
        $segment_value = 'user';
        break;

    case 'update-admin-user':
        $segment_prameter = 'admin-users';
        $segment_value = 'user';
        break;

    case 'update-registered-user':
        $segment_prameter = 'register-user';
        $segment_value = 'user';
        break;

    case 'create-user':
        $segment_prameter = 'admin-user';
        $segment_value = 'user';
        break;
    
    case 'update-admin-user':
        $segment_prameter = 'admin-user';
        $segment_value = 'user';
        break;

    case 'manage-users':
        $segment_prameter = 'register-user';
        $segment_value = 'user';
        break;
    
    case 'update-registered-user':
        $segment_prameter = 'register-user';
        $segment_value = 'user';
        break;
    
    case 'create-registered-user':
        $segment_prameter = 'register-user';
        $segment_value = 'user';
        break;

    case 'content-pages':
        $segment_prameter = 'content-pages';
        $segment_value = 'cms';
        break;

    case 'email-templates':
        $segment_prameter = 'email-template';
        $segment_value = 'email';
        break;

    case 'categories-list':
        $segment_prameter = 'category';
        $segment_value = 'category';
        break;

    case 'products-list':
        $segment_prameter = 'product';
        $segment_value = 'product';
        break;
    
    case 'style-list':
        $segment_prameter = 'styles';
        $segment_value = 'styles';
        break;

    case 'occasion-list':
        $segment_prameter = 'occasion';
        $segment_value = 'occasion';
        break;
    
    case 'collection-style-list':
        $segment_prameter = 'collection_styles';
        $segment_value = 'collection_styles';
        break;
    
    
    case 'attributes-list':
        $segment_prameter = 'attribute';
        $segment_value = 'attribute';
        break;
    
    case 'gallery':
        $segment_prameter = 'gallery';
        $segment_value = 'gallery';
        break;
    
    case 'coupon':
        $segment_prameter = 'coupon';
        $segment_value = 'coupon';
        break;
    case 'attribute':
        $segment_prameter = 'attribute';
        $segment_value = 'attribute';
        break;
    
    case 'inventory':
        $segment_prameter = 'inventory';
        $segment_value = 'inventory';
        break;
    case 'orders':
        $segment_prameter = 'orders';
        $segment_value = 'orders';
        break;
    
    case 'category':
        $segment_prameter = 'category';
        $segment_value = 'category';
        break;
    
    
    case 'contact-request-categories':
        $segment_prameter = 'contact-request-categories';
        $segment_value = 'contact';
        break;

    case 'contact-request-category':
        $segment_prameter = 'contact-request-categories';
        $segment_value = 'contact';
        break;


    case 'contact-requests':
        $segment_prameter = 'contact';
        $segment_value = 'contact';
        break;
    
//    case 'gallery':
//        $segment_prameter = 'gallery';
//        $segment_value = 'gallery';
//        break;

    case 'faq-categories':
        $segment_value = 'faq';
        $segment_prameter = 'faq-categories';
        break;
    case 'faq-category':
        $segment_value = 'faq';
        $segment_prameter = 'faq-categories';
        break;

    case 'faqs':
        $segment_prameter = 'faq';
        $segment_value = 'faq';
        $segment_prameter = 'faqs';
        break;

    case 'faq':
        $segment_value = 'faq';
        $segment_prameter = 'faqs';
        break;

    case 'blog-categories':
        $segment_prameter = 'blog-category';
        $segment_value = 'blog';
        $segment_prameter = 'blog-categories';
        break;

    case 'blog-category':
        $segment_value = 'blog';
        $segment_prameter = 'blog-categories';
        break;

    case 'blog':
        $segment_prameter = 'blog';
        $segment_value = 'blog';
        break;


    case 'blog-post':
        $segment_prameter = 'blog';
        $segment_value = 'blog';
        break;
    
    
     case 'story-categories':
        $segment_prameter = 'story-category';
        $segment_value = 'story';
        $segment_prameter = 'story-categories';
        break;

    case 'story-category':
        $segment_value = 'story';
        $segment_prameter = 'story-categories';
        break;

    case 'story':
        $segment_prameter = 'story';
        $segment_value = 'story';
        break;


    case 'story-post':
        $segment_prameter = 'story';
        $segment_value = 'story';
        break;

    
    case 'manage-appointments':
        $segment_prameter = 'manage-appointments';
        $segment_value = 'manage-appointments';
        break;

    case 'testimonials':
        $segment_value = 'testimonial';
        break;

    case 'newsletters':
        $segment_value = 'newsletters';
        break;

    case 'gift-wrap':
        $segment_value = 'gift-wrap';
        break;


    case 'artist':
        $segment_value = 'artist';
        break;
}

?>
<div class="page-sidebar-wrapper">

    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="start active ">
                <a href="{{url("admin/dashboard")}}">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>

            <li  class="@if($segment_value=='global') open @endif">
                <a href="javascript:void(0);">
                    <i class="glyphicon glyphicon-cog"></i>
                    <span class="title">Manage Global Values</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" @if($segment_value=='global') style='display:block' @endif>
                    @if(Auth::user()->hasPermission('view.roles')==true || Auth::user()->isSuperadmin())
                    <li class="@if($segment_prameter=='role') active @endif"> 
                        <a href="{{url('admin/manage-roles')}}">
                            <i class="glyphicon glyphicon-check"></i> Manage Roles {{ Route::getCurrentRoute()->getPrefix()}}
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->hasPermission('view.global-settings')==true || Auth::user()->isSuperadmin())
                    <li class="@if($segment_prameter=='globalsetting') active @endif"> 
                        <a href="{{url('admin/global-settings')}}">
                            <i class="glyphicon glyphicon-cog"></i> Manage Global Settings
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->hasPermission('view.email-templates')==true || Auth::user()->isSuperadmin())
                    <li class="@if($segment_prameter=='countries') active @endif"> 
                        <a href="{{url('admin/countries/list')}}">
                            <i class="glyphicon glyphicon-globe"></i> Manage Countries
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->hasPermission('view.manage-countries')==true || Auth::user()->isSuperadmin())
                    <li class="@if($segment_prameter=='states') active @endif"> 
                        <a href="{{url('admin/states/list')}}">
                            <i class="glyphicon glyphicon-globe"></i> Manage States
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->hasPermission('view.manage-cities')==true || Auth::user()->isSuperadmin())
                    <li class="@if($segment_prameter=='cities') active @endif"> 
                        <a href="{{url('admin/cities/list')}}">
                            <i class="glyphicon glyphicon-globe"></i> Manage Cities
                        </a>
                    </li>
                    @endif

                </ul>
            </li>
            <li  class="@if($segment_value=='user') open @endif">
                <a href="javascript:void(0);">
                    <i class="icon-user"></i>
                    <span class="title">Manage Users</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" @if($segment_value=='user') style='display:block' @endif>
                    @if(Auth::user()->hasPermission('view.admin-users')==true || Auth::user()->isSuperadmin())

                    <li class="@if($segment_prameter=='admin-users') active @endif"> 
                        <a href="{{url('admin/admin-users')}}">
                            <i class="icon-user"></i> Manage Admin Users</a>
                    </li>
                    @endif

                    @if(Auth::user()->hasPermission('view.registered-users')==true || Auth::user()->isSuperadmin())

                    <li class="@if($segment_prameter=='register-user') active @endif"> 
                        <a href="{{url('admin/manage-users')}}">
                            <i class="icon-user"></i> Manage Customer/Business Users</a>
                    </li>
                    @endif

                </ul>
            </li>
            @if(Auth::user()->hasPermission('view.content-pages')==true || Auth::user()->isSuperadmin())

            <li class="@if($segment_prameter=='content-pages') active @endif"> 
                <a href="{{url("admin/content-pages/list")}}">
                    <i class="icon-list"></i>
                    <span class="title">Manage CMS Pages</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->hasPermission('view.email-templates')==true || Auth::user()->isSuperadmin())

            <li class="@if($segment_prameter=='email-template') active @endif"> 
                <a href="{{url("admin/email-templates/list")}}">
                    <i class="icon-list"></i>
                    <span class="title">Manage Email template</span>
                </a>
            </li>
            @endif
            
            @if(Auth::user()->hasPermission('view.attributes')==true || Auth::user()->isSuperadmin())

            <li class="@if($segment_prameter=='attribute') active @endif">
                <a href="{{url("admin/attributes-list")}}">
                    <i class="icon-list"></i>
                    <span class="title">Manage Attributes</span>
                </a>
            </li>
            @endif
            
            
            
            
            
            @if(Auth::user()->hasPermission('view.categories')==true || Auth::user()->isSuperadmin())

            <li class="@if($segment_prameter=='category') active @endif"> 
                <a href="{{url("admin/categories-list")}}">
                    <i class="icon-list"></i>
                    <span class="title">Manage Categories</span>
                </a>
            </li>
            @endif


                        @if(Auth::user()->hasPermission('view.products')==true || Auth::user()->isSuperadmin())
            
                        <li class="@if($segment_prameter=='products-list') active @endif"> 
                        <li>
                            <a href="{{url("admin/products-list/?stock=&category=")}}">
                                <i class="icon-list"></i>
                                <span class="title">Manage Products</span>
                            </a>
                        </li>
                        @endif

                        @if(Auth::user()->hasPermission('view.styles')==true || Auth::user()->isSuperadmin())
            
                        <li class="@if($segment_prameter=='style-list') active @endif"> 
                        <li>
                            <a href="{{url("/admin/product-styles")}}">
                                <i class="icon-list"></i>
                                <span class="title">Manage Styles</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasPermission('view.collection_styles')==true || Auth::user()->isSuperadmin())
            
                        <li class="@if($segment_prameter=='collection-style-list') active @endif"> 
                        <li>
                            <a href="{{url("/admin/product-collection-styles")}}">
                                <i class="icon-list"></i>
                                <span class="title">Manage Collection Styles</span>
                            </a>
                        </li>
                        @endif

            @if(Auth::user()->hasPermission('view.gallery')==true || Auth::user()->isSuperadmin())
                <li>
                    <a href="javascript:void(0);">
                        <i class="icon-list"></i>
                        <span class="title">Manage Gallery</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu" @if($segment_value=='gallery') style='display:block' @endif>
                        @if(Auth::user()->hasPermission('view.gallery')==true || Auth::user()->isSuperadmin())

                            <li class="@if($segment_prameter=='gallery') active @endif">

                                <a href="{{url("/admin/gallery-list")}}">Manage Gallery</a>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermission('view.gallery')==true || Auth::user()->isSuperadmin())

                            <li class="@if($segment_prameter=='gallery') active @endif">

                                <a href="{{url("/admin/rivaah-galleries-list")}}">Manage Rivaah Gallery</a>
                            </li>
                        @endif
                    </ul>
                </li>

            @endif
            @if(Auth::user()->hasPermission('view.coupon')==true || Auth::user()->isSuperadmin())
                <li>
                    <a href="javascript:void(0);">
                        <i class="icon-list"></i>
                        <span class="title">Manage Gift</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu" @if($segment_value=='coupon') style='display:block' @endif>
                        @if(Auth::user()->hasPermission('view.coupon')==true || Auth::user()->isSuperadmin())

                            <li class="@if($segment_prameter=='coupon') active @endif">

                                <a href="{{url("/admin/box-list")}}">Manage Box</a>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermission('view.coupon')==true || Auth::user()->isSuperadmin())

                            <li class="@if($segment_prameter=='coupon') active @endif">

                                <a href="{{url("/admin/paper-list")}}">Manage Paper</a>
                            </li>
                        @endif
                            @if(Auth::user()->hasPermission('view.coupon')==true || Auth::user()->isSuperadmin())

                                <li class="@if($segment_prameter=='coupon') active @endif">

                                    <a href="{{url("/admin/display-list")}}">Manage Display</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasPermission('view.coupon')==true || Auth::user()->isSuperadmin())

                                <li class="@if($segment_prameter=='coupon') active @endif">

                                    <a href="{{url("/admin/gift-card-list")}}">Manage Gift Cards</a>
                                </li>
                            @endif
                    </ul>
                </li>

            @endif
                         @if(Auth::user()->hasPermission('view.coupon')==true || Auth::user()->isSuperadmin())
            
                        <li class="@if($segment_prameter=='coupon') active @endif"> 
                        <li>
                            <a href="{{url("/admin/coupons-list")}}">
                                <i class="icon-list"></i>
                                <span class="title">Manage Coupons/Promos</span>
                            </a>
                        </li>
                        @endif

                        @if(Auth::user()->hasPermission('view.occasion')==true || Auth::user()->isSuperadmin())
            
                        <li class="@if($segment_prameter=='occasion-list') active @endif"> 
                        <li>
                            <a href="{{url("/admin/product-occasion")}}">
                                <i class="icon-list"></i>
                                <span class="title">Manage Occasion</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasPermission('view.inventory')==true || Auth::user()->isSuperadmin())

            <li class="@if($segment_prameter=='inventory') active @endif"> 
                <a href="{{url("/admin/inventory-list")}}">
                    <i class="icon-list"></i>
                    <span class="title">Manage Inventory</span>
                </a>
            </li>
            @endif
            
            @if(Auth::user()->hasPermission('view.orders')==true || Auth::user()->isSuperadmin())

            <li class="@if($segment_prameter=='orders') active @endif"> 
                <a href="{{url("/admin/orders")}}/0">
                    <i class="icon-list"></i>
                    <span class="title">Manage Orders</span>
                </a>
            </li>
            @endif
            
            
            @if(Auth::user()->hasPermission('view.newsletter')==true || Auth::user()->isSuperadmin())

            <li class="@if($segment_prameter=='newsletter') active @endif"> 
                <a href="{{url("/admin/newsletters")}}">
                    <i class="icon-list"></i>
                    <span class="title">Manage Newsletters</span>
                </a>
            </li>
            @endif
            

            @if(Auth::user()->hasPermission('view.manage-artist')==true || Auth::user()->isSuperadmin())

            <li class="@if($segment_prameter=='manage-artist') active @endif"> 
                <a href="{{url('/admin/manage-artist')}}">
                    <i class="icon-list"></i>
                    <span class="title">Manage Artist</span>
                </a>
            </li>
            @endif

                        
            @if(Auth::user()->hasPermission('view.contact-requests')==true || Auth::user()->isSuperadmin())
            <li>
                <a href="javascript:void(0);">
                    <i class="icon-envelope"></i>
                    <span class="title">Manage Contact Us</span>
                    <span class="arrow"></span>
                </a>

                <ul class="sub-menu" @if($segment_value=='contact') style='display:block' @endif>
                    @if(Auth::user()->hasPermission('view.contact-requests')==true || Auth::user()->isSuperadmin())

                    <li class="@if($segment_prameter=='contact-request-categories') active @endif"> 

                        <a href="{{url("admin/contact-request-categories")}}">Manage Contact Categories</a>
                    </li>
                    @endif

                    @if(Auth::user()->hasPermission('view.contact-requests')==true || Auth::user()->isSuperadmin())

                    <li class="@if($segment_prameter=='contact-requests') active @endif"> 

                        <a href="{{url("admin/contact-requests")}}">Manage Contact Requests</a>
                    </li>
                    @endif
                </ul>
            </li>

            @endif

            
            @if(Auth::user()->hasPermission('view.faqs')==true || Auth::user()->isSuperadmin())
                                <li class="@if($segment_prameter=='faqs') active @endif"> 

            <!--<li>-->
                <a href="{{url("admin/faqs")}}">
                    <i class="icon-question"></i>
                    <span class="title">Manage FAQ's</span>
                    <!--<span class="arrow"></span>-->
                </a>
                <!--<ul class="sub-menu" @if($segment_value=='faq') style='display:block' @endif>-->
<!--                    @if(Auth::user()->hasPermission('view.faq-categories')==true || Auth::user()->isSuperadmin())

                    <li class="@if($segment_prameter=='faq-categories') active @endif"> 

                        <a href="{{url("admin/faq-categories")}}">Manage FAQ Categories</a>
                    </li>
                    @endif-->

<!--                    @if(Auth::user()->hasPermission('view.faqs')==true || Auth::user()->isSuperadmin())

                    <li class="@if($segment_prameter=='faqs') active @endif"> -->

<!--                        <a href="{{url("admin/faqs")}}">Manage FAQ's</a>-->
                    </li>
                    <!--@endif-->

<!--                </ul>
            </li>-->

            @endif

            @if(Auth::user()->hasPermission('view.blog')==true || Auth::user()->isSuperadmin())
            <li>
                <a href="javascript:void(0);" >
                    <i class="icon-list"></i>
                    <span class="title">Manage Blogs</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" @if($segment_value=='blog') style='display:block' @endif>
                    @if(Auth::user()->hasPermission('view.blog-categories')==true || Auth::user()->isSuperadmin())

                    <li class="@if($segment_prameter=='blog-categories') active @endif">
                        <a href="{{url("/admin/blog-categories")}}">Manage Blog Categories</a>
                    </li>
                    @endif

                    @if(Auth::user()->hasPermission('view.blog')==true || Auth::user()->isSuperadmin())

                    <li class="@if($segment_prameter=='blog') active @endif">

                        <a href="{{url("admin/blog")}}">Manage Blog Posts</a>
                    </li>
                    @endif

                </ul>
            </li>
            @endif
            
            
             @if(Auth::user()->hasPermission('view.story')==true || Auth::user()->isSuperadmin())
            <li class="@if($segment_prameter=='story') active @endif"> 
                <a href="{{url("/admin/story")}}">
                    <i class="icon-list"></i>
                    <span class="title">Manage User Stories</span>
                </a>
            </li>
            @endif
            
             {{--@if(Auth::user()->hasPermission('view.appointments')==true || Auth::user()->isSuperadmin())--}}
            {{--<li class="@if($segment_prameter=='manage-appointments') active @endif"> --}}
                {{--<a href="{{url("/admin/manage-appointments")}}">--}}
                    {{--<i class="icon-list"></i>--}}
                    {{--<span class="title">Manage Appointments</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
            @if(Auth::user()->hasPermission('view.appointments')==true || Auth::user()->isSuperadmin())
                <li>
                    <a href="javascript:void(0);">
                        <i class="icon-envelope"></i>
                        <span class="title">Manage Appointments</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu" @if($segment_value=='manage-appointments') style='display:block' @endif>
                        @if(Auth::user()->hasPermission('view.appointments')==true || Auth::user()->isSuperadmin())

                            <li class="@if($segment_prameter=='manage-appointments') active @endif">

                                <a href="{{url("/admin/manage-appointments")}}">Manage Appointments</a>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermission('view.appointments')==true || Auth::user()->isSuperadmin())

                            <li class="@if($segment_prameter=='manage-appointments') active @endif">

                                <a href="{{url("admin/manage-artist-appointments")}}">Manage Artist Appointments</a>
                            </li>
                        @endif
                    </ul>
                </li>

        @endif
            
            
            
<!--            @if(Auth::user()->hasPermission('view.testimonials')==true || Auth::user()->isSuperadmin())

            <li class="start">
                <a href="{{url("admin/testimonials/list")}}">
                    <i class="icon-list"></i>
                    <span class="title">Manage Testimonials</span>
                </a>
            </li>

            @endif-->
            <!--                                  @if(Auth::user()->hasPermission('view.testimonials')==true || Auth::user()->isSuperadmin())
                                                           
                                            <li class="start">
                                                    <a href="{{url("admin/testimonials/list")}}">
                                                      <i class="icon-list"></i>
                                                     <span class="title">Manage Testimonials</span>
                                                    </a>
                                            </li>
                                            @endif-->

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>