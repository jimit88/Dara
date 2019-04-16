<?php
namespace Plumtree\FullActionNameAlert\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Tax\Helper\Data as TaxHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
 

class TaxConfigProvider  extends \Magento\Tax\Model\TaxConfigProvider 
{
	
	 public function aftergetConfig()
    {
	
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tableName = $resource->getTableName('core_config_data');
		
		$sql_freeshipping_enable = "SELECT value FROM " . $tableName." WHERE `path` = 'carriers/freeshipping/active'";
		$result_freeshipping_enable = $connection->fetchAll($sql_freeshipping_enable);
		
		
		$sql_freeshipping_amt = "SELECT value FROM " . $tableName." WHERE `path` = 'carriers/freeshipping/free_shipping_subtotal'";
		$result_freeshipping_amt = $connection->fetchAll($sql_freeshipping_amt);
		
		$custom_var_value = $result_freeshipping_amt['0']['value'];
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$cart = $objectManager->get('\Magento\Checkout\Model\Cart'); 
		$subTotal = $cart->getQuote()->getSubtotal();
		$grandTotal = $cart->getQuote()->getGrandTotal();
		$priceHelper = $objectManager->create('Magento\Framework\Pricing\Helper\Data');
		
		$new_final = $custom_var_value - $grandTotal;
		

		$style = '';
		$_msg = '';
		if($result_freeshipping_enable['0']['value'] != 0){
			if($new_final<=0){
			
				$_msg = "<div class='add-free-shipping-section  green-msg'><span class='add-free-shipping'>YOU Will RECEIVE FREE SHIPPING ON YOUR ORDER !</span></div>";
			}else{
				$_msg = "<div class='add-free-shipping-section '><span class='add-free-shipping'>ADD ".str_replace('.00', '',$priceHelper->currency($new_final, true, false))." To RECEIVE FREE SHIPPING ON YOUR ORDER !</span></div>";				
			}
		}
		
        return [
            'isDisplayShippingPriceExclTax' => $this->isDisplayShippingPriceExclTax(),
            'isDisplayShippingBothPrices' => $this->isDisplayShippingBothPrices(),
            'reviewShippingDisplayMode' => $this->getDisplayShippingMode(),
            'reviewItemPriceDisplayMode' => $this->getReviewItemPriceDisplayMode(),
            'reviewTotalsDisplayMode' => $this->getReviewTotalsDisplayMode(),
            'includeTaxInGrandTotal' => $this->isTaxDisplayedInGrandTotal(),
            'isFullTaxSummaryDisplayed' => $this->isFullTaxSummaryDisplayed(),
            'isZeroTaxDisplayed' => $this->taxConfig->displayCartZeroTax(),
            'reloadOnBillingAddress' => $this->reloadOnBillingAddress(),
            'defaultCountryId' => $this->scopeConfig->getValue(
                \Magento\Tax\Model\Config::CONFIG_XML_PATH_DEFAULT_COUNTRY,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            ),
            'defaultRegionId' => $this->scopeConfig->getValue(
                \Magento\Tax\Model\Config::CONFIG_XML_PATH_DEFAULT_REGION,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            ),
            'defaultPostcode' => $this->scopeConfig->getValue(
                \Magento\Tax\Model\Config::CONFIG_XML_PATH_DEFAULT_POSTCODE,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            ),
			'freeshippingsubtotal' => $_msg,
        ];
    }
	

}