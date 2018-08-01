@extends(config("piplmodules.front-view-layout-location"))

@section('meta')
<title>Search Results Price</title>
@endsection

@section("content")
<div class="container">
    <section>
        <div class="row">

            @include('product::left-section')

            <div class="col-md-9 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                           ok
<!--                        @if(count($products) < 1)

                        <div class="well">We didn't found any product related to "{{$keyword}}" tag. Please try other tags.</div>
                        @endif
                        @foreach($products as $key => $value)
                        @if($key > 0) <hr /> @endif
                        <div class="row">
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
                        </div>
                        @endforeach-->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection