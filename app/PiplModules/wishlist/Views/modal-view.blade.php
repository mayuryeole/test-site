<form method="post" action="{{url('ajax-update-wishlist')}}" >
    {!!csrf_field() !!}
    <input type="hidden" value="{{ $ajaxProduct[0]['id'] }}" name="id">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><img src="{{ url('public/media/front/img/cancel.png') }}" alt="close"></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="gal-img">
                            <div class="cust-detail-slide">
                                <div id="carousel" class="carousel slide propertySlider" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="item active">
                                            <img src="{{ url('storage/app/public/product/image/') }}/{{$ajaxProduct[0]['image']}}">
                                        </div>                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="h-product-details">
                            <div class="h-product-heading"><h2 class="h-section-title">{{ $ajaxProduct[0]['name'] }}</h2></div>
                            <div class="h-product-rating">
                                <span><i class="fa fa-star"></i></span>
                                <span><i class="fa fa-star"></i></span>
                                <span><i class="fa fa-star"></i></span>
                                <span><i class="fa fa-star"></i></span>
                                <span><i class="fa fa-star"></i></span>
                                <div class="h-product-review">Be the first to review this product</div>
                            </div>
                            <div class="h-price">
                            @if($ajaxProduct[0]['is_original'] == 1)
                                {{ $ajaxProduct[0]['discount_rate'] }}
                                {!! $ajaxProduct[0]['price'] !!}
                                {{ $ajaxProduct[0]['discount_percent'] }}
                            @else
                                {{ $ajaxProduct[0]['price'] }}
                            @endif                            
                            </div>
                            <div class="h-product-availability">
                                <ul class="h-stock-detail">
                                    <!-- <li>
                                        <i class="fa fa-stack-exchange"></i>
                                        <span>Only 15 Left</span>
                                    </li> -->
                                    <li>
                                        <span class="h-prod-status">Available:</span>
                                        <span class="h-green">
                                            @if($ajaxProduct[0]['availability'] == 1)
                                            {{ "Out Of Stock" }}
                                            @else
                                            {{ "In Stock" }}
                                            @endif
                                        </span>
                                    </li>
                                </ul>
                            </div>
                           {{-- <div class="h-product-description">
                                <p>{{ $ajaxProduct[0]['short_description'] }}</p>
                            </div>  --}}
                            <div class="product-options">
                            @if(isset($ajaxProduct[0]['colors']))                                
                                <div class="color-optn font-2">
                                    <label> <span class="option"> Color </span> <span class="red-color"></label>
                                    <ul class="list-unstyled">
                                        @if(isset($ajaxProduct[0]['colors']))
                                        @foreach($ajaxProduct[0]['colors'] as $c)
                                        <img src="{{url('')}}" id="image_{{$ajaxProduct[0]['id']}}" onclick="changeImage('{{$c['color']}}','{{$ajaxProduct[0]['id']}}')">
                                        
                                        <!--<p style=""> {{ $c['color'] }} </p>-->
                                        @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @endif    
                            @if(isset($ajaxProduct['attribute_name']))  
                                <div class="size-optn font-2">
                                    <label> <span class="option"> SIZE OPTIONS </span> </label>
                                    <ul class="list-inline">
                                    <?php
                                    for($i=0;$i<count($ajaxProduct['attribute_name']);$i++){
                                        ?>
                                        <p style=""> {{ $ajaxProduct['attribute_name'][$i] }} : {{ $ajaxProduct['attribute_value'][$i] }}</p>
                                    <?php }
                                    ?>
                                    </ul>
                                </div>
                            @endif    

                            </div>
                            <div class="h-product-buttons clearfix">
                                <div class="h-quantity">
                                    <button type="button" class="h-minus-pro"><i class="icon-substract"></i></button>
                                    <input type="text" class="form-control" value="1"/>
                                    <button type="button" class="h-plus-pro"><i class="icon-add"></i></button>
                                </div>
                                <div class="h-add-cart">
                                    <button class="h-cart-btn" type="button">Update Wishlist</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function changeImage(color,product)
    {
         $.ajax({
            type:"get",
            url: javascript_site_path + 'get-product-image',
            dataType:'json',
            data:{
                color_id: color,
                product_id : product_id
            },
            success:function(res)
            {
                $('#image_'+product).attr('src', res.src);
            }  
        });
    }
</script>    