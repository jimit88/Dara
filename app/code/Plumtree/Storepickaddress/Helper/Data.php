<?php
namespace Plumtree\Storepickaddress\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    public function __construct(
        \Magento\Checkout\Model\Session $session,
        \Magento\Quote\Api\Data\AddressInterface $address,
        \Magento\Checkout\Api\ShippingInformationManagementInterface $shippingInformationManagement,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $shippingInformation,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Directory\Model\RegionFactory $regionFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->session = $session;
        $this->address = $address;
        $this->shippingInformationManagement = $shippingInformationManagement;
        $this->shippingInformation = $shippingInformation;
        $this->messageManager = $messageManager;
        $this->regionFactory = $regionFactory;
        $this->scopeConfig = $scopeConfig;

    }

    public function saveShippingInformation()
    {
        if ($this->session->getQuote()) {
            $cartId = $this->session->getQuote()->getId();
            $cartSkuArray = $this->getCartItemsSkus();
            if ($cartSkuArray) {
                $shippingAddress = $this->getShippingAddressInformation();
         		$this->shippingInformationManagement->saveAddressInformation($cartId, $shippingAddress);
            }
        }
    }
    public function getShippingAddressInformation() {
        $cartSkuArray = $this->getCartItemsSkus();
        $collectionPointResponse = $this->getCollectionPointAddress($cartSkuArray);
        $shippingAddress = $this->prepareShippingAddress($collectionPointResponse);
        $address = $this->shippingInformation->setShippingAddress($shippingAddress)
            ->setShippingCarrierCode('mpcustomshipping')
            ->setShippingMethodCode('express');
        return $address;
    }

    /* prepare shipping address from your custom shipping address */
    protected function prepareShippingAddress($collectionPointResponse) {
		
        $collectionMessage = ''; //$collectionPointResponse['message'][0];
		
        $firstName = $this->session->getQuote()->getBillingAddress()->getFirstName();
        $lastName = $this->session->getQuote()->getBillingAddress()->getLastName();
		$street = '1885 N Clybourn Ave';
        $countryId = 'US';
        $pincode = '60614';
        $region = "Illinois";
        $company = 'Jayson Home';
        $city = 'Chicago';
        $telephone = '773-248-8180';
        $regionId = $this->getRegionByName($region, $countryId);
        $address = $this->address
            ->setFirstname($firstName)
            ->setLastname($lastName)
			->setCompany($company)
            ->setStreet($street)
            ->setCity($city)
            ->setCountryId($countryId)
            ->setRegionId($regionId)
            ->setRegion($region)
            ->setPostcode($pincode)
            ->setTelephone($telephone)
            //->setFax('3333')
            ->setSaveInAddressBook(0)
			//->setSameAsShipping(1)
            ->setSameAsBilling(0)->setCollectShippingRates(true);
			
        return $address;
    }

    public function getCartItemsSkus() {
        $cartSkuArray = [];
        $cartItems = $this->session->getQuote()->getAllVisibleItems();
        foreach ($cartItems as $product) {
            $cartSkuArray[] = $product->getSku();
        }
        return $cartSkuArray;
    }

    public function getRegionByName($region, $countryId) {
        return $this->regionFactory->create()->loadByName($region, $countryId)->getRegionId();
    }

    protected function getCollectionPointAddress($cartSkuArray) {
      $customShipping = $cartSkuArray;// write your logic here to gets your custom shipping
   	 return $customShipping;
    }
}