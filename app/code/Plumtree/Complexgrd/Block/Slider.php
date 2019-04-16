<?php
/**
 * Plumtree_Complexgrd extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Plumtree
 * @package        Plumtree_Complexgrd
 * @copyright      Copyright (c) 2016
 * @author         Sam
 * @license        Plumtree License
 */


namespace Plumtree\Complexgrd\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\ObjectManagerInterface;
use \Magento\Framework\View\Element\Template\Context;
use Plumtree\Complexgrd\Model\SliderFactory as SliderModelFactory;
use Plumtree\Complexgrd\Model\BannerFactory as BannerModelFactory;


class Slider extends \Magento\Framework\View\Element\Template
{
	protected $sliderFactory;
	protected $bannerFactory;

	public function __construct(
		Context $context,
		SliderModelFactory $sliderFactory,
		BannerModelFactory $bannerFactory
	)
	{
		$this->sliderFactory = $sliderFactory;
		$this->bannerFactory = $bannerFactory;
		parent::__construct($context);
	}

	protected function _prepareLayout()
	{
	}

	public function getSliders()
	{
		$sliderId = $this->getBannerId();
		$model = $this->sliderFactory->create()->load($sliderId);
		if($model){
			$banners = $model->getSelectedBannersCollection();
			return $banners;
		} else{
			return null;
		}

	}

}