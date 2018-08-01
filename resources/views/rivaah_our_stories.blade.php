@extends(config("piplmodules.front-view-layout-location"))

@section("meta")
    <title>Rivaah story</title>
    @php  $cnt=0; @endphp
@endsection
@section("content")
    <section class="our-story-banner">
        <img src="{{ url('public/media/front/img/paras-story-banner.jpg') }}" alt="banner image"/>
        <div class="paras-pos-absu paras-ban-cap">
            <div class="dis_table">
                <div class="disp_tabcell width50">
                    <div class="paras_maxWid">
                        @if(isset($rivaah_gal->name) && $rivaah_gal->name!='')
                        <h1>{{ $rivaah_gal->name}}</h1>
                        @else
                        <h1>Rivaah Gallery Name</h1>
                        @endif
                        <div class="paras-step"></div>
                        <div class="paras-ban-desp">
                        @if(isset($rivaah_gal->description) && $rivaah_gal->description!='')
                                <p id="see-less">
                                    @if(isset($rivaah_gal->description) && strlen($rivaah_gal->description)>150)
                                        {{ stripslashes(substr($rivaah_gal->description,0,200)) }}
                                    @elseif(isset($rivaah_gal->description) && strlen($rivaah_gal->description)<150)
                                        {{ stripslashes($rivaah_gal->description) }}
                                    @endif
                                </p>

                        </div>
                        @endif
                        @if(isset($rivaah_gal_img) && count($rivaah_gal_img)>0)
                        <div class="view-more">
                            <a href="{{ url('rivaah-story-semi-details').'/'. $rivaah_gal_img->id }}">view more</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="dis_tabcell wid50 vis_hid"></div>
            </div>
        </div>
    </section>
    @if(isset($all_rivaah_gal_img) && count($all_rivaah_gal_img)>0)
     @foreach($all_rivaah_gal_img as $img)
         @php $cnt++;
          $gallery = \App\PiplModules\rivaah\Models\RivaahGallery::where('id',$img->rivaah_gallery_id)->first();
         @endphp
    <section class="history-details">
        <div class="container">
            @if($cnt % 2 == 0)
                <div id="dv-story-holder-{{ $gallery->id }}-0" class="view-story-here">
                    <div  class="table-cell story-content width50">
                        <h4>{{ $gallery->name  }}</h4>
                        <p id="see-less_{{ $gallery->id }}">
                            @if(isset($gallery->description) && strlen($gallery->description)>150)
                                {{ stripslashes(substr($gallery->description,0,150)) }}
                                @else
                                {{ stripslashes($gallery->description) }}
                            @endif
                        </p>
                        <div class="view-more">
                            <a href="{{ url('rivaah-story-semi-details').'/'. $img->id }}">view more</a>
                        </div>
                    </div>
                    <div class="table-cell story-image width50">
                        <img src="{{ url('storage/app/public/rivaah/images/').'/'.$img->image }}" alt="story image"/>
                    </div>
                </div>
            @else
                <div id="dv-story-holder-{{ $gallery->id }}-1" class="view-story-here">
                    <div class="table-cell story-image width50">
                        <img src="{{ url('storage/app/public/rivaah/images/').'/'.$img->image }}" alt="story image"/>
                    </div>
                    <div class="table-cell story-content width50">
                        <h4>{{ $gallery->name  }}</h4>
                        <p id="see-less_{{ $gallery->id }}">
                            @if(isset($gallery->description) && strlen($gallery->description)>150)
                                {{ stripslashes(substr($gallery->description,0,150)) }}
                            @else
                                {{ stripslashes($gallery->description) }}
                            @endif
                        </p>
                        <p id="see-more_{{ $gallery->id }}" style="display: none;" >

                            {{ stripslashes($gallery->description) }}<a id="see-more-anchor_{{ $gallery->id }}" href="javascript:void(0);" onclick="replaceDown(this.id)">See less</a>

                        </p>
                        <div  class="view-more">
                            <a href="{{ url('rivaah-story-semi-details').'/'. $img->id }}">view more</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    @endforeach
   <div style="text-align:right;margin-right:10%"> {!! $all_rivaah_gal_img->render() !!}</div>
    @endif
    <script>
        var cnt;
        function replaceUp(id)
        {
            cnt = id.split('_').pop();
            if(id == "see-less-anchor")
            {
                $("#see-more").show();
                $("#see-less").hide();
            }
            else{
                $("#see-more_"+cnt).show();
                $("#see-less_"+cnt).hide();
            }

        }
        function replaceDown(id)
        {
            cnt = id.split('_').pop();
            if(id == "see-more-anchor"){
                $("#see-more").hide();
                $("#see-less").show();
            }
            else{
                $("#see-more_"+cnt).hide();
                $("#see-less_"+cnt).show();
            }

        }
    </script>
    <script>
        // $(function(){
        //     var len =$('.view-story-here').length;
        //      for(var i =0; i<len;i++)
        //      {
        //         var elid = $('.view-story-here:eq('+ i +')').attr('id');
        //         var cnt = elid.split('-').pop();
        //         if(cnt == 1)
        //         {
        //             $('#'+elid).children('.story-content').insertAfter('.story-img');
        //         }
        //      }
        //     // $('.view-story-here').forEach(function(element) {
        //     //     console.log(element.id);
        //     // });
        // });
        // $('.view-story-here:eq(1)').attr('id').split('-').pop();

        jQuery(window).resize(function()
        {
            if (jQuery(window).width() <= 767)
            {
                var len =$('.view-story-here').length;
                for(var i =0; i<len;i++)
                    {
                        var elid = $('.view-story-here:eq('+ i +')').attr('id');
                        var cnt = elid.split('-').pop();
                        if(cnt == 0)
                        {
                            var content =$('#'+ elid).children('.story-content');
                            var image =$('#'+ elid).children('.story-image');
                            $(content).insertAfter(image);
                        }
                    }
                }
        });
    </script>
@endsection