
       @if(isset(Auth::user()->userWishlist) && count(Auth::user()->userWishlist)>0)
            @foreach(Auth::user()->userWishlist as $wishlist)
            <div class="row">
            <img src="{{url('storage/app/public/product/image/'.$wishlist->productDescription->image)}}" />
                {{$wishlist->productDescription->description}}
                <span>{{$wishlist->productDescription->price}}</span> 
                <button type="button" onclick="removeFromWishlist('{{$wishlist->product_id}}')"> Remove </button>  
            </div>        
            @endforeach
       @endif
 
