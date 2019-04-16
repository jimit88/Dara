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
namespace Plumtree\Complexgrd\Block\Adminhtml\Banner\Edit\Tab;

class Banner extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Type options
     * 
     * @var \Plumtree\Complexgrd\Model\Banner\Source\Type
     */
    protected $typeOptions;

    /**
     * Status options
     * 
     * @var \Plumtree\Complexgrd\Model\Banner\Source\Status
     */
    protected $statusOptions;

    /**
     * constructor
     * 
     * @param \Plumtree\Complexgrd\Model\Banner\Source\Type $typeOptions
     * @param \Plumtree\Complexgrd\Model\Banner\Source\Status $statusOptions
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Plumtree\Complexgrd\Model\Banner\Source\Type $typeOptions,
        \Plumtree\Complexgrd\Model\Banner\Source\Status $statusOptions,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    )
    {
        $this->typeOptions   = $typeOptions;
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
        /** @var \Plumtree\Complexgrd\Model\Banner $banner */
        $banner = $this->_coreRegistry->registry('plumtree_complexgrd_banner');
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('banner_');
        $form->setFieldNameSuffix('banner');
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Article Information'),
                'class'  => 'fieldset-wide'
            ]
        );
        $fieldset->addType('image', 'Plumtree\Complexgrd\Block\Adminhtml\Banner\Helper\Image');
        if ($banner->getId()) {
            $fieldset->addField(
                'banner_id',
                'hidden',
                ['name' => 'banner_id']
            );
        }
        $fieldset->addField(
            'name',
            'text',
            [
                'name'  => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'upload_file',
            'image',
            [
                'name'  => 'upload_file',
                'label' => __('Upload File'),
                'title' => __('Upload File'),
            ]
        );
        $fieldset->addField(
            'url',
            'text',
            [
                'name'  => 'url',
                'label' => __('Banner Url'),
                'title' => __('Banner Url'),
            ]
        );
//        $fieldset->addField(
//            'type',
//            'select',
//            [
//                'name'  => 'type',
//                'label' => __('Type'),
//                'title' => __('Type'),
//                'values' => array_merge(['' => ''], $this->typeOptions->toOptionArray()),
//            ]
//        );
//
        $fieldset->addField(
            'status',
            'select',
            [
                'name'  => 'status',
                'label' => __('Status'),
                'title' => __('Status'),
                'values' => $this->statusOptions->toOptionArray(),
            ]
        );
		
		$fieldset->addField(
            'upload_file_1',
            'image',
            [
                'name'  => 'upload_file1',
                'label' => __('Upload File 1'),
                'title' => __('Upload File 1'),
            ]
        );
		
		$fieldset->addField(
            'upload_file_2',
            'image',
            [
                'name'  => 'upload_file2',
                'label' => __('Upload File 2'),
                'title' => __('Upload File 2'),
            ]
        );
		
		$fieldset->addField(
            'upload_file_3',
            'image',
            [
                'name'  => 'upload_file3',
                'label' => __('Upload File 3'),
                'title' => __('Upload File 3'),
            ]
        );
		
		$fieldset->addField(
            'upload_file_4',
            'image',
            [
                'name'  => 'upload_file4',
                'label' => __('Upload File 4'),
                'title' => __('Upload File 4'),
            ]
        );
		
		$fieldset->addField(
            'upload_file_5',
            'image',
            [
                'name'  => 'upload_file5',
                'label' => __('Upload File 5'),
                'title' => __('Upload File 5'),
            ]
        );
		

        $bannerData = $this->_session->getData('plumtree_complexgrd_banner_data', true);
        if ($bannerData) {
            $banner->addData($bannerData);
        } else {
            if (!$banner->getId()) {
                $banner->addData($banner->getDefaultValues());
            }
        }
        $form->addValues($banner->getData());
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
        return __('Article');
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
