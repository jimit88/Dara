define(
[
    'uiComponent'
],
function (Component) {
    "use strict";
    var quoteItemData = window.checkoutConfig.quoteItemData;
    return Component.extend({
        defaults: {
            template: 'Magento_Checkout/summary/item/details'
        },
        quoteItemData: quoteItemData,
        /*getValue: function(quoteItem) {
            return quoteItem.name;
        },*/
		getItemTo: function(quoteItem) {
            var itemProduct = this.getItemProduct(quoteItem.item_id);
            return itemProduct.recipient;
        },
		getItemFrom: function(quoteItem) {
            var itemProduct = this.getItemProduct(quoteItem.item_id);
            return itemProduct.sender;
        },
		getItemMsg: function(quoteItem) {
            var itemProduct = this.getItemProduct(quoteItem.item_id);
            return itemProduct.message;
        },
		getItemId: function(quoteItem) {
            return "/checkout/cart/?msg="+quoteItem.item_id
        },
        getItemProduct: function(item_id) {
            var itemElement = null;
            _.each(this.quoteItemData, function(element, index) {
                if (element.item_id == item_id) {
                    itemElement = element;
                }
            });
            return itemElement;
        }

    });
}

);