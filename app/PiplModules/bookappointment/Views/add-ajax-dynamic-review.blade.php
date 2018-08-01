 @if(isset($my_rating) && count($my_rating)!=0)
    @foreach($my_rating as $rating)
    <li>
            <div class="media">
                <span class="pull-left media-left">
                    <div class="rate-user-img img-circle">
                        @if($rating->ratingGivenBy->userInformation->gender==1)
                         <img src="{{url('public/media/front/img/male-user.png')}}"/>
                        @else
                         <img src="{{url('public/media/front/img/woman-avatar.png')}}"/>
                         @endif
                    </div>
                </span>
                <div class="media-body inform-review">
                    <span class="names">{{$rating->ratingGivenBy->userInformation->first_name.' '.$rating->ratingGivenBy->userInformation->last_name}}</span>
                    <span class="desc">{{$rating->review}}</span>
                     <span class="desc_review">
                            <?php

                $k = 0;
                $is_flot = false;
                $arr_rat = explode('.', $rating->rating);
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
                     </span>

                </div>
            </div>

    </li>

    @endforeach
    @endif
    
    @if(count($all_rating_count)>5)
    <li class="view-more-button"  id="addMore">
     <center><button type="button" class="vi-more hvr-trim" onclick="showAll('{{$my_rating->last()->id}}')" ><i class="fa fa-plus" aria-hidden="true"></i></button></center>
     </li>
    @endif  