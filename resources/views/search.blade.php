@extends('layouts.app')
@section('content')
    <style>
    </style>
    <form method="get" id="frm_search_product">

        <input type="hidden" name="currentPage" id="currentPage" value="{{ $all_products->currentPage() }}">
        <input type="hidden" name="lastPage" id="lastPage" value="{{ $all_products->lastPage() }}">

        <input type="hidden" name="totalPage" id="totalPage" value="{{ $all_products->total() }}">

        <input type="hidden" name="min" id="min" value=<?php  echo isset($_GET["min"]) ? $_GET["min"] : 0; ?>>
        <input type="hidden" name="max" id="max" value=<?php  echo isset($_GET["max"]) ? $_GET["max"] : 5000; ?>>
        {!!  csrf_field() !!}
        @php
            if(! \Auth::guest()){

            $userInfo = \App\UserInformation::where('user_id',\Auth::user()->id)->first();
            $cart = \App\PiplModules\cart\Models\Cart::where('customer_id',\Auth::user()->id)->first();
            }
            else{
               $ipaddress = Request::ip();
               $cart = \App\PiplModules\cart\Models\Cart::where('ip_address',$ipaddress)->first();
            }
        @endphp
        <section class="product-listing-blk h-product-listing-blk">
            <div class="container">
                <div class="h-listing-view-holder relative">
                    <div class="new-list-view">
                        <ul class="view-filter text-right">
                            <li>
                                <a href="javascript:void(0);" class="filter-btn"><i class="fa fa-filter"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="h-greed-view"><i class="fa fa-th"></i></a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="h-list-view"><i class="fa fa-th-list"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="listing-option">
                        <div class="row clearfix">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <label class="filter-name">Occasion</label>
                                <input type="hidden" name="range[]" id="range">
                                <div class="custom-multiselect form-group relative">
                                    <select class="occasion" multiple="multiple" name="occasion[]" id="search_occasion"
                                            onchange="loadMoreProductSelectBox('search_occasion')">
                                        @if(isset($all_occasion) && count($all_occasion)>0)
                                            @foreach($all_occasion as $key=>$o)
                                                <option value="{{$o->id}}"
                                                        @if(isset($_GET['occasion']) && in_array($o->id,$_GET['occasion']) == true) selected="selected" @endif >{{$o->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <label class="filter-name">Collection</label>
                                <div class="custom-multiselect form-group relative">
                                    <select class="collectionStyle" multiple="multiple" name="collection_style[]"
                                            id="search_collection_style"
                                            onchange="loadMoreProductSelectBox('search_collection_style')">
                                        @if(isset($all_collection) && count($all_collection)>0)
                                            @foreach($all_collection as $c)
                                                <option value="{{$c->id}}"
                                                        @if(isset($_GET['collection_style']) && in_array($c->id,$_GET['collection_style']) == true) selected="selected" @endif>{{$c->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <label class="filter-name">Style</label>
                                <div class="custom-multiselect form-group relative">
                                    <select class="estyle" multiple="multiple" id="style" name="style[]"
                                            onchange="loadMoreProductSelectBox('search_estyle')">
                                        @if(isset($all_style) && count($all_style)>0)
                                            @foreach($all_style as $s)
                                                <option value="{{$s->id}}"
                                                        @if(isset($_GET['style']) && in_array($s->id,$_GET['style']) == true) selected="selected" @endif >{{$s->name}}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>
                            @if(isset($all_colors) && count($all_colors)>0)
                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <label class="filter-name">Color</label>
                                    <div class="custom-multiselect h-color-scroll form-group relative">
                                        <select class="color" multiple="multiple" id="color" name="color[]"
                                                onchange="loadMoreProductSelectBox('search_color')">
                                            @foreach($all_colors as $color)
                                                <option value="{{$color->name}}"
                                                        @if(isset($_GET['color']) && in_array($color->name,$_GET['color']) == true) selected="selected" @endif>{{$color->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <label class="filter-name">Select Price</label>
                                <div class="h-price-range relative">
                                    <div id="slider-range"></div>
                                    <input type="text" id="amount" readonly
                                           style="border:0; color:#353535; font-size: 12px;">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <label class="filter-name">Categories</label>
                                <div class="h-cust-select">
                                    <select class="form-control" name="category" onchange="loadMoreProductSelectBox(this)">
                                        <option value="">Category</option>
                                        @if(isset($all_category) && count($all_category)>0)
                                            @foreach($all_category as $key=>$val)
                                                <option value="{{$val->category_id}}"
                                                        @if(isset($_GET['category']) && $_GET['category'] == $val->category_id) selected="selected" @endif>{{$val->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{--<!-- <div class="col-md-2 col-sm-6 col-xs-12 text-right h-last-filter">--}}
                                {{--<div class="lsit-grid-view">--}}
                                    {{--<span><a href="javascript:void(0);" class="h-greed-view"><i class="fa fa-th"></i></a></span>--}}
                                    {{--<span><a href="javascript:void(0);" class="h-list-view"><i class="fa fa-th-list"></i></a></span>--}}
                                {{--</div>--}}
                            {{--</div> -->--}}
                        </div>
                    </div>
                </div>
                <div class="product-list-grid">
                    <ul class="product-list row link-sort-list" id="replace_main_upper">
                            @php $cnt=0; @endphp
                        @if(isset($all_products) && count($all_products)>0)
                            @foreach($all_products as $pro)
                                {{--{{ dd($pro) }}--}}

                                    <li id="li-pro-data-{{$pro->id }}" class="col-md-4 col-sm-6 col-xs-12 sort-divs"  data-sort="">
                                        <div class="product-item-wrapper">
                                            <div class="product-item clearfix">
                                                <div class="product-thumbnail">
                                                    <a href="{{ url('product') }}/{{ $pro->id }}">
                                                        <img src="{{ url('/storage/app/public/product/image/') }}/{{ $pro->productDescription['image'] }}" alt="product image"/>
                                                    </a>
                                                    <div class="image-hover">
                                                        <a href="{{ url('product') }}/{{ $pro->id }}">
                                                            @php
                                                              $prodImg = \App\PiplModules\product\Models\ProductImage::where('product_id',$pro->id)->where('color',trim($pro->productDescription['color']))->first();
                                                              $plusCnt =0;
                                                            @endphp
                                                            @if(isset($prodImg) && count($prodImg)>0)
                                                                @if(!empty($prodImg->productColorImages))
                                                                @foreach($prodImg->productColorImages as $imgs)
                                                                    @if(!empty($imgs->image))
                                                                        @if($plusCnt == 0)
                                                                        <img src="{{ url('/storage/app/public/product/product_images/')}}/{{ $imgs->image  }}" alt="image"/>
                                                                        @php $plusCnt++ @endphp
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                                @endif
                                                            @else
                                                            <img src="{{ url('public/media/front/img/wed-logo.png')}}"
                                                                 alt="image"/>
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="discount-show">
                                                        @if(isset($pro->productDescription->discount_valid_from)   && strtotime($pro->productDescription->discount_valid_from) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->productDescription->discount_valid_to) >= strtotime(date('Y-m-d H:i:s')))
                                                            @if(isset($pro->productDescription->discount_type) &&  $pro->productDescription->discount_type =="0")
                                                                {{ $pro->productDescription->discount_price }}
                                                            @elseif(isset($pro->productDescription->discount_type) &&  $pro->productDescription->discount_type =="1")
                                                                -{{ $pro->productDescription->discount_percent }}%
                                                            @else
                                                                0 %
                                                            @endif
                                                        @elseif(isset($pro->transCat->trans[0]['discount_valid_from']) && strtotime($pro->transCat->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($pro->transCat->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                                            @if(isset($pro->transCat->trans[0]['discount_type']) &&  $pro->transCat->trans[0]['discount_type'] =="0")
                                                                {{ $pro->transCat->trans[0]['discount_price'] }}
                                                            @elseif(isset($pro->transCat->trans[0]['discount_type']) &&  $pro->transCat->trans[0]['discount_type'] =="1")
                                                                {{ $pro->transCat->trans[0]['discount_percent'] }}%
                                                            @else
                                                                 0 %
                                                            @endif
                                                        @elseif(isset($pro->transCat) && $pro->transCat->parent_id != 0)
                                                            @php
                                                                $proGrandParentId = $pro->transCat->parent_id;
                                                                $mainParent = \App\PiplModules\category\Models\Category::find($proGrandParentId);
                                                            @endphp
                                                            @if(isset($mainParent) && count($mainParent)>0)
                                                                @if(isset($mainParent->trans[0]['discount_valid_from']) && strtotime($mainParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($mainParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                                                    @if(isset($mainParent->trans[0]['discount_type']) &&  $mainParent->trans[0]['discount_type'] =="0")
                                                                        {{ $mainParent->trans[0]['discount_price'] }}
                                                                    @elseif(isset($mainParent->trans[0]['discount_type']) &&  $mainParent->trans[0]['discount_type'] =="1")
                                                                        -{{ $mainParent->trans[0]['discount_percent'] }}%
                                                                    @else
                                                                         0 %
                                                                    @endif
                                                                @elseif(isset($mainParent) && $mainParent->parent_id != 0)
                                                                    @php
                                                                        $mainGrandParentId = $mainParent->parent_id;
                                                                        $mainGrandParent = \App\PiplModules\category\Models\Category::find($mainGrandParentId);
                                                                    @endphp
                                                                    @if(isset($mainGrandParent) && count($mainGrandParent)>0)
                                                                        @if(isset($mainGrandParent->trans[0]['discount_valid_from']) && strtotime($mainGrandParent->trans[0]['discount_valid_from']) <= strtotime(date('Y-m-d H:i:s')) && strtotime($mainGrandParent->trans[0]['discount_valid_to']) >= strtotime(date('Y-m-d H:i:s')))
                                                                            @if(isset($mainGrandParent->trans[0]['discount_type']) &&  $mainGrandParent->trans[0]['discount_type'] =="0")
                                                                                {{ $mainGrandParent->trans[0]['discount_price'] }}
                                                                            @elseif(isset($mainGrandParent->trans[0]['discount_type']) &&  $mainGrandParent->trans[0]['discount_type'] =="1")
                                                                                {{ $mainGrandParent->trans[0]['discount_percent'] }}%
                                                                            @else
                                                                                 0 %
                                                                            @endif
                                                                        @else
                                                                            0 %
                                                                        @endif
                                                                    @else
                                                                        0 %
                                                                    @endif
                                                                @else
                                                                    0 %
                                                                @endif
                                                            @else
                                                                0 %
                                                            @endif
                                                        @else
                                                             0 %
                                                        @endif
                                                    </div>
                                                    <div class="like-opt"><i class="fa fa-thumbs-up"></i></div>
                                                    <div class="video-opt"><!--<i class="fa fa-vimeo"></i>--><a href="{{ url('/product/show-video').'/'.$pro->id }}"> <img class="video_img" src="{{ url('/') }}/public/media/front/img/video icon.png"></a></div>
                                                    <div class="quick-view">
                                                        <button type="button" class="quick-view-btn" data-toggle="modal"
                                                                onclick="showQuickView('{{ $pro->id }}')"><i
                                                                    class="fa fa-eye"></i></button>
                                                    </div>
                                                </div>
                                                <div style="background-color: transparent;" class="product-info">
                                                    <div class="h-product-info-blk">
                                                        <h3 id="my-h3-{{ $cnt }}" class="product-name-price my-h3-opt clearfix">
                                                            <span class="title"> <a href="{{ url('product').'/'.$pro->id }}">{{$pro->name}}</a></span>
                                                            @if($pro->is_original == 1)
                                                                <div id="dv-prod-price-{{ $pro->id }}" class="prod-with-dis-price prod-price">
                                                                  @if(!empty($pro->discount_rate))  {{ $pro->discount_rate  }} @endif
                                                                </div>
                                                            @elseif($pro->is_original == 0)
                                                                <div id="dv-prod-price-{{ $pro->id }}" class="prod-with-dis-price prod-price">
                                                                    {{ $pro->price }}
                                                                </div>
                                                            @elseif($pro->is_original == 2)
                                                                <div id="dv-prod-price-{{ $pro->id }}" class="prod-price h-interested-link"><a style="cursor:pointer;" onclick="productRateRequest('{{ $pro->id }}')">Request For Rate</a></div>
                                                                <div id="dv-cust-load-{{ $pro->id }}" style="display:none;" class="h-cust-loader">
                                                                    <div class="act-loader">
                                                                        <div id="circularG">
                                                                            <div id="circularG_1" class="circularG"></div>
                                                                            <div id="circularG_2" class="circularG"></div>
                                                                            <div id="circularG_3" class="circularG"></div>
                                                                            <div id="circularG_4" class="circularG"></div>
                                                                            <div id="circularG_5" class="circularG"></div>
                                                                            <div id="circularG_6" class="circularG"></div>
                                                                            <div id="circularG_7" class="circularG"></div>
                                                                            <div id="circularG_8" class="circularG"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            {{--<span class="prod-description"> {{ (strlen($pro->productDescription['description'])>100)?substr($pro->productDescription['description'],0,100)."...":$pro->productDescription['description'] }}</span>--}}
                                                                <div class="prod-description">{{ $pro->productDescription['description'] }}</div>
                                                        </h3>

                                                        

                                                        @if($pro->productDescription['is_featured'] == 1)
                                                            <span class="featured-product">Featured</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @php $cnt++; @endphp
                            @endforeach
                        @elseif(count($all_products)<1)
                            Sorry!! No products found in stock.
                        @endif
                    </ul>
                    <div class="button-div text-center">
                        <button class="load-more" type="button" id="load-more" onclick="loadMoreProduct()">Load More
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <section class="add_to_shoping_bag">
            <div class="shop-img">
                <a href="{{url('/cart')}}">
                    <img src="{{url('public/media/front/img/shop-bag.png')}}"/>
                </a>
            </div>
        </section>
        <section class="h-sorting-option">
            <div class="h-sort-icon"><i class="fa fa-sort-amount-asc"></i></div>
            <div class="h-sortiin-content">
                <div class="h-sort-head">
                    <h6>Sort By :</h6>
                </div>
                <div class="construction-content">
                    <p class="h-cust-radio">
                        <input type="radio" id="new" name="sort_by1"
                               value="-1" @if(isset($_GET['sort_by']) && $_GET['sort_by']=="-1")  {{ "checked" }}  @endif>
                        <label for="new">New</label>
                    </p>
                    {{--<p class="h-cust-radio">--}}
                    {{--<input type="radio" id="top-rated" name="sort_by" value="-1"  @if(isset($_GET['sort_by']) && $_GET['sort_by']=="-1")  {{ "checked" }}  @endif>--}}
                    {{--<label for="popular">Top Rated</label>--}}
                    {{--</p>--}}
                    <p class="h-cust-radio">
                        <input type="radio" id="low-high-1" onclick="sortProductsByOrder('asc')" name="sort_by1"
                               value="asc" >
                        <label for="low-high-1">Price Low to High</label>
                    </p>
                    <p class="h-cust-radio">
                        <input type="radio"  id="high-low-2" onclick="sortProductsByOrder('desc')" name="sort_by1"
                               value="desc" >
                        <label for="high-low-2">Price High to Low</label>
                    </p>
                </div>
            </div>
        </section>


        <!--   Modal View here   -->
        <div class="cust-modal modal fade" id="h-quick-view" data-easein="perspectiveLeftIn" tabindex="-1" role="dialog"
             aria-labelledby="costumModalLabel" aria-hidden="true">

        </div>

        <input type="hidden" id="browser_url" value="{{$browser_url}}">
        <div id="replace_main" style="display: none;">
            <li id="li-pro-data-replace-dv-id" class="col-md-4 col-sm-6 col-xs-12 sort-divs" data-sort="">
                <div class="product-item-wrapper">
                        <div class="product-item clearfix">
                            <div class="product-thumbnail">
                                <a href="{{ url('product') }}/replace-link">
                                    <img src="{{ url('storage/app/public/product/image/') }}/replace-4"
                                         alt="product image"/>
                                </a>
                                <div class="image-hover">
                                    {{--<a href="{{ url('product')}}/replace-mult-link">--}}
                                        {{--@php--}}
                                            {{--$prodImg = \App\PiplModules\product\Models\ProductImage::where('product_id','replace-mult-img')->inRandomOrder()->first();--}}
                                        {{--@endphp--}}
                                        {{--@if(isset($prodImg) && count($prodImg)>0)--}}
                                            {{--@if(!empty($prodImg->images))--}}
                                            {{--<img src="{{ url('/storage/app/public/product/product_images')}}.'/'.{{ $prodImg->images }}"--}}
                                                 {{--alt="image"/>--}}
                                             {{--@else--}}
                                            {{--<img src="{{ url('public/media/front/img/wed-logo.png')}}"--}}
                                                 {{--alt="image"/>--}}
                                            {{--@endif--}}
                                        {{--@else--}}
                                            {{--<img src="{{ url('public/media/front/img/wed-logo.png')}}"--}}
                                                 {{--alt="image"/>--}}
                                        {{--@endif--}}
                                    {{--</a>--}}
                                    <a href="{{ url('product') }}/replace-mult-link">
                                        @php
                                            $prodImg = \App\PiplModules\product\Models\ProductImage::where('product_id','replace-mult-img')->where('color','repl_prod_colr')->first();
                                            $plusCnt =0;
                                        @endphp
                                        @if(isset($prodImg) && count($prodImg)>0)
                                            @if(isset($prodImg->productColorImages) && count($prodImg->productColorImages)>0)
                                                @foreach($prodImg->productColorImages as $imgs)
                                                    @if(!empty($imgs) && $imgs->image!='')
                                                        @if($plusCnt == 0)
                                                            <img src="{{ url('/storage/app/public/product/product_images/')}}/{{ $imgs->image  }}" alt="image"/>
                                                            @php $plusCnt++ @endphp
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        @else
                                            <img src="{{ url('public/media/front/img/wed-logo.png')}}"
                                                 alt="image"/>
                                        @endif
                                    </a>
                                </div>
                                <div class="like-opt"><i class="fa fa-thumbs-up"></i></div>
                                <div class="video-opt"><!--<i class="fa fa-vimeo"></i>--><a href="{{ url('/product/show-video').'/'.'replace-vdo-id' }}"> <img class="video_img" src="{{ url('/') }}/public/media/front/img/video icon.png"></a></div>
                                <div class="quick-view">
                                    <button type="button" class="quick-view-btn" data-toggle="modal"
                                            onclick="showQuickView(replace-5)"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="h-product-info-blk">
                                    <h3 id="my-h3" class="product-name-price  my-h3-opt clearfix">
                                        <span class="title"><a href="{{ url('product').'/'}}replace-name-link">replace-1</a></span>
                                        <div id="replace-prod-price" class="prod-with-dis-price prod-price">
                                           replace-3
                                            <div id="dv-cust-load-replace-rate-req" style="display:none;" class="h-cust-loader">
                                                <div class="act-loader">
                                                    <div id="circularG">
                                                        <div id="circularG_1" class="circularG"></div>
                                                        <div id="circularG_2" class="circularG"></div>
                                                        <div id="circularG_3" class="circularG"></div>
                                                        <div id="circularG_4" class="circularG"></div>
                                                        <div id="circularG_5" class="circularG"></div>
                                                        <div id="circularG_6" class="circularG"></div>
                                                        <div id="circularG_7" class="circularG"></div>
                                                        <div id="circularG_8" class="circularG"></div>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                        <div class="prod-description">replace-2</div>
                                     </h3>
                                    @if('replace-original' == 1)
                                        <span class="featured-product">Featured</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </li>
        </div>
    </form>
    <script>
        function hideLoadMore(lastPage, currentPage) {
            if (lastPage == currentPage || totalPage == 0) {
                $("#load-more").hide();
            }
        }
    </script>
    <script>
        var lastPage = $("#lastPage").val();
        var currentPage = $("#currentPage").val();
        var totalPage = $("#totalPage").val();
        hideLoadMore(lastPage, currentPage, totalPage);
    </script>
    <script>
        function loadMoreProductSelectBox(selectId) {

            form = $("#frm_search_product");
            form.submit();
        }
    </script>
    <script>
        $(function () {
            arr = [];
            arr.push($("#min").val());
            arr.push($("#max").val());
            $("#slider-range").slider({
                range: true,
                min: 0,
                max: 10000,
                values: arr,
                slide: function (event, ui) {
                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                    $("#min").val(ui.values[0]);
                    $("#max").val(ui.values[1]);
                    form = $("#frm_search_product");
                    form.submit();
                }
            });
            $("#amount").val("$" + $("#slider-range").slider("values", 0) +
                " - $" + $("#slider-range").slider("values", 1));
        });
    </script>
    <script>
        function loadMoreProduct() {
            browser_url = $("#browser_url").val();
            currentPage = $("#currentPage").val();
            var ar = browser_url.split('?');
            currentPage = parseInt(currentPage) + 1;
            $("#currentPage").val(currentPage);
            var sample = ar[0] + "?page=" + currentPage + "&" + ar[1];
            $.ajax({
                type: "get",
                url: sample,
                dataType: 'json',
                data: {
                    _token: $("[name=_token]").val()
                },
                success: function (res) {
                    //alert(res);return;
                    //     alert(res.all_products[0]['image']);return;
                    var searchlastPage = $("#lastPage").val();
                    var searchcurrentPage = $("#currentPage").val();
                    var searchtotalPage = $("#totalPage").val();
                    hideLoadMore(lastPage, currentPage, totalPage);
                    $(res.all_products).each(function (index, value) {
                        replace_main = $("#replace_main").html();
                        if (value['is_original'] == 0) {

                            setTimeout(function () {
                                $("#replace_main_upper").append(replace_main.replace("replace-1", value['name']).replace("replace-2", value['long_description']).replace("replace-3",value['price']).replace("replace-4", value['image']).replace('replace-5', value['id']).replace('replace-fes', value['featured']).replace('replace-link', value['id']).replace("replace-cart", value['id']).replace('replace-cart-rel', value['id']).replace('replace-dv-id', value['id']).replace('replace-vdo-id', value['id']).replace('replace-prod-price', 'dv-prod-price-'+value['id']).replace('replace-name-link',value['id']).replace('replace-mult-img',value['id']).replace('replace-mult-link',value['id']).replace('replace-original',value['is_original']).replace('repl_prod_colr',value['pro_color']));
                                addProdDataSortPrice();
                                var sort = $("[name='sort_by1']:checked").val();
                                if(sort !='' && (sort =='asc' || sort =='desc')){
                                    sortProductsByOrder(sort);
                                }
                            }, 1000);
                        } else if(value['is_original'] == 1) {
                            setTimeout(function () {
                                $("#replace_main_upper").append(replace_main.replace("replace-1", value['name']).replace("replace-2", value['long_description']).replace("replace-3", value['discount_rate']).replace("replace-4", value['image']).replace('replace-5', value['id']).replace('replace-fes', value['featured']).replace('replace-link', value['id']).replace("replace-cart", value['id']).replace('replace-cart-rel', value['id']).replace('replace-vdo-id', value['id']).replace('replace-dv-id', value['id']).replace('replace-prod-price', 'dv-prod-price-'+value['id']).replace('replace-name-link',value['id']).replace('replace-mult-img',value['id']).replace('replace-mult-link',value['id']).replace('replace-original',value['is_original']).replace('repl_prod_colr',value['pro_color']));
                                addProdDataSortPrice();
                                var sort = $("[name='sort_by1']:checked").val();
                                if(sort !='' && (sort =='asc' || sort =='desc')){
                                    sortProductsByOrder(sort);
                                }
                                }, 1000);
                        }
                        else{
                            setTimeout(function () {
                                $("#replace_main_upper").append(replace_main.replace("replace-1", value['name']).replace("replace-2", value['long_description']).replace("replace-3", "<a onclick='productRateRequest("+ value['id'] + ")' >"+"Request For Rate"+"</a>").replace("replace-rate-req", value['id']).replace("replace-4", value['image']).replace('replace-5', value['id']).replace('replace-fes', value['featured']).replace('replace-link', value['id']).replace("replace-cart", value['id']).replace('replace-cart-rel', value['id']).replace('replace-vdo-id', value['id']).replace('replace-dv-id', value['id']).replace('replace-prod-price', 'dv-prod-price-'+value['id']).replace('replace-name-link',value['id']).replace('replace-mult-img',value['id']).replace('replace-mult-link',value['id']).replace('replace-original',value['is_original']).replace('repl_prod_colr',value['pro_color']));
                                addProdDataSortPrice(); //replace-rate-req
                                var sort = $("[name='sort_by1']:checked").val();
                                if(sort !='' && (sort =='asc' || sort =='desc'))
                                {
                                    sortProductsByOrder(sort);
                                }
                            }, 1000);
                        }


                    });

                }
            });
        }
    </script>
    <script>
        $("[name=sort_by]").on('change', function () {
            $("#frm_search_product").submit();
        });
    </script>
    <script>
        function showQuickView(product_id) {
            if (product_id != "") {
                $.ajax({
                    type: "get",
                    url: javascript_site_path + 'get-product-quick-view',
                    dataType: 'html',
                    data: {
                        _token: $("[name=_token]").val(),
                        product_id: product_id
                    },
                    success: function (res) {
                        $("#h-quick-view").html(res);
                        $("#h-quick-view").modal('show');
                    }
                });
            }
        }

        function addToWishlist(product_id) {
            $.ajax({
                url: '{{url( "/ajax-add-product-in-wishlist")}}',
                data: {'product_id': product_id},
                dataType: "json",
                type:"get",
                success: function (res) {
                    if (res.msg == 'Deleted From Wishlist') {
                        $("#add-wishlist-" + product_id).removeClass('active');
                    } else if (res.msg == 'Added In Wishlist') {
                        $("#add-wishlist-" + product_id).addClass('active');
                    }

                }
            });
        }
    </script>
    <script>
        //  url('/product-rate-request')
        function productRateRequest(product_id)
        {
            $("#dv-cust-load-"+product_id).show();

            $.ajax({
                url: '{{url( "/user/product-rate-request")}}'+'/'+product_id,
                dataType: "json",
                type:"get",
                success: function (res) {
                    if(res.success =='1')
                    {
                        $('#dv-prod-price-'+product_id+' a').html('Rate Requested');
                        $("#dv-cust-load-"+product_id).hide();
                    }
                    else{
                        $("#dv-cust-load-"+product_id).hide();
                        alert(res.msg);
                    }
                }
            });
        }

        function addToCart(id) {
            //alert(id);return;
            var quantity = 1;
            var product_id = id;

            // $('#popup_div').addClass('active');
            // $('#popup_div').show();

            $.ajax({
                url: '{{  url('add-product-to-cart') }}',
                type: "get",
                dataType: 'json',
                data: {
                    product_id: product_id,
                    quantity: quantity
                },
                success: function (response) {
                    // alert(response);
                    if (response.success == "1") {
                        //  console.log(123);
                        //  console.log(response.success);
                        // console(response.success);return;
                        $('#added-in-cart').show();
                        //  $('addT')
                        window.location.href = window.location.href;
                    }
                    else {
                        // console.log(111);
                        // console.log(response.msg);
                       // alert(response.msg);
                        return;
                    }

                }
            });
        }

    </script>
    <script>
        // $(document).on('click', '.add-cart', function () {
        //     // alert($(this).attr("rel"));return;
        //     id = $(this).attr("rel");
        //     // alert(id);return;
        //     addToCart(id);
        // });

    </script>

    <script>
        // $(".product-list .add-cart").on('click',function(e){
        //     alert($(this).attr("rel"));return;
        //      id   = e.attr("rel");
        //     alert(id);return;
        //     addToCart(id);
        // });

    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.2/velocity.ui.min.js'></script>
	<script>
        $(".modal").each(function (l) {
            $(this).on("show.bs.modal", function (l) {
                var o = $(this).attr("data-easein");
                "shake" == o ? $(".modal-dialog").velocity("callout." + o) : "pulse" == o ? $(".modal-dialog").velocity("callout." + o) : "tada" == o ? $(".modal-dialog").velocity("callout." + o) : "flash" == o ? $(".modal-dialog").velocity("callout." + o) : "bounce" == o ? $(".modal-dialog").velocity("callout." + o) : "swing" == o ? $(".modal-dialog").velocity("callout." + o) : $(".modal-dialog").velocity("transition." + o)
            })
        });
        //# sourceURL=pen.js
    </script>
    <script type="text/javascript">
        var cnt =0;
        $(function(){
            var numItems = $('.my-h3-opt').length;
            // alert(numItems);return;
            // jQuery('.my-h3-opt').len
            for(var i=0;i<numItems;i++){
              jQuery("#cartFormal-"+i).insertAfter(jQuery("#my-h3-"+i));
            }
            
        });
    </script>
    <script>
        $(function(){
            addProdDataSortPrice();
            $('.discount-show').each(function(){
                var val =$(this).html();
                    val = val.trim();
                if(val == '0 %')
                {
                    $(this).hide();
                }

            });
        });
    </script>
    <script>

        function addProdDataSortPrice()
        {
            $('.prod-with-dis-price').each(function () {
                var price =$(this).html().trim();
                var realVal =parseFloat(price.substr(1));
                var id = $(this).attr('id');
                id = id.split('-').pop();
                if (!isNaN(realVal) && realVal !='')
                {
                    if(!isNaN(id))
                    {
                        $("#li-pro-data-"+id).attr('data-sort',realVal);
                    }
                }
            });
        }

	</script>
    <script>
        function sortProductsByOrder(order)
        {
            var sort =order;
            var $list = $('#replace_main_upper');
            var $listLi = $('li',$list);
            $listLi.sort(function(a, b){
                var keyA = parseFloat($(a).data('sort'));
                var keyB = parseFloat($(b).data('sort'));
                // console.log(keyB);
                // console.log(keyA);
                if(isNaN(keyA))
                {
                    return 1;
                }
                if(isNaN(keyB))
                {
                    return -1;
                }
                    if(sort=='asc')
                    {
                        return (keyA > keyB) ? 1 : 0;
                    } else {
                        return (keyA < keyB) ? 1 : 0;
                    }

            });
            $.each($listLi, function(index, row){
                $list.append(row);
            });
        }
    </script>
    <script>
    function closeSizeGuide()
    {
        $('#h-cust-modal-size').modal('hide');
        
       setTimeout(function(){
        $('body').addClass('modal-open');
         },500);
    }
</script>
    <script>
    </script>

<div id="h-cust-modal-size" class="modal h-cust-modal open-my-custom-modal">

      <!-- Modal content -->
      <div class="modal-content">
          <button type="button" class="close h-cust-close" aria-label="Close" onclick="closeSizeGuide()">
              <span aria-hidden="true"><img src="{{url("/public/media/front/img/cancel.png")}}" alt="close" height="20px;" width="20px;"></span>
                        </button>
                    
         <div class="size-heading"><h2>SIZE GUIDE</h2></div> 
         <div class="container">
            <div class="row">
               <div class="arrow-up"></div>
              <div class="top_head">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h3>WOMEN</h3>
                </div><!-- col-md-4 -->
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h3>MEN</h3>
                </div><!-- col-md-4 -->
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <h3>KIDS</h3>
                </div><!-- col-md-4 -->
              </div><!-- top_head -->
            </div><!-- row -->

            <div class="row main_mnu">
                  <ul class="nav nav-pills mnu">
                    <li class="active"><a data-toggle="pill" href="#home"><i class="fa fa-female"></i></a></li>
                    <li><a data-toggle="pill" href="#menu1"><i class="fa fa-male"></i></a></li>
                    <li><a data-toggle="pill" href="#menu2"><i class="fa fa-child"></i></a></li>
                  </ul>
            </div><!-- row -->

            <!-- <div class="row">
                <div class="size-head">
                  <div class="col-md-4">
                    <h4><a href="#"> REGULAR </a></h4>
                  </div>
                  <div class="col-md-8">
                    <h4><a href="#">BIG AND TALL </a></h4>
                  </div>
                </div>
            </div> -->

            <div class="row">
                <div class="mesurment tab-content">

                  <div id="home" class="tab-pane fade in active">
                  <div class="col-md-4">
                    <div class="left_pan">
                        <h4> HOW TO MEASURE </h4>
                        <p><span class="number"><b> 1 </b></span> <span class="mwsure_head"><b> Chest </b></span> Measure across  the fullest part. </p>
                        <p><span class="number"><b> 2 </b></span> <span class="mwsure_head"><b> Waist </b></span> Measure around the natural waistline. </p>
                        <p><span class="number"><b> 3 </b></span> <span class="mwsure_head"><b> Hips </b></span> Measure at the widest  part. </p>
                        <p><span class="number"><b> 4 </b></span> <span class="mwsure_head"><b> Inside Leg </b></span> Measure from top of inside leg at the crotch to the ankle bone. </p>
                    </div><!-- left_pan -->
                    <div class="right_pan">
                        <img src="{{url("public/media/front/img/women-size-guide.png")}}" alt="size image">
                    </div><!-- right_pn -->
                  </div><!-- col-md-4 -->

                  <div class="col-md-8">
                    <div class="tbl_head">
                        <span class="left_head"> <h4>INTERNATIONAL CONVERSION</h4> </span>
                        <span class="right_head"> <h4>IN CM</h4> </span>
                    </div><!-- tbl_head -->
                    <div class="table-responsive">
                        <table>
                          <tr>
                            <th>SIZE</th>
                            <th>XSS</th>
                            <th>XS</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                            <th>XXL</th>
                          </tr>
                          <tr>
                            <td>UK</td>
                            <td>32 </td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                            <td>40</td>
                            <td>42</td>
                            <td>44-46</td>
                          </tr>
                          <tr>
                            <td>EUROPE</td>
                            <td>44 </td>
                            <td>46</td>
                            <td>48</td>
                            <td>56</td>
                            <td>58</td>
                            <td>60</td>
                            <td>62-64</td>
                          </tr>
                          <tr>
                            <td>USA</td>
                            <td>32 </td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                            <td>40</td>
                            <td>42</td>
                            <td>44</td>
                          </tr>
                          <tr>
                            <td>CANADA</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>AUS/NZ</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>CHEST(in)</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>COLLAR(in)</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                            <td>19</td>
                          </tr>
                        </table>
                    </div>
                  </div><!-- col-md-8 -->
                </div><!-- tab_pane -->

                <div id="menu1" class="tab-pane fade in">
                  <div class="col-md-4">
                    <div class="left_pan">
                        <h4> HOW TO MEASURE </h4>
                        <p><span class="number"><b> 1. </b></span> <span class="mwsure_head"><b> Chest </b></span> Measure across  the fullest part. </p>
                        <p><span class="number"><b> 2. </b></span> <span class="mwsure_head"><b> Waist </b></span> Measure around the natural waistline. </p>
                        <p><span class="number"><b> 3. </b></span> <span class="mwsure_head"><b> Hips </b></span> Measure at the widest  part. </p>
                        <p><span class="number"><b> 4. </b></span> <span class="mwsure_head"><b> Inside Leg </b></span> Measure from top of inside leg at the crotch to the ankle bone. </p>
                    </div><!-- left_pan -->
                    <div class="right_pan">
                        <img src="{{url("public/media/front/img/size.png")}}" alt="size image">
                    </div><!-- right_pn -->
                  </div><!-- col-md-4 -->

                  <div class="col-md-8">
                    <div class="tbl_head">
                        <span class="left_head"> <h4>INTERNATIONAL CONVERSION 2</h4> </span>
                        <span class="right_head"> <h4>IN CM</h4> </span>
                    </div><!-- tbl_head -->
                    <div class="table-responsive">
                        <table>
                          <tr>
                            <th>SIZE</th>
                            <th>XSS</th>
                            <th>XS</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                            <th>XXL</th>
                          </tr>
                          <tr>
                            <td>UK</td>
                            <td>34 </td>
                            <td>36</td>
                            <td>38</td>
                            <td>42</td>
                            <td>52</td>
                            <td>472</td>
                            <td>80-90</td>
                          </tr>
                          <tr>
                            <td>Europe</td>
                            <td>52</td>
                            <td>54</td>
                            <td>56</td>
                            <td>58</td>
                            <td>60</td>
                            <td>62</td>
                            <td>64-66</td>
                          </tr>
                          <tr>
                            <td>USA</td>
                            <td>42 </td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                            <td>50</td>
                            <td>52</td>
                            <td>54</td>
                          </tr>
                          <tr>
                            <td>CANADA</td>
                            <td>30</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                            <td>40</td>
                            <td>42</td>
                          </tr>
                          <tr>
                            <td>AUS/NZ</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>CHEST(in)</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>           
                          </tr>
                          <tr>
                            <td>COLLAR(in)</td>
                            <td>10</td>
                            <td>11</td>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                          </tr>
                        </table>
                    </div>
                  </div><!-- col-md-8 -->
                </div><!-- tab_pane -->

                <div id="menu2" class="tab-pane fade">

                  <div class="col-md-12">
                    <div class="tbl_head">
                        <span class="left_head"> <h4>INTERNATIONAL CONVERSION</h4> </span>
                    </div><!-- tbl_head -->
                        <div class="table-responsive">
                        <table>
                          <tr>
                            <th>SIZE</th>
                            <th>XSS</th>
                            <th>XS</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                            <th>XXL</th>
                          </tr>
                          <tr>
                            <td>UK</td>
                            <td>32 </td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                            <td>40</td>
                            <td>42</td>
                            <td>44-46</td>
                          </tr>
                          <tr>
                            <td>europe</td>
                            <td>44 </td>
                            <td>46</td>
                            <td>48</td>
                            <td>56</td>
                            <td>58</td>
                            <td>60</td>
                            <td>62-64</td>
                          </tr>
                          <tr>
                            <td>USA</td>
                            <td>32 </td>
                            <td>34</td>
                            <td>36</td>
                            <td>38</td>
                            <td>40</td>
                            <td>42</td>
                            <td>44</td>
                          </tr>
                          <tr>
                            <td>CANADA</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>AUS/NZ</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>CHEST(in)</td>
                            <td>32</td>
                            <td>34</td>
                            <td>36</td>
                            <td>40</td>
                            <td>44</td>
                            <td>46</td>
                            <td>48</td>
                          </tr>
                          <tr>
                            <td>COLLAR(in)</td>
                            <td>13</td>
                            <td>14</td>
                            <td>15</td>
                            <td>16</td>
                            <td>17</td>
                            <td>18</td>
                            <td>19</td>
                          </tr>
                        </table>
                    </div>
                  </div><!-- col-md-12 -->
                </div><!-- tab_pane -->


                </div><!-- mesurment tab-content -->
            </div><!-- row -->

         </div><!-- container -->
      </div><!-- modal-content -->
    </div>
@endsection


