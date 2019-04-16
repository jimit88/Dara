<?php
namespace Plumtree\Complexgrd\Model\ResourceModel\Products;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'product_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Plumtree\Complexgrd\Model\Products', 'Plumtree\Complexgrd\Model\ResourceModel\Products');
    }
}