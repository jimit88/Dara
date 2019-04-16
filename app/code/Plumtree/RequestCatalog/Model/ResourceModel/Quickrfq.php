<?php

namespace Plumtree\RequestCatalog\Model\ResourceModel;

class Quickrfq extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
        
        
           
    protected function _construct()
    {
        $this->_init('plumtree_requestcatalog', 'requestcatalog_id');
    }
}
