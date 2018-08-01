<?php
namespace App\PiplModules\cart\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model 
{
	
	protected $fillable = ['customer_id','admin_discount', 'shipping_name','shipping_email','shipping_address1','shipping_address2','shipping_city','shipping_state','shipping_zip','shipping_telephone','shipping_country','shipping_iso2','billing_name','billing_address1','billing_address2','billing_city','billing_state','billing_zip','billing_country','billing_iso2'];
	
        public function cartItems()
        {
            return $this->hasMany('App\PiplModules\cart\Models\CartItem');
        }
        public function user(){
            return $this->belongsTo('App\User','user_id');
        }
        
        public function getTotalItems($id)
        {
            $cart_items = CartItem::where('cart_id',$id)->get();
            $total_count=0;
            if(count($cart_items)>0)
            {
                foreach($cart_items as $cart_item)
                {
                    $total_count += $cart_item->product_quantity;
                }
            }
            return $total_count;
        }
}