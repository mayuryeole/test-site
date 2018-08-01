@extends('layouts.app')
@section('meta')
    <title>Thank You</title>
@endsection

<!------------------------------------------------------THANKS SECTION-------------------------------------------->
<section class="thnks dash-cms-cust">
	<div class="jumbotron text-center">
    	<center><div class="com-app"><img src="{{url('public/media/front/img/if_11_-_Valid_1815560.png')}}" class="img-responsive check-imgs"></div></center>
 		 <h1 class="display-3">Thank You!</h1>
 		 <p class="lead"><strong>Dear {{Auth::user()->userInformation->first_name.' '.Auth::user()->userInformation->last_name}}</strong> Thank you for using services at Buckup.</p>
 		 <hr>
 		 <p>
    		Having trouble? <a href="{{url('/contact-us')}}" class="contc" >Contact us</a>
 		</p>
  		<p class="lead">
    		<a class="btn btn-primary btn-sm conti-btn" href="{{url('/')}}" role="button">Continue to homepage</a>
  		</p>
	</div>
</section>