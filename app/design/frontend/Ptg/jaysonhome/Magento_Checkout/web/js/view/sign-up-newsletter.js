/*
 * *
 *  Copyright © 2016 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *  
 */
/*global define*/
define(
    [
        'ko',
        'uiComponent'
    ],
    function(ko, Component) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Magento_Checkout/sign-up-newsletter'
            },

             is ShowNewsletter: ko.observable(window.checkoutConfig.show_newsletter),
			isChecked: ko.observable(window.checkoutConfig.newsletter_default_checked)
        });
    }
);