<div class="col-lg-3 col-sm-12">
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <li class="start active ">
                    <a href="{{url("product/dashboard")}}">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="title ">
                    <a href="javascript:void(0);">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <span class="title">Search</span>
                        <form role="form" id="form_search" method="get" action="{{ url('/product/search') }}">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="form-group @if(!empty(session('search-error'))) has-error @endif">
                                    <div class="input-group">
                                        <input type="text" name="searchText" value="{{ old('searchText',isset($keyword)?$keyword:'')}}"  class="form-control"/>
                                        <input type="hidden" id="minPrice" name="minPrice">
                                        <input type="hidden" id="maxPrice" name="maxPrice">
                                        <input type="hidden" id="color" name="color">
                                        <span class="input-group-btn" id="basic-addon1"><button type="submit" class="btn btn-default">Search</button></span>
                                    </div>

                                    @if(!empty(session('search-error')))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ session('search-error') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </a>
                </li>

                <li class="title">
                    <a href="javascript:void(0)">
                    <label for="price" style="font-family:Verdana;">Price Range:</label></a>
                    <input type="text" id="price" style="border:0; color:#fa4b2a; font-weight:bold;">
                    <div id="mySlider"></div><br><br>
                </li>
                <li>
                     <a href="javascript:void(0)"><label for="price" style="font-family:Verdana;">Color</label></a>
                     Select color: <input type="color" name="color" id="color1" onfocusout="myFunction(this.value)"> 
                </li>
            </ul>
        </div>
    </div>
</div>

 <script>
                function myFunction(value) {
                    alert(value);
                    var x = document.getElementById("color1").value;
                    document.getElementById("color").innerHTML = x;
                }
        </script>
