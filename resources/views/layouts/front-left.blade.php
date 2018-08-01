@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
<title>Products</title>
@endsection

@section("content")
<div class="container-fluid">

    <div class="row" style="background-color: #0FF; height: 50px;">

        <div class="col-md-2">
            <input type="text" name="search" placeholder="Search for products, categories and more...">
        </div>

    </div>

</div>
<div class="page-sidebar-wrapper">

    <div class="page-sidebar navbar-collapse collapse">

        <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <i class="glyphicon glyphicon-home"></i><span class="title">Categories</span>
            
            <ul class="sub-menu">
                @foreach($parent_category as $key=>$val)
                <span class="title">{{$val->name}}</span>
                <?php $child_category = App\PiplModules\category\Models\Category::where('parent_id', $val->id)->get(); ?>
                     @foreach($child_category as $child)
                        <li><a href="{{url("/product/categories-list/".$child->id)}}">{{$child->name}}</a></li>
                     @endforeach <br>
                
                @endforeach
            </ul>            
        </ul>
    </div>
</div>
@endsection


