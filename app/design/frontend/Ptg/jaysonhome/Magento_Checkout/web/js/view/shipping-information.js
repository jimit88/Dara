/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/*jshint browser:true jquery:true*/
/*global alert*/
define(
    [
        'jquery',
        'uiComponent',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/step-navigator',
        'Magento_Checkout/js/model/sidebar'
    ],
    function($, Component, quote, stepNavigator, sidebarModel) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Magento_Checkout/shipping-information'
            },

            isVisible: function() {
                return !quote.isVirtual() && stepNavigator.isProcessed('shipping');
            },
			
			getShippingFullName: function() {
                var shippingfullaame = jQuery('#shippingfullnm').val(); // jQuery('[name="firstname"]').val()+ " " + jQuery('[name="lastname"]').val();
                return shippingfullaame;
            },

            getShippingMethodTitle: function() {
                var shippingMethod = quote.shippingMethod();
				
				if(shippingMethod.carrier_code == 'mpcustomshipping' ){
							jQuery('.ship-to .shipping-information-content').hide();
							jQuery('#co-payment-form').hide();	
							jQuery('div.newclass').hide();
							jQuery('.set-store-address').show();
							setTimeout(
							function() {
								jQuery('.storeadd1').show();
								jQuery('body').addClass('second-step');
								jQuery('#checkout-step-payment').show();
								jQuery('#co-payment-form').show();	
								jQuery('div.newclass').show();
								jQuery('div.newclass').trigger('click');
							}, 3600);
					
				}else{
						jQuery('.ship-to .shipping-information-content').show();
						jQuery('.set-store-address').hide();
						jQuery('.storeadd1').hide();
						jQuery('#checkout-step-payment').show();
						jQuery('#co-payment-form').show();	
						jQuery('div.newclass').show();
						setTimeout(
							function() {
								jQuery('body').addClass('second-step');
							}, 3600);
				}
				
                return shippingMethod ? shippingMethod.carrier_title + " - " + shippingMethod.method_title : '';
            },

            back: function() {
                sidebarModel.hide();
                stepNavigator.navigateTo('shipping');
            },

            backToShippingMethod: function() {
                sidebarModel.hide();
                stepNavigator.navigateTo('shipping', 'opc-shipping_method');
            }
        });
    }
);
