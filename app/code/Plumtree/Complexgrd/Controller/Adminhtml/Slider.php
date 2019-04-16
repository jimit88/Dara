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
namespace Plumtree\Complexgrd\Controller\Adminhtml;

abstract class Slider extends \Magento\Backend\App\Action
{
    /**
     * Slider Factory
     * 
     * @var \Plumtree\Complexgrd\Model\SliderFactory
     */
    protected $sliderFactory;

    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Result redirect factory
     * 
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */

    /**
     * constructor
     * 
     * @param \Plumtree\Complexgrd\Model\SliderFactory $sliderFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Plumtree\Complexgrd\Model\SliderFactory $sliderFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->sliderFactory         = $sliderFactory;
        $this->coreRegistry          = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init Slider
     *
     * @return \Plumtree\Complexgrd\Model\Slider
     */
    protected function initSlider()
    {
        $sliderId  = (int) $this->getRequest()->getParam('slider_id');
        /** @var \Plumtree\Complexgrd\Model\Slider $slider */
        $slider    = $this->sliderFactory->create();
        if ($sliderId) {
            $slider->load($sliderId);
        }
        $this->coreRegistry->register('plumtree_complexgrd_slider', $slider);
        return $slider;
    }
}
