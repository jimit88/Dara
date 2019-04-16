<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Plumtree\RequestCatalog\Model\ResourceModel\Quickrfq;

use Plumtree\RequestCatalog\Model\ResourceModel\AbstractCollection;

/**
 * CMS page collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'requestcatalog_id';

    
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Plumtree\RequestCatalog\Model\Quickrfq', 'Plumtree\RequestCatalog\Model\ResourceModel\Quickrfq');
        $this->_map['fields']['requestcatalog_id'] = 'main_table.requestcatalog_id';
    }

    
    public function addStoreFilter($store, $withAdmin = true)
    {
        return $this;
    }
}
 