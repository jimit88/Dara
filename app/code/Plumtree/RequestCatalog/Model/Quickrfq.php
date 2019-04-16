<?php

namespace Plumtree\RequestCatalog\Model;

class Quickrfq extends \Magento\Framework\Model\AbstractModel
{
        
        
    protected function _construct()
    {
        $this->_init('Plumtree\RequestCatalog\Model\ResourceModel\Quickrfq');
    }
        
        
    public function getAvailableStatuses()
    {
                
                
        $availableOptions = ['New' => 'New',
                          'Under Process' => 'Under Process',
                          'Pending' => 'Pending'];
                          
                
        return $availableOptions;
    }
        
  
}
