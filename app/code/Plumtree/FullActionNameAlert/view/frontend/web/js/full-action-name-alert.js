/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*jshint browser:true jquery:true*/
define([
    "jquery"
], function($){
    "use strict";
	
	// top stickey start
	  var visited = $.cookie("top-stickey");
	  
	    // set cookie
		var cookie_val = $.cookie("promo_bar_reset");
		var date = new Date();
		var minutes = cookie_val
		date.setTime(date.getTime() + (minutes * 60 * 1000));
		$.cookie('top-stickey', 'yes', { expires: date, path: '/' });
	// top stickey end
			
	// top header block end
	
	// mini cart block start
	jQuery('#btn-minicart-close').click(function(){
		$('div.block-minicart').hide();
	});
	
	jQuery(document).on("click", '#btn-minicart-close', function ($e) {
		jQuery('a.showcart').trigger('click');
	} );
	
	// mini cart block end
	
	// category page start
	
	// category page end
	jQuery(".category_content2:last").appendTo("div.column");	
	
	
	// pdp custom product start
	jQuery('div.product-info-price span.price-wrapper').hide();
		
	if (jQuery("body").hasClass("simple-product-view")) {
	jQuery('div.product-info-price span.price-wrapper').show();
	}
	
	if (jQuery("body").hasClass("custom-product-view")) {
	jQuery('span.price-container').show();
	}
	

	if (jQuery('input[type=radio].customproduct').length) {
	
	}else{
		$('div.product-add-form').show();
		}
	var addhight = 0;
	jQuery("input[name='EventloadRadio']").click(function(){												 
		if (jQuery(this).val() === 'simpleproduct') {
			$('div.product-add-form').hide();
			$('div.related_product').show();
			$('div.product-info-price').hide();
			
			$('.simp_opt_prc').show();
			$('.cust_opt_prc').hide();
			
			$('div.related_product div.price-box').hide();
			$('div.product-info-main').removeClass('stat');
		}else{
			$('div.product-info-main').addClass('stat');
			$('.simp_opt_prc').hide();
			$('.cust_opt_prc').hide();
			$('.cust_opt_prc:first').show();
			var cust_opt_prc = $('.cust_opt_prc').html();
			
			if($('span.opt-cnt').length){
				
			}else{
				jQuery('div.product-options-bottom span.price-wrapper').html(cust_opt_prc);
				}
			
			$('div.product-add-form').show();
			$('div.related_product').hide();
			$('div.product-info-price').show();
			$('div.product-options-wrapper label.label-title:first').trigger('click');
			addhight = 250;
			jQuery('#product-addtocart-button').hide();
			jQuery('button.scrolltodiv ').show();
			
		}
	});
	
	jQuery('label.label-title').on('click', function() {
	});
	
	jQuery('div.control div.pro-ing,div.control span.sw-tit,div.control .radio').on('click', function() {
		jQuery('div.product-info-price span.price-wrapper').show();
		jQuery('span.price-wrapper').show();
	});
	
	jQuery("label.label-title").each(function(i) {
		jQuery(this).find('span:first').prepend(++i+'.');
	});
	
	// pdp custom product end

	// stick header start
	
	  jQuery(".header.content").append( $(".block.ves-megamenu"));
	
	// group product sticky product-count show after title
	
	

var windowWidth = $(window).width();
if(windowWidth >= 768){
	jQuery(window).scroll(function() {
		var height = jQuery(window).scrollTop();
		
		if(height  > 160) {
			jQuery('.page-header').addClass('fixed-menu-sticky');
			jQuery('#maincontent').addClass('maincontent-sticky');
			height = height-130;
			jQuery('div.categories-menu').addClass('cat-sticky');
			jQuery('div.categories-menu').removeClass('cat-sticky1');
			jQuery('div.categories-menu').css('top',height+'px');
			
		}else{
			jQuery('.page-header').removeClass('fixed-menu-sticky');
			jQuery('#maincontent').removeClass('maincontent-sticky');
			jQuery('div.categories-menu').removeClass('cat-sticky');

			
		}
	});
}
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
//jQuery( "ul.header" ).wrap( "<div tabindex='0' class='my-div' ></div>" );


// start category page - new arrival slider 
if(windowWidth < 768){
var pro_img = jQuery('img.product-image-photo').length;

for (i = 0; i < pro_img; i++){
	jQuery('div.sponsor-media-count-6881703303').append('<div class="count">&nbsp;</div>');
	
}

jQuery("ol.widget-new-grid li:eq(0)").nextAll().hide();
jQuery("div.upsell ol.widget-new-grid li:eq(0)").nextAll().hide();

jQuery("ol.widget-product-grid li:eq(0)").nextAll().hide();
jQuery(".sponsor-media-count-6881703303 div:eq(0)").trigger('click');


jQuery(".sponsor-media-count-6881703303 div").click(function (e) {
	var $this = jQuery(this),
		index = $this.index();
	jQuery(".sponsor-media-count-6881703303 div").removeClass('selected');
	$this.addClass('selected');
	jQuery("ol.widget-new-grid li").eq(index).show().siblings().hide();
	jQuery("ol.widget-product-grid li").eq(index).show().siblings().hide();
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
	jQuery("ol.widget-new-grid li").eq(index).show().siblings().hide();
	jQuery("ol.widget-product-grid li").eq(index).show().siblings().hide();
});

jQuery('#prev-6881703303').click(function(){ 

	var $selected = jQuery('div.sponsor-media-count-6881703303').find('.selected');
	var index = $selected.prev('div').index();
	var $curr = jQuery(".sponsor-media-count-6881703303 div").eq(index);
	jQuery(".sponsor-media-count-6881703303 div").removeClass('selected');
	$curr.addClass('selected');
	jQuery("ol.widget-new-grid li").eq(index).show().siblings().hide();
	jQuery("ol.widget-product-grid li").eq(index).show().siblings().hide();

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

	$(document).bind('click', function(e) {
		var $clicked = $(e.target);
		if (! $clicked.parents().hasClass("sorter-dropdown"))
			$(".sorter-dropdown dd ul").hide();
	});

// end listing page sorter dropdown

	
	// custom layout category page start 
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
	
	if (jQuery("body").hasClass("catalog-category-view")) {
		$('dl#sorter dt a span').html($('dl#sorter dd ul li.selected a').text());
	}
	
	// End onclick Sorter toggleClass	active-toolbar div toolbar-sorter
	
	
	// start  Quantity input
	
	if(!jQuery("body").hasClass("page-product-grouped")) {
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
	}
	// End Quantity input
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
	  // Add smooth scrolling to all links
	  $(".faq-left-side ul li a").on('click', function(event) {
	
	    if (this.hash !== "") {
		 event.preventDefault();
		 var hash = this.hash;
	
		 $('html, body').animate({
		   scrollTop: $(hash).offset().top
		 }, 800, function(){
		   window.location.hash = hash;
		 });
	    }
	  });
	if( jQuery('footer').length > 0){
	
	var stickyHeight = $('.fixed-left-menu-sticky').height();	
	$(window).scroll(function(){ // scroll event
							  
		var footerTop = $('footer').offset().top;
		//var windowTop = $(window).scrollTop() + 450;
		if($('dl#sample').height()>393 && $('dl#sample').height()<=690 ){
			var windowTop = $(window).scrollTop() + 550;
			
		}else if($('dl#sample').height()>0 && $('dl#sample').height()<=370 ){

			var windowTop = $(window).scrollTop() + 220;
			footerTop = footerTop-100;
			
		}else if($('dl#sample').height()>690){

			var windowTop = $(window).scrollTop() + 700;
			
		}else{
			var windowTop = $(window).scrollTop()+ 250;
			footerTop = footerTop-111;
			
		}
		

		if (windowTop > footerTop ) {
		if($('.column.main').height()>$('div.categories-menu').height()){	
			var height = $('.column.main').height();	
				height = height-$('div.categories-menu').height();	
        	$('.faq-left-side').removeClass('fixed-left-menu-sticky');

			jQuery('div.categories-menu').removeClass('cat-sticky');
			jQuery('div.categories-menu').addClass('cat-sticky1');
			jQuery('div.categories-menu').css('top',height+'px');
		}else{
			jQuery('div.categories-menu.cat-sticky').addClass('antqty');
			}
    	}
	});
	}

	$( ".cms-faqs .page-title-wrapper" ).append( $( ".need-help-area" ) );
	$( ".checkout-cart-index .page-title-wrapper" ).append( $( ".need-help-area" ) );
	
	
	/* js code for pdp qty add in price div */
	// pdp sticky select items button scroll start
	jQuery('button.select-item').on('click', function(){
		jQuery('a#back-to-top').trigger('click');
	});
	
	
	// meet-our-buyers start

	if(window.location.href.indexOf("meet-our-buyers") > -1) {
		jQuery('div.category-view').prependTo('div.column.main');
	}
	// meet-our-buyers end
	
	// buyer-s-picks start
	var c_url      = window.location.href; 
	var buyspic = c_url.replace(/\-/g, '');
	if(buyspic.indexOf("buyerspicks") > -1) {
		jQuery('body').addClass('buys-picks');
	}
	
	
	/* start Group prodct fixed sidebar
	================================= */
	if(windowWidth > 768){
	
	$(window).scroll(function () {
	var fixSidebar = $('.page-header').innerHeight();
	var contentHeight = $('.product-info-main').innerHeight();
	var sidebarHeight = $('.product.media').height();

	var widget_static = $('.page-product-grouped .spring-roll.block-static-block').height();
	var header_contetn = $('.page-product-grouped .header.content').height();
	
  	var sidebarBottomPos = contentHeight - sidebarHeight; 
	if (jQuery("body").hasClass("page-product-grouped")) {
		 	var trigger = $(window).scrollTop()-125;
	}else{
	 	var trigger = $(window).scrollTop() - fixSidebar;
	}
	
		if(contentHeight>sidebarHeight){
			if ($(window).scrollTop() >= fixSidebar) {
				
				var gp_top = $(window).scrollTop()-130;
					/*if ($('div.widget.block.block-static-block:first').css('display') == 'none' ) {*/

					if ($('div.spring-roll.block-static-block').contents().length>=1) {
					//gp_top = gp_top + $('div.header-top').height();
						
						$('.catalog-product-view .product.media').addClass('fixedblack');
						$('.product.media').removeClass('fixedblackrm');
					}else{
						$('.product.media').removeClass('fixedblack');
						$('.catalog-product-view .product.media').addClass('fixedblackrm');
					}
				$('.catalog-product-view .product.media').addClass('fixed');
				$('.catalog-product-view .product.media.fixed').css('top',gp_top+'px');
			} else {
				$('.product.media').removeClass('fixed');
				$('.product.media').css('top','');
			}
			
			var gpcnt = 0;
			
			if (jQuery("body").hasClass("page-product-grouped")) {
				contentHeight = contentHeight - sidebarHeight;
			}else{
				contentHeight = contentHeight - sidebarHeight - widget_static - header_contetn;	
			}
			if (trigger >= sidebarBottomPos) {
				if(gpcnt == 0){
					if (jQuery("body").hasClass("page-product-grouped")) {
					contentHeight = contentHeight - 10 ;
					}
					
					if (jQuery("body").hasClass("custom-product-view")) {
						if (jQuery(".simpleproduct").prop("checked")) {
							
						if(jQuery('div.custom-pro-rgt-area').height()>100){
						contentHeight =  jQuery('div.custom-pro-rgt-area').height()/5;	
							}else{
						contentHeight =  jQuery('div.custom-pro-rgt-area').height()/111;
							}

						}else{
						contentHeight = contentHeight - 77;
						}
					}
					
					if (jQuery("body").hasClass("page-product-configurable")) {
					contentHeight = contentHeight - 77;
					}
					
					$('.product.media.bottom').css('top',contentHeight+'px');
					
					}
					
					$('.product.media').addClass('bottom');
					gpcnt++;
				
				$('.product.media').removeClass('fixed');
			} else {
				$('.product.media').removeClass('bottom');
			}
			
	   }
	});

	}
	else
	 {
	 }




/* start Group prodct fixed sidebar
	================================= */
	
	jQuery('#sorter dt a span').html(jQuery('#sorter li.selected').text());
	
	
	setTimeout( function()  {
		if (jQuery('.message-success.success.message').length > 0) {
			if (jQuery("body").hasClass("checkout-cart-index") || jQuery("body").hasClass("catalog-product-view")) {
			jQuery('[data-block="minicart"]').find('[data-role="dropdownDialog"]').dropdownDialog("open");
			}


		}
	}, 1500);

	jQuery('ul.children li.item.active').parent().parent().addClass("active");
	
	////////// random upsell products load on pdp
	
	jQuery('ol.widget-new-grid.products.list.items.product-items.upsell').each(function(){
            
            var $ul = jQuery(this);            
            var $liArr = $ul.children('li');            
            $liArr.sort(function(a,b){            
                  var temp = parseInt( Math.random()*10 );            
                  var isOddOrEven = temp%2;            
                  var isPosOrNeg = temp>5 ? 1 : -1;            
                  return( isOddOrEven*isPosOrNeg );
            })            
            .appendTo($ul);
      });
		
	/////////
	
	if (jQuery('.related_product span.new-start.old-price').is(':empty')) { 
		jQuery('.related_product span.new-start.old-price').hide();
	} 
	
	if (jQuery('.grouped span.new-start.old-price').is(':empty')) { 
		jQuery('.grouped span.new-start.old-price').hide();
	} 
	
	if (jQuery('.simple-product-view span.new-start.old-price').is(':empty')) { 
		jQuery('.simple-product-view span.new-start.old-price').hide();
	}

		
		setTimeout(function() {
			jQuery('.mycntnumber1').hide();
			jQuery('.mycntnumber2').show();
		}, 3500);	

	/* add div for checkout page , left right side , sticky */
	jQuery('div.opc-wrapper,.opc-sidebar.opc-summary-wrapper').wrapAll('<div class="opc_custom_cls"></div>');

});

function getSelectedValue(id) {
		return jQuery("#" + id).find("dt a span.value").html();
	}
	
