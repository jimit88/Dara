<?php
/**
 * Copyright © 2015 Plumtree. All rights reserved.
 */
namespace Plumtree\Complexoptiongroup\Model\ResourceModel;

/**
 * Complexoptiongroup resource
 */
class Complexoptiongroup extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('complexoptiongroup_complexoptiongroup', 'id');
    }

  
}
