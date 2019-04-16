<?php
namespace Plumtree\FullActionNameAlert\Model;

use Magento\Quote\Model\Quote\Address\RateResult\Error;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrierOnline;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Simplexml\Element;
use Magento\Ups\Helper\Config;
use Magento\Framework\Xml\Security;


class Carrier extends \Magento\Ups\Model\Carrier
{
	public function collectRates(RateRequest $request)
		{
		
		/*$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

 	$activeShipping = $objectManager->create('Magento\Shipping\Model\Config')->getActiveCarriers();
	*/
	$methosenable = 0;
	$morecnt = 1;
	/*$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/Ups111.log');
	$logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
			 $logger->info("activeShipping - " );
			foreach ($activeShipping as $shippigCode => $shippingModel) {
			 $logger->info("shippigCode - ". $shippigCode );
			 
			 if($shippigCode=='matrixrate'){
			 $methosenable = 0;
			 }
        }*/
		

			//$logger->info("activeShipping - ". $activeShipping );
			
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$productObject = $objectManager->get('Magento\Catalog\Model\Product');
			$methosenable = 0;
			$morecnt = 0;
			
			$cnt=count($request->getAllItems());
			if ($request->getAllItems()) {
				foreach ($request->getAllItems() as $item) {				
					$prod_uct = $productObject->loadByAttribute('sku', $item->getSku());
					if($prod_uct){
					if($prod_uct->getAttributeText('local_delivery_only')=="Yes"){
						$methosenable = 1;
					}else{
						$methosenable = 0;
						$morecnt = 0;
					}
					}
				}
			
			}
			
 
		if($methosenable==0 && $morecnt == 0){
		
			$this->setRequest($request);
			if (!$this->canCollectRates()) {
				return $this->getErrorMessage();
			}
	
			$this->setRequest($request);
			$this->_result = $this->_getQuotes();
			$this->_updateFreeMethodQuote($request);
	
			return $this->getResult();
			}else{
				return;
			}
		}
		
}
