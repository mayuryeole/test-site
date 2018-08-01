@extends(config("piplmodules.front-view-layout-location"))

@section("meta")

<title>Product Dashboard</title>

@endsection

@section("content")

<div class="container">
    <section>
        @include('product::left-section')
        <div class="col-md-9 col-sm-12">
            <div class="well">
                <h1 id = "hi" onmouseover="mouseOver()" onmouseout="mouseOut()">Welcome You....!!!</h1>
                <p id="para1">Search for Products, Brands and more here...</p>
                <img src="{{url('public/media/front/images/wel.jpeg')}}">
            </div>
        </div>
    </section>
</div> 
@endsection
<style>
    #hi  { /* element selector */
        color: #2ab27b;
        text-align: center;
    }
    #para1 { /* id selector */
        color: red;
        text-align: center;
    }

</style>

<script>
    function mouseOver() {
        document.getElementById('hi').style.color = "red";
    }
    function mouseOut() {
        document.getElementById('hi').style.color = "#2ab27b";
    }
</script>