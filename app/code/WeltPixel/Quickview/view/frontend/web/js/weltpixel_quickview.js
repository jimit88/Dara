define([
    'jquery',
    'magnificPopup'
    ], function ($, magnificPopup) {
    "use strict";

var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
var base_url = document.getElementById("my_site_base_url").value;  

    return {
        displayContent: function(prodUrl) {
            if (!prodUrl.length) {
                return false;
            }



var base_url = document.getElementById("my_site_base_url").value;  

var url = base_url + 'weltpixel_quickview/index/updatecart';

            /*var url = window.weltpixel_quickview.baseUrl + 'weltpixel_quickview/index/updatecart';
            var showMiniCart = parseInt(window.weltpixel_quickview.showMiniCart);

            window.weltpixel_quickview.showMiniCartFlag = false;*/
			//alert(jQuery('span.counter-number').text());
			

            $.magnificPopup.open({
                items: {
                  src: prodUrl
                },
                type: 'iframe',
                closeOnBgClick: false,
                preloader: true,
                tLoading: '',
                callbacks: {
                    open: function() {
                      $('.mfp-preloader').css('display', 'block');
					  document.getElementById('mfp-iframe').onload = function() {
						  jQuery('.mfp-iframe-holder .mfp-content button.mfp-close').show();
						  
						  if (jQuery("iframe.mfp-iframe").contents().find("body").hasClass("custom-product-view") || jQuery("body").hasClass("custom-product-view")) {
								  jQuery("iframe.mfp-iframe").contents().find("body").addClass(' custom-product-view-quickview');

								  	var sPageURL = prodUrl;
									var sURLVariables = sPageURL.split('?');	
									for (var i = 0; i < sURLVariables.length; i++)	
									{	
										var sParameterName = sURLVariables[i].split('=');
										if (sParameterName[0] == 'remove_add_btn')
										{
											if(sParameterName[1]=='yes'){
											 jQuery("iframe.mfp-iframe").contents().find("div.product-add-form").addClass(' remove-btn');
											 
											}

										}
									}
							}
					  }
					  
							 
                    },
                    beforeClose: function() {
						//var url = baseUrl+ 'weltpixel_quickview/index/updatecart';
                        //$('[data-block="minicart"]').trigger('contentLoading');
						$.ajax({
							url: url,
							method: "POST"
						});
						var status = jQuery('.mfp-iframe').contents().find('.box-tocart .actions #product-addtocart-button').hasClass('customclass');
						//alert('Class Status -- ' +status);
						if (status){
							//alert('add 2 cart');
							setTimeout(function(){								
                                $('.action.showcart').trigger('click');
								console.log('weltpixel_quickview.js mini cart triggered');
                            }, 1000);	
						}
                    },
                    close: function() {						
                      $('.mfp-preloader').css('display', 'none');
                    },
                    afterClose: function() {
						console.log('after close 1');
						var url = base_url + 'weltpixel_quickview/index/updatecart';
						//var showMiniCart = parseInt(jQuery('span.counter-number').text()/*window.weltpixel_quickview.showMiniCart*/);						
						var showMiniCart = parseInt(window.weltpixel_quickview.showMiniCart);
						
						//window.weltpixel_quickview.showMiniCartFlag = false;
                        /* Show only if product was added to cart and enabled from admin */
                        /*if (window.weltpixel_quickview.showMiniCartFlag) {
							console.log('product added to cart');
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            setTimeout(function(){								
                                $('.action.showcart').trigger('click');
								console.log('mini cart triggered');
                            }, 1000);							
                        }*/
						window.weltpixel_quickview.showMiniCartFlag = undefined;
						console.log('done');
						
                    }
                  }
            });
        },
		displayContent1: function(prodUrl) {
            if (!prodUrl.length) {
                return false;
            }

            var url = base_url + 'weltpixel_quickview/index/updatecart';
            var showMiniCart = parseInt(jQuery('span.counter-number').text()/*window.weltpixel_quickview.showMiniCart*/);

            window.weltpixel_quickview.showMiniCartFlag = false;

            $.magnificPopup.open({
                items: {
                  src: prodUrl
                },
                type: 'iframe',
                closeOnBgClick: false,
                preloader: true,
                tLoading: '',
                callbacks: {
                    open: function() {
                      $('.mfp-preloader').css('display', 'block');
					  $(this).addClass('custom-layout ');
                    },
                    beforeClose: function() {
                        //$('[data-block="minicart"]').trigger('contentLoading');
                        $.ajax({
                        url: url,
                        method: "POST"
                      });
                    },
                    close: function() {
                      $('.mfp-preloader').css('display', 'none');
                    },
                    afterClose: function() {
						console.log('after close 2');
                        /* Show only if product was added to cart and enabled from admin */
                        if (window.weltpixel_quickview.showMiniCartFlag && showMiniCart) {
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            setTimeout(function(){
                                $('.action.showcart').trigger('click');
                            }, 1000);
                        }
                    }
                  }
            });
        }
    };

});