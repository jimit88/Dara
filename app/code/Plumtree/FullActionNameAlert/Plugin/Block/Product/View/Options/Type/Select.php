<?php 

namespace Plumtree\FullActionNameAlert\Plugin\Block\Product\View\Options\Type;

class Select {

   public function afterGetValuesHtml(\Magento\Catalog\Block\Product\View\Options\Type\Select $subject, $result)
    {
        // modify code at $result
        return $result; 
    }
    public function beforeGetValuesHtml(\Magento\Catalog\Block\Product\View\Options\Type\Select $subject, $result)
    {
        // modify code at $result
        return $result; 
    }
     public function aroundGetValuesHtml(\Magento\Catalog\Block\Product\View\Options\Type\Select  $subject, callable $proceed)
    {
       // change here
        $returnValue = $proceed();
        if ($returnValue) {
           //chnages
        }
        return $returnValue;
    }
	
} 
