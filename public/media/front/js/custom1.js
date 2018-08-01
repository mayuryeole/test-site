$(document).ready(function(){
	
 $('body').append('<div id="toTop" class="btn"><span class="fa fa-angle-up"></span></div>');
	$(window).scroll(function () {
		if ($(this).scrollTop() != 0) {
			$('#toTop').fadeIn();
		} else {
			$('#toTop').fadeOut();
		}
	});
	$('#toTop').click(function(){
		$("html, body").animate({ scrollTop: 0 }, 1500);
		return false;
	});
/*************full height js****************/
	fullSize();
	function fullSize() {
        var heights = window.innerHeight;
        jQuery(".fullHt").css('min-height', (heights + 0) + "px");
    }
/***************************custom js for dashboard*********************/

/**********custome js***********/
//main menu active class add remove
$(".menu-bar li").click(function(){
    $(".menu-bar li").removeClass("active");
    $(this).addClass("active");
});
/****************sign in sign out*****************/
$('.sign_in_person').click(function(){
  if($('.sign_in_person').hasClass('active')){
  	$('.sign_in_person').removeClass('active');
  }
  else{
  	$('.sign_in_person').removeClass('active');
  	$('.sign_in_person').addClass('active');   
  }
});
/*************responsive menu*************/
$('.burger-menu').click(function(){
  if($('body').hasClass('open-menu')){
  	$('body').removeClass('open-menu');
  }
  else{
  	$('body').removeClass('open-menu');
  	$('body').addClass('open-menu');   
  }
});
/***************************End custom js for dashboard***************/	
$(".hamberger").click(function(){
    $('body').toggleClass("menu-active");
    $(this).toggleClass("bar-active");
});

	// BS tabs hover (instead - hover write - click)
	$('.tab-menu a').hover(function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	})
/***************************End custom js for dashboard***************/	

/*************End full height js****************/
	$('#mid_product_slider, #mid_product_slider_sec').owlCarousel({
		loop:true,
		margin:0,
		nav:true,
		/*animateOut: 'fadeOut',
		animateIn: 'fadeIn',*/
		dots:false,
		autoplay:false,
		smartSpeed:250,
		autoplayTimeout:1800,
		items:1,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
	})
/**************************gallery slider************************/
	$('#gallery_slider').owlCarousel({
		loop:true,
		margin:5,
		nav:true,
		autoplayHoverPause:true,
		animateOut: 'fadeOut',
		animateIn: 'fadeIn',
		dots:false,
		autoplay:true,
		smartSpeed:250,
		autoplayTimeout:1800,
		items:4,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
	})
	
	$('#gallery_categories_slider').owlCarousel({
		loop:true,
		margin:30,
		nav:false,
		rtl:true,
		animateOut: 'fadeOut',
		animateIn: 'fadeIn',
		dots:true,
		autoplay:true,
		smartSpeed:250,
		autoplayTimeout:1800,
		items:6,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
	})
/****************************testimonials slider***********************/
	$('.testimonials_slider').owlCarousel({
		loop:true,
		margin:30,
		nav:false,
		animateOut: 'fadeOut',
		animateIn: 'fadeIn',
		dots:true,
		autoplay:true,
		smartSpeed:250,
		autoplayTimeout:1800,
		items:1,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
	})
/****************************artist slider***********************/
	$('#artist_gal').owlCarousel({
		loop:true,
		margin:30,
		nav:true,
		animateOut: 'fadeOut',
		animateIn: 'fadeIn',
		dots:false,
		autoplay:true,
		smartSpeed:250,
		autoplayTimeout:1800,
		items:4,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
	})
	
/**************middle product slider*************/
/*$('#mid_product_slider').owlCarousel({
		loop:true,
		margin:0,
		nav:false,
		animateOut: 'fadeOut',
		animateIn: 'fadeIn',
		dots:false,
		autoplay:true,
		smartSpeed:250,
		autoplayTimeout:1800,
		items:1,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ],
	})*/
	
/******************mcustomscrollbar js*****************/
    (function($){
        $(window).on("load",function(){
            $(".content").mCustomScrollbar();
        });
    })(jQuery);
	
});


/*****************************Open responsive menu******************/
$(".hamberger").click(function(){
	if($('body').hasClass('open-menu')){
		$('body').removeClass('open-menu');
	}
	else{
		$('body').addClass('open-menu');
		}
});
/***********************listing menu***********************/

/*
$(".dropbtn").hover(function(){
	if($('body').hasClass('dropdown-menu')){
		$('body').removeClass('dropdown-menu');
	}
	else{
		$('body').addClass('dropdown-menu');
		}
});*/
