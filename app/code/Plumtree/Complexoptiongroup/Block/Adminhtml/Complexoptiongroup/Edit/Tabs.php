<?php
namespace Plumtree\Complexoptiongroup\Block\Adminhtml\Complexoptiongroup\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_complexoptiongroup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Complexoptiongroup Information'));
    }
}