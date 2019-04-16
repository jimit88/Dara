<?php
namespace Plumtree\FullActionNameAlert\Model\Quote;

class Address extends \Magento\Quote\Model\Quote\Address
{

    public function getGroupedAllShippingRates()
    {

		$car_code = array();
        foreach ($this->getShippingRatesCollection() as $rate) {
				$car_code[] = $rate->getCarrier();
		}	
		
        $rates = [];
        foreach ($this->getShippingRatesCollection() as $rate) {
            if (!$rate->isDeleted() && $this->_carrierFactory->get($rate->getCarrier())) {
			
			//$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/'.$rate->getCarrier().'.log');
			if($rate->getCarrier()=='matrixrate'){
                if (!isset($rates[$rate->getCarrier()])) {
                    $rates[$rate->getCarrier()] = [];
                }

                $rates[$rate->getCarrier()][] = $rate;
                $rates[$rate->getCarrier()][0]->carrier_sort_order = $this->_carrierFactory->get(
                    $rate->getCarrier()
                )->getSortOrder();
				
			}

			if($rate->getCarrier()=='mpcustomshipping'){
                if (!isset($rates[$rate->getCarrier()])) {
                    $rates[$rate->getCarrier()] = [];
                }

                $rates[$rate->getCarrier()][] = $rate;
                $rates[$rate->getCarrier()][0]->carrier_sort_order = $this->_carrierFactory->get(
                    $rate->getCarrier()
                )->getSortOrder();
				
				}
				
				if($rate->getCarrier()=='flatrate'  && !in_array('matrixrate', $car_code)){
                if (!isset($rates[$rate->getCarrier()])) {
                    $rates[$rate->getCarrier()] = [];
                }

                $rates[$rate->getCarrier()][] = $rate;
                $rates[$rate->getCarrier()][0]->carrier_sort_order = $this->_carrierFactory->get(
                    $rate->getCarrier()
                )->getSortOrder();
				
				}
				
				if($rate->getCarrier()=='ups' && !in_array('flatrate', $car_code) && !in_array('matrixrate', $car_code)){
                if (!isset($rates[$rate->getCarrier()])) {
                    $rates[$rate->getCarrier()] = [];
                }

                $rates[$rate->getCarrier()][] = $rate;
                $rates[$rate->getCarrier()][0]->carrier_sort_order = $this->_carrierFactory->get(
                    $rate->getCarrier()
                )->getSortOrder();
				
				}
				
				
            }
        }
        uasort($rates, [$this, '_sortRates']);

        return $rates;
    }

   
   
}
