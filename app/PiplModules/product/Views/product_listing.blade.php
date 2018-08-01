@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
<title>Product Listing</title>
@endsection

@section("content")

<section class="cms-header" style="background-image:url({{url('/')}}/public/media/front/img/bg_cms_1.jpg);">
	<div class="container">
    	<div class="cms-caption">
            <div class="cms-ban-heading">
                Product Listing
            </div>
            <div class="cms-ban-breadcrumbs">
               	<ul>
                	<li><a href="{{url('/')}}">Home</a></li>
                    <li><span>>></span></li>
                    <li class="active">Product Listing</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!---------------------------------------------------------All product category page--------------------------------------->
<section class="all-product-category">
	<div class="container-fluid">
    	<div class="row">
        	<div class="col-sm-3 col-xs-12">
                <div class="filter-heading">Filters</div>
            	<div class="filter-option">
                	<h6><span>Categories</span></h6>
                    <ul class="filter-category">                    	
                    	<li><a href="javascript:void(0);">Option One</a></li>
                        <li><a href="javascript:void(0);">Option One</a></li>
                    </ul>
                    <div class="filter-collapse panel-group" id="accordion" role="tablist">
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#type">
                                       Type <i class="fa fa-angle-down"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="type" class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body">
                       				<ul>
                                    	<li><label><input type="checkbox"> Dry</label></li>
                                        <li><label><input type="checkbox"> Garment Steamer</label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#brand">
                                       Brand <i class="fa fa-angle-down"></i>
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
            <div class="col-sm-9 col-xs-12">
                <div class=" product-detail-category">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-details-info">
                            	<a href="javascript:void(0);">
                                    <img src="{{url('public/media/front/img/18.jpg')}}" alt="image">
                                    <div class="offers-blk">45% off</div>
                                </a>
                                <div class="product-desc">
                                    <a href="javascript:void(0);">
                                        <p>Magikware Super</p>
                                        <p>Kitchen Combo - Juicer, Slicer, Cutter</p>
                                    </a>
                                    <div class="available-product clearfix">
                                    	<p class="product-color">white & blue</p>
                                    	<span class="user-rating">
                                        	<a href="javascript:void(0);">4.8 <span><i class="fa fa-star"></i></span></a>
                                        </span>
                                        <span class="qty">qty : 16 pcs</span>
                                        <span class="bank-offer">Bank offer</span>
                                        <div class="price">
	                                        <h5>Rs. 18,500.00</h5>
                                            <h5 class="stritline">Rs. 40,500.00</h5>
                                            <h5>45% Off</h5>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="javascript:void(0);" class="cust-btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-details-info">
                            	<a href="javascript:void(0);">
                                    <img src="{{url('public/media/front/img/18.jpg')}}" alt="image">
                                </a>
                                <div class="product-desc">
                                    <a href="javascript:void(0);">
                                        <p>Magikware Super</p>
                                        <p>Kitchen Combo - Juicer, Slicer, Cutter</p>
                                    </a>
                                    <div class="available-product clearfix">
                                    	<p class="product-color">white & blue</p>
                                    	<span class="user-rating">
                                        	<a href="javascript:void(0);">4.8 <span><i class="fa fa-star"></i></span></a>
                                        </span>
                                        <span class="qty">qty : 16 pcs</span>
                                        <span class="bank-offer">Bank offer</span>
                                        <div class="price">
	                                        <h5>Rs. 45,500.00</h5>
                                            <h5 class="stritline">Rs. 0.00</h5>
                                            <h5>0% Off</h5>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="javascript:void(0);" class="cust-btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-details-info">
                            	<a href="javascript:void(0);">
                                    <img src="{{url('public/media/front/img/18.jpg')}}" alt="image">
                                    <div class="offers-blk">45% off</div>
                                </a>
                                <div class="product-desc">
                                    <a href="javascript:void(0);">
                                        <p>Magikware Super</p>
                                        <p>Kitchen Combo - Juicer, Slicer, Cutter</p>
                                    </a>
                                    <div class="available-product clearfix">
                                    	<p class="product-color">white & blue</p>
                                    	<span class="user-rating">
                                        	<a href="javascript:void(0);">4.8 <span><i class="fa fa-star"></i></span></a>
                                        </span>
                                        <span class="qty">qty : 16 pcs</span>
                                        <span class="bank-offer">Bank offer</span>
                                        <div class="price">
	                                        <h5>Rs. 18,500.00</h5>
                                            <h5 class="stritline">Rs. 40,500.00</h5>
                                            <h5>45% Off</h5>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="javascript:void(0);" class="cust-btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-details-info">
                            	<a href="javascript:void(0);">
                                    <img src="{{url('public/media/front/img/18.jpg')}}" alt="image">
                                </a>
                                <div class="product-desc">
                                    <a href="javascript:void(0);">
                                        <p>Magikware Super</p>
                                        <p>Kitchen Combo - Juicer, Slicer, Cutter</p>
                                    </a>
                                    <div class="available-product clearfix">
                                    	<p class="product-color">white & blue</p>
                                    	<span class="user-rating">
                                        	<a href="javascript:void(0);">4.8 <span><i class="fa fa-star"></i></span></a>
                                        </span>
                                        <span class="qty">qty : 16 pcs</span>
                                        <span class="bank-offer">Bank offer</span>
                                        <div class="price">
	                                        <h5>Rs. 45,500.00</h5>
                                            <h5 class="stritline">Rs. 0.00</h5>
                                            <h5>0% Off</h5>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="javascript:void(0);" class="cust-btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-details-info">
                            	<a href="javascript:void(0);">
                                    <img src="{{url('public/media/front/img/18.jpg')}}" alt="image">
                                    <div class="offers-blk">45% off</div>
                                </a>
                                <div class="product-desc">
                                    <a href="javascript:void(0);">
                                        <p>Magikware Super</p>
                                        <p>Kitchen Combo - Juicer, Slicer, Cutter</p>
                                    </a>
                                    <div class="available-product clearfix">
                                    	<p class="product-color">white & blue</p>
                                    	<span class="user-rating">
                                        	<a href="javascript:void(0);">4.8 <span><i class="fa fa-star"></i></span></a>
                                        </span>
                                        <span class="qty">qty : 16 pcs</span>
                                        <span class="bank-offer">Bank offer</span>
                                        <div class="price">
	                                        <h5>Rs. 18,500.00</h5>
                                            <h5 class="stritline">Rs. 40,500.00</h5>
                                            <h5>45% Off</h5>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="javascript:void(0);" class="cust-btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-details-info">
                            	<a href="javascript:void(0);">
                                    <img src="{{url('public/media/front/img/18.jpg')}}" alt="image">
                                </a>
                                <div class="product-desc">
                                    <a href="javascript:void(0);">
                                        <p>Magikware Super</p>
                                        <p>Kitchen Combo - Juicer, Slicer, Cutter</p>
                                    </a>
                                    <div class="available-product clearfix">
                                    	<p class="product-color">white & blue</p>
                                    	<span class="user-rating">
                                        	<a href="javascript:void(0);">4.8 <span><i class="fa fa-star"></i></span></a>
                                        </span>
                                        <span class="qty">qty : 16 pcs</span>
                                        <span class="bank-offer">Bank offer</span>
                                        <div class="price">
	                                        <h5>Rs. 45,500.00</h5>
                                            <h5 class="stritline">Rs. 0.00</h5>
                                            <h5>0% Off</h5>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="javascript:void(0);" class="cust-btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-details-info">
                            	<a href="javascript:void(0);">
                                    <img src="{{url('public/media/front/img/18.jpg')}}" alt="image">
                                </a>
                                <div class="product-desc">
                                    <a href="javascript:void(0);">
                                        <p>Magikware Super</p>
                                        <p>Kitchen Combo - Juicer, Slicer, Cutter</p>
                                    </a>
                                    <div class="available-product clearfix">
                                    	<p class="product-color">white & blue</p>
                                    	<span class="user-rating">
                                        	<a href="javascript:void(0);">4.8 <span><i class="fa fa-star"></i></span></a>
                                        </span>
                                        <span class="qty">qty : 16 pcs</span>
                                        <span class="bank-offer">Bank offer</span>
                                        <div class="price">
	                                        <h5>Rs. 45,500.00</h5>
                                            <h5 class="stritline">Rs. 0.00</h5>
                                            <h5>0% Off</h5>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="javascript:void(0);" class="cust-btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-details-info">
                            	<a href="javascript:void(0);">
                                    <img src="{{url('public/media/front/img/18.jpg')}}" alt="image">
                                </a>
                                <div class="product-desc">
                                    <a href="javascript:void(0);">
                                        <p>Magikware Super</p>
                                        <p>Kitchen Combo - Juicer, Slicer, Cutter</p>
                                    </a>
                                    <div class="available-product clearfix">
                                    	<p class="product-color">white & blue</p>
                                    	<span class="user-rating">
                                        	<a href="javascript:void(0);">4.8 <span><i class="fa fa-star"></i></span></a>
                                        </span>
                                        <span class="qty">qty : 16 pcs</span>
                                        <span class="bank-offer">Bank offer</span>
                                        <div class="price">
	                                        <h5>Rs. 45,500.00</h5>
                                            <h5 class="stritline">Rs. 0.00</h5>
                                            <h5>0% Off</h5>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="javascript:void(0);" class="cust-btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="product-details-info">
                            	<a href="javascript:void(0);">
                                    <img src="{{url('public/media/front/img/18.jpg')}}" alt="image">
                                </a>
                                <div class="product-desc">
                                    <a href="javascript:void(0);">
                                        <p>Magikware Super</p>
                                        <p>Kitchen Combo - Juicer, Slicer, Cutter</p>
                                    </a>
                                    <div class="available-product clearfix">
                                    	<p class="product-color">white & blue</p>
                                    	<span class="user-rating">
                                        	<a href="javascript:void(0);">4.8 <span><i class="fa fa-star"></i></span></a>
                                        </span>
                                        <span class="qty">qty : 16 pcs</span>
                                        <span class="bank-offer">Bank offer</span>
                                        <div class="price">
	                                        <h5>Rs. 45,500.00</h5>
                                            <h5 class="stritline">Rs. 0.00</h5>
                                            <h5>0% Off</h5>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="javascript:void(0);" class="cust-btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!---------------------------------------------------------End All product category page----------------------------------->
@endsection