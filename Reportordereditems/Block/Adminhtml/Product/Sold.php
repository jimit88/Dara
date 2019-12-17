<?php
namespace Plumtree\Reportordereditems\Block\Adminhtml\Product;

class Sold extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @var string
     */
    protected $_blockGroup = 'Plumtree_Reportordereditems';

    /**
     * Initialize container block settings
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Plumtree_Reportordereditems';
        $this->_controller = 'adminhtml_product_sold';
        $this->_headerText = __('Ordered Items');
        parent::_construct();
        $this->buttonList->remove('add');
    }
}
