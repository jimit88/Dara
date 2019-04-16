<?php
namespace Plumtree\RequestCatalog\Block;

use Magento\Framework\View\Element\Template;
 
class Postform extends \Magento\Contact\Block\ContactForm
{
        
 public function __construct(\Magento\Framework\View\Element\Template\Context $context,
            \Magento\Directory\Block\Data $directoryBlock, 
			 \Magento\Directory\Model\CountryFactory $countryFactory,
            array $data = [])
    {
        
        $this->scopeConfig = $context->getScopeConfig();
        //parent::__construct($context);
		parent::__construct($context, $data);
		$this->_countryFactory = $countryFactory;
        $this->_isScopePrivate = true;
        $this->directoryBlock = $directoryBlock;
    }
        
        
               
    public function getFormAction()
    {
        return $this->getUrl('requestcatalog/index/post', ['_secure' => true]);
    }
	public function getCountries()
    {
        $country = $this->directoryBlock->getCountryHtmlSelect();
        return $country;
    }
    public function getRegion()
    {
        $region = $this->directoryBlock->getRegionHtmlSelect();
        return $region;
    }
	public function getCountryname($countryCode){    
        $countryname = $this->_countryFactory->create()->loadByCode($countryCode);
        return $countryname->getName();
    }
        
 }
