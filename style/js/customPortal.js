/* ------------------------------------------ */
/*             TABLE OF CONTENTS
/* ------------------------------------------ */

/*   01 - MENU                  */
/*   02 - Portfolio             */
/*   03 - Sticky Navigation     */
/*   04 - Scroll Div            */
/*   05 - owl Slider            */
/*   06 - Hover Portfolio       */
/*   07 - Hover Shop Content    */
/*   08 - Search                */
/*   09 - Contact form          */
/*   10 - Fancybox              */
/*   11 - Progress-Bar          */
/*   12 - Option-Box            */
/*   13 - Accordions            */
/*   14 - Flickr                */
/*   15 - Tweet                 */
/*   16 - Items Number Shop     */
/*   17 - Shop Checkout         */
/*   18 - Shop images zoom      */
/*   19 - Features us           */
/*   20 - Case Studies          */
/*   21 - Tabs Work Process     */
/*   22 - Back to top button    */
/*   23 - Parallax Mobile       */
/*   24 - Tooltip               */
/*   25 - WOW Animation         */
/*   26 - Date Count down       */
/*   27 - Social Share          */


/*-----------------------------------------------------------------------------------*/
/*	Start MENU
/*-----------------------------------------------------------------------------------*/


	$(document).ready(function () {
		parent_list = jQuery('li.has-sub');
		parent_list.on({
			'mouseover': function () {
				jQuery(this).find('ul:first').addClass('animated fadeIn');
			},
			'mouseleave': function () {
				jQuery(this).find('ul:first').removeClass('animated fadeIn');
			}
		});
	});


/*-----------------------------------------------------------------------------------*/
/*	End MENU
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Start Sticky Navigation
/*-----------------------------------------------------------------------------------*/

//menu header//
jQuery(document).ready(function($){
    //if you change this breakpoint in the style.css file (or _layout.scss if you use SASS), don't forget to update this value as well
    var MQL = 1170;

    //primary navigation slide-in effect
    if($(window).width() > MQL) {
        var headerHeight = $('.Navbar-Header').height();
        $(window).on('scroll',
        {
            previousTop: 0
        },
        function () {
            var currentTop = $(window).scrollTop();
            //check if user is scrolling up
            if (currentTop < this.previousTop ) {
                //if scrolling up...
                if (currentTop > 0 && $('.Navbar-Header').hasClass('is-fixed')) {
                    $('.Navbar-Header').addClass('is-visible');
                } else {
                    $('.Navbar-Header').removeClass('is-visible is-fixed');
                }
            } else {
                //if scrolling down...
                $('.Navbar-Header').removeClass('is-visible');
                if( currentTop > headerHeight && !$('.Navbar-Header').hasClass('is-fixed')) $('.Navbar-Header').addClass('is-fixed');
            }
            this.previousTop = currentTop;
        });
    }


});


$(document).ready(function () {

if($('.Navbar-Header-sticky').attr('data-sticky') === "true"){
	$(window).on("scroll",function(){
		var Scrl = $(window).scrollTop();
		if (Scrl > 1) {
			$('.Navbar-Header-sticky').addClass('sticky animated fadeInDown');
		}else{
			$('.Navbar-Header-sticky').removeClass('sticky animated fadeInDown');
		}
	});
	$('document').ready(function(){
		var Scrl = $(window).scrollTop();
		if (Scrl > 1) {
			$('.Navbar-Header-sticky').addClass('sticky animated fadeInDown');
		}else{
			$('.Navbar-Header-sticky').removeClass('sticky animated fadeInDown');
		}
	});
}

});



/*-----------------------------------------------------------------------------------*/
/*	End Sticky Navigation
/*-----------------------------------------------------------------------------------*/

$(document).ready(function() {  
	$(".SliderText").each(function(){
		var contentHeight = $(this).height();
		contentHeight = (contentHeight * 8) / 22;
		$(this).css("margin-top",contentHeight);
	});
});	


/*-----------------------------------------------------------------------------------*/
/*	Start Scroll counter
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	End Scroll counter
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Start SCROLL DIVS
/*-----------------------------------------------------------------------------------*/

$(document).ready(function () {

(function() {

 var current = 1;

 var height = $('.text-scroll').height();

 var numberDivs = $('.text-scroll').children().length;

 var first = $('.text-scroll h1:nth-child(1)');

 setInterval(function() {

	var number = current * -height;

	first.css('margin-top', number + 'px');

	if (current === numberDivs) {

	  first.css('margin-top', '0px');

	  current = 1;

	} else current++;

 }, 2500);

})();

});

/*-----------------------------------------------------------------------------------*/
/*	End SCROLL DIVS
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Start owl Slider
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	End owl Slider
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Start Portfolio
/*-----------------------------------------------------------------------------------*/

$(document).ready(function () {

	$('ul#filters li a').click(function(e) {
		e.preventDefault();
	    $('ul#filters .active-link').removeClass('active-link');
		$(this).parent().addClass('active-link');
		var filter = $(this).attr('data-filter').toLowerCase();
		$('.portfolio-items > div:visible').each(function(i) {
			$(this).fadeOut(200,function(){show(filter);});
			$('.portfolio-items > div').addClass('portfolio-item-masonry');
		});
		return false;
	});

	function show(filter){
		if(filter === '*') {
			$('.portfolio-items > div').fadeIn(200);
			$('.portfolio-items > div').removeClass('portfolio-item-masonry');
		} else {
			$('.portfolio-items > div').each(function() {
				if($(this).attr('data-filter') === filter) {
					$(this).fadeIn(200);
				}
			});
		}
	}

});

/*-----------------------------------------------------------------------------------*/
/*	End Portfolio
/*-----------------------------------------------------------------------------------*

/*-----------------------------------------------------------------------------------*/
/*	Start Hover Portfolio
/*-----------------------------------------------------------------------------------*/

$(document).ready(function () {
	$('.portfolio-item').each(function(){
		var $this = $(this),
			$index = $this.index(),
			contents = $this.find('.projectItem-hover');
		$this.hover(function(){
			contents.fadeIn(300).find('.link').removeClass('animated fadeOutUp').addClass('animated fadeInDown');
			contents.find('.zoom').removeClass('animated fadeOutDown').addClass('animated fadeInUp');
			return false;
		},function(){
			contents.fadeOut(30).find('.link').removeClass('animated fadeInDown').addClass('animated fadeOutUp');
			contents.find('.zoom').removeClass('animated fadeInUp').addClass('animated fadeOutDown');
			return false;
		});
	});
});

/*-----------------------------------------------------------------------------------*/
/*	End Hover Portfolio
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Start Hover Shop Content


$(document).ready(function () {
	$('.top-shop-content').each(function(){
		var $this = $(this),
			$index = $this.index(),
			contents = $this.find('.hover-shop-content');
		$this.hover(function(){
			contents.fadeIn(300).find('.hover-shop-content').removeClass('animated fadeOutUp').addClass('animated fadeInDown');
			contents.find('.zoom').removeClass('animated fadeOutDown').addClass('animated fadeInUp');
			return false;
		},function(){
			contents.fadeOut(300).find('.hover-shop-content').removeClass('animated fadeInDown').addClass('animated fadeOutUp');
			contents.find('.zoom').removeClass('animated fadeInUp').addClass('animated fadeOutDown');
			return false;
		});
	});
});
-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	End Hover Shop Content
/*-----------------------------------------------------------------------------------*/

/* ---------------------------------------------------------------------- */
/*	Start Search
/* ---------------------------------------------------------------------- */




/* ---------------------------------------------------------------------- */
/*	End Search
/* ---------------------------------------------------------------------- */

/*-----------------------------------------------------------------------------------*/
/*	Start Contact form
/*-----------------------------------------------------------------------------------*/
			

/*-----------------------------------------------------------------------------------*/
/*	End Contact form
/*-----------------------------------------------------------------------------------*/

/* ---------------------------------------------------------------------- */
/*	Start Fancybox
/* ---------------------------------------------------------------------- */


/* ---------------------------------------------------------------------- */
/*	End Fancybox
/* ---------------------------------------------------------------------- */

/*-----------------------------------------------------------------------------------*/
/*	Start Progress-Bar
/*-----------------------------------------------------------------------------------*/

$(document).ready(function () {
	if (jQuery(".progress-bar").length) {
		jQuery(".progress-bar").each(function(){
			var $this = jQuery(this);
			var percent = $this.attr("data-percent");
			$this.bind("inview", function(event, isInView, visiblePartX, visiblePartY) {
				if (isInView) {
					$this.animate({ "width" : percent + "%"}, percent*20);
				}
			});
		});
	}

});

/*-----------------------------------------------------------------------------------*/
/*	End Progress-Bar
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Start Option-Box
/*-----------------------------------------------------------------------------------*/

	/*-----------------------------------------------------------------------------------*/
	/*	Strat LOADING OVERLAY
	/*-----------------------------------------------------------------------------------*/

	$(window).load(function()
	{
		$(".loading-overlay .spinner").fadeOut(300);

		$(".loading-overlay").fadeOut(300);
	});

	$(window).load(function() {
	  $('body').css({'overflow':'auto', 'height':'auto', 'position':'relative'});
	});

	/*-----------------------------------------------------------------------------------*/
	/*	End LOADING OVERLAY
	/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	End Option-Box
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Start Accordions
/*-----------------------------------------------------------------------------------*/

jQuery(".tap-title").each(function(){
	jQuery(this).click(function() {
		if (jQuery(this).parent().parent().hasClass("toggle-accordion")) {
			jQuery(this).parent().find("li:first .tap-title").addClass("active");
			jQuery(this).parent().find("li:first .tap-title").next(".accordion-inner").addClass("active");
			jQuery(this).toggleClass("active");
			jQuery(this).next(".accordion-inner").slideToggle().toggleClass("active");
			jQuery(this).find("i").toggleClass("fa-plus").toggleClass("fa-minus");
		}else {
			if (jQuery(this).next().is(":hidden")) {
				jQuery(this).parent().parent().find(".tap-title").removeClass("active").next().slideUp(200);
				jQuery(this).parent().parent().find(".tap-title").next().removeClass("active").slideUp(200);
				jQuery(this).toggleClass("active").next().slideDown(200);
				jQuery(this).next(".accordion-inner").toggleClass("active");
				jQuery(this).parent().parent().find("i").removeClass("fa-minus").addClass("fa-plus");
				jQuery(this).find("i").removeClass("fa-plus").addClass("fa-minus");
			}
		}
		return false;
	});
});

jQuery(".tap-title2").each(function(){
	jQuery(this).click(function() {
		if (jQuery(this).parent().parent().hasClass("toggle-accordion")) {
			jQuery(this).parent().find("li:first .tap-title2").addClass("active");
			jQuery(this).parent().find("li:first .tap-title2").next(".accordion-inner").addClass("active");
			jQuery(this).toggleClass("active");
			jQuery(this).next(".accordion-inner").slideToggle().toggleClass("active");
			jQuery(this).find("i").toggleClass("fa-caret-right").toggleClass("fa-caret-down");
		}else {
			if (jQuery(this).next().is(":hidden")) {
				jQuery(this).parent().parent().find(".tap-title2").removeClass("active").next().slideUp(200);
				jQuery(this).parent().parent().find(".tap-title2").next().removeClass("active").slideUp(200);
				jQuery(this).toggleClass("active").next().slideDown(200);
				jQuery(this).next(".accordion-inner").toggleClass("active");
				jQuery(this).parent().parent().find("i").removeClass("fa-caret-down").addClass("fa-caret-right");
				jQuery(this).find("i").removeClass("fa-caret-right").addClass("fa-caret-down");
			}
		}
		return false;
	});
});


/*-----------------------------------------------------------------------------------*/
/*	End Accordions
/*-----------------------------------------------------------------------------------*/


/* ---------------------------------------------------------------------- */
/*	Start Flickr
/* ---------------------------------------------------------------------- */



/*-----------------------------------------------------------------------------------*/
/*	End Flickr
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Start Tweet
/*-----------------------------------------------------------------------------------*/



/*-----------------------------------------------------------------------------------*/
/*	End Tweet
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Start Items Number Shop
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	End Items Number Shop
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Start Shop Checkout
/*-----------------------------------------------------------------------------------*/	

/*-----------------------------------------------------------------------------------*/
/*	Start Shop Checkout
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Start Shop images zoom
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	End Shop images zoom
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Start Features us
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	End Features us
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Start Case Studies
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($){
	var tabItems = $('.Top-Case a'),
		tabContentWrapper = $('.Tap-Case');

	tabItems.on('click', function(event){
		event.preventDefault();
		var selectedItem = $(this);
		if( !selectedItem.hasClass('selected') ) {
			var selectedTab = selectedItem.data('content'),
				selectedContent = tabContentWrapper.find('li[data-content="'+selectedTab+'"]'),
				slectedContentHeight = selectedContent.innerHeight();

			tabItems .parent().removeClass('selected');
			selectedItem .parent().addClass('selected');
			selectedContent.addClass('selected').siblings('li').removeClass('selected');
			//animate tabContentWrapper height when content changes
			tabContentWrapper.animate({
				'height': slectedContentHeight
			}, 200);
		}
	});

});

/*-----------------------------------------------------------------------------------*/
/*	End Case Studies
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Start Tabs Work Process
/*-----------------------------------------------------------------------------------*/


jQuery(document).ready(function($){
	var tabItems = $('.Process-tabs-navigation a'),
		tabContentWrapper = $('.Process-tabs-content');

	tabItems.on('click', function(event){
		event.preventDefault();
		var selectedItem = $(this);
		if( !selectedItem.hasClass('selected') ) {
			var selectedTab = selectedItem.data('content'),
				selectedContent = tabContentWrapper.find('li[data-content="'+selectedTab+'"]'),
				slectedContentHeight = selectedContent.innerHeight();

			tabItems.removeClass('selected');
			selectedItem.addClass('selected');
			selectedContent.addClass('selected').siblings('li').removeClass('selected');
			//animate tabContentWrapper height when content changes
			tabContentWrapper.animate({
				'height': slectedContentHeight
			}, 100);
		}
	});

});

/*-----------------------------------------------------------------------------------*/
/*	End Tabs Work Process
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/*	Start Back to top button
/*-----------------------------------------------------------------------------------*/

var winScroll = $(window).scrollTop();
	if (winScroll > 1) {
		$('#to-top').css({bottom:"10px"});
	} else {
		$('#to-top').css({bottom:"-100px"});
	}
	$(window).on("scroll",function(){
		winScroll = $(window).scrollTop();

		if (winScroll > 1) {
			$('#to-top').css({opacity:1,bottom:"30px"});
		} else {
			$('#to-top').css({opacity:0,bottom:"-100px"});
		}
	});
	$('#to-top').click(function(){
		$('html, body').animate({scrollTop: '0px'}, 800);
		return false;
});

$('.fa-hover').wrapInner('<span />');

/*-----------------------------------------------------------------------------------*/
/*	End Back to top button
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/*	Start Parallax Mobile
/*-----------------------------------------------------------------------------------*/

$(document).ready(function () {

    if (navigator.userAgent.match(/Android/i) ||

        navigator.userAgent.match(/webOS/i) ||

        navigator.userAgent.match(/iPhone/i) ||

        navigator.userAgent.match(/iPad/i) ||

        navigator.userAgent.match(/iPod/i) ||

        navigator.userAgent.match(/BlackBerry/i)) {

        $('.parallax').addClass('mobile');

    }

});

/*-----------------------------------------------------------------------------------*/
/*	End Parallax Mobile
/*-----------------------------------------------------------------------------------*/

/* ---------------------------------------------------------------------- */
/*	Start Tooltip
/* ---------------------------------------------------------------------- */


$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

/*-----------------------------------------------------------------------------------*/
/*	End Tooltip
/*-----------------------------------------------------------------------------------*/


/* ---------------------------------------------------------------------- */
/*	Start WOW Animation
/* ---------------------------------------------------------------------- */



/*-----------------------------------------------------------------------------------*/
/*	End WOW Animation
/*-----------------------------------------------------------------------------------*/

