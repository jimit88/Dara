<?php
/**
 * Plumtree_Complexgrd extension
 *                     NOTICE OF LICENSE
 * 
 *                     This source file is subject to the Plumtree License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://www.plumtree.com/LICENSE.txt
 * 
 *                     @category  Plumtree
 *                     @package   Plumtree_Complexgrd
 *                     @copyright Copyright (c) 2016
 *                     @license   https://www.plumtree.com/LICENSE.txt
 */
namespace Plumtree\Complexgrd\Block\Adminhtml\Slider\Edit\Tab;

class Slider extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Status options
     * 
     * @var \Plumtree\Complexgrd\Model\Slider\Source\Status
     */
    protected $statusOptions;

    /**
     * constructor
     * 
     * @param \Plumtree\Complexgrd\Model\Slider\Source\Status $statusOptions
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Plumtree\Complexgrd\Model\Slider\Source\Status $statusOptions,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    )
    {
        $this->statusOptions = $statusOptions;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Plumtree\Complexgrd\Model\Slider $slider */
        $slider = $this->_coreRegistry->registry('plumtree_complexgrd_slider');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('slider_');
        $form->setFieldNameSuffix('slider');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Product Information'),
                'class'  => 'fieldset-wide'
            ]
        );
        if ($slider->getId()) {
            $fieldset->addField(
                'slider_id',
                'hidden',
                ['name' => 'slider_id']
            );
        }
        $fieldset->addField(
            'name',
            'text',
            [
                'name'  => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'readonly' => true,
            ]
        );
        $fieldset->addField(
            'description',
            'textarea',
            [
                'name'  => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
				'readonly' => true,
            ]
        );
        /*$fieldset->addField(
            'status',
            'select',
            [
                'name'  => 'status',
                'label' => __('Status'),
				'readonly' => true,
                'title' => __('Status'),
                'values' => array_merge(['' => ''], $this->statusOptions->toOptionArray()),
            ]
        );
        $fieldset->addField(
            'config_serialized',
            'textarea',
            [
                'name'  => 'config_serialized',
                'label' => __('Config'),
                'title' => __('Config'),
				'readonly' => true,
            ]
        );*/

        $sliderData = $this->_session->getData('plumtree_complexgrd_slider_data', true);
        if ($sliderData) {
            $slider->addData($sliderData);
        } else {
            if (!$slider->getId()) {
                $slider->addData($slider->getDefaultValues());
            }
        }
        $form->addValues($slider->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Product');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
