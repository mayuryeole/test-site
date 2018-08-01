@php
   $totalAmount=0;
    if (Auth::check()) {

           $cart = \Auth::user()->cart;
       }
       else
       {
           $cart=  \App\PiplModules\cart\Models\Cart::where('ip_address',\Request::ip())->first();
       }
     if (isset($cart) && count($cart)>0) {
            foreach ($cart->cartItems as $items) {
                $totalAmount +=$items->product_quantity;
          }
        }
@endphp
<header>
    <div class="custom-header clearfix">
        <nav>
            <div class="hamberger"><span class="line"></span></div>
            <div class="meu-fixx">
                <section class="blok">
                    <div class="blok-body">
                        <div class="row">
                            <!-- Nav tabs -->
                            @php
                            $all_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', '0')->get();
                            $sub = array();
                            
                            $cntCat = 0;
                            $cntSub = 0;
                            @endphp



                            <!--  Start category -->
                            <ul class="nav fullHt tab-menu nav-pills col-sm-3 nav-stacked pr15">
                                @foreach ($all_category as $key=>$value)

                                @php
                                $cntCat++;
                                $sub[] = $value->id;  
                                @endphp
                                    @if($cntCat == 1)
                                        <li class="active"  data-toggle="tab"><a href="#{{$value->id }}" onclick='goHere("{{ $value->id }}")'><span>{{$value->name}}</span> <img src="public/media/front/img/menu1.jpg" alt="bg-images"/></a>
                                        </li>
                                    @else
                                        <li data-toggle="tab"><a href="#{{ $value->id }}" onclick='goHere("{{ $value->id }}")' ><span>{{$value->name}}</span> <img src="public/media/front/img/menu1.jpg" alt="bg-images"/></a>
                                        </li>
                                    @endif
                                {{--@if($cntCat == 1)   --}}
                                {{--<li class="active"  data-toggle="tab">--}}
                                    {{--<a href="{{ url('/') }}/search-product?category={{ $value->category_id }}"><span>{{$value->name}}</span> <img src="{{ url('public/media/front/img/menu1.jpg') }}" alt="bg-images"/></a>--}}
                                {{--</li>--}}
                                {{--@else--}}
                                {{--<li data-toggle="tab"><a href="{{ url('/') }}/search-product?category={{ $value->category_id }}" ><span>{{$value->name}}</span> <img src="{{ url('public/media/front/img/menu1.jpg') }}" alt="bg-images"/></a>--}}
                                {{--</li>--}}
                                {{--@endif--}}
                                @endforeach  
                            </ul>
                            <!-- Tab panes -->
                            <!--  Start  SUB category -->
                            <div class="tab-content col-sm-9">
                                @foreach($sub as $s)
                                @php
                                $cntSub++;
                                @endphp

                                @if($cntSub == 1)
                                <div class="tab-pane well active in active" id="{{ $s }}" style="background-image:url(public/media/front/img/ss-div.jpg);">
                                    <div class="iter-tab-vi fullHt" >
                                        @php 
                                        $all_sub_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', $s)->get(); @endphp


                                        <ul class="custome-iner-nav">
                                            @foreach($all_sub_category as $value1)
                                            <li><a href="{{ url('/') }}/search-product?category={{ $value1->category_id }}">{{$value1->name}}</a>
                                                <div class="inner_sub_menu">
                                                    <div class="row">
                                                        
                                                        <div class="col-md-4">
                                                            <ul>
                                                                @php
                                                                $all_child_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', $value1->id)->get();
                                                                @endphp   
                                                                @foreach($all_child_category as $child)
                                                                <li>
                                                                    <a href="{{ url('/') }}/search-product?category={{ $child->category_id }}">
                                                                        {{  $child->name }}

                                                                    </a>
                                                                </li>     
                                                                @endforeach

                                                            </ul>
                                                        </div>



                                                    </div>
                                                </div>                        	
                                            </li>
                                            @endforeach
                                        </ul>


                                    </div>
                                </div>
                                @else

                                <div class="tab-pane fullHt well fade" id="{{ $s }}" style="background-image:url(public/media/front/img/ss-div.jpg);">
                                    <div class="iter-tab-vi fullHt" >
                                        @php $all_sub_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', $s)->get(); @endphp

                                        <ul class="custome-iner-nav">
                                            @foreach ($all_sub_category as $value1)
                                            <li><a href="{{ url('/') }}/search-product?category={{ $value1->category_id }}">{{$value1->name}}</a>
                                                <div class="inner_sub_menu">
                                                    <div class="row">

                                                        <div class="col-md-4">
                                                            <ul>
                                                                @php
                                                                $all_child_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', $value1->id)->get();
                                                                @endphp   
                                                                @foreach($all_child_category as $child)
                                                                <li>
                                                                    <a href="{{ url('/') }}/search-product?category={{ $child->category_id }}">
                                                                        {{  $child->name }}

                                                                    </a>
                                                                </li>     
                                                                @endforeach

                                                            </ul>
                                                        </div>



                                                    </div>
                                                </div>                        	
                                            </li>
                                            @endforeach
                                        </ul>


                                    </div>
                                </div>
                                @endif


                                @endforeach 
                            </div><!--  END SUb category -->

                        </div><!--  END  category --><!-- //row -->
                    </div><!-- blok-body // -->
                </section>
            </div>
            <form method="get" action="{{ url('search-product') }}" id="frm_front_search">
            <div class="search_bar relative">
                <input type="text" class="form-control" placeholder="Search..." name="name" title="Search By Product Name or leave blank to view all Products"/>
                <span><a href="javascript:void(0)" class="search_btn" onclick="returnSubmit()">
                <i class="fa fa-search"></i></a></span>
                <input type="submit" style="display:none;">
            </div>
            </form>
            <script>
                function  returnSubmit()
                {
                    $("#frm_front_search").submit();
                }
            </script>            
            <div class="logo"><a href="{{ url('/')}}"><img src="{{ url('/') }}/public/media/front/img/logo.png" alt="logo here"/></a></div>

            {{--<div class="right_nav pull-right">--}}
                {{--<ul>--}}
                    {{--<li><a href="{{url('/wishlist')}}">Wishlist</a></li>--}}
                    {{--<li><a href="javascript:void(0);">Request Appointment</a></li>--}}
                    {{--<li><a href="{{ url('/cart') }}"><img src="{{ url('/') }}/public/media/front/images/cart-icon.png" width="18"> <span class="icon-cart-num" id="cart_count">{{ $totalAmount }}</span></a></li>--}}
                    {{--<!--Authentication Links--> --}}
                    {{--@if (Auth::guest())--}}
                    {{--<li><a href="{{ url('/login') }}">Sign In</a></li>--}}
                    {{--@else--}}
                    {{--<li class="dropdown">--}}
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                            {{--Hello &nbsp;  {{ Auth::User()->UserInformation->first_name }} <span class="caret"></span>--}}
                        {{--</a>--}}

                        {{--<ul style="background-color: black;color: white"  class="dropdown-menu" role="menu">--}}
                            {{--<li ><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>My Profile</a></li>--}}
                            {{--<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--@endif--}}
                {{--</ul>--}}
            {{--</div>--}}
            <div class="right_nav pull-right">
                <ul>
                <!--<li><a href="{{url('/wishlist')}}">Wishlist</a></li>-->
                    <li><a href="javascript:void(0);">Request Appointment</a></li>
                <!--<li class="h-mg-cart"><a href="{{ url('/cart') }}"><!--<img src="{{ url('/') }}/public/media/front/images/cart-icon.png" width="18">-->
                    <!--<span class="header-cart"><i class="fa fa-shopping-basket"></i></span>
                    <span class="icon-cart-num header-cart-count cart-move" id="cart_count"> 1 </span></a></li>-->
                    <!--Authentication Links-->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Sign In</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Hello &nbsp;  {{ Auth::User()->UserInformation->first_name }} <span class="caret"></span>
                            </a>

                            <ul style="background-color: black;color: white"  class="dropdown-menu" role="menu">
                                <li ><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>My Profile</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <div class="h-mg-cart">
                <a href="{{ url('/cart') }}"><!--<img src="{{ url('/') }}/public/media/front/images/cart-icon.png" width="18">-->
                    <span class="header-cart"><!--<i class="fa fa-shopping-basket"></i>-->
                        <img class="cart_img" src="{{ url('/') }}/public/media/front/img/shopping_bag.png"></span>

                    <span class="icon-cart-num header-cart-count cart-move" id="cart_count">{{ $totalAmount }}</span>
                </a>
            </div>
            <div class="h-mg-wishlist">
                <a href="{{url('/wishlist')}}"><i class="fa fa-heart-o" title="wishlist"></i></a>
            </div>
        </nav>
    </div>
</header>
<script>
    function getActive(id)
    {
//        $("#"+id).show();
    }
</script> 

