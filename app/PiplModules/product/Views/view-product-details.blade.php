<div class="col-md-9 col-sm-12">
    <div class="slideshow-container">

        @for($i = 0; $i < count($productImages); $i++)
        <div class="mySlides fade">
            <img src="{{ asset("storageasset/product/thumbnail/".$productImages[$i]->images)}}">
        </div>
        @endfor
        <a class="prev">&#10094;</a>
        <a class="next">&#10095;</a>
    </div>


</div>
<style>
    .slideshow-container {
        width: 100%;
    }
    .fade {
        -webkit-animation-name: fade;
        -webkit-animation-duration: 1.5s;
        animation-name: fade;
        animation-duration: 1.5s;
    }
</style>