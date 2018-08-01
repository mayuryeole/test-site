   <div class="expert-slider">
                    <div class="col-md-12">
                        <div id="experts1">
                            @foreach($all_expert_list as $expert)
                            <a id="select-expert" href="{{url('appointment/mode-of-contact/'.base64_encode($expert->user_id))}}">
                            <div class="item" >
                                <div class="in-ex text-center">
                                    <div class="exp_item_img">
                                        <center><img src="{{url('public/media/front/img/user/'.$expert->user_id.'/'.$expert->profile_picture)}}" alt="image" class="img-responsive ex-img"></center>
                                    </div>
                                    <div class="ex-name">
                                        <p>{{$expert->first_name}}</p>
                                        <p class="ex">

                                            @if(isset($expert->Expertise)&& count($expert->Expertise)>0)

                                            @foreach($expert->Expertise as $expert_cat)
                                            {{$expert_cat->categoryName->name}}
                                            @endforeach
                                            @endif  

                                        </p>
                                    </div>
                                    <div class="ex-rate">
                                        <?php

                                            $k = 0;
                                            $is_flot = false;
                                            $arr_rat = explode('.', $expert->avg_rating);
                                            if (count($arr_rat) == 1) {
                                                $arr_rat[1] = '0';
                                            }
                                            if ($arr_rat[0] != "") {
                                                if ($arr_rat[1] != '0') {
                                                    $is_flot = "true";
                                                }
                                                for ($ii = 0; $ii < $arr_rat[0]; $ii++) {
                                                    ?>
                                                    <img  src="{{url('public/media/front/img/star-on.png')}}"/>
                                                    <?php
                                                    $k++;
                                                }
                                                if ($is_flot) {
                                                    ?>
                                                    <img  src="{{url('public/media/front/img/star-half.png')}}"/>
                                                    <?php
                                                }
                                                if ($is_flot) {
                                                    $s = $arr_rat[0] + 1;
                                                } else {
                                                    $s = $arr_rat[0];
                                                }
                                                if ($s < 5) {
                                                    for ($j = $s; $j < 5; $j++) {
                                                        ?>
                                                        <img  src="{{url('public/media/front/img/star-off.png')}}"/>
                                                        <?php
                                                        $s++;
                                                    }
                                                }
                                            }

                                        ?>
                                    
                                    </div>
                                    <div class="last-act">
                                        <p>{{$expert->last_login}}</p>
                                    </div>
                                    <div class="check-experts">
                                        <span class="chec-ex">
                                            <!--<a id="select-expert" href="{{url('appointment/mode-of-contact/'.base64_encode($expert->user_id))}}">-->
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            <!--</a>-->
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
<script>
$('#experts1').owlCarousel({
    loop: true,
    margin: 0,
    nav: true,
    dots: true,
    autoplay: false,
    autoplayTimeout: 5000,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 3
        },
        1000: {
            items: 4
        }
    },
    navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>"
    ],
})
</script>