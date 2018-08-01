<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
@php
    $order_items = null;
    $total_qty = 0;
    $total_unit_prize = 0;
   if(isset($order) && count($order)>0){
                  $order_items=  \App\PiplModules\cart\Models\OrderItem::where('order_id',$order->id)->get();
   }
@endphp
<body>
@if(isset($order) && count($order)>0)
<section class="invoice-container" style="/*background-color: #f1f1f1;*/ width: 95%; margin: 0px auto;">
    <div class="title" style="text-transform:uppercase; font-weight: 600; font-size: 16px; color: #353535; text-align: center; padding: 7px 0px;
		">
        Invoice
    </div>
    <div class="title" style="text-transform:capitalize; font-weight: 400; font-size: 13px; color: #353535; text-align: center;
		; border-width:1px 0px 1px 0px; border-style: solid; border-color: #353535;padding: 5px 0px;">
        <span style="text-transform: uppercase;">COD SHIPMENT</span> - (Collect only cash on delivery)
    </div>
    <!------------Identity Table---------------->
    <table class="identity-table" style="width: 100%; font-size:13px">
        <tr>
            <th width="33.33%"></th>
            <th width="33.33%"></th>
            <th width="33.33%"></th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <div class="logo" style="width: 200px; padding: 0 15px; background-color: #353535;">
                    <a href="javascript:void(0);"><img src="{{ url('/public/media/front/img/logo.png') }}" style="width: 100%;"></a>
                </div>
                <div class="address" style="margin-top:15px;">
                    <p style="margin: 0; line-height: 15px;"><strong style="text-transform: uppercase;">
                            Chawla's International</strong>
                    </p>
                    <p style="margin: 0; line-height: 15px;">Unit No 20/21 , Eastern Plaza,</p>
                    <p style="margin: 0; line-height: 15px;">Daftary Road , Malad (East),</p>
                    <p style="margin: 0; line-height: 15px;">Mumbai - 400097. MH, India</p>
                </div>
            </td>
            <td style="vertical-align: top;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;">
                        <strong style="text-transform: capitalize;">Order Date :</strong>{{ $order->created_at }}
                    </p>
                    <p style="margin: 0; line-height: 15px;">
                        <strong style="text-transform: capitalize;">Invoice Date :</strong>{{ $order->created_at }}
                    </p>
                    <p style="margin: 0; line-height: 15px;">
                        <strong style="text-transform: capitalize;">Invoice No. Bar Code</strong>
                    </p>
                </div>
                <div class="logo" style="width: 300px; margin-top: 15px;">
                    <!-- <a href="javascript:void(0);"><img src="bar-code.jpg" style="width: 100%;"></a> -->
                    <a href="https://www.barcodesinc.com/generator/"><img src="https://www.barcodesinc.com/generator/image.php?code=harshad jagtap&style=197&type=C128B&width=232&height=50&xres=1&font=3" border="0"></a>
                </div>
                <div class="address" style="margin-top: 15px;">
                    <p style="margin: 0; line-height: 15px;">
                        <strong style="text-transform: capitalize;">Order Id :</strong> {{ $order->id }}
                    </p>
                    <p style="margin: 0; line-height: 15px;">
                        <strong style="text-transform: capitalize;">Order Id Bar Code :</strong> {{ $order->created_at }}
                    </p>
                    <p style="margin: 0; line-height: 15px;">
                        <strong style="text-transform: capitalize;">Invoice No. Bar Code</strong>
                    </p>
                </div>
                <div class="logo" style="width: 300px; margin-top: 15px;">
                    <a href="https://www.barcodesinc.com/generator/"><img src="https://www.barcodesinc.com/generator/image.php?code=harshad jagtap&style=197&type=C128B&width=232&height=50&xres=1&font=3" border="0"></a>
                </div>
            </td>
            <td style="vertical-align: top;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;"><strong style="text-transform: uppercase;">
                            Shipping Details</strong>
                    </p>
                    <p style="margin: 0; line-height: 15px;">
                        <strong style="text-transform: capitalize;">Shiped By :</strong> Delivery
                    </p>
                    <p style="margin: 0; line-height: 15px;">
                        <strong style="text-transform: capitalize;">Routing Code :</strong> NA
                    </p>
                    <p style="margin: 0; line-height: 15px;">
                        <strong style="text-transform: capitalize;">AWB Tracking No :</strong> NA
                    </p>
                </div>
                <div class="logo" style="width: 300px; margin-top: 15px;">
                    <!-- <a href="javascript:void(0);"><img src="bar-code.jpg" style="width: 100%;"></a> -->
                    <a href="https://www.barcodesinc.com/generator/"><img src="https://www.barcodesinc.com/generator/image.php?code=harshad jagtap&style=197&type=C128B&width=232&height=50&xres=1&font=3" border="0"></a>
                </div>
            </td>
        </tr>
    </table>

    <!------------Identity Table---------------->
    <table class="identity-table" style="width: 100%; text-align: left;font-size:13px " cellspacing="0">
        <tr>
            <th width="50%" style="border: 1px solid #353535; height: 25px; padding: 0 10px;">Shipping Address</th>
            <th width="50%" style="border: 1px solid #353535; border-left: 0px; height: 25px; padding: 0 10px;">Billing Address</th>
        </tr>
        <tr>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height: 15px; padding:10px 10px;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;"><strong style="text-transform: uppercase;">
                           {{ $order->shipping_name }}</strong>
                    </p>
                    <p style="margin: 0; line-height: 15px;">{{ $order->shipping_address1 }},</p>
                    <p style="margin: 0; line-height: 15px;">{{ $order->shipping_address2 }},</p>
                    <p style="margin: 0; line-height: 15px;">{{ $order->shipping_city }} - {{ $order->shipping_zip }}. {{ $order->shipping_state }}, {{ $order->shipping_country }}</p>
                    <p style="margin: 0; line-height: 15px;">{{ $order->shipping_email }}</p>
                    <p style="margin: 0; line-height: 15px;">{{ $order->shipping_telephone }}</p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 15px; padding:10px 10px;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;"><strong style="text-transform: uppercase;">
                            {{ $order->billing_name }}</strong>
                    </p>
                    <p style="margin: 0; line-height: 15px;">{{ $order->billing_address1 }},</p>
                    <p style="margin: 0; line-height: 15px;">{{ $order->billing_address2 }},</p>
                    <p style="margin: 0; line-height: 15px;">{{ $order->billing_city }} - {{ $order->billing_zip }}. {{ $order->billing_state }}, {{ $order->billing_country }}</p>
                    <p style="margin: 0; line-height: 15px;">{{ $order->billing_email }}</p>
                    <p style="margin: 0; line-height: 15px;">{{ $order->billing_telephone }}</p>
                </div>
            </td>
        </tr>
    </table>

    <!------------Value Table---------------->
    @if(isset($order_items) && count($order_items)>0)
    <table class="identity-table" style="width: 100%; text-align: left; font-size:13px" cellspacing="0">

        <tr>
            <th width="30%" style="border: 1px solid #353535; height: 25px; padding: 0 10px;border-top: 0px;">Product Name</th>
            <th width="10%" style="border: 1px solid #353535; border-left: 0px; height: 25px; padding: 0 10px;border-top: 0px;">Product SKU</th>
            <th width="10%" style="border: 1px solid #353535; border-left: 0px; height: 25px; padding: 0 10px;border-top: 0px;">Product Color</th>
            <th width="10%" style="border: 1px solid #353535; border-left: 0px; height: 25px; padding: 0 10px;border-top: 0px;">Product Size</th>
            <th width="10%" style="border: 1px solid #353535; border-left: 0px; height: 25px; padding: 0 10px; border-top: 0px;text-align: right">Quantity</th>
            <th width="15%" style="border: 1px solid #353535; border-left: 0px; height: 25px; padding: 0 10px;border-top: 0px; text-align: right">Unit Price</th>
            <th width="15%" style="border: 1px solid #353535; border-left: 0px; height: 25px; padding: 0 10px;border-top: 0px; text-align: right">Total</th>
        </tr>

        @foreach($order_items as $item)
            @php
                $total_qty +=isset($item->product_quantity)?$item->product_quantity:0;
                $total_unit_prize +=isset($item->product_amount)?floatval(trim($item->product_amount)):0;
            @endphp

        <tr>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height: 15px; padding:10px 10px;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;">@if(!empty($item->product->name)){{ $item->product->name }} @endif</p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 15px; padding:10px 10px;">
                <div class="address" style="">
                    <p style="margin: 0; line-height:15px;">@if(!empty($item->product->productDescription->sku)) {{ $item->product->productDescription->sku }} @endif</p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 15px; padding:10px 10px; text-align: right;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;">@if(!empty($item->product_color_name)) {{ $item->product_color_name }} @endif</p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 15px; padding:10px 10px; text-align: right;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;">@if(!empty($item->product_size_name)) {{ $item->product_size_name }} @endif</p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 15px; padding:10px 10px; text-align: right;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;">@if(!empty($item->product_quantity)) {{ $item->product_quantity }} @endif</p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 15px; padding:10px 10px; text-align: right;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;">@if(!empty($item->product_amount)) {{ number_format($item->product_amount,2,'.','') }} @endif</p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 15px; padding:10px 10px; text-align: right;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;">@if(!empty($item->product_quantity) && !empty($item->product_amount)) {{ number_format($item->product_quantity * $item->product_amount,2,'.','')}} @endif</p>
                </div>
            </td>
        </tr>
      @endforeach
        <tr>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height: 15px; padding:10px 10px;" colspan="4">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;">Total</p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 15px; padding:10px 10px; text-align: right;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;"><strong>@if(!empty($total_qty)){{ $total_qty }} @else {{ 0 }}@endif</strong>
                    </p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 15px; padding:10px 10px; text-align: right;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;"><strong>{{ $total_unit_prize }}</strong></p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 15px; padding:10px 10px; text-align: right;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;"><strong>@if(!empty($order->order_subtotal)){{ $order->order_subtotal }} @else {{ 0 }} @endif</strong></p>
                </div>
            </td>
        </tr>
        @if(!empty($order->order_shipping_cost)&& $order->order_shipping_cost !='')
        <tr>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height:15px; padding:10px 10px; text-align: right;" colspan="6">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;"><strong>Shipping Charges</strong></p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 20px; padding:10px 10px; text-align: right;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 20px;">{{ $order->order_shipping_cost }}
                    </p>
                </div>
            </td>
        </tr>
        @endif
        @if(!empty($order->coupon_amount)&& $order->coupon_amount !='')
            <tr>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height:15px; padding:10px 10px; text-align: right;" colspan="6">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 15px;"><strong>Coupon Amount</strong></p>
                    </div>
                </td>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 20px; padding:10px 10px; text-align: right;">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 20px;">{{ $order->coupon_amount }}
                        </p>
                    </div>
                </td>
            </tr>
        @endif
        @if(!empty($order->promo_amount)&& $order->promo_amount !='')
            <tr>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height:15px; padding:10px 10px; text-align: right;" colspan="6">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 15px;"><strong>Promo Amount</strong></p>
                    </div>
                </td>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 20px; padding:10px 10px; text-align: right;">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 20px;">{{ $order->promo_amount }}
                        </p>
                    </div>
                </td>
            </tr>
        @endif
        @if(!empty($order->gift_card_amount)&& $order->gift_card_amount !='')
            <tr>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height:15px; padding:10px 10px; text-align: right;" colspan="6">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 15px;"><strong>Gift Card Amount</strong></p>
                    </div>
                </td>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 20px; padding:10px 10px; text-align: right;">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 20px;">{{ $order->gift_card_amount }}
                        </p>
                    </div>
                </td>
            </tr>
        @endif
        @if(!empty($order->box_amount)&& $order->box_amount !='')
            <tr>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height:15px; padding:10px 10px; text-align: right;" colspan="6">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 15px;"><strong>Box Amount</strong></p>
                    </div>
                </td>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 20px; padding:10px 10px; text-align: right;">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 20px;">{{ $order->box_amount }}
                        </p>
                    </div>
                </td>
            </tr>
        @endif
        @if(!empty($order->paper_amount)&& $order->paper_amount !='')
            <tr>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height:15px; padding:10px 10px; text-align: right;" colspan="6">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 15px;"><strong>Paper Amount</strong></p>
                    </div>
                </td>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 20px; padding:10px 10px; text-align: right;">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 20px;">{{ $order->paper_amount }}
                        </p>
                    </div>
                </td>
            </tr>
        @endif
        @if(!empty($order->display_amount)&& $order->display_amount !='')
            <tr>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height:15px; padding:10px 10px; text-align: right;" colspan="6">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 15px;"><strong>Display Amount:</strong></p>
                    </div>
                </td>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 20px; padding:10px 10px; text-align: right;">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 20px;">{{ $order->display_amount }}
                        </p>
                    </div>
                </td>
            </tr>
        @endif
        @if(!empty($order->order_tax)&& $order->order_tax !='')
            <tr>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height:15px; padding:10px 10px; text-align: right;" colspan="6">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 15px;"><strong>Total Tax Amount:</strong></p>
                    </div>
                </td>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 20px; padding:10px 10px; text-align: right;">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 20px;">{{ $order->order_tax }}
                        </p>
                    </div>
                </td>
            </tr>
        @endif
        @if(!empty($order->order_discount)&& $order->order_discount !='')
            <tr>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height:15px; padding:10px 10px; text-align: right;" colspan="6">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 15px;"><strong> Total Savings:</strong></p>
                    </div>
                </td>
                <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height: 20px; padding:10px 10px; text-align: right;">
                    <div class="address" style="">
                        <p style="margin: 0; line-height: 20px;">{{ $order->order_discount }}
                        </p>
                    </div>
                </td>
            </tr>
        @endif
        @if(!empty($order->order_total) && $order->order_total !='')
        <tr>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; height: 15px; padding:10px 10px; text-align: right;" colspan="6">
                <div class="address" style="">
                    <p style="margin: 0; line-height:15px;"><strong>Grand Total</strong></p>
                </div>
            </td>
            <td style="vertical-align: top; border: 1px solid #353535; border-top: 0px; border-left: 0px; height:15px; padding:10px 10px; text-align: right;">
                <div class="address" style="">
                    <p style="margin: 0; line-height: 15px;">{{ $order->order_total }}
                    </p>
                </div>
            </td>
        </tr>
        @endif
    </table>
    @endif
</section>
@endif
</body>
</html>