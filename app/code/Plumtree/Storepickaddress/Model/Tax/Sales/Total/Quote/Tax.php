<?php
namespace Plumtree\Storepickaddress\Model\Tax\Sales\Total\Quote;

use ClassyLlama\AvaTax\Framework\Interaction\Tax\Get\Proxy as InteractionGet;
use ClassyLlama\AvaTax\Framework\Interaction\TaxCalculation\Proxy as TaxCalculation;
use ClassyLlama\AvaTax\Helper\Config;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Item;
use Magento\Quote\Model\Quote\Address as QuoteAddress;
use Magento\Customer\Api\Data\AddressInterfaceFactory as CustomerAddressFactory;
use Magento\Customer\Api\Data\RegionInterfaceFactory as CustomerAddressRegionFactory;
use Magento\Quote\Model\Quote\Address;
use Magento\Tax\Model\Calculation;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\RemoteServiceUnavailableException;
use Magento\GiftWrapping\Model\Total\Quote\Tax\Giftwrapping;
use Magento\Tax\Api\Data\QuoteDetailsInterfaceFactory;
use Magento\Tax\Api\Data\QuoteDetailsItemInterfaceFactory;
use Magento\Tax\Api\Data\TaxClassKeyInterfaceFactory;

class Tax extends \ClassyLlama\AvaTax\Model\Tax\Sales\Total\Quote\Tax
{
	 public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Address\Total $total
    ) {
        // If quote is virtual, getShipping will return billing address, so no need to check if quote is virtual
        $address = $shippingAssignment->getShipping()->getAddress();
		
		if($address->getData('shipping_method')=="mpcustomshipping_express"){
			
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$storeInformation = $objectManager->create('Magento\Store\Model\Information');
			$store = $objectManager->create('Magento\Store\Model\Store');
			$storeInfo = $storeInformation->getStoreInformationObject($store);
			
			$address['region'] = $storeInfo->getData('region');
			$address['region_id'] = $storeInfo->getData('region_id');
			$address['postcode'] = $storeInfo->getData('postcode'); 
		}

        $storeId = $quote->getStoreId();
        // This will allow a merchant to configure default tax settings for their site using Magento's core tax
        // calculation and AvaTax's calculation will only kick in during cart/checkout. This is useful for countries
        // where merchants are required to display prices including tax (such as some countries that charge VAT tax).
        if (!$this->config->isModuleEnabled($storeId)
            || $this->config->getTaxMode($storeId) == Config::TAX_MODE_NO_ESTIMATE_OR_SUBMIT
            || !$this->config->isAddressTaxable($address, $storeId)
        ) {
            return parent::collect($quote, $shippingAssignment, $total);
        }


        $postcode = $address->getPostcode();
        // If postcode is not present, then collect totals is being run from a context where customer has not submitted
        // their address, such as on the product listing, product detail, or cart page. Once the user enters their
        // postcode in the "Estimate Shipping & Tax" form on the cart page, or submits their shipping address in the
        // checkout, then a postcode will be present; but only send request if the postcode is at least 4 characters.
        if (!$postcode || \strlen($postcode) < 4) {
            return parent::collect($quote, $shippingAssignment, $total);
        }

        $this->clearValues($total);
        if (!$shippingAssignment->getItems()) {
            return $this;
        }

        $taxQuoteDetails = $this->getTaxQuoteDetails($shippingAssignment, $total, $storeId, false);
        $baseTaxQuoteDetails = $this->getTaxQuoteDetails($shippingAssignment, $total, $storeId, true);

        // Get array of tax details
        try {
            $taxDetailsList = $this->interactionGetTax->getTaxDetailsForQuote($quote, $taxQuoteDetails, $baseTaxQuoteDetails, $shippingAssignment);
        } catch (\Exception $e) {
            switch ($this->config->getErrorAction($quote->getStoreId())) {
                case Config::ERROR_ACTION_DISABLE_CHECKOUT:
                    $this->coreRegistry->register(self::AVATAX_GET_TAX_REQUEST_ERROR, true, true);
                    return parent::collect($quote, $shippingAssignment, $total);
                    break;
                case Config::ERROR_ACTION_ALLOW_CHECKOUT_NATIVE_TAX:
                default:
                    /**
                     * Note: while this should return Magento's tax calculation, the tax calculation may be slightly
                     * off, as these two collect methods will not have run:
                     * @see \Magento\Tax\Model\Sales\Total\Quote\Shipping::collect()
                     * @see \Magento\Tax\Model\Sales\Total\Quote\Subtotal::collect()
                     */
                    return parent::collect($quote, $shippingAssignment, $total);
                    break;
            }
        }

        $taxDetails = $taxDetailsList[InteractionGet::KEY_TAX_DETAILS];
        $baseTaxDetails = $taxDetailsList[InteractionGet::KEY_BASE_TAX_DETAILS];

        $itemsByType = $this->organizeItemTaxDetailsByType($taxDetails, $baseTaxDetails);

        if (isset($itemsByType[self::ITEM_TYPE_PRODUCT])) {
            $this->processProductItems($shippingAssignment, $itemsByType[self::ITEM_TYPE_PRODUCT], $total);
        }

        if (isset($itemsByType[self::ITEM_TYPE_SHIPPING])) {
            $shippingTaxDetails = $itemsByType[self::ITEM_TYPE_SHIPPING][self::ITEM_CODE_SHIPPING][self::KEY_ITEM];
            $baseShippingTaxDetails =
                $itemsByType[self::ITEM_TYPE_SHIPPING][self::ITEM_CODE_SHIPPING][self::KEY_BASE_ITEM];
            $this->processShippingTaxInfo($shippingAssignment, $total, $shippingTaxDetails, $baseShippingTaxDetails);
        }

        //Process taxable items that are not product or shipping
        $this->processExtraTaxables($total, $itemsByType);

        //Save applied taxes for each item and the quote in aggregation
        $this->processAppliedTaxes($total, $shippingAssignment, $itemsByType);

        if ($this->includeExtraTax()) {
            $total->addTotalAmount('extra_tax', $total->getExtraTaxAmount());
            $total->addBaseTotalAmount('extra_tax', $total->getBaseExtraTaxAmount());
        }

        return $this;
    }

   
   
   protected function getTaxQuoteDetails($shippingAssignment, $total, $storeId, $useBaseCurrency)
    {
        // If quote is virtual, getShipping will return billing address, so no need to check if quote is virtual
        $address = $shippingAssignment->getShipping()->getAddress();
		
		if($address->getData('shipping_method')=="mpcustomshipping_express"){
			
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$storeInformation = $objectManager->create('Magento\Store\Model\Information');
			$store = $objectManager->create('Magento\Store\Model\Store');
			$storeInfo = $storeInformation->getStoreInformationObject($store);
			
			$address['region'] = $storeInfo->getData('region');
			$address['region_id'] = $storeInfo->getData('region_id');
			$address['postcode'] = $storeInfo->getData('postcode'); 
		}
		
        //Setup taxable items
        $priceIncludesTax = $this->_config->priceIncludesTax($address->getQuote()->getStore());
        $itemDataObjects = $this->mapItems($shippingAssignment, $priceIncludesTax, $useBaseCurrency);

        //Add shipping
        $shippingDataObject = $this->getShippingDataObject($shippingAssignment, $total, $useBaseCurrency);
        if ($shippingDataObject != null) {
            $this->addInfoToQuoteDetailsItemForShipping($shippingDataObject, $storeId);
            $itemDataObjects[] = $shippingDataObject;
        }

        //process extra taxable items associated only with quote
        $quoteExtraTaxables = $this->mapQuoteExtraTaxables(
            $this->quoteDetailsItemDataObjectFactory,
            $address,
            $useBaseCurrency
        );
        if (!empty($quoteExtraTaxables)) {
            $itemDataObjects = array_merge($itemDataObjects, $quoteExtraTaxables);
        }

        //Preparation for calling taxCalculationService
        $quoteDetails = $this->prepareQuoteDetails($shippingAssignment, $itemDataObjects);

        return $quoteDetails;
    }

   
}