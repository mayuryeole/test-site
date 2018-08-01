<?php

namespace App\Http\Middleware;

use App\PiplModules\cart\Models\Cart;
use App\PiplModules\cart\Models\CartItem;
use App\PiplModules\product\Models\Product;
use App\PiplModules\wishlist\Models\Wishlist;
use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Helpers\Helper;

class GlobalCurrencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cart = null;
        $wishlist = null;
        if(Session::has('universal_currency') == false)
        {
            Helper::setSessionDefaultCurrency();
        }

        if(Auth::check())
        {
            $cart = Cart::where('customer_id',Auth::user()->id)->first();
            $wishlist_items = Wishlist::where('customer_id',Auth::user()->id)->get();

            if (isset($wishlist_items) && count($wishlist_items) > 0)
            {
                  foreach ($wishlist_items as $items)
                  {
                      $product = Product::where('id',$items->product_id)->FilterProductStatus()->FilterHideProduct()->FilterHideProductPrice()->first();
                      if(!$product)
                      {
                          $items->delete();
                      }
                  }
            }
        }
        else
        {
            $ip_address = $request->ip();
            $cart = Cart::where('ip_address',$ip_address)->first();
        }

        if(isset($cart) && count($cart)>0)
        {
//            dd($cart);

           $cart_items = CartItem::where('cart_id',$cart->id)->get();
           foreach ($cart_items as $item)
           {
               $product = Product::where('id',$item->product_id)->FilterProductStatus()->FilterHideProduct()->FilterHideProductPrice()->first();
               if(!$product)
               {
                   $item->delete();
               }
           }
        }
        return $next($request);
    }
}
