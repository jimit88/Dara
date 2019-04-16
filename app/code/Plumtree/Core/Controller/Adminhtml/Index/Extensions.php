<?php
/**
 * Plumtree
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Plumtree.com license that is
 * available through the world-wide-web at this URL:
 * https://www.plumtree.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Plumtree
 * @package     Plumtree_Core
 * @copyright   Copyright (c) 2016 Plumtree (http://www.plumtree.com/)
 * @license     https://www.plumtree.com/LICENSE.txt
 */

namespace Plumtree\Core\Controller\Adminhtml\Index;

/**
 * Class Extensions
 * @package Plumtree\Core\Controller\Adminhtml\Index
 */
class Extensions extends \Magento\Backend\App\Action
{
	/**
	 * Authorization level of a basic admin session
	 */
	const ADMIN_RESOURCE = 'Plumtree_Core::extensions';

	/**
	 * @var \Magento\Framework\View\Result\PageFactory
	 */
	protected $resultPageFactory;

	/**
	 * @param \Magento\Backend\App\Action\Context $context
	 * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
	 */
	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	)
	{
		$this->resultPageFactory = $resultPageFactory;

		parent::__construct($context);
	}

	public function execute()
	{
		/** @var \Magento\Backend\Model\View\Result\Page $resultPage */
		$resultPage = $this->resultPageFactory->create();

		return $resultPage;

	}
}
