@extends('layouts.app')

@section('content')
    <section class="paras-video-details">
        <div class="container-fluid">
            <div class="row">
                <div class="parar-full-video">
                    <video width="100%" height="100%" loop="" autoplay="">
                        <source type="video/mp4" src="{{ url('storage/app/public/product/video').'/'.$video }}"></source>
                        <source type="video/ogg" src="video/paras-intro.ogg"></source>
                    </video>
                </div>
            </div>
        </div>
    </section>
    <div class="back-top-pre-page"><a href="javascript:history.go(-1)"><i class="fa fa-hand-o-left"></i> <span>Back</span></a></div>

@endsection