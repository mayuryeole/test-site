@extends(config("piplmodules.front-view-layout-location"))

@section('meta')
<title>Search Results for "{{$keyword}}" tag</title>
@endsection

@section("content")
<div class="container">
    <section>
        <div class="row">

            @include('product::left-section')

            <div class="col-md-9 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        @if(count($products) < 1)

                        <div class="well">
                            <h3>Sorry...We didn't found any product related to "{{$keyword}}" tag. Please try other tags with different price or color.
                                <a href="{{ url('/product/searchAll') }}">You can see all Products here</a><h3></div>
                                    @else 
                                    <h4 id="tag" onmouseover="mouseOver()" onmouseout="mouseOut()"> Search result for "{{ $keyword }}" tag </h4>
                                    @endif

                                    <div class="row">
                                        @foreach($products as $key => $value)

                                        @if($key > 0) <hr /> @endif

                                        @if($value->productImages->first()->images)
                                        <div class="col-md-2 text-center">
                                            <img src="{{ asset('storageasset/product/thumbnail/'.$value->productImages->first()->images) }}"  height="100" class="img-responsive thumbnail" />
                                        </div>
                                        @endif

                                        <div class=" @if($value->productImages->first()->images) col-md-10 @else col-md-12 @endif">
                                            <h4>{{$value->product->name}}</h4>
                                            Color: {{$value->color}}<br>
                                            Size: {{$value->size}}<br>
                                            Price: {{$value->price}}
                                        </div>
                                        @endforeach
                                        {{  $products->links() }}
                                    </div>
                                    
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </section>
                                    </div>
                                    @endsection

                                    <style>
                                        .tag  { /* element selector */
                                            color: #2ab27b;
                                            text-align: center;
                                        }
                                    </style>

                                    <script>
                                        function mouseOver() {
                                            document.getElementById('tag').style.color = "red";
                                        }
                                        function mouseOut() {
                                            document.getElementById('tag').style.color = "#2ab27b";
                                        }
                                    </script>