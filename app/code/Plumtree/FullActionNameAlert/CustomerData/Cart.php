<?php
namespace Plumtree\FullActionNameAlert\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;

class Cart extends \Magento\Checkout\CustomerData\Cart
{	

 public function getSectionData()
    {
        $totals = $this->getQuote()->getTotals();
		
		
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
			
				$_msg = "YOU Will RECEIVE FREE SHIPPING ON YOUR ORDER !";
			}else{
				$_msg = "ADD ".str_replace('.00', '',$priceHelper->currency($new_final, true, false))." To RECEIVE FREE SHIPPING ON YOUR ORDER !";				
			}
		}
				


        return [
            'summary_count' => $this->getSummaryCount(),
            'subtotal' => isset($totals['subtotal'])
                ? $this->checkoutHelper->formatPrice($totals['subtotal']->getValue())
                : 0,
            'possible_onepage_checkout' => $this->isPossibleOnepageCheckout(),
            'items' => $this->getRecentItems(),
            'extra_actions' => $this->layout->createBlock('Magento\Catalog\Block\ShortcutButtons')->toHtml(),
            'isGuestCheckoutAllowed' => $this->isGuestCheckoutAllowed(),
            'website_id' => $this->getQuote()->getStore()->getWebsiteId(),
			'msg' => $_msg,
			'free_shipping_subtotal' => 555
        ];
    }
	
}