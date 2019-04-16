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

abstract class Banner extends \Magento\Backend\App\Action
{
    /**
     * Banner Factory
     * 
     * @var \Plumtree\Complexgrd\Model\BannerFactory
     */
    protected $bannerFactory;

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
     * @param \Plumtree\Complexgrd\Model\BannerFactory $bannerFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Plumtree\Complexgrd\Model\BannerFactory $bannerFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->bannerFactory         = $bannerFactory;
        $this->coreRegistry          = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Init Banner
     *
     * @return \Plumtree\Complexgrd\Model\Banner
     */
    protected function initBanner()
    {
        $bannerId  = (int) $this->getRequest()->getParam('banner_id');
        /** @var \Plumtree\Complexgrd\Model\Banner $banner */
        $banner    = $this->bannerFactory->create();
        if ($bannerId) {
            $banner->load($bannerId);
        }
        $this->coreRegistry->register('plumtree_complexgrd_banner', $banner);
        return $banner;
    }
}
