@extends('layouts.app')

@section('content')
    <section class="product-listing-blk h-product-listing-blk product-gift-card-list">
        <div class="container">
            <div class="product-list-grid">
                @if(isset($giftCards) && count($giftCards)>0)
                <ul class="product-list row">
                     @foreach($giftCards as $card)
                    <li class="col-md-4 col-sm-6 col-xs-12">
                        <div class="product-item-wrapper">
                                <div class="product-item clearfix">
                                    <div class="product-thumbnail">
                                        <a href="{{ url('/gift-card').'/'. $card->id}}">
                                          <img src="{{ url('storage/app/public/gift_card_image').'/'.$card->image }}" alt="product image"/>
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <div class="h-product-info-blk clearfix">
                                            <h3 class="pull-left">
                                                <span class="title"><a href="{{ url('/gift-card').'/'. $card->id}}">{{ $card->name }}</a></span>
                                                {{--<span class="prod-description">{{ $card->description }}</span>--}}
                                            </h3>
                                            <div class="prod-price pull-right">{{ \App\Helpers\Helper::getCurrencySymbol().round(App\Helpers\Helper::getRealPrice($card->price),4) }}</div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </section>
@endsection