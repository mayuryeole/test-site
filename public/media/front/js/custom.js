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

/**********sign in option****/
$('.sining-opt').click(function(){
  $('body').toggleClass('open-sign-right');
});

/*********************custom modal js***********************/
/****************custom popup measurment block*************/
	
/*************full height js****************/
	fullSize();
	function fullSize() {
        var heights = window.innerHeight;
        jQuery(".fullHt").css('min-height', (heights + 0) + "px");
    }
/*****************responsive view banner remove class fullHt class*************/	
$(window).resize(function(){
   var width = $(window).width();
   if(width < 992){
       $('.banner').removeClass('fullHt');
   }
})
.resize();//trigger the resize event on page load.

/***************************custom js for dashboard*********************/
/************************selected services 22.02.2018***************************/
/**********************time active****************/
$('.book-time-slid .item').click(function(){
  $(this).toggleClass('active');
});
/*************artist photo gallery slider****************/
	$('.par-art-slid').owlCarousel({
		loop:true,
		margin:0,
		nav:true,
		dots:false,
		autoplay:false,
		smartSpeed:250,
		autoplayTimeout:1800,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:3
			},
			1000:{
				items:4
			}
		},	
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ]
	});

	$('.might-like-img').owlCarousel({
		loop:true,
		margin:30,
		nav:true,
		dots:false,
		autoplay:false,
		smartSpeed:250,
		autoplayTimeout:1800,
		items:4,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ]
	});
	$('.wed-mobile-image').owlCarousel({ 
		loop:true,
		margin:0,
		nav:true,
		dots:false,
		autoplay:false, 
		items:1, 
		autoPlayTimeout:5000,
		navText: [
			"<i class='fa fa-angle-left'></i>",
			"<i class='fa fa-angle-right'></i>"
		],    
		responsive: {
			1000: {
				items:1
			},
			767: {
				items:1
			},
			320: {
			   items:1	
			}
		}
	}) ;	
	//mobile responsive menu
	$('.mob-main-menu > li > .dropper').click(function(){
		$(this).parent().toggleClass('activer').siblings().removeClass('activer');
		$(this).parent().siblings().find(".drop-menu").slideUp();
		if($(this).parent().hasClass('activer')){
			$(this).parent().find(".drop-menu").slideDown();
		}else{
			$(this).parent().find(".drop-menu").slideUp();
		}
	});

	$('.drop-menu > li > .dropper').click(function(){
		$(this).parent().toggleClass('activer').siblings().removeClass('activer');
		$(this).parent().siblings().find(".dropdown-sub-menu").slideUp();
		if($(this).parent().hasClass('activer')){
			$(this).parent().find(".dropdown-sub-menu").slideDown();
		}else{
			$(this).parent().find(".dropdown-sub-menu").slideUp();
		}
	});
	//end mobile responsive menu

//search option
	$('.custom-search .input-group-btn').click(function(){
		if($('body').hasClass('searching-data') && $('#ser-inp-field').val() !='')
		{
            searchData($('#ser-inp-field').val());
		}
	  $('body').toggleClass('searching-data');
	});
	/*************artist photo gallery slider****************/
	// $('.book-time-slid').owlCarousel({
	// 	loop:true,
	// 	margin:0,
	// 	nav:true,
	// 	dots:false,
	// 	autoplay:false,
	// 	smartSpeed:250,
	// 	autoplayTimeout:1800,
	// 	items:5,
	// 	navText: [
 //            "<i class='fa fa-angle-left'></i>",
 //            "<i class='fa fa-angle-right'></i>"
 //        ],
	// })
/*******************22.02.2018***************/
/*************artist photo gallery slider****************/
	// $('#mid_product_slider, #mid_product_slider_sec').owlCarousel({
	// 	loop:true,
	// 	margin:0,
	// 	nav:true,
	// 	/*animateOut: 'fadeOut',
	// 	animateIn: 'fadeIn',*/
	// 	dots:false,
	// 	autoplay:false,
	// 	smartSpeed:250,
	// 	autoplayTimeout:1800,
	// 	items:1,
	// 	navText: [
 //            "<i class='fa fa-angle-left'></i>",
 //            "<i class='fa fa-angle-right'></i>"
 //        ],
	// })
/*************End artist slider****************/
	// $('.par-art-slid').owlCarousel({
	// 	loop:true,
	// 	margin:0,
	// 	nav:true,
	// 	dots:false,
	// 	autoplay:false,
	// 	smartSpeed:250,
	// 	autoplayTimeout:1800,
	// 	items:3,
	// 	navText: [
 //            "<i class='fa fa-angle-left'></i>",
 //            "<i class='fa fa-angle-right'></i>"
 //        ],
	// })

/**********custome js***********/
/****************sign in sign out*****************/
$('.filter-btn').click(function(){
  if($('body').hasClass('open-fliter-blk')){
  	$('body').removeClass('open-fliter-blk');
  }
  else{
  	$('body').removeClass('open-fliter-blk');
  	$('body').addClass('open-fliter-blk');   
  }
});
//Open filter option menu
// $(".filter-btn").click(function(){
//   $('.listing-option').fadeToggle();
// });
// $(".h-menu-toggle").click(function(){
// 	if($('body').hasClass('open-menu')){
// 		$('body').removeClass('open-menu');
// 	}
// 	else{
// 		$('body').addClass('open-menu');
// 		}
// });
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
/*********************TO CHANGE LIST & GREED VIEW********************/
	$('a.h-greed-view').click(function(){
	  if($('body').hasClass('h-greed-view-open')){
		$('body').removeClass('h-lsit-view-open');
	  }
	  else{
		$('body').removeClass('h-lsit-view-open');
		$('body').addClass('h-greed-view-open');   
	  }
	});
	
	$('a.h-list-view').click(function(){
	  if($('body').hasClass('h-lsit-view-open')){
		$('body').removeClass('h-greed-view-open');
	  }
	  else{
		$('body').removeClass('h-greed-view-open');
		$('body').addClass('h-lsit-view-open');   
	  }
	});
/*********************OPEN SORT OPTION********************/
	$('.h-sort-icon').click(function(){
	  if($('body').hasClass('h-open-sort')){
		$('body').removeClass('h-open-sort');
	  }
	  else{
		$('body').removeClass('h-open-sort');
		$('body').addClass('h-open-sort');   
	  }
	});
/*********************END CHANGE LIST & GREED VIEW********************/
/***************************End custom js for dashboard***************/	
$(".hamberger").click(function(){
    $('body').toggleClass("menu-active");
    $(this).toggleClass("bar-active");
});

	// BS tabs hover (instead - hover write - click)
	$('.tab-menu a').hover(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	});

//alter div block
// 	jQuery(window).resize(function(){
// 	if (jQuery(window).width() <= 767){
// 		jQuery("#dv-story-holder-20-0 .story-content").insertAfter(jQuery(".story-image"));
// 		jQuery("#dv-story-holder-22-0 .story-content").insertAfter(jQuery(".story-image"));
// 		jQuery("#dv-story-holder-24-0 .story-content").insertAfter(jQuery(".story-image"));
// 		jQuery("#dv-story-holder-26-0 .story-content").insertAfter(jQuery(".story-image"));
// 		jQuery("#dv-story-holder-28-0 .story-content").insertAfter(jQuery(".story-image"));
// 		jQuery("#dv-story-holder-30-0 .story-content").insertAfter(jQuery(".story-image"));
// 	}
//  });
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
		autoplayTimeout:5000,
		items:1,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ]
	});
/**************************gallery slider************************/
	$('#gallery_slider').owlCarousel({
		loop:true,
		margin:5,
		nav:true,
		autoplayHoverPause:true,
		/*animateOut: 'fadeOut',
		animateIn: 'fadeIn',*/
		dots:false,
		autoplay:true,
		smartSpeed:250,
		autoplayTimeout:5000,
		responsive:{
			0:{
				items:2
			},
			600:{
				items:3
			},
			1000:{
				items:4
			}
		},	
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ]
	});
	
	$('#gallery_categories_slider').owlCarousel({
		loop:true,
		margin:30,
		nav:false,
		rtl:true,
		/*animateOut: 'fadeOut',
		animateIn: 'fadeIn',*/
		dots:true,
		autoplay:true,
		smartSpeed:250,
		autoplayTimeout:5000,
		autoplayHoverPause:true,
		responsive:{
			0:{
				items:2
			},
			600:{
				items:3
			},
			1000:{
				items:6
			}
		},	
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ]
	});
/****************************testimonials slider***********************/
	$('.testimonials_slider').owlCarousel({
		loop:true,
		margin:30,
		nav:false,
		/*animateOut: 'fadeOut',
		animateIn: 'fadeIn',*/
		dots:false,
		autoplay:true,
		smartSpeed:250,
		autoplayTimeout:5000,
		items:1,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ]
	});
/****************************testimonials slider***********************/
	$('.my-tab-sld').owlCarousel({
	  loop:true,
      margin:5,
	  nav:true,
	  dots:false,
	  autoplay:false,
	  smartSpeed:250,
	  autoplayTimeout:5000,
		responsive:{
			0:{
				items:3
				},
			600:{
				items:3
			},
			1000:{
				items:3
			}
			},
			navText: [
				"<i class='fa fa-angle-left'></i>",
				"<i class='fa fa-angle-right'></i>"
			]
	});
	
/****************************artist slider***********************/
	$('#artist_gal').owlCarousel({
		loop:true,
		margin:30,
		nav:true,
		/*animateOut: 'fadeOut',
		animateIn: 'fadeIn',*/
		dots:false,
		autoplay:true,
		smartSpeed:250,
		autoplayTimeout:5000,
		autoplayHoverPause: true,
		//items:4,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:2
			},
			1000:{
				items:4
			}
		},	
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ]
	});
	
	/****************************artist slider***********************/
	$('.recomanded_details_product_slider').owlCarousel({
		loop:true,
		margin:30,
		nav:true,
		dots:false,
		autoplay:false,
		smartSpeed:250,
		autoplayTimeout:5000,
		items:4,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ]
	});
	$('.details_product_slider').owlCarousel({
		loop:true,
		margin:30,
		nav:true,
		dots:false,
		autoplay:false,
		smartSpeed:250,
		autoplayTimeout:5000,
		items:1,
		navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
        ]
	});
/**************view_slider*************/
$('#view_slider').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    pagination : true,
    autoplayTimeout:5000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
});

$('#view_slider2').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    autoplay:true,
    pagination : true,
    autoplayTimeout:5000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});
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



/*****************************Open responsive menu******************/
$(".hamberger").click(function(){
	if($('body').hasClass('open-menu')){
		$('body').removeClass('open-menu');
	}
	else{
		$('body').addClass('open-menu');
		}
});
/*********************select gift wrap content*************/
// $('.box-containr').click(function(){
//
// 	var id = $(this).attr('id');
// 	$('.box-containr').removeClass('selected-wrap');
// 	$("#"+id).addClass('selected-wrap');
// });


    // $('.paper-containr').click(function(){
    //     var id = $(this).attr('id');
    //     $('.paper-containr').removeClass('selected-wrap');
    //     $("#"+id).addClass('selected-wrap');
    // });
    // $('.message-card-containr').click(function(){
    //     var id = $(this).attr('id');
    //     $('.message-card-containr').removeClass('selected-wrap');
    //     $("#"+id).addClass('selected-wrap');
    // });



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




	
});


