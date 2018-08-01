@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
    <title>Rivaah story</title>
@endsection
@section("content")
    @if(isset($gal_details) && count($gal_details)>0)
    <section class="our-story-banner sem-details-banner" style="background-image:url('{{ url("public/media/front/img/paras-story-banner.jpg") }}');">
        <div class="paras-pos-absu paras-ban-cap">
            <div class="dis_table">
                <div class="disp_tabcell width50">
                    <div class="paras_maxWid">
                        <h1><span>@if(!empty($gal_details->name)){{ $gal_details->name }} @endif</span> Fashions Details</h1>
                        <div class="paras-step"></div>
                    </div>
                </div>
                <div class="dis_tabcell wid50 vis_hid"></div>
            </div>
        </div>
    </section>
    <section class="history-semi-details">
        <div class="container">
            <div class="par-semi-details clearfix">
                <div class="semi-left-img pull-left">
                    <img src="{{ url('storage/app/public/rivaah/images').'/'.$gal_img_details->image }}">
                </div>
                <div class="semi-details">
                    <h4>The @if(!empty($gal_details->name)){{ $gal_details->name }} @endif Bride</h4>
                    <div class="semi-description">
                        <p> {{ stripslashes($gal_details->description) }}</p>
                      </div>
                    <div class="view-more">
                        <a href="{{ url('rivaah-story-details').'/'. $gal_img_details->id}}">view Product List</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection