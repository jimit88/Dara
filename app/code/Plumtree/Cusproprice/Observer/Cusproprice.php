<?php
namespace Plumtree\Cusproprice\Observer;
 
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;
  
class Cusproprice implements \Magento\Framework\Event\ObserverInterface
{ 
  public function execute(\Magento\Framework\Event\Observer $observer)
  {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
				
			$variable = $objectManager->create('Magento\Variable\Model\Variable');
    		$cus_pro_dis = $variable->loadByCode('cus_pro_dis')->getPlainValue();
	
	 		$item = $observer->getEvent()->getData('quote_item');         
            $item = ( $item->getParentItem() ? $item->getParentItem() : $item );
			
			if($item->getProduct()->getHasOptions()==1 && $cus_pro_dis){
			
			$discount_percent = $cus_pro_dis;
			$pri_ce = $item->getProduct()->getFinalPrice()*$discount_percent/100;			
			$price = $item->getProduct()->getFinalPrice()-$pri_ce;
			
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            $item->getProduct()->setIsSuperMode(true);
			}
		 
            
		   
			
  }
}