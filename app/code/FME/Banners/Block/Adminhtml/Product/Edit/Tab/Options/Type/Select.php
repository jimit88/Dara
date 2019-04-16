<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * customers defined options
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */

namespace FME\Banners\Block\Adminhtml\Product\Edit\Tab\Options\Type;


class Select extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Tab\Options\Type\AbstractType
{
    /**
     * @var string
     */
	//protected $_template = 'FME_Banners::catalog/product/edit/options/type/select.phtml';

 
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\Config\Source\Product\Options\Price $optionPrice,
        array $data = []
    ) {
        $this->_optionPrice = $optionPrice;
        parent::__construct($context, $optionPrice, $data);
    }
    
}