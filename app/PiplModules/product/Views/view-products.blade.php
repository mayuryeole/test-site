@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
<title>Product Listing</title>
@endsection

@section("content")
<section class="product-listing-blk h-product-listing-blk">
	<div class="container">
    	<div class="listing-option">
        	<div class="row clearfix">
                <div class="col-md-2">
                    <div class="custom-multiselect form-group relative">
                        <select class="lstFruits" multiple="multiple">
                            <option value="1">HP</option>
                            <option value="2">Hansol</option>
                            <option value="3">Samsung</option>
                            <option value="4">LG</option>
                            <option value="5">Pantech</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="custom-multiselect form-group relative">
                        <select class="lstFruits" multiple="multiple">
                            <option value="1">HP</option>
                            <option value="2">Hansol</option>
                            <option value="3">Samsung</option>
                            <option value="4">LG</option>
                            <option value="5">Pantech</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="custom-multiselect form-group relative">
                        <select class="lstFruits" multiple="multiple">
                            <option value="1">HP</option>
                            <option value="2">Hansol</option>
                            <option value="3">Samsung</option>
                            <option value="4">LG</option>
                            <option value="5">Pantech</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="custom-multiselect form-group relative">
                        <select class="lstFruits" multiple="multiple">
                            <option value="1">HP</option>
                            <option value="2">Hansol</option>
                            <option value="3">Samsung</option>
                            <option value="4">LG</option>
                            <option value="5">Pantech</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="custom-multiselect form-group relative">
                        <select class="lstFruits" multiple="multiple">
                            <option value="1">HP</option>
                            <option value="2">Hansol</option>
                            <option value="3">Samsung</option>
                            <option value="4">LG</option>
                            <option value="5">Pantech</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 text-right h-last-filter">
                	<div class="lsit-grid-view">
                    	<span><a href="javascript:void(0);" class="h-greed-view"><i class="fa fa-th"></i></a></span>
                        <span><a href="javascript:void(0);" class="h-list-view"><i class="fa fa-th-list"></i></a></span>
                    </div>
                </div>
        	</div>
        </div>
        <div class="product-list-grid">
        	<ul class="product-list row">
            	<li class="col-md-4 col-sm-6 col-xs-12">
                	<div class="product-item-wrapper">
                    	<a href="javascript:void(0);">
                        	<div class="product-item clearfix">
                            	<div class="product-thumbnail">
                                	<img src="{{asset('public/media/front/img/list1.jpg')}}" alt="product image"/>
                                    <div class="image-hover">
                                    	<img src="{{asset('public/media/front/img/story3.jpg')}}" alt="image"/>
                                    </div>
                                    <div class="quick-view"><button type="button" class="quick-view-btn" data-toggle="modal" href="#h-quick-view"><i class="fa fa-plus"></i></button></div>
                                </div>
                                <div class="product-info">
                                	<div class="h-product-info-blk">
                                        <h3>
                                            <span class="title">What is Lorem Ipsum</span>
                                            <span class="prod-description">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000.</span>
                                        </h3>
                                        <div class="prod-price">$80.00</div>
                                        <div class="cart-option">
                                            <button type="button" class="add-cart">Add to Cart</button>
                                            <button type="button" class="add-cart"><i class="fa fa-heart"></i></button>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </li> 
                <li class="col-md-4 col-sm-6 col-xs-12">
                	<div class="product-item-wrapper">
                    	<a href="javascript:void(0);">
                        	<div class="product-item clearfix">
                            	<div class="product-thumbnail">
                                	<img src="{{asset('public/media/front/img/list1.jpg')}}" alt="product image"/>
                                    <div class="image-hover">
                                    	<img src="{{asset('public/media/front/img/story3.jpg')}}" alt="image"/>
                                    </div>
                                    <div class="quick-view"><button type="button" class="quick-view-btn" data-toggle="modal" href="#h-quick-view"><i class="fa fa-plus"></i></button></div>
                                </div>
                                <div class="product-info">
                                	<div class="h-product-info-blk">
                                        <h3>
                                            <span class="title">What is Lorem Ipsum</span>
                                            <span class="prod-description">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000.</span>
                                        </h3>
                                        <div class="prod-price">$80.00</div>
                                        <div class="cart-option">
                                            <button type="button" class="add-cart">Add to Cart</button>
                                            <button type="button" class="add-cart"><i class="fa fa-heart"></i></button>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </li> 
                <li class="col-md-4 col-sm-6 col-xs-12">
                	<div class="product-item-wrapper">
                    	<a href="javascript:void(0);">
                        	<div class="product-item clearfix">
                            	<div class="product-thumbnail">
                                	<img src="{{asset('public/media/front/img/list1.jpg')}}" alt="product image"/>
                                    <div class="image-hover">
                                    	<img src="{{asset('public/media/front/img/story3.jpg')}}" alt="image"/>
                                    </div>
                                    <div class="quick-view"><button type="button" class="quick-view-btn" data-toggle="modal" href="#h-quick-view"><i class="fa fa-plus"></i></button></div>
                                </div>
                                <div class="product-info">
                                	<div class="h-product-info-blk">
                                        <h3>
                                            <span class="title">What is Lorem Ipsum</span>
                                            <span class="prod-description">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000.</span>
                                        </h3>
                                        <div class="prod-price">$80.00</div>
                                        <div class="cart-option">
                                            <button type="button" class="add-cart">Add to Cart</button>
                                            <button type="button" class="add-cart"><i class="fa fa-heart"></i></button>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="col-md-4 col-sm-6 col-xs-12">
                	<div class="product-item-wrapper">
                    	<a href="javascript:void(0);">
                        	<div class="product-item clearfix">
                            	<div class="product-thumbnail">
                                	<img src="{{asset('public/media/front/img/list1.jpg')}}" alt="product image"/>
                                    <div class="image-hover">
                                    	<img src="{{asset('public/media/front/img/story3.jpg')}}" alt="image"/>
                                    </div>
                                    <div class="quick-view"><button type="button" class="quick-view-btn" data-toggle="modal" href="#h-quick-view"><i class="fa fa-plus"></i></button></div>
                                </div>
                                <div class="product-info">
                                	<div class="h-product-info-blk">
                                        <h3>
                                            <span class="title">What is Lorem Ipsum</span>
                                            <span class="prod-description">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000.</span>
                                        </h3>
                                        <div class="prod-price">$80.00</div>
                                        <div class="cart-option">
                                            <button type="button" class="add-cart">Add to Cart</button>
                                            <button type="button" class="add-cart"><i class="fa fa-heart"></i></button>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="col-md-4 col-sm-6 col-xs-12">
                	<div class="product-item-wrapper">
                    	<a href="javascript:void(0);">
                        	<div class="product-item clearfix">
                            	<div class="product-thumbnail">
                                	<img src="{{asset('public/media/front/img/list1.jpg')}}" alt="product image"/>
                                    <div class="image-hover">
                                    	<img src="{{asset('public/media/front/img/story3.jpg')}}" alt="image"/>
                                    </div>
                                    <div class="quick-view"><button type="button" class="quick-view-btn" data-toggle="modal" href="#h-quick-view"><i class="fa fa-plus"></i></button></div>
                                </div>
                                <div class="product-info">
                                	<div class="h-product-info-blk">
                                        <h3>
                                            <span class="title">What is Lorem Ipsum</span>
                                            <span class="prod-description">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000.</span>
                                        </h3>
                                        <div class="prod-price">$80.00</div>
                                        <div class="cart-option">
                                            <button type="button" class="add-cart">Add to Cart</button>
                                            <button type="button" class="add-cart"><i class="fa fa-heart"></i></button>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="col-md-4 col-sm-6 col-xs-12">
                	<div class="product-item-wrapper">
                    	<a href="javascript:void(0);">
                        	<div class="product-item clearfix">
                            	<div class="product-thumbnail">
                                	<img src="{{asset('public/media/front/img/list1.jpg')}}" alt="product image"/>
                                    <div class="image-hover">
                                    	<img src="{{asset('public/media/front/img/story3.jpg')}}" alt="image"/>
                                    </div>
                                    <div class="quick-view"><button type="button" class="quick-view-btn" data-toggle="modal" href="#h-quick-view"><i class="fa fa-plus"></i></button></div>
                                </div>
                                <div class="product-info">
                                	<div class="h-product-info-blk">
                                        <h3>
                                            <span class="title">What is Lorem Ipsum</span>
                                            <span class="prod-description">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000.</span>
                                        </h3>
                                        <div class="prod-price">$80.00</div>
                                        <div class="cart-option">
                                            <button type="button" class="add-cart">Add to Cart</button>
                                            <button type="button" class="add-cart"><i class="fa fa-heart"></i></button>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>  
            </ul>
        </div>
    </div>
</section>
<section class="add_to_shoping_bag">
	<i class="fa fa-shopping-basket"></i>
    <!--<div class="h-cart-pro-list">
    	<ul>
        	<li><a href="javascript:void(0)">Product Name Here</a></li>
        </ul>
    </div>-->
</section>
<div class="cust-modal modal fade" id="h-quick-view">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="img/cancel.png" alt="close"></span></button>
      </div>
      <div class="modal-body">
      	<div class="row">
        	<div class="col-md-5">
            	<div class="gal-img">
                    	<div class="cust-detail-slide">
                            <div id="carousel" class="carousel slide propertySlider" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="item active">
                                            <img src="{{asset('public/media/front/img/list1.jpg')}}">
                                            <div class="zoom-icon">
                                                <a href="{{asset('public/media/front/img/list1.jpg')}}" class="swipebox" title="Product View">
                                                    <i class="fa fa-arrows-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="{{asset('public/media/front/img/slid-2.jpg')}}">
                                            <div class="zoom-icon">
                                                <a href="{{asset('public/media/front/img/slid-2.jpg')}}" class="swipebox" title="Product View">
                                                    <i class="fa fa-arrows-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="{{asset('public/media/front/img/list1.jpg')}}">
                                            <div class="zoom-icon">
                                                <a href="{{asset('public/media/front/img/list1.jpg')}}" class="swipebox" title="Product View">
                                                    <i class="fa fa-arrows-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item">
                                           <img src="{{asset('public/media/front/img/slid-2.jpg')}}">
                                            <div class="zoom-icon">
                                                <a href="{{asset('public/media/front/img/slid-2.jpg')}}" class="swipebox" title="Product View">
                                                    <i class="fa fa-arrows-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="{{asset('public/media/front/img/list1.jpg')}}">
                                            <div class="zoom-icon">
                                                <a href="{{asset('public/media/front/img/list1.jpg')}}" class="swipebox" title="Product View">
                                                    <i class="fa fa-arrows-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="{{asset('public/media/front/img/slid-2.jpg')}}">
                                            <div class="zoom-icon">
                                                <a href="{{asset('public/media/front/img/slid-2.jpg')}}" class="swipebox" title="Product View">
                                                    <i class="fa fa-arrows-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="{{asset('public/media/front/img/list1.jpg')}}">
                                            <div class="zoom-icon">
                                                <a href="{{asset('public/media/front/img/list1.jpg')}}" class="swipebox" title="Product View">
                                                    <i class="fa fa-arrows-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="{{asset('public/media/front/img/slid-2.jpg')}}">
                                            <div class="zoom-icon">
                                                <a href="{{asset('public/media/front/img/slid-2.jpg')}}" class="swipebox" title="Product View">
                                                    <i class="fa fa-arrows-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item">
                                           <img src="{{asset('public/media/front/img/list1.jpg')}}">
                                            <div class="zoom-icon">
                                                <a href="{{asset('public/media/front/img/list1.jpg')}}" class="swipebox" title="Product View">
                                                    <i class="fa fa-arrows-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="{{asset('public/media/front/img/slid-2.jpg')}}">
                                            <div class="zoom-icon">
                                                <a href="{{asset('public/media/front/img/slid-2.jpg')}}" class="swipebox" title="Product View">
                                                    <i class="fa fa-arrows-alt"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="clearfix">
                                    <div id="thumbcarousel" class="carousel slide propertySliderThumb" data-interval="false">
                                        <div class="carousel-inner">
                                            <div class="item active">
                                                <div data-target="#carousel" data-slide-to="0" class="thumb"><img src="{{asset('public/media/front/img/list1.jpg')}}"></div>
                                                <div data-target="#carousel" data-slide-to="1" class="thumb"><img src="{{asset('public/media/front/img/slid-2.jpg')}}"></div>
                                                <div data-target="#carousel" data-slide-to="2" class="thumb"><img src="{{asset('public/media/front/img/list1.jpg')}}"></div>
                                                <div data-target="#carousel" data-slide-to="3" class="thumb"><img src="{{asset('public/media/front/img/slid-2.jpg')}}"></div>
                                                <div data-target="#carousel" data-slide-to="4" class="thumb"><img src="{{asset('public/media/front/img/list1.jpg')}}"></div>
                                            </div>
                                            <div class="item">
                                                <div data-target="#carousel" data-slide-to="5" class="thumb"><img src="{{asset('public/media/front/img/slid-2.jpg')}}"></div>
                                                <div data-target="#carousel" data-slide-to="6" class="thumb"><img src="{{asset('public/media/front/img/list1.jpg')}}"></div>
                                                <div data-target="#carousel" data-slide-to="7" class="thumb"><img src="{{asset('public/media/front/img/slid-2.jpg')}}"></div>
                                                <div data-target="#carousel" data-slide-to="8" class="thumb"><img src="{{asset('public/media/front/img/list1.jpg')}}"></div>
                                                <div data-target="#carousel" data-slide-to="9" class="thumb"><img src="{{asset('public/media/front/img/slid-2.jpg')}}"></div>
                                            </div>
                                        </div>
                                        <a class="left carousel-control" href="#thumbcarousel" role="button" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                        </a>
                                        <a class="right carousel-control" href="#thumbcarousel" role="button" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                        </a>
                                    </div>
                                </div>
          				</div>
                    </div>
            </div>
            <div class="col-md-7">
            	<div class="h-product-details">
                	<div class="h-product-heading"><h2 class="h-section-title">Us polo t-shirt</h2></div>
                    <div class="h-product-rating">
                    	<span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <span><i class="fa fa-star"></i></span>
                        <div class="h-product-review">Be the first to review this product</div>
                    </div>
                    <div class="h-price">
                    	<b>$45.05</b>
                        <del>$85.10</del>
                    </div>
                    <div class="h-product-availability">
                    	<ul class="h-stock-detail">
                        	<li>
                            	<i class="fa fa-stack-exchange"></i>
                                <span>Only 15 Left</span>
                                <i class="fa fa-angle-down"></i>
                            </li>
                            <li>
                                <span class="h-prod-status">Available:</span>
                                <span class="h-green">in stock</span>
                            </li>
                        </ul>
                    </div>
                    <div class="h-product-description">
                    	<p>A t-shirt that comes in three colors (red, white and blue) and three sizes (small, medium, large) is a configurable product. A configurable product is made up of other simple products. you can create a configurable product that ties them all together, and gives the end user the choice, usually from a drop-down menu. </p>
                    </div>
                    <div class="product-options">
                        <div class="color-optn font-2">
                            <label> <span class="option"> Color </span> <span class="red-color"> * </span> <span class="required red-color pull-right"> Field Required *</span> </label>
                            <ul class="list-unstyled">
                                <li> <a href="#"> <img src="{{asset('public/media/front/img/color-1.jpg')}}" alt=""> </a> </li>
                                <li> <a href="#"> <img src="{{asset('public/media/front/img/color-2.jpg')}}" alt=""> </a> </li>
                                <li> <a href="#"> <img src="{{asset('public/media/front/img/color-3.jpg')}}" alt=""> </a> </li>
                                <li> <a href="#"> <img src="{{asset('public/media/front/img/color-4.jpg')}}" alt=""> </a> </li>
                            </ul>
                        </div>
                        <div class="size-optn font-2">
                            <label> <span class="option"> SIZE OPTIONS </span> </label>
                            <ul class="list-inline">
                                <li> <a href="#"> S </a> </li>
                                <li> <a href="#"> M </a> </li>
                                <li> <a href="#"> L </a> </li>
                                <li> <a href="#"> XL </a> </li>
                                <li> <a href="#"> XXL </a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="h-product-buttons clearfix">
                    	<div class="h-quantity">
                        	<button type="button" class="h-minus-pro"><i class="icon-substract"></i></button>
                            <input type="text" class="form-control" value="1"/>
                            <button type="button" class="h-plus-pro"><i class="icon-add"></i></button>
                        </div>
                        <div class="h-add-cart">
                        	<button class="h-cart-btn" type="button">Add to Cart </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="{{url("/")}}/public/media/front/js/jquery.js"></script>
<script src="{{url("/")}}/public/media/front/js/bootstrap.min.js"></script>
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('.lstFruits').multiselect({
                includeSelectAllOption: true
            });
            $('#btnSelected').click(function () {
                var selected = $("#lstFruits option:selected");
                var message = "";
                selected.each(function () {
                    message += $(this).text() + " " + $(this).val() + "\n";
                });
                alert(message);
            });
        });
		$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<script src="{{url("/")}}/public/media/front/js/owl.carousel.min.js"></script>
<script src="{{url("/")}}/public/media/front/js/jquery.mCustomScrollbar.min.js"></script>
<script src="{{url("/")}}/public/media/front/js/wow.js"></script>
<script src="{{url("/")}}/public/media/front/js/jquery.swipebox.min.js"></script>
<script src="{{url("/")}}/public/media/front/js/custom.js"></script>
<script>
// Swipebox Start //

;( function( $ ) {

/* Basic Gallery */
$( '.swipebox' ).swipebox();

/* Video */
$( '.swipebox-video' ).swipebox();

/* Dynamic Gallery */
$( '#gallery' ).click( function( e ) {
	e.preventDefault();
	$.swipebox( [
		{ href : 'http://swipebox.csag.co/mages/image-1.jpg', title : 'My Caption' },
		{ href : 'http://swipebox.csag.co/images/image-2.jpg', title : 'My Second Caption' }
	] );
} );

} )
( jQuery );jQuery(document).ready(function(e) {
	$('.team-img-inner').freetile();
  
	$('.teamslider-wrap').teamslider();

});
@endsection