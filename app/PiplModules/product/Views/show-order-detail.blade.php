@extends(config("piplmodules.back-view-layout-location"))

@section("meta")

<title>View Order Product Details</title>
{{--{{ dd($order_items) }}--}}
@endsection

@section('content')

<div class="page-content-wrapper">
  <div class="page-content">
    <!-- BEGIN PAGE BREADCRUMB -->
    <ul class="page-breadcrumb breadcrumb">
      <li>
       <a href="{{url('admin/dashboard')}}">Dashboard</a>
       <i class="fa fa-circle"></i>
     </li>
     <li>
       <a href="{{url('admin/orders')}}">Manage Orders</a>
       <i class="fa fa-circle"></i>

     </li>
     <li>
       <a href="javascript:void(0);">View Order Product Details</a>

     </li>
   </ul>



   <!-- BEGIN SAMPLE FORM PORTLET-->
   <div class="portlet box blue">
     <div class="portlet-title">
      <div class="caption">
        <i class="fa fa-gift"></i>View Order Product Details
      </div>

    </div>
    <div class="portlet-body form">
       <div class="form-body">
        @if(isset($order_items) && count($order_items)>0)
        <div class="row">
            @foreach($order_items as $o)
          <div class="col-md-12">    
           <div class="form-group  clearfix @if ($errors->has('title')) has-error @endif">
            <label class="col-md-3">Product Name</label>
            <div class="col-md-9">
                <div class="inputtes">
                   
                    @if(isset($o->product->name) && $o->product->name!="")
              {{$o->product->name}}
              @else
              -
              @endif
                </div>
            </div>
          </div>
          <div class="form-group clearfix {{ $errors->has('reason_reject') ? ' has-error' : '' }}">
            <label class="col-md-3">Product Quantity:</label>
            <div class="col-md-9">
                <div class="inputtes">
                           @if(isset($o->product_quantity) && $o->product_quantity!="")
             
                    {{$o->product_quantity}}
                  @else
                  -
                  @endif
                </div>
            </div>
        </div> 
        
         
      
      
      
      
      
      <div class="form-group clearfix">
                                    <label class="col-md-3">Product Price:</label>
                                    <div class="col-md-9">
                                        <div class="inputtes">
                                          @if(isset($o->product->productDescription->price) && $o->product->productDescription->price!="")
             
                    {{$o->product->productDescription->price}}
                  @else
                  -
                  @endif
                                         </div>
                                    </div>
                                </div>
      <div class="form-group clearfix">
                                    <label class="col-md-3">Product Weight :</label>
                                    <div class="col-md-9">
                                        <div class="inputtes">
                                                          @if(isset($o->weight) && $o->weight!="")
             
                                            {{$o->weight}}
                                            @else
                                            -
                                            @endif
                                        </div>
                                    </div>
                                </div>
      
          </div>
            @endforeach
</div>
            @endif
</div>
</div>
   </div>
  </div></div>
@endsection