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
namespace Plumtree\Complexgrd\Controller\Adminhtml\Banner;

class Sliders extends \Plumtree\Complexgrd\Controller\Adminhtml\Banner
{
    /**
     * Result layout factory
     * 
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * constructor
     * 
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param \Plumtree\Complexgrd\Model\BannerFactory $sliderFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Plumtree\Complexgrd\Model\BannerFactory $sliderFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->resultLayoutFactory = $resultLayoutFactory;
        parent::__construct($sliderFactory, $registry, $context);
    }

    /**
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $this->initBanner();
        $resultLayout = $this->resultLayoutFactory->create();
        /** @var \Plumtree\Complexgrd\Block\Adminhtml\Banner\Edit\Tab\Slider $slidersBlock */
        $slidersBlock = $resultLayout->getLayout()->getBlock('banner.edit.tab.slider');
        if ($slidersBlock) {
            $slidersBlock->setBannerSliders($this->getRequest()->getPost('banner_sliders', null));
        }
        return $resultLayout;
    }
}
