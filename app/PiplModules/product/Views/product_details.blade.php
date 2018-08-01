@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
<title>Product Listing</title>
@endsection

@section("content")

<section class="cms-header" style="background-image:url({{url('/')}}/public/media/front/img/bg_cms_1.jpg);">
	<div class="container">
    	<div class="cms-caption">
            <div class="cms-ban-heading">
                Product Details
            </div>
            <div class="cms-ban-breadcrumbs">
               	<ul>
                	<li><a href="{{url('/')}}">Home</a></li>
                    <li><span>>></span></li>
                    <li class="active">Product Details</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!---------------------------------------------------------Purchase Product--------------------------------------->
<section class="purchase-product">
	<div class="container-fluid">
    	<div class="purchase-pro-holder">
            <div class="row clearfix">
            	<div class="col-sm-5 col-xs-12">
                    <div class="product-zoom-image clearfix">
                        <div class="prod-thumb">
                            <ul class="xzoom-thumbs">
                                <li>
                                    <a href="{{url('public/media/front/img/18.jpg')}}">
                                        <img class="xzoom-gallery" src="{{url('public/media/front/img/18.jpg')}}" xpreview="{{url('public/media/front/img/18.jpg')}}" alt="image"/>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('public/media/front/img/18.jpg')}}">
                                         <img class="xzoom-gallery" src="{{url('public/media/front/img/18.jpg')}}" alt="image"/>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('public/media/front/img/18.jpg')}}">
                                         <img class="xzoom-gallery" src="{{url('public/media/front/img/18.jpg')}}" alt="image"/>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('public/media/front/img/18.jpg')}}">
                                         <img class="xzoom-gallery" src="{{url('public/media/front/img/18.jpg')}}" alt="image"/>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="prod-zoom-img">
                            <a href="javascript:void(0);"><img class="xzoom" xoriginal="{{url('public/media/front/img/18.jpg')}}" src="{{url('public/media/front/img/18.jpg')}}" alt="image"/></a>
                        </div>                        
                    </div>
                    <div class="purchase-button">
                        <button type="button" class="add-cart-btn">Add To Cart</button>
                        <button type="button" class="buy-now-btn">Buy Now</button>
                    </div>
                </div>
                
                
               <!-- <div class="bzoom_wrap hidden">
                    <ul id="bzoom">
                        <li>
                            <img class="bzoom_thumb_image" src="img/18.jpg" title="first img" />
                            <img class="bzoom_big_image" src="img/18.jpg"/>
                        </li>
                        <li>
                            <img class="bzoom_thumb_image" src="img/18.jpg"/>
                            <img class="bzoom_big_image" src="img/18.jpg"/>
                        </li>
                        <li>
                            <img class="bzoom_thumb_image" src="img/18.jpg"/>
                            <img class="bzoom_big_image" src="img/18.jpg"/>
                        </li>
                        <li>
                            <img class="bzoom_thumb_image" src="img/18.jpg"/>
                            <img class="bzoom_big_image" src="img/18.jpg"/>
                        </li>
                        <li>
                            <img class="bzoom_thumb_image" src="img/18.jpg"/>
                            <img class="bzoom_big_image" src="img/18.jpg"/>
                        </li>
                    </ul>
                </div>-->
                
                
                
                
                <div class="col-sm-5 col-xs-12 hidden">
                	<div class="bzoom_wrap">
                        <ul id="bzoom">
                            <li>
                                <img class="bzoom_thumb_image" src="img/18.jpg" title="first img" />
                                <img class="bzoom_big_image" src="img/18.jpg"/>
                            </li>
                            <li>
                                <img class="bzoom_thumb_image" src="img/18.jpg"/>
                                <img class="bzoom_big_image" src="img/18.jpg"/>
                            </li>
                            <li>
                                <img class="bzoom_thumb_image" src="img/18.jpg"/>
                                <img class="bzoom_big_image" src="img/18.jpg"/>
                            </li>
                            <li>
                                <img class="bzoom_thumb_image" src="img/18.jpg"/>
                                <img class="bzoom_big_image" src="img/18.jpg"/>
                            </li>
                            <li>
                                <img class="bzoom_thumb_image" src="img/18.jpg"/>
                                <img class="bzoom_big_image" src="img/18.jpg"/>
                            </li>
                        </ul>
                	</div>
                    <!--<div class="product-zoom-image clearfix hidden">
                        <div class="bzoom_wrap">
                            <ul id="bzoom">
                                <li>
                                	<img class="bzoom_thumb_image" src="img/18.jpg" title="first img" />
                            		<img class="bzoom_big_image" src="img/18.jpg"/>                                    
                                </li>
                                <li>
                                	<img class="bzoom_thumb_image" src="img/18.jpg" title="first img" />
                            		<img class="bzoom_big_image" src="img/18.jpg"/>                                    
                                </li>
                                <li>
                                	<img class="bzoom_thumb_image" src="img/18.jpg" title="first img" />
                            		<img class="bzoom_big_image" src="img/18.jpg"/>                                    
                                </li>
                                <li>
                                	<img class="bzoom_thumb_image" src="img/18.jpg" title="first img" />
                            		<img class="bzoom_big_image" src="img/18.jpg"/>                                    
                                </li>
                            </ul>
                        </div>-->
                        <!--<div class="prod-zoom-img">
                            <a href="javascript:void(0);"><img class="xzoom" xoriginal="img/18.jpg" src="img/18.jpg" alt="image"/></a>
                        </div>-->  
                    <div class="purchase-button">
                        <button type="button" class="add-cart-btn">Add To Cart</button>
                        <button type="button" class="buy-now-btn">Buy Now</button>
                    </div>
                </div>
                <div class="col-sm-7 col-xs-12 pull-right">
                	<div class="cust-breadcrumb">
                    	<ul>
                        	<li><a href="javascript:void(0);">Home</a> <span>></span></li>
                            <li><a href="javascript:void(0);">Prduct Details</a> <span>></span></li>
                            <li>Purchase Product</li>
                        </ul>
                    </div>
                    <div class="prod-details">
                    	<h5>Syska Magic SDI-05 Dry Iron  (White & Red)</h5>
                        <div class="available-product clearfix">                            
                            <span class="user-rating">
                                <a href="javascript:void(0);">4.8 <span><i class="fa fa-star"></i></span></a>
                            </span>
                            <span class="rating">qty : 16 Ratings</span>
                            <span class="review">3 Review</span>
                            <div class="price">
                                <h5>Rs. 18,500.00</h5>
                                <h5 class="stritline">Rs. 40,500.00</h5>
                                <h5>45% Off</h5>
                            </div>
                            <div class="row">
                            	<div class="col-sm-6 col-xs-12">
                                    <div class="product-desc-query">
                                        <div class="filter-collapse panel-group" id="accordion" role="tablist">
                                            <div class="panel">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#type">
                                                           Bank Offers <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="type" class="panel-collapse collapse in" role="tabpanel">
                                                    <div class="panel-body">
                                                        <div class="bank-offers">
                                                            <h5>
                                                                <span>
                                                                    Bank OfferExtra
                                                                </span> 
                                                                5% off* on Axis Bank Buzz Credit Cards 
                                                                <a href="javascript:void(0)">T&C </a>
                                                            </h5>
                                                            <h5>
                                                                <span>
                                                                    Bank OfferExtra
                                                                </span> 
                                                                5% off* on Axis Bank Buzz Credit Cards 
                                                                <a href="javascript:void(0)">T&C </a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#brand">
                                                           Product Details <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="brand" class="panel-collapse collapse" role="tabpanel">
                                                    <div class="panel-body">
                                                        <ul>
                                                            <li><label><input type="checkbox"> Calvin Klein</label></li>
                                                            <li><label><input type="checkbox"> Tommy Hilfiger</label></li>
                                                            <li><label><input type="checkbox"> French Connection</label></li>
                                                            <li><label><input type="checkbox"> Louis Vitton</label></li>
                                                            <li><label><input type="checkbox"> GUESS</label></li>
                                                            <li><label><input type="checkbox"> Nike</label></li>
                                                            <li><label><input type="checkbox"> Prada</label></li>
                                                            <li><label><input type="checkbox"> Lacoste</label></li>
                                                            <li><label><input type="checkbox"> Levis</label></li>
                                                            <li><label><input type="checkbox"> Pepe Jeans</label></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#offers">
                                                           Offers <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="offers" class="panel-collapse collapse" role="tabpanel">
                                                    <div class="panel-body">
                                                        <ul>
                                                            <li><label><input type="checkbox"> Bank Offers</label></li>
                                                            <li><label><input type="checkbox"> Special Offers</label></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="product-desc-query">
                                        <div class="filter-collapse panel-group" id="accordion" role="tablist">
                                            <div class="panel">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#one">
                                                           Bank Offers <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="one" class="panel-collapse collapse" role="tabpanel">
                                                    <div class="panel-body">
                                                        <div class="bank-offers">
                                                            <h5>
                                                                <span>
                                                                    Bank OfferExtra
                                                                </span> 
                                                                5% off* on Axis Bank Buzz Credit Cards 
                                                                <a href="javascript:void(0)">T&C </a>
                                                            </h5>
                                                            <h5>
                                                                <span>
                                                                    Bank OfferExtra
                                                                </span> 
                                                                5% off* on Axis Bank Buzz Credit Cards 
                                                                <a href="javascript:void(0)">T&C </a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#two">
                                                           Product Details <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="two" class="panel-collapse collapse" role="tabpanel">
                                                    <div class="panel-body">
                                                        <ul>
                                                            <li><label><input type="checkbox"> Calvin Klein</label></li>
                                                            <li><label><input type="checkbox"> Tommy Hilfiger</label></li>
                                                            <li><label><input type="checkbox"> French Connection</label></li>
                                                            <li><label><input type="checkbox"> Louis Vitton</label></li>
                                                            <li><label><input type="checkbox"> GUESS</label></li>
                                                            <li><label><input type="checkbox"> Nike</label></li>
                                                            <li><label><input type="checkbox"> Prada</label></li>
                                                            <li><label><input type="checkbox"> Lacoste</label></li>
                                                            <li><label><input type="checkbox"> Levis</label></li>
                                                            <li><label><input type="checkbox"> Pepe Jeans</label></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <div class="panel-heading" role="tab" id="headingOne">
                                                    <h4 class="panel-title">
                                                        <a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#three">
                                                           Offers <i class="fa fa-angle-down"></i>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="three" class="panel-collapse collapse" role="tabpanel">
                                                    <div class="panel-body">
                                                        <ul>
                                                            <li><label><input type="checkbox"> Bank Offers</label></li>
                                                            <li><label><input type="checkbox"> Special Offers</label></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product_color_option">
                            	<ul class="clearfix">
                                	<li><a href="javascript:void(0);"><img src="img/18.jpg" alt="Product Image"/></a></li>
                                    <li><a href="javascript:void(0);"><img src="img/18.jpg" alt="Product Image"/></a></li>
                                    <li><a href="javascript:void(0);"><img src="img/18.jpg" alt="Product Image"/></a></li>
                                    <li><a href="javascript:void(0);"><img src="img/18.jpg" alt="Product Image"/></a></li>
                                    <li><a href="javascript:void(0);"><img src="img/18.jpg" alt="Product Image"/></a></li>
                                </ul>
                            </div>
                            <div class="pin-code">
								<span class="pin-heading">Delivery</span><span class="pin-input"><input type="text" class="form-control" placeholder="Enter Pin Code"/></span> 
                                <span class="delivery-time">Delivery in7-10 days|₹120</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!---------------------------------------------------------End Purchase Product----------------------------------->
@endsection