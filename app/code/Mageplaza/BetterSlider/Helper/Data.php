<?php

namespace Mageplaza\BetterSlider\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    protected $_backendUrl;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * @param \Magento\Framework\App\Helper\Context   $context
     * @param \Magento\Backend\Model\UrlInterface $backendUrl
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->storeManager = $storeManager;
    }

    /**
     * get products tab Url in admin
     * @return string
     */
    public function getProductsGridUrl()
    {
	
        //return $this->_backendUrl->getUrl('mageplaza_betterslider/products1/products2', ['_current' => true]);
        //return $this->_backendUrl->getUrl('*/*/products', ['_current' => true]);
		return $this->_backendUrl->getUrl('mageplaza_betterslider/banner/products', ['_current' => true]);
				
    }
}