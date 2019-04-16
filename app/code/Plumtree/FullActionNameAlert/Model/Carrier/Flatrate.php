<?php
namespace Plumtree\FullActionNameAlert\Model\Carrier;


use Magento\OfflineShipping\Model\Carrier\Flatrate\ItemPriceCalculator;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;

class Flatrate extends \Magento\OfflineShipping\Model\Carrier\Flatrate
{



	public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }


			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$productObject = $objectManager->get('Magento\Catalog\Model\Product');
			
			$local_delivery = 0;
			
			if ($request->getAllItems()) {
        	foreach ($request->getAllItems() as $item) {
			
			//var_dump($item->getData());
			
			
				$prod_uct = $productObject->loadByAttribute('sku', $item->getSku());
				if($prod_uct){
				if($prod_uct->getAttributeText('local_delivery_only')=="Yes"){
					$local_delivery = 1;
				}	
				}
			}
			
			}
		
		$postCode = $request->getDestPostcode();
        

			$variable = $objectManager->create('Magento\Variable\Model\Variable');
			$zipcodelist = $variable->loadByCode('zipcodelist')->getPlainValue();
			$restrictedCodes = explode(",",$zipcodelist);
			
			$freeBoxes = $this->getFreeBoxesCount($request);
			$this->setFreeBoxes($freeBoxes);
			/** @var Result $result */
			$result = $this->_rateResultFactory->create();
	
			$shippingPrice = $this->getShippingPrice($request, $freeBoxes);

			
	 if (in_array($postCode, $restrictedCodes)) {
        
		if($local_delivery == 1){	
				
				if ($shippingPrice !== false) {
					$method = $this->createResultMethod($shippingPrice);
					$result->append($method);
				}
			}
		}

        return $result;
    }
	
	private function createResultMethod($shippingPrice)
    {
        /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
        $shippingPrice = $this->getConfigData('price');
		$method = $this->_rateMethodFactory->create();

        $method->setCarrier('flatrate');
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod('flatrate');
        $method->setMethodTitle($this->getConfigData('name'));

        $method->setPrice($shippingPrice);
        $method->setCost($shippingPrice);
        return $method;
    }
	

 }