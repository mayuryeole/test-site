<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
</head>
@php
    $order_items = null;
   if(isset($order) && count($order)>0){
                  $order_items=  \App\PiplModules\cart\Models\OrderItem::where('order_id',$order->id)->get();
   }

@endphp
<body>
@if(isset($order) && count($order)>0)
<section class="invoice" style="border: 1px solid #e5e5e5; box-shadow: 0 0 10px #e5e5e5; margin: 50px auto; padding: 10px 10px 50px; width: 100%;font-size: 14px;letter-spacing: 0.5px;">
    <table class="table" width="100%" cellspacing="0" style="border-bottom:1px solid #1E1E1E;">
        <tr>
            <td style="padding:0px 10px;">
                <h3 style="color:#1E1E1E;text-align:center;">Retail Invoices/Bill</h3>
            </td>
        </tr>
        <tr>
            <td style="padding:0px 10px;">
                <h3 style="color:#1E1E1E;margin:0px;">Sold By:<span style="font-weight:400;"> Paras Fashions</span></h3>
                <p style="font-size: 14px;font-style: italic;margin: 0px;line-height: 30px;color:#1E1E1E;">
                    Unit No 20 & 21,Ground Floor,Eastern Plaza,Shivaji Chowk Daftary Road , Malad (East),Mumbai(400097)
                </p>
            </td>
        </tr>
    </table>
    <table class="table" style="width: 100%;" cellspacing="0">
        <tr>
            <td style="width:33.3%; padding:0px 10px;vertical-align:top;">
                <p class="order-id" style="font-weight:bold;line-height: 30px;margin: 0px;font-size: 14px;">Order ID: <span style="font-weight:400;">{{ $order->sku }}</span></p>
                <p class="order-date" style="font-weight:bold;line-height: 30px;margin: 0px;font-size: 14px;">Order Date: <span style="font-weight:400;">{{ $order->created_at }}</span></p>
                <p class="invoice-date" style="font-weight:bold;line-height: 30px;margin: 0px;font-size: 14px;">Invoice Date: <span style="font-weight:400;">{{ $order->created_at }}</span></p>
                <p class="vat" style="font-weight:bold;line-height: 35px;margin: 0px;font-size: 14px;">VAT/TIN: <span style="font-weight:400;">98750</span></p>
                <p class="service-tax" style="font-weight:bold;line-height: 30px;margin: 0px;font-size: 14px;">Service tax #: <span style="font-weight:400;">98750</span></p>
            </td>
            <td style="width:33.3%; padding:0px 10px;vertical-align:top;">
                <p class="bill-addr" style="font-weight:bold;margin: 0px;font-size: 14px;line-height: 35px">Billing Address: </p>
                <p class="bill-addr-detail" style="font-weight:400;font-size: 14px;margin: 0px;line-height: 23px;">{{ $order->shipping_address1 }},{{ $order->billing_city}},{{ $order->billing_state}},{{ $order->billing_country}}{{$order->billing_zip  }}</p>
            </td>
            <td style="width:33.3%; padding:0px 10px;vertical-align:top;">
                <p class="shipp-addr" style="font-weight:bold;margin: 0px;font-size: 14px;line-height: 35px">Shipping Address: </p>
                <p class="shipp-addr-detail" style="font-weight:400;font-size: 14px;margin: 0px;line-height: 23px;">{{ $order->shipping_address1 }},{{ $order->shipping_city}},{{ $order->shipping_state}},{{ $order->shipping_country}}{{$order->shipping_zip  }}</p>
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
        </tr>
    </table>
    <table class="table" cellspacing="0" style="padding: 0px 10px;margin-top: 25px; width: 100%;">
        <tr>
        <th style="width: 20%; text-align: left;border-bottom: 1px solid #1E1E1E;border-top: 1px solid #1E1E1E;line-height: 30px;"> Product Name</th>
        <th style="width: 20%; text-align: left;border-bottom: 1px solid #1E1E1E;border-top: 1px solid #1E1E1E;line-height: 30px;"> Product Code</th>
        <th style="width: 10%; text-align: right;border-bottom: 1px solid #1E1E1E;border-top: 1px solid #1E1E1E;line-height: 30px;"> Qty</th>
        <th style="width: 10%; text-align: right;border-bottom: 1px solid #1E1E1E;border-top: 1px solid #1E1E1E;line-height: 30px;"> Price </th>
        <th style="width: 10%; text-align: right;border-bottom: 1px solid #1E1E1E;border-top: 1px solid #1E1E1E;line-height: 30px;"> Color </th>
        <th style="width: 10%; text-align: right;border-bottom: 1px solid #1E1E1E;border-top: 1px solid #1E1E1E;line-height: 30px;"> Size  </th>
        <th style="width: 10%; text-align: right;border-bottom: 1px solid #1E1E1E;border-top: 1px solid #1E1E1E;line-height: 30px;"> Total </th>
        </tr>
        <tr>
            <td style="height: 10px;" colspan="7">
            </td>
        </tr>
        @if(isset($order_items) && count($order_items)>0)
            @foreach($order_items as $item)
        <tr>
            <td> @if(!empty($item->product->name)){{ $item->product->name }} @endif</td>
            <td>@if(!empty($item->product->productDescription->sku)) {{ $item->product->productDescription->sku }} @endif</td>
            <td style="text-align:right;">@if(!empty($item->product_quantity)) {{ $item->product_quantity }} @endif</td>
            <td style="text-align:right;">@if(!empty($item->product_amount)) {{ number_format($item->product_amount,2,'.','') }} @endif</td>
            <td style="text-align:right;">@if(!empty($item->product_color_name)) {{ $item->product_color_name }} @endif</td>
            <td style="text-align:right;">@if(!empty($item->product_size_name)) {{ $item->product_size_name }} @endif</td>
            <td style="text-align:right;"> @if(!empty($item->product_quantity) && !empty($item->product_amount)) {{ number_format($item->product_quantity * $item->product_amount,2,'.','')}} @endif</td>
        </tr>
            @endforeach
        @endif
        <tr>
            <td style="height: 10px;" colspan="7">
            </td>
        </tr>
        @if(!empty($order->order_subtotal) && $order->order_subtotal !='')
        <tr>
            <td colspan="5" style="text-align:right;font-size: 14px; border-top: 1px solid #1e1e1e; line-height: 50px; font-weight: bold;">Product Total Amount:</td>
            <td colspan="2" style="text-align:right;font-size: 14px; border-top: 1px solid #1e1e1e; line-height: 50px; font-weight: bold;">{{ number_format($order->order_subtotal,2,'.','') }}</td>
        </tr>
        @endif
        @if(!empty($order->order_shipping_cost)&& $order->order_shipping_cost !='')
        <tr>
            <td colspan="5" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;"> Shipping Charges:</td>
            <td colspan="2" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;">{{ number_format($order->order_shipping_cost,2,'.','') }}</td>
        </tr>
        @endif
        @if(!empty($order->coupon_amount) && $order->coupon_amount !='')
        <tr>
            <td colspan="5" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;"> Coupon Amount:</td>
            <td colspan="2" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;">{{ number_format($order->coupon_amount,2,'.','') }}</td>
        </tr>
        @endif
        @if(!empty($order->promo_amount) && $order->promo_amount !='')
        <tr>
            <td colspan="5" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;"> Promo Amount:</td>
            <td colspan="2" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;">{{ number_format($order->coupon_amount,2,'.','') }}</td>
        </tr>
        @endif
        @if(!empty($order->gift_card_amount) && $order->gift_card_amount!='')
        <tr>
            <td colspan="5" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;"> Gift Card Amount:</td>
            <td colspan="2" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;">{{ number_format($order->gift_card_amount,2,'.','') }}</td>
        </tr>
        @endif
        @if(!empty($order->box_amount) || !empty($order->paper_amount))
        <tr>
            <td colspan="5" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;"> Total Packaging Cost:</td>
            <td colspan="2" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;">{{ number_format((floatval($order->box_amount)+floatval($order->paper_amount)),2,'.','')}}</td>
        </tr>
        @endif
        @if(!empty($order->display_amount))
        <tr>
            <td colspan="5" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;"> Display Amount:</td>
            <td colspan="2" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;">{{ number_format($order->display_amount,2,'.','') }}</td>
        </tr>
        @endif
        @if(!empty($order->order_tax))
        <tr>
            <td colspan="5" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;"> Total Taxes:</td>
            <td colspan="2" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;">{{ number_format($order->order_tax,2,'.','') }}</td>
        </tr>
        @endif
        @if(!empty($order->order_discount))
        <tr>
            <td colspan="5" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;"> Total Savings:</td>
            <td colspan="2" style="text-align:right;font-size: 14px; line-height: 30px; font-weight: normal;">{{ number_format($order->order_discount,2,'.','') }}</td>
        </tr>
        @endif
        @if(!empty($order->order_subtotal))
        <tr>
            <td colspan="5" style="text-align:right;font-size: 22px;border-top: 1px solid #1e1e1e;border-bottom: 1px solid #1e1e1e;line-height: 30px;"> Grand Total:</td>
            <td colspan="2" style="text-align:right;font-size: 22px;border-top: 1px solid #1e1e1e;border-bottom: 1px solid #1e1e1e;line-height: 30px;"> {{ number_format($order->order_total,2,'.','') }}</td>
        </tr>
        @endif
    </table>
    <table class="table" cellspacing="0" style="width: 100%; padding: 0px 10px;text-align:right;">
        <tr>
            <td style="width: 60%; font-style:italic;vertical-align: top;line-height: 40px;"><span>*</span> This is a computer generated invoice</td>
            <td style="width: 40%;"><p>Paras Fashions</p>
                <p class="signature"></p>
                <p style="line-height:40px;font-size:12px;">(Authorized Signature)</p>
            </td>
        </tr>
    </table>
</section>
    @endif
</body>
</html>

