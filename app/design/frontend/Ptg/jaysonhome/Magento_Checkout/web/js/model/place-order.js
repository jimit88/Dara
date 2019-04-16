/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define(
    [
        'mage/storage',
        'Magento_Checkout/js/model/error-processor',
        'Magento_Checkout/js/model/full-screen-loader'
    ],
    function (storage, errorProcessor, fullScreenLoader) {
        'use strict';
		document.body.className += " second-step";
		
		var selectedVal = "";
		var selected = jQuery("#checkout-shipping-method-load input[type='radio']:checked");
		if (selected.length > 0) {
			selectedVal = selected.val();
		}
		if(selectedVal=="mpcustomshipping_express"){
					jQuery('.ship-to .shipping-information-content').hide();
					jQuery('.set-store-address').show();
					jQuery('div.store-add1').show();
					jQuery('div.newclass').trigger('click');
		}else{
					jQuery('.ship-to .shipping-information-content').show();
					jQuery('.set-store-address').hide();
					jQuery('div.store-add1').hide();
		}
		
		setTimeout(
		function() {
			jQuery('body').addClass('second-step');
		}, 1200);
			
        return function (serviceUrl, payload, messageContainer) {
            fullScreenLoader.startLoader();

            return storage.post(
                serviceUrl, JSON.stringify(payload)
            ).fail(
                function (response) {
                    errorProcessor.process(response, messageContainer);
                    fullScreenLoader.stopLoader();
                }
            );
        };
    }
);
