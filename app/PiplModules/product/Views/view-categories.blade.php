@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
<title>Products</title>
@endsection
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script src="http://localhost/laravel-pipl-lib/public/media/backend/js/bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript">

    function toggleDiv(divId) {

        $("#" + divId).toggle();

    }

</script>

@section("content")
<div class="container-fluid">
    <form role="form" method="post" action="{{ url('/product/search') }}">
        {!! csrf_field() !!}
        <div class="row" style="background-color: #0FF; height: 50px;">
            <div class="col-md-3">
                <input type="text" name="searchText"  placeholder="Search for products, categories and more...">
                <button>Search</button>
            </div>
            @if(!empty(session('search-error')))
            <span class="help-block">
                <strong class="text-danger">{{ session('search-error') }}</strong>
            </span>
            @endif
        </div>
    </form>
    <hr>
    <div class="col-md-3 col-sm-12">
        <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <i class="glyphicon glyphicon-home"></i><span class="title">Categories</span>
            <ul class="sub-menu">
                @foreach($parent_category as $key=>$val)
                <span class="title">{{$val->name}}</span>
                <?php $child_category = App\PiplModules\category\Models\Category::where('parent_id', $val->id)->get(); ?>

                @foreach($child_category as $child)

                <br><a href="javascript:toggleDiv('{{$child->id}}');">{{$child->name}}</a>

                <div id="{{$child->id}}" style="display: none;">
                    <?php $sub_child_category = App\PiplModules\category\Models\Category::where('parent_id', $child->id)->get(); ?>
                    @foreach($sub_child_category as $sub_child)
                    <thead>
                        <tr><a href="{{url("/product/lists/".$sub_child->id)}}">{{$sub_child->name}}<br></tr>
                        </thead>
                        @endforeach
                        </div>
                        @endforeach <br>
                        @endforeach
                        </ul>
                        </ul>
                        </div>
                        </div>
                        <style> 
                            input[type=text] {
                                width: 800px;
                                box-sizing: border-box;
                                border: 2px solid #ccc;
                                border-radius: 4px;
                                font-size: 16px;
                                background-color: white;
                                background-position: 10px 10px; 
                                background-repeat: no-repeat;
                                padding: 12px 20px 12px 40px;
                                transition: width 0.4s ease-in-out;
                            }
                        </style>
                        @endsection