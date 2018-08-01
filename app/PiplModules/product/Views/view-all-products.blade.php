@extends(config("piplmodules.front-view-layout-location"))

@section('meta')
<title>Search Results for all products</title>
@endsection

@section("content")
<div class="container">
    <section>
        <div class="row">

            @include('product::left-section')

            <div class="col-md-9 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <h3 id = "all" onmouseover="mouseOver()" onmouseout="mouseOut()">List of all products...</h3><hr />

                        <div class="row">  

                            <div style="border-style: solid;">
                                <h4 style="color: red;">Featured Products</h4>
                                @foreach($products as $key => $value)
                                @if($value->priority == 1)
                                @if($key > 0) <hr /> @endif

                                <div class="row">
                                    @if($value->productImages()->first()->images)

                                    <div class="col-md-2 text-center">
                                        <img src="{{ asset('storageasset/product/thumbnail/'.$value->productImages()->first()->images) }}"  height="100" class="img-responsive thumbnail" />
                                    </div>
                                    @endif

                                    <div class=" @if($value->productImages()->first()->images) col-md-10 @else col-md-12 @endif">
                                        <h4><a href="{{ url('product/viewProductsDetails') }}/{{$value->id}}">{{$value->name}}</a></h4>
                                        <b>Uploaded by: {{ $value->user->userInformation->first_name }}</b><br>
                                        Color: {{$value->productDescription->color}}<br>
                                        Size: {{$value->productDescription->size}}<br>
                                        Price: {{$value->productDescription->price}}<br>
                                        Tags: {{$value->productDescription->tags}}
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <div>
                                @foreach($products as $key => $value)
                                @if($value->priority != 1)
                                @if($key > 0) <hr /> @endif

                                <div class="row">
                                    @if($value->productImages()->first()->images)

                                    <div class="col-md-2 text-center">
                                        <img src="{{ asset('storageasset/product/thumbnail/'.$value->productImages()->first()->images) }}"  height="100" class="img-responsive thumbnail" />
                                    </div>
                                    @endif

                                    <div class=" @if($value->productImages()->first()->images) col-md-10 @else col-md-12 @endif">
                                        <h4><a href="{{ url('product/viewProductsDetails') }}/{{$value->id}}">{{$value->name}}</a></h4>
                                        <b>Uploaded by: {{ $value->user->userInformation->first_name }}</b><br>
                                        Color: {{$value->productDescription->color}}<br>
                                        Size: {{$value->productDescription->size}}<br>
                                        Price: {{$value->productDescription->price}}<br>
                                        Tags: {{$value->productDescription->tags}}
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>


                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection

<style>
    .all  { /* element selector */
        color: #2ab27b;
        text-align: center;
    }
</style>

<script>
    function mouseOver() {
        document.getElementById('all').style.color = "red";
    }
    function mouseOut() {
        document.getElementById('all').style.color = "#2ab27b";
    }
</script>