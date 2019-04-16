<?php
namespace Plumtree\Complexoptiongroup\Block\Adminhtml;
class Complexoptiongroup extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_complexoptiongroup';/*block grid.php directory*/
        $this->_blockGroup = 'Plumtree_Complexoptiongroup';
        $this->_headerText = __('Complexoptiongroup');
        $this->_addButtonLabel = __('Add New Entry'); 
        parent::_construct();
		
    }
}
