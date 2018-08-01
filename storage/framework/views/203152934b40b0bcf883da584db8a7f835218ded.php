<?php 
    $cart = null;
    $totalCount =0;
    $totalAmount=0;
    $grandTotal =0;
    $getAllCredit =0;
    $getAllSaving=0;
    $wishlist = null;

    if (!Auth::guest()) {
            $cart = Auth::user()->cart;
            $wishlist = Auth::user()->userWishlist;
    }

    else
    {
        $cart= \App\PiplModules\cart\Models\Cart::where('ip_address',Request::ip())->first();
    }
            if (isset($cart) && count($cart)>0) {
            foreach ($cart->cartItems as $items) {
              $all_products = \App\PiplModules\product\Models\Product::find($items->product_id);
              if(isset($all_products) && count($all_products)>0)
              {
                  $totalAmount += $items->product_amount * $items->product_quantity;
                  $totalCount += $items->product_quantity;
              }
            }
          $dis_amt = isset($cart->display_amount)? $cart->display_amount:0.00;
          $tax = isset($cart->tax)? $cart->tax:0.00;
          $ship_chrg = isset($cart->shipping_charge)? $cart->shipping_charge:0.00;
          $box_amt = isset($cart->box_amount)? $cart->box_amount:0.00;
          $paper_amt = isset($cart->paper_amount)? $cart->paper_amount:0.00;

          $getAllCredit = $dis_amt + $tax + $ship_chrg + $box_amt + $paper_amt + $totalAmount;
    }
      if(Session::has('all_cart_data')){
          $data = Session::get('all_cart_data');
          $getAllSaving = $data['coupon_amount']+$data['promo_amount']+$data['refer_points']+$data['gift_voucher'];
      }
    $grandTotal = App\Helpers\Helper::getCurrencySymbol().number_format(App\Helpers\Helper::getRealPrice($getAllCredit - $getAllSaving),2,'.','');


 ?>
<header>
    <div class="custom-header clearfix">
        <nav>
            <div class="hamberger"><span class="line"></span></div>
            <div class="meu-fixx">
                <section class="blok">
                    <div class="blok-body">
                        <div class="row hidden-xs">
                            <!-- Nav tabs -->
                            <?php 
                            $all_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', '0')->get();
                            $sub = array();
                            
                            $cntCat = 0;
                            $cntSub = 0;
                             ?>
                            <!--  Start category -->
                            <ul class="nav fullHt tab-menu nav-pills col-sm-3 col-xs-3 nav-stacked pr15">
                                <?php foreach($all_category as $key=>$value): ?>

                                <?php 
                                $cntCat++;
                                $sub[] = $value->id;  
                                 ?>
                                    <?php if($cntCat == 1): ?>
                                        <li class="active"  data-toggle="tab"><a href="#<?php echo e($value->id); ?>" onclick='goHere("<?php echo e($value->id); ?>")'><span><?php echo e($value->name); ?></span> 
                                               
                                                <?php if(isset($value->image) && $value->image!=""): ?>
                                                <img src="<?php echo e(url('storage/app/public/category').'/'.$value->image); ?>" alt="bg-images"/>
                                                <?php else: ?>
                                                <img src="<?php echo e(url('public/media/front/img/menu1.jpg')); ?>" alt="bg-images"/>
                                                <?php endif; ?>
                                                </a>
                                        </li>
                                    <?php else: ?>
                                        <li data-toggle="tab"><a href="#<?php echo e($value->id); ?>" onclick='goHere("<?php echo e($value->id); ?>")' ><span><?php echo e($value->name); ?></span> 
                                                <?php if(isset($value->image) && $value->image!=""): ?>
                                                <img src="<?php echo e(url('storage/app/public/category').'/'.$value->image); ?>" alt="bg-images"/>
                                                <?php else: ?>
                                                <img src="<?php echo e(url('public/media/front/img/menu1.jpg')); ?>" alt="bg-images"/>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php /*<?php if($cntCat == 1): ?>   */ ?>
                                <?php /*<li class="active"  data-toggle="tab">*/ ?>
                                    <?php /*<a href="<?php echo e(url('/')); ?>/search-product?category=<?php echo e($value->category_id); ?>"><span><?php echo e($value->name); ?></span> <img src="<?php echo e(url('public/media/front/img/menu1.jpg')); ?>" alt="bg-images"/></a>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<?php else: ?>*/ ?>
                                <?php /*<li data-toggle="tab"><a href="<?php echo e(url('/')); ?>/search-product?category=<?php echo e($value->category_id); ?>" ><span><?php echo e($value->name); ?></span> <img src="<?php echo e(url('public/media/front/img/menu1.jpg')); ?>" alt="bg-images"/></a>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<?php endif; ?>*/ ?>
                                <?php endforeach; ?>  
                            </ul>
                            <!-- Tab panes -->
                            <!--  Start  SUB category -->
                            <div class="tab-content col-sm-9 col-xs-9 fullHt">
                                <?php foreach($sub as $s): ?>
                                <?php 
                                $cntSub++;
                                 ?>

                                <?php if($cntSub == 1): ?>
                                <div class="tab-pane well active in active" id="<?php echo e($s); ?>" style="background-image:url('<?php echo e(url("public/media/front/img/ss-div.jpg")); ?>');">
                                    <div class="iter-tab-vi fullHt" >
                                        <?php  
                                        $all_sub_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', $s)->get();  ?>


                                        <ul class="custome-iner-nav">
                                            <?php foreach($all_sub_category as $value1): ?>
                                            <li><a href="<?php echo e(url('/')); ?>/search-product?category=<?php echo e($value1->category_id); ?>"><?php echo e($value1->name); ?></a>
                                                <div class="inner_sub_menu">
                                                    <div class="row">
                                                        
                                                        <div class="col-md-6">
                                                            <ul>
                                                                <?php 
                                                                $all_child_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', $value1->id)->get();
                                                                 ?>   
                                                                <?php foreach($all_child_category as $child): ?>
                                                                <li>
                                                                    <a href="<?php echo e(url('/')); ?>/search-product?category=<?php echo e($child->category_id); ?>">
                                                                        <?php echo e($child->name); ?>


                                                                    </a>
                                                                </li>     
                                                                <?php endforeach; ?>

                                                            </ul>
                                                        </div>



                                                    </div>
                                                </div>                        	
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>


                                    </div>
                                </div>
                                <?php else: ?>

                                <div class="tab-pane fullHt well fade" id="<?php echo e($s); ?>" style="background-image:url('<?php echo e(url("public/media/front/img/ss-div.jpg")); ?>');">
                                    <div class="iter-tab-vi fullHt" >
                                        <?php  $all_sub_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', $s)->get();  ?>

                                        <ul class="custome-iner-nav">
                                            <?php foreach($all_sub_category as $value1): ?>
                                            <li><a href="<?php echo e(url('/')); ?>/search-product?category=<?php echo e($value1->category_id); ?>"><?php echo e($value1->name); ?></a>
                                                <div class="inner_sub_menu">
                                                    <div class="row">

                                                        <div class="col-md-4">
                                                            <ul>
                                                                <?php 
                                                                $all_child_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', $value1->id)->get();
                                                                 ?>   
                                                                <?php foreach($all_child_category as $child): ?>
                                                                <li>
                                                                    <a href="<?php echo e(url('/')); ?>/search-product?category=<?php echo e($child->category_id); ?>">
                                                                        <?php echo e($child->name); ?>


                                                                    </a>
                                                                </li>     
                                                                <?php endforeach; ?>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>                        	
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>


                                    </div>
                                </div>
                                <?php endif; ?>


                                <?php endforeach; ?> 
                            </div><!--  END SUb category -->

                        </div><!--  END  category --><!-- //row -->

                        <div class="menu-for-mobile-view hidden-sm hidden-md hidden-lg">
                            <ul class="mob-main-menu">
                                <?php 
                                    $all_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', '0')->get();
                                 ?>
                                <?php if(isset($all_category) && count($all_category)>0): ?>
                                    <?php foreach($all_category as $key=>$value): ?>
                                <li>
                                    <?php 
                                        $all_sub_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id',$value->id)->get();
                                     ?>
                                    <a href="#<?php echo e($value->id); ?>" onclick='goHere("<?php echo e($value->id); ?>")'><?php echo e($value->name); ?></a>
                                    <?php if(count($all_sub_category)>0): ?>
                                    <span class="dropper"><i class="fa fa-angle-left"></i></span>
                                    <?php endif; ?>
                                    <ul class="drop-menu" style="display: none;">

                                        <?php if(isset($all_sub_category) && count($all_sub_category)>0): ?>
                                            <?php foreach($all_sub_category as $key1=>$value1): ?>
                                        <li>
                                            <?php 
                                                $all_child_category = \App\PiplModules\category\Models\Category::translatedIn(\App::getLocale())->where('parent_id', $value1->id)->get();
                                             ?>
                                            <a href="#<?php echo e($value1->id); ?>" onclick='goHere("<?php echo e($value1->id); ?>")'><?php echo e($value1->name); ?></a>
                                            <?php if(count($all_child_category)>0): ?>
                                            <span class="dropper"><i class="fa fa-angle-left"></i></span>
                                            <?php endif; ?>
                                                <ul class="dropdown-sub-menu" style="display: none;">

                                                <?php if(isset($all_child_category) && count($all_child_category)>0): ?>
                                                    <?php foreach($all_child_category as $key2=>$value2): ?>
                                                <li>
                                                    <a href="#<?php echo e($value2->id); ?>" onclick='goHere("<?php echo e($value2->id); ?>")'><?php echo e($value2->name); ?></a>
                                                </li>
                                                <?php endforeach; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    </ul>
                                </li>
                                <?php endforeach; ?>
                                <?php endif; ?>

                                <?php /*<li>*/ ?>
                                    <?php /*<a href="javascript:void(0);">jewellery</a>*/ ?>
                                    <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                    <?php /*<ul class="drop-menu" style="display: none;">*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    <?php /*</ul>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<li>*/ ?>
                                    <?php /*<a href="javascript:void(0);">jewellery</a>*/ ?>
                                    <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                    <?php /*<ul class="drop-menu" style="display: none;">*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    <?php /*</ul>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<li>*/ ?>
                                    <?php /*<a href="javascript:void(0);">jewellery</a>*/ ?>
                                    <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                    <?php /*<ul class="drop-menu" style="display: none;">*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    <?php /*</ul>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<li>*/ ?>
                                    <?php /*<a href="javascript:void(0);">jewellery</a>*/ ?>
                                    <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                    <?php /*<ul class="drop-menu" style="display: none;">*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    <?php /*</ul>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<li>*/ ?>
                                    <?php /*<a href="javascript:void(0);">jewellery</a>*/ ?>
                                    <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                    <?php /*<ul class="drop-menu" style="display: none;">*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    <?php /*</ul>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<li>*/ ?>
                                    <?php /*<a href="javascript:void(0);">jewellery</a>*/ ?>
                                    <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                    <?php /*<ul class="drop-menu" style="display: none;">*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    <?php /*</ul>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<li>*/ ?>
                                    <?php /*<a href="javascript:void(0);">jewellery</a>*/ ?>
                                    <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                    <?php /*<ul class="drop-menu" style="display: none;">*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    <?php /*</ul>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<li>*/ ?>
                                    <?php /*<a href="javascript:void(0);">jewellery</a>*/ ?>
                                    <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                    <?php /*<ul class="drop-menu" style="display: none;">*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    <?php /*</ul>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<li>*/ ?>
                                    <?php /*<a href="javascript:void(0);">jewellery</a>*/ ?>
                                    <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                    <?php /*<ul class="drop-menu" style="display: none;">*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    <?php /*</ul>*/ ?>
                                <?php /*</li>*/ ?>
                                <?php /*<li>*/ ?>
                                    <?php /*<a href="javascript:void(0);">jewellery</a>*/ ?>
                                    <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                    <?php /*<ul class="drop-menu" style="display: none;">*/ ?>
                                        <?php /*<li>*/ ?>
                                            <?php /*<a href="javascript:void(0);">jewellery 1</a>*/ ?>
                                            <?php /*<span class="dropper"><i class="fa fa-angle-left"></i></span>*/ ?>
                                            <?php /*<ul class="dropdown-sub-menu" style="display: none;">*/ ?>
                                                <?php /*<li><a href="javascript:void(0);">jewellery 1.1</a></li>*/ ?>
                                            <?php /*</ul>*/ ?>
                                        <?php /*</li>*/ ?>
                                    <?php /*</ul>*/ ?>
                                <?php /*</li>*/ ?>

                            </ul>


                            <!-- <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel">
                                    <div class="panel-heading" role="tab">                      
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#main1">      
                                            <i class="fa fa-angle-down"></i> 
                                            Jewellery
                                        </a>
                                    </div>
                                    <div id="main1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">

                                            
                                            <div class="panel-group sub-menu-mobile" id="accordion1" role="tablist" aria-multiselectable="true">
                                                <div class="panel">
                                                    <div class="panel-heading" role="tab">                         
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#sub1">
                                                            <i class="fa fa-angle-down"></i>  
                                                            Jewellery 1
                                                        </a>
                                                    </div>
                                                    <div id="sub1" class="panel-collapse collapse sub-collaps" role="tabpanel" aria-labelledby="headingOne">
                                                        <div class="panel-body">
                                                            <a href="javascript:void(0);">Jewellery 1.1</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>                     


                    </div><!-- blok-body // -->
                </section>
            </div>
            <form method="get" action="<?php echo e(url('search-product')); ?>" id="frm_front_search">
                <div class="search_bar relative">
                    <input type="text" class="form-control" placeholder="Search By Product Name.." name="name" title="Search By Product Name or leave blank to view all Products"/>
                    <span><a href="javascript:void(0)" class="search_btn" onclick="returnSubmit()">
                    <i class="fa fa-search"></i></a></span>
                    <input type="submit" style="display:none;">
                </div>          
            </form>
              
            <form  method="get" action="<?php echo e(url('search-product')); ?>" id="searchs" class="hidden-lg hidden-xs hidden-sm search-form">
                <div class="form-group has-feedback">
            		<label for="search" class="sr-only">Search By Product Name or leave blank to view all Products</label>
            		<input type="text" class="form-control" name="name" id="search" placeholder="Search By Product Name..">
              		<a href="javascript:void(0)" class="search_btn" onclick="returnSubmit()"><span class="glyphicon glyphicon-search form-control-feedback"></span></a>			 <input type="submit" style="display:none;">
            	</div>
            </form>
            <script>
                function  returnSubmit()
                {
                    $("#frm_front_search").submit();
                }
            </script>  
              <script>
                function  returnSubmit()
                {
                    $("#searchs").submit();
                }
            </script>          
            <div class="logo"><a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(url('/')); ?>/public/media/front/img/logo.png" alt="logo here"/></a></div>

            <?php /*<div class="right_nav pull-right">*/ ?>
                <?php /*<ul>*/ ?>
                    <?php /*<li><a href="<?php echo e(url('/wishlist')); ?>">Wishlist</a></li>*/ ?>
                    <?php /*<li><a href="javascript:void(0);">Request Appointment</a></li>*/ ?>
                    <?php /*<li><a href="<?php echo e(url('/cart')); ?>"><img src="<?php echo e(url('/')); ?>/public/media/front/images/cart-icon.png" width="18"> <span class="icon-cart-num" id="cart_count"><?php echo e($totalAmount); ?></span></a></li>*/ ?>
                    <?php /*<!--Authentication Links--> */ ?>
                    <?php /*<?php if(Auth::guest()): ?>*/ ?>
                    <?php /*<li><a href="<?php echo e(url('/login')); ?>">Sign In</a></li>*/ ?>
                    <?php /*<?php else: ?>*/ ?>
                    <?php /*<li class="dropdown">*/ ?>
                        <?php /*<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">*/ ?>
                            <?php /*Hello &nbsp;  <?php echo e(Auth::User()->UserInformation->first_name); ?> <span class="caret"></span>*/ ?>
                        <?php /*</a>*/ ?>

                        <?php /*<ul style="background-color: black;color: white"  class="dropdown-menu" role="menu">*/ ?>
                            <?php /*<li ><a href="<?php echo e(url('/profile')); ?>"><i class="fa fa-btn fa-user"></i>My Profile</a></li>*/ ?>
                            <?php /*<li><a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>*/ ?>
                        <?php /*</ul>*/ ?>
                    <?php /*</li>*/ ?>
                    <?php /*<?php endif; ?>*/ ?>
                <?php /*</ul>*/ ?>
            <?php /*</div>*/ ?>
            <div class="sining-opt hidden-lg">
                <a href="javascript:void(0);"><i class="fa fa-user"></i></a>
            </div>
            <div class="right_nav pull-right">
                <ul>
                <!--<li><a href="<?php echo e(url('/wishlist')); ?>">Wishlist</a></li>-->
                    <li><a href="<?php echo e(url('/get-appointment/book-business-appointment')); ?>">Request Appointment</a></li>
                <?php /*<!--<li class="h-mg-cart"><a href="<?php echo e(url('/cart')); ?>"><!--<img src="<?php echo e(url('/')); ?>/public/media/front/images/cart-icon.png" width="18">-->*/ ?>
                    <?php /*<!--<span class="header-cart"><i class="fa fa-shopping-basket"></i></span>*/ ?>
                    <?php /*<span class="icon-cart-num header-cart-count cart-move" id="cart_count"> 1 </span></a></li>-->*/ ?>
                    <?php /*<!--Authentication Links-->*/ ?>
                    <?php if(Auth::guest()): ?>
                        <?php /*<li><a href="<?php echo e(url('/login')); ?>">Sign In</a></li>*/ ?>
                        <li class="dropdown h-mg-header">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                User <span class="caret"></span>
                            </a>
                            <ul style="background-color: black;color: white"  class="dropdown-menu" role="menu">
                                <li><a href="<?php echo e(url('/login')); ?>">Sign In</a></li>
                                <li><a href="<?php echo e(url('/order/view-orders')); ?>"><i class="fa fa-btn fa-user"></i> Manage Order</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Hello <?php echo e(Auth::User()->UserInformation->first_name); ?> <span class="caret"></span>
                            </a>

                            <ul style="background-color: black;color: white"  class="dropdown-menu" role="menu">
                                <li><a href="<?php echo e(url('/profile')); ?>"><i class="fa fa-btn fa-user"></i> My Profile</a></li>
                                <li><a href="<?php echo e(url('/order/view-orders')); ?>"><i class="fa fa-btn fa-user"></i> Manage Order</a></li>
                                <li><a href="<?php echo e(url('/gift-card-list')); ?>"><i class="fa fa-btn fa-user"></i> Gift Card</a></li>
                                <li><a href="<?php echo e(url('/profile')); ?>"><i class="fa fa-btn fa-user"></i> Option 2</a></li>
                                <li><a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="h-mg-cart">
                <a href="<?php echo e(url('/cart')); ?>"><!--<img src="<?php echo e(url('/')); ?>/public/media/front/images/cart-icon.png" width="18">-->
                    <span class="header-cart"><!--<i class="fa fa-shopping-basket"></i>-->
                        <img class="cart_img" src="<?php echo e(url('/')); ?>/public/media/front/img/shop-bag.png">
                    </span>

                    <span class="icon-cart-num header-cart-count cart-move" id="cart_count"><?php echo e($totalCount); ?></span>
                </a>
                <?php if(isset($cart) && count($cart)>0): ?>
                <?php if(count($cart->cartItems)>0): ?>
                <div class="h-mgt-cart-list">
                    <div class="cart-table table-responsive mCustomScrollbar">
                        <table>
                            <tbody>
                                <?php foreach($cart->cartItems as $item): ?>
                                   <?php if(isset($item->product)): ?>
                                <tr class="border-all">
                                    <td class="pro-thumbnail"><a href="#"><img alt="product image" <?php if(isset($item->product)): ?> src="<?php echo e(url('storage/app/public/product/image').'/'.$item->product->productDescription->image); ?>" <?php endif; ?>></a></td>
                                    <td class="pro-title">
                                        <strong><?php if(isset($item->product)): ?><?php echo e($item->product->name); ?> <?php endif; ?></strong>
                                        <div class="h-ct h-ct-price"><span>Price:</span><?php echo e(App\Helpers\Helper::getCurrencySymbol(). number_format(App\Helpers\Helper::getRealPrice($item->product_amount),2,'.','')); ?></div>
                                        <div class="h-ct h-ct-size"><span>Size:</span><?php if($item->product_size_name != null): ?> <?php echo e($item->product_size_name); ?> <?php endif; ?></div>
                                        <div class="h-ct h-ct-color"><span>Color:</span><?php if($item->product_color_name != null): ?><?php echo e($item->product_color_name); ?> <?php endif; ?></div>
                                        <div class="h-ct h-ct-qrty"><span>Quantity:</span><?php echo e($item->product_quantity); ?></div>
                                    </td>
                                    <td class="pro-remove" style="vertical-align: top; text-align: right;"><a id="rm-cart-item_<?php echo e($item->id); ?>" onclick="removeCartItemFromHeader(id)"><img src="public/media/front/img/cancel.png" width="12px" alt="close"></a></td>
                                </tr>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>                        
                    </div>
                    <div class="h-cart-price">
                        <ul class="">
                            <li class="price-li clearfix">
                                <div class="h-qty-view clearfix">
                                    <span class="ct-qty-blk pull-left">Qty:</span>
                                    <span class="ct-qty-blk pull-right"> <?php echo e($totalCount); ?></span>
                                </div>
                                <div class="h-ct-total pull-left">Total:</div>
                                <div class="h-ct-total-cost pull-right"> <?php echo e($grandTotal); ?> </div>
                            </li>
                            <li><a href="<?php echo e(url('/cart')); ?>" type="button" class="btn view-bag-pay">view bag / pay securely</a></li>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if(!Auth::guest()): ?>

            <div class="h-mg-wishlist">
                <a href="<?php echo e(url('/wishlist')); ?>"><i class="fa fa-heart-o" title="wishlist"></i></a>
                <?php if(isset($wishlist) && count($wishlist)>0): ?>
                    <?php  $total =0;$cnt=0;  ?>
                <div class="h-mgt-cart-list">
                    <div class="cart-table table-responsive mCustomScrollbar">
                        <table>
                            <tbody>
                            <?php foreach($wishlist as $wish): ?>
                                <?php 
                                    $total +=floatval($wish->product_amount) * floatval($wish->product_quantity);
                                    $total = App\Helpers\Helper::getCurrencySymbol().number_format(App\Helpers\Helper::getRealPrice($total),2,'.','');
                                   $cnt +=$wish->product_quantity;
                                 ?>
                                <tr class="border-all">
                                    <td class="pro-thumbnail"><a href="#"><img alt="product image" <?php if($wish->product): ?> src="<?php echo e(url('storage/app/public/product/image').'/'.$wish->product->productDescription->image); ?>" <?php endif; ?>></a></td>
                                    <td class="pro-title">
                                        <strong><?php if(!empty($wish->product->name)): ?><?php echo e($wish->product->name); ?> <?php endif; ?></strong>
                                        <div class="h-ct h-ct-price"><span>Price:</span><?php if(!empty($wish->product_amount)): ?> <?php echo e(App\Helpers\Helper::getCurrencySymbol(). number_format(App\Helpers\Helper::getRealPrice($wish->product_amount),2,'.','')); ?> <?php endif; ?></div>
                                        <div class="h-ct h-ct-size"><span>Size:</span> <?php if(!empty($wish->product_size_name)): ?> <?php echo e($wish->product_size_name); ?> <?php endif; ?></div>
                                        <div class="h-ct h-ct-color"><span>Color:</span> <?php if(!empty($wish->product_color_name)): ?> <?php echo e($wish->product_color_name); ?> <?php endif; ?></div>
                                        <div class="h-ct h-ct-qrty"><span>Quantity:</span> <?php if(!empty($wish->product_quantity)): ?>  <?php echo e($wish->product_quantity); ?> <?php endif; ?></div>
                                    </td>
                                    <td class="pro-remove" style="vertical-align: top; text-align: right;"><a href="#"><img src="public/media/front/img/cancel.png" width="15px" alt="close"></a></td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                        </table>                        
                    </div>
                    <div class="h-cart-price">
                        <ul class="">
                            <li class="price-li clearfix">
                                <div class="h-qty-view clearfix">
                                    <span class="ct-qty-blk pull-left">Qty:</span>
                                    <span class="ct-qty-blk pull-right"><?php echo e($cnt); ?></span>
                                </div>
                                <div class="h-ct-total pull-left">Total:</div>
                                <div class="h-ct-total-cost pull-right"><?php echo e($total); ?></div>
                            </li>
                            <li><a href="<?php echo e(url('/wishlist')); ?>" type="button" class="btn view-bag-pay">view bag / pay securely</a></li>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </nav>
        <div class="custom-search hidden-sm hidden-md hidden-lg">
            <div class="input-group input-group-sm">
              <input id="ser-inp-field" type="text" class="form-control" placeholder="Search by product name">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
        </div>
    </div>
</header>
<script>
    function getActive(id)
    {
//        $("#"+id).show();
    }
    function removeCartItemFromHeader(id)
    {
        cartItemId =id.split('_').pop();
        $.ajax({
            url: '<?php echo e(url("/remove-cart-item")); ?>',
            type: "get",
            dataType: "json",
            data: {
                cart_item_id: cartItemId
            },
            success: function(response) {
                if(response.success=="1"){
                    window.location.href = window.location.href
                }
                else{
                    alert(response.msg);
                    window.location.href = window.location.href
                }
            }
        });
    }

</script> 

