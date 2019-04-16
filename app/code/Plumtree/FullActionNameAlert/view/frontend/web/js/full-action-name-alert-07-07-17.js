/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*jshint browser:true jquery:true*/
define([
    "jquery"
], function($){
    "use strict";
	
	// top header block start 
	jQuery('a.close').click(function(){
		$('div.block-static-block').hide();
	});
	// top header block end
	
	// category page start
	
	// category page end
	jQuery(".category_content2:last").appendTo("div.column");	
	// pdp custom product start
	jQuery("input[name='EventloadRadio']").click(function(){												 
		if (jQuery(this).val() === 'simpleproduct') {
			$('div.product-add-form').hide();
			$('div.related_product').show();
		}else{
			$('div.product-add-form').show();
			$('div.related_product').hide();
		}
	});
	// pdp custom product end

	// stick header start
	jQuery(window).scroll(function() {
		var height = jQuery(window).scrollTop();		
		//console.log('height:-'+jQuery("div.fixed-menu").children().length);
		if(height  > 160) {
			jQuery('.page-header').addClass('fixed-menu-sticky');
		}else{
			jQuery('.page-header').removeClass('fixed-menu-sticky');
		}
	});
	
	// stick header end
	
	
	
	// start Top-to-back 
	if (jQuery('#back-to-top').length) {
    var scrollTrigger = 400, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                jQuery('#back-to-top').addClass('show');
            } else {
                jQuery('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    jQuery(window).on('scroll', function () {
        backToTop();
    });
    jQuery('#back-to-top').on('click', function (e) {
        e.preventDefault();
        jQuery('html,body').animate({
            scrollTop: 0
        }, 800);
    });
}

// End Top-to-back 


// Start Footer Accordion (careers page)

var acc = document.getElementsByClassName("accordion");
var panel = document.getElementsByClassName('panel');

for (var i = 0; i < acc.length; i++) {
    acc[i].onclick = function() {
    	var setClasses = !this.classList.contains('active');
        setClass(acc, 'active', 'remove');
        setClass(panel, 'show', 'remove');
        
       	if (setClasses) {
            this.classList.toggle("active");
            this.nextElementSibling.classList.toggle("show");
        }
    }
}

function setClass(els, className, fnName) {
    for (var i = 0; i < els.length; i++) {
        els[i].classList[fnName](className);
    }
}

// End Footer Accordion


var windowWidth = $(window).width();
jQuery( "ul.header" ).wrap( "<div tabindex='0' class='my-div' ></div>" );


// start category page - new arrival slider 
if(windowWidth < 768){
//jQuery( "div.block-content" ).after( jQuery( "<div class='sponsor-media-count-6881703303 sponsor-media-count'></div> <button id='prev-6881703303' class='prev'> &lt; </button>	<button id='next-6881703303' class='next'> &gt; </button>" ) );
var pro_img = jQuery('ol li').length;
for (i = 0; i < pro_img; i++){
	jQuery('div.sponsor-media-count-6881703303').append('<div class="count">&nbsp;</div>');
	
}

jQuery("ol.product-items li:eq(0)").nextAll().hide();
jQuery(".sponsor-media-count-6881703303 div:eq(0)").trigger('click');


jQuery(".sponsor-media-count-6881703303 div").click(function (e) {
	var $this = jQuery(this),
		index = $this.index();
	jQuery(".sponsor-media-count-6881703303 div").removeClass('selected');
	$this.addClass('selected');
	jQuery("ol.product-items li").eq(index).show().siblings().hide();
});
jQuery('#next-6881703303').click(function(){ 
	var $selected = jQuery('div.sponsor-media-count-6881703303').find('.selected');
	var index = $selected.next('div').index();
	if(index == -1){
		index = 0;
	}
	var $curr = jQuery(".sponsor-media-count-6881703303 div").eq(index);
	jQuery(".sponsor-media-count-6881703303 div").removeClass('selected');
	$curr.addClass('selected');
	jQuery("ol.product-items li").eq(index).show().siblings().hide();
});

jQuery('#prev-6881703303').click(function(){ 

	var $selected = jQuery('div.sponsor-media-count-6881703303').find('.selected');
	var index = $selected.prev('div').index();
	var $curr = jQuery(".sponsor-media-count-6881703303 div").eq(index);
	jQuery(".sponsor-media-count-6881703303 div").removeClass('selected');
	$curr.addClass('selected');
	jQuery("ol.product-items li").eq(index).show().siblings().hide();
});

jQuery('#next-6881703303').trigger('click');
}
// end category page - new arrival slider 


// start category page and sub category - Layer navigation Left side

if(windowWidth < 768){
$(".dropdown dt a").click(function() {
		$(".dropdown dd ul").toggle();
	});
				
	$(".dropdown dd ul li a").click(function() {
		var text = $(this).html();
		$(".dropdown dt a span").html(text);
		$(".dropdown dd ul").hide();
		$("#result").html("Selected value is: " + getSelectedValue("sample"));
		
		$(this).next('input:radio').prop("checked", true);
	});
				
	function getSelectedValue(id) {
		return $("#" + id).find("dt a span.value").html();
	}

	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
		if (! $clicked.parents().hasClass("dropdown"))
			$(".dropdown dd ul").hide();
	});
}
// end category page and sub category - Layer navigation Left side



// start listing page sorter dropdown


$(".sorter-dropdown dt a").click(function() {
		$(".sorter-dropdown dd ul").toggle();
	});
				
	$(".sorter-dropdown dd ul li a").click(function() {
		var text = $(this).html();
		$(".sorter-dropdown dt a span").html(text);
		$(".sorter-dropdown dd ul").hide();
		$("#result").html("Selected value is: " + getSelectedValue("sorter"));
		$(this).next('input:radio').prop("checked", true);
	});
				
	function getSelectedValue(id) {
		return $("#" + id).find("dt a span.value").html();
	}

	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
		if (! $clicked.parents().hasClass("sorter-dropdown"))
			$(".sorter-dropdown dd ul").hide();
	});

// end listing page sorter dropdown

	
	// custom layout category page start 
	if (jQuery("body").hasClass("custom-column-layout")) {
		jQuery('ol.products li:nth-child(8)').addClass('featured-product fright');
		jQuery('ol.products li:nth-child(23)').addClass('featured-product fleft');
	// custom layout category page end
	}

	
	// Start onclick Sorter toggleClass	active-toolbar div toolbar-sorter
	var removeClass = true;	
	jQuery(".toolbar-sorter .sorter-dropdown dt a").click(function () {
		$(".toolbar-sorter").toggleClass('active-toolbar');
		removeClass = false;
	});

	jQuery(".toolbar-sorter").click(function() {
		removeClass = false;
	});

	jQuery("html").click(function () {
		if (removeClass) {
			jQuery(".toolbar-sorter").removeClass('active-toolbar');
		}
		removeClass = true;
	});	
	
	// End onclick Sorter toggleClass	active-toolbar div toolbar-sorter
	
	
	// start  Quantity input
	
	jQuery(".qty .control").prepend('<div class="dec button">-</div>');
  	jQuery(".qty .control").append('<div class="inc button">+</div>');

  jQuery(".button").on("click", function() {

    var $button = $(this);
    var oldValue = $button.parent().find("input").val();

    if ($button.text() == "+") {
  	  var newVal = parseFloat(oldValue) + 1;
  	} else {
	   // Don't allow decrementing below zero
      if (oldValue > 0) {
        var newVal = parseFloat(oldValue) - 1;
	    } else {
        newVal = 0;
      }
	  }

    $button.parent().find("input").val(newVal);

  });


	// End Quantity input
	
	
	////////// check for thumb images exist of not start
	
		jQuery( document ).ajaxComplete(function() {
			var thumnimg = jQuery("div.fotorama__nav--thumbs").find("img").length;
			if(thumnimg == 0){
					jQuery('div.pdp-left-icons').addClass('without-thumb');
				}
					
		 });
	
	
	
	////////// check for thumb images exist of not end
	
	// faq sticky start
	jQuery(window).scroll(function() {
	if( jQuery('#nav-anchor').length > 0){
	var window_top = jQuery(window).scrollTop() + 62; // the "12" should equal the margin-top value for nav.stick
    var div_top = jQuery('#nav-anchor').offset().top;
        if (window_top > div_top) {
            jQuery(".faq-left-side").addClass('fixed-left-menu-sticky');
			jQuery(".faq-right-side-sr").addClass('faq-rgt-shipping-returns');
        }
		 else {
            jQuery(".faq-left-side").removeClass('fixed-left-menu-sticky');
			jQuery(".faq-right-side-sr").removeClass('faq-rgt-shipping-returns');
        }
		}
	});
	
	
	jQuery(".faq-lft-link-sr").click(function() {
		
		jQuery(".faq-right-side-sr").addClass('faq-rgt-shipping-returns');
		jQuery(".faq-right-side-fd").removeClass('faq-rgt-furniture-delivery');
		jQuery(".faq-right-side-checkout").removeClass('faq-rgt-checkout');
		jQuery(".faq-right-side-promotions").removeClass('faq-rgt-promotions');
		jQuery(".faq-right-side-trade").removeClass('faq-rgt-trade');
	});
	jQuery(".faq-lft-link-fd").click(function() {
		jQuery(".faq-right-side-sr").removeClass('faq-rgt-shipping-returns');
		jQuery(".faq-right-side-fd").addClass('faq-rgt-furniture-delivery');
		jQuery(".faq-right-side-checkout").removeClass('faq-rgt-checkout');
		jQuery(".faq-right-side-promotions").removeClass('faq-rgt-promotions');
		jQuery(".faq-right-side-trade").removeClass('faq-rgt-trade');
	});
	jQuery(".faq-lft-link-checkout").click(function() {
		jQuery(".faq-right-side-sr").removeClass('faq-rgt-shipping-returns');
		jQuery(".faq-right-side-fd").removeClass('faq-rgt-furniture-delivery');
		jQuery(".faq-right-side-checkout").addClass('faq-rgt-checkout');
		jQuery(".faq-right-side-promotions").removeClass('faq-rgt-promotions');
		jQuery(".faq-right-side-trade").removeClass('faq-rgt-trade');
	});
	jQuery(".faq-lft-link-promotions").click(function() {
		jQuery(".faq-right-side-sr").removeClass('faq-rgt-shipping-returns');
		jQuery(".faq-right-side-fd").removeClass('faq-rgt-furniture-delivery');
		jQuery(".faq-right-side-checkout").removeClass('faq-rgt-checkout');
		jQuery(".faq-right-side-promotions").addClass('faq-rgt-promotions');
		jQuery(".faq-right-side-trade").removeClass('faq-rgt-trade');
	});
	jQuery(".faq-lft-link-trade").click(function() {
		jQuery(".faq-right-side-sr").removeClass('faq-rgt-shipping-returns');
		jQuery(".faq-right-side-fd").removeClass('faq-rgt-furniture-delivery');
		jQuery(".faq-right-side-checkout").removeClass('faq-rgt-checkout');
		jQuery(".faq-right-side-promotions").removeClass('faq-rgt-promotions');
		jQuery(".faq-right-side-trade").addClass('faq-rgt-trade');
	});
	
	

	/**
         * This part handles the highlighting functionality.
         * We use the scroll functionality again, some array creation and 
         * manipulation, class adding and class removing, and conditional testing
         */
        var aChildren = $(".faq-left-side ul li").children(); // find the a children of the list items
        var aArray = []; // create the empty aArray
        for (var i=0; i < aChildren.length; i++) {    
            var aChild = aChildren[i];
            var ahref = $(aChild).attr('href');
            aArray.push(ahref);
        } // this for loop fills the aArray with attribute href values
        
        $(window).scroll(function(){
            var windowPos = $(window).scrollTop() + 78; // get the offset of the window from the top of page
            var windowHeight = $(window).height(); // get the height of the window
            var docHeight = $(document).height();
            
            for (var i=0; i < aArray.length; i++) {
                var theID = aArray[i];
                var divPos = $(theID).offset().top; // get the offset of the div from the top of page
                var divHeight = $(theID).height(); // get the height of the div in question
                if (windowPos >= divPos && windowPos < (divPos + divHeight)) {
                    $("a[href='" + theID + "']").addClass("nav-active");
                } else {
                    $("a[href='" + theID + "']").removeClass("nav-active");
                }
            }
            
            if(windowPos + windowHeight == docHeight) {
                if (!$(".faq-left-side ul li:last-child a").hasClass("nav-active")) {
                    var navActiveCurrent = $(".nav-active").attr("href");
                    $("a[href='" + navActiveCurrent + "']").removeClass("nav-active");
                    $(".faq-left-side ul li:last-child a").addClass("nav-active");
                }
            }
        });
	
	// faq sticky end

// Smooth Scroll
	//$(document).ready(function(){
	  // Add smooth scrolling to all links
	  $(".faq-left-side ul li a").on('click', function(event) {
	
	    // Make sure this.hash has a value before overriding default behavior
	    if (this.hash !== "") {
		 // Prevent default anchor click behavior
		 event.preventDefault();
	
		 // Store hash
		 var hash = this.hash;
	
		 // Using jQuery's animate() method to add smooth page scroll
		 // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
		 $('html, body').animate({
		   scrollTop: $(hash).offset().top
		 }, 800, function(){
	   
		   // Add hash (#) to URL when done scrolling (default click behavior)
		   window.location.hash = hash;
		 });
	    } // End if
	  });
	//});
// End of smooth scroll

/*var nav = $('.content-nav');
var contentNav = nav.offset().top;*/
	//var nav = $('#sticky');
	//var stickyTop = nav.offset().top;
	//$('.fixed-left-menu-sticky').offset().top;
	if( jQuery('footer').length > 0){
	var footerTop = $('footer').offset().top;
	var stickyHeight = $('.fixed-left-menu-sticky').height();	
	$(window).scroll(function(){ // scroll event
		var windowTop = $(window).scrollTop() + 450;		  
		if (windowTop > footerTop ) {
        	$('.faq-left-side').removeClass('fixed-left-menu-sticky');
    	}
	});
	}

	$( ".cms-faqs .page-title-wrapper" ).append( $( ".need-help-area" ) );
	$( ".checkout-cart-index .page-title-wrapper" ).append( $( ".need-help-area" ) );
	// start  - request-a-swatch
	/*if(window.location.href.indexOf("request-a-swatch") > -1) {
	
     $('.icon-zoom-in').fancybox({
    fitToView: false,
    beforeShow: function () {
        this.width = 500;
        this.height = 500;
    }
    });
   

	/* Different effects * /
	// Change title type, overlay closing speed		
	$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedOut : 0
					}
				}
			});		
 // Disable opening and closing animations, change title type
	$(".fancybox-effects-b").fancybox({
				openEffect  : 'none',
				closeEffect	: 'none',

				helpers : {
					title : {
						type : 'over'
					}
				}
			});		
			
/*Button helper. Disable animations, hide close button, change title type and content * /
	$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});		
/*  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked * /			
    $('.fancybox-thumbs').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,
				arrows    : false,
				nextClick : true,

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});
	}*/
	//	end - request-a-swatch
	console.log('full-action-name-alert.js');
});
