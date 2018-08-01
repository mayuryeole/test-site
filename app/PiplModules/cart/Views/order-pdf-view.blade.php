@php
         $order_items = null;
        if(isset($order) && count($order)>0){
                       $order_items=  \App\PiplModules\cart\Models\OrderItem::where('order_id',$order->id)->get();
        }

@endphp
@if(isset($order_items) && count($order_items)>0)
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group  clearfix @if ($errors->has('title')) has-error @endif">
                                <div class="s-prod-list-table table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Weight</th>
                                            <th>Quantity</th>
                                            <th style="text-align: right;">Price</th>
                                        </tr>
                                        </thead>
                                        @foreach($order_items as $o)
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="s-div">
                                                    @if(isset($o->product->name) && $o->product->name!="")
                                                    {{$o->product->name}}
                                                    @else
                                                    -
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="s-div">
                                                    @if(isset($o->product->weight) && $o->product->weight!="")
                                                    {{$o->product->weight}}
                                                    @else
                                                    -
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="s-div">
                                                    @if(isset($o->product_quantity) && $o->product_quantity!="")
                                                    {{$o->product_quantity}}
                                                    @else
                                                    -
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="s-div" style="text-align: right;">
                                                    @if(isset($o->product->productDescription->price) && $o->product->productDescription->price!="")
                                                    {{$o->product->productDescription->price}}
                                                    @else
                                                    -
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                        @endforeach
                                        <tfoot>

                                        <tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">TOTAL AMOUNT</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    @if(isset($order->order_subtotal) && $order->order_subtotal!='')
                                                    <span class="s-count-right">{{ $order->order_subtotal }}</span>
                                                    @else
                                                    <span class="s-count-right">0.00</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">ESTIMATED SHIPPING COST</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    @if(isset($order->order_shipping_cost) && $order->order_shipping_cost!='')
                                                    <span class="s-count-right">{{ $order->order_shipping_cost }}</span>
                                                    @else
                                                    <span class="s-count-right">0.00</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">COUPON AMOUNT</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    @if(isset($order->coupon_amount) && $order->coupon_amount!='')
                                                    <span class="s-count-right">{{ $order->coupon_amount }}</span>
                                                    @else
                                                    <span class="s-count-right">0.00</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">PROMO CODE AMOUNT</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    @if(isset($order->promo_amount) && $order->promo_amount!='')
                                                    <span class="s-count-right">{{ $order->promo_amount }}</span>
                                                    @else
                                                    <span class="s-count-right">0.00</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">GIFT VOUCHER AMT</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    @if(isset($order->gift_card_amount) && $order->gift_card_amount!='')
                                                    <span class="s-count-right">{{ $order->gift_card_amount }}</span>
                                                    @else
                                                    <span class="s-count-right">0.00</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">REFFER POINTS AMOUNT</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-count-right">0.00</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">PACKAGING COST</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    @if((isset($order->box_amount) && $order->paper_amount!='') || (isset($order->box_amount) && $order->paper_amount!=''))
                                                    <span class="s-count-right">{{ floatval($order->box_amount) + floatval($order->paper_amount)}}</span>
                                                    @else
                                                    <span class="s-count-right">0.00</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">DISPLAY COST</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    @if(isset($order->display_amount) && $order->display_amount!='')
                                                    <span class="s-count-right">{{ $order->display_amount }}</span>
                                                    @else
                                                    <span class="s-count-right">0.00</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">TAXES</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    @if(isset($order->order_tax) && $order->order_tax!='')
                                                    <span class="s-count-right">{{ $order->order_tax }}</span>
                                                    @else
                                                    <span class="s-count-right">0.00</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">TOTAL SAVINGS</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    @if(isset($order->order_discount) && $order->order_discount!='')
                                                    <span class="s-count-right">{{ $order->order_discount }}</span>
                                                    @else
                                                    <span class="s-count-right">0.00</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr><tr>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    <span class="s-head-left">Grand Total</span>
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <div class="s-div" style="text-align:right">
                                                    @if(isset($order->order_total) && $order->order_total!='')
                                                    <span class="s-count-right">{{ $order->order_total }}</span>
                                                    @else
                                                    <span class="s-count-right">0.00</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

