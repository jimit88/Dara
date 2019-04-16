<?php
namespace Plumtree\Storepickaddress\Observer;

class Setstoreadd implements \Magento\Framework\Event\ObserverInterface
{
    public function __construct(
        \Magento\Checkout\Model\Session $session,
        \Magento\Quote\Api\Data\AddressInterface $address,
        \Magento\Checkout\Api\ShippingInformationManagementInterface $shippingInformationManagement,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $shippingInformation,
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        \Plumtree\Storepickaddress\Helper\Data $helperData,
        \Magento\Framework\Url $url,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\App\Response\Http $http
    )
    {
        $this->session = $session;
        $this->address = $address;
        $this->shippingInformationManagement = $shippingInformationManagement;
        $this->shippingInformation = $shippingInformation;
        $this->quoteRepository = $quoteRepository;
        $this->helperData = $helperData;
        $this->url = $url;
        $this->messageManager = $messageManager;
        $this->http = $http;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
	
		if($this->session->getQuote()->getShippingAddress()->getShippingMethod() == "mpcustomshipping_express"){
        if ($this->session->getQuote()) {
            $cartId = $this->session->getQuote()->getId();
            if ($cartId) {
                $quote = $this->quoteRepository->getActive($cartId);
				$this->helperData->saveShippingInformation();
            }

        }
		}
    }

}