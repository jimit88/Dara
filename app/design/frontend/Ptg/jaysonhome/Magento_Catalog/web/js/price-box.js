/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'Magento_Catalog/js/price-utils',
    'underscore',
    'mage/template',
    'jquery/ui'
], function ($, utils, _, mageTemplate) {
    'use strict';

    var globalOptions = {
        productId: null,
        priceConfig: null,
        prices: {},
        priceTemplate: '<span class="price"><%- data.formatted %></span>'
    };

    $.widget('mage.priceBox', {
        options: globalOptions,
        cache: {},

        /**
         * Widget initialisation.
         * Every time when option changed prices also can be changed. So
         * changed options.prices -> changed cached prices -> recalculation -> redraw price box
         */
        _init: function initPriceBox() {
            var box = this.element;

            box.trigger('updatePrice');
            this.cache.displayPrices = utils.deepClone(this.options.prices);
        },

        /**
         * Widget creating.
         */
        _create: function createPriceBox() {
            var box = this.element;

            this._setDefaultsFromPriceConfig();
            this._setDefaultsFromDataSet();

            box.on('reloadPrice', this.reloadPrice.bind(this));
            box.on('updatePrice', this.onUpdatePrice.bind(this));
        },

        /**
         * Call on event updatePrice. Proxy to updatePrice method.
         * @param {Event} event
         * @param {Object} prices
         */
        onUpdatePrice: function onUpdatePrice(event, prices) {
            return this.updatePrice(prices);
        },

        /**
         * Updates price via new (or additional values).
         * It expects object like this:
         * -----
         *   "option-hash":
         *      "price-code":
         *         "amount": 999.99999,
         *         ...
         * -----
         * Empty option-hash object or empty price-code object treats as zero amount.
         * @param {Object} newPrices
         */
        updatePrice: function updatePrice(newPrices) {
            var prices = this.cache.displayPrices,
                additionalPrice = {},
                pricesCode = [],
                priceValue, origin, finalPrice;

            this.cache.additionalPriceObject = this.cache.additionalPriceObject || {};

            if (newPrices) {
                $.extend(this.cache.additionalPriceObject, newPrices);
            }

            if (!_.isEmpty(additionalPrice)) {
                pricesCode = _.keys(additionalPrice);
            } else if (!_.isEmpty(prices)) {
                pricesCode = _.keys(prices);
            }

            _.each(this.cache.additionalPriceObject, function (additional) {
                if (additional && !_.isEmpty(additional)) {
                    pricesCode = _.keys(additional);
                }
                _.each(pricesCode, function (priceCode) {
                    priceValue = additional[priceCode] || {};
                    priceValue.amount = +priceValue.amount || 0;
                    priceValue.adjustments = priceValue.adjustments || {};

                    additionalPrice[priceCode] = additionalPrice[priceCode] || {
                            'amount': 0,
                            'adjustments': {}
                        };
                    additionalPrice[priceCode].amount =  0 + (additionalPrice[priceCode].amount || 0) +
                        priceValue.amount;
                    _.each(priceValue.adjustments, function (adValue, adCode) {
                        additionalPrice[priceCode].adjustments[adCode] = 0 +
                            (additionalPrice[priceCode].adjustments[adCode] || 0) + adValue;
                    });
                });
            });

            if (_.isEmpty(additionalPrice)) {
                this.cache.displayPrices = utils.deepClone(this.options.prices);
            } else {
                _.each(additionalPrice, function (option, priceCode) {
                    origin = this.options.prices[priceCode] || {};
                    finalPrice = prices[priceCode] || {};
                    option.amount = option.amount || 0;
                    origin.amount = origin.amount || 0;
                    origin.adjustments = origin.adjustments || {};
                    finalPrice.adjustments = finalPrice.adjustments || {};

                    finalPrice.amount = 0 + origin.amount + option.amount;
                    _.each(option.adjustments, function (pa, paCode) {
                        finalPrice.adjustments[paCode] = 0 + (origin.adjustments[paCode] || 0) + pa;
                    });
                }, this);
            }

            this.element.trigger('reloadPrice');
        },

        /*eslint-disable no-extra-parens*/
        /** 
         * Render price unit block.
         */
        reloadPrice: function reDrawPrices() {
            var priceFormat = (this.options.priceConfig && this.options.priceConfig.priceFormat) || {},
                priceTemplate = mageTemplate(this.options.priceTemplate);

            _.each(this.cache.displayPrices, function (price, priceCode) {
                price.final = _.reduce(price.adjustments, function (memo, amount) {
                    return memo + amount;
                }, price.amount);
				
				var price_final = price.final*jQuery('#cus_pro_dis').val()/100;
				price_final = price.final-price_final;
				if (jQuery("body").hasClass("custom-product-view")) {
					price.formatted = utils.formatPrice(price_final, priceFormat);
					if(price.final!=0 && price_final != price.final){
					jQuery('div.price-box.price-final_price:first span.new-start.old-price').text('$'+price.final.toFixed(2).replace('.00','').replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
					}
				}else{
                	price.formatted = utils.formatPrice(price.final, priceFormat);
				}
				if(price.final>0){
					$('[data-price-type="' + priceCode + '"]', this.element).html(priceTemplate({
						data: price
					}));
					$('div.product-options-bottom .product-info-price').show();
				}else{
					$('div.product-options-bottom .product-info-price').hide();
					}
            }, this);
        },

        /*eslint-enable no-extra-parens*/
        /**
         * Overwrites initial (default) prices object.
         * @param {Object} prices
         */
        setDefault: function setDefaultPrices(prices) {
            this.cache.displayPrices = utils.deepClone(prices);
            this.options.prices = utils.deepClone(prices);
        },

        /**
         * Custom behavior on getting options:
         * now widget able to deep merge of accepted configuration.
         * @param  {Object} options
         * @return {mage.priceBox}
         */
        _setOptions: function setOptions(options) {
            $.extend(true, this.options, options);

            if ('disabled' in options) {
                this._setOption('disabled', options.disabled);
            }

            return this;
        },

        /**
         * setDefaultsFromDataSet
         */
        _setDefaultsFromDataSet: function _setDefaultsFromDataSet() {
            var box = this.element,
                priceHolders = $('[data-price-type]', box),
                prices = this.options.prices;

            this.options.productId = box.data('productId');

            if (_.isEmpty(prices)) {
                priceHolders.each(function (index, element) {
                    var type = $(element).data('priceType'),
                        amount = parseFloat($(element).data('priceAmount'));

                    if (type && !_.isNaN(amount)) {
                        prices[type] = {
                            amount: amount
                        };
                    }
                });
            }
        },

        /**
         * setDefaultsFromPriceConfig
         */
        _setDefaultsFromPriceConfig: function _setDefaultsFromPriceConfig() {
            var config = this.options.priceConfig;

            if (config && config.prices) {
                this.options.prices = config.prices;
            }
        }
    });

    return $.mage.priceBox;
});
