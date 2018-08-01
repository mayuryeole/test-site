@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
    <title>Checkout</title>
@endsection
@section("content")
    <section class="semi-banner" style="background-image: url('{{ url('public/media/front/img/appoinment.jpg') }}');">
        <div class="check-out-details-cap">
            <div class="container">
                <div class="semi-ban-head">Order Confirmation</div>
            </div>
        </div>
    </section>
    <section class="check-out-message">
        <div class="container">
            <div class="disp-table-div">
                <div class="disp-colom-div">
                    <h3>Your order has been succesfully placed please check following link...
                        <sapn><a href="{{ url('/order/view-orders') }}">Click Here</a></sapn>
                    </h3>
                </div>
            </div>
        </div>
    </section>
@endsection