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

namespace Plumtree\Core\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class PredispatchAdminActionControllerObserver
 * @package Plumtree\Core\Observer
 */
class PredispatchAdminActionControllerObserver implements ObserverInterface
{
	/**
	 * @type \Plumtree\Core\Model\FeedFactory
	 */
	protected $_feedFactory;

	/**
	 * @type \Magento\Backend\Model\Auth\Session
	 */
	protected $_backendAuthSession;

	/**
	 * @param \Plumtree\Core\Model\FeedFactory $feedFactory
	 * @param \Magento\Backend\Model\Auth\Session $backendAuthSession
	 */
	public function __construct(
		\Plumtree\Core\Model\FeedFactory $feedFactory,
		\Magento\Backend\Model\Auth\Session $backendAuthSession
	)
	{
		$this->_feedFactory        = $feedFactory;
		$this->_backendAuthSession = $backendAuthSession;
	}

	/**
	 * @param \Magento\Framework\Event\Observer $observer
	 */
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		if ($this->_backendAuthSession->isLoggedIn()) {
			/* @var $feedModel \Plumtree\Core\Model\Feed */
			$feedModel = $this->_feedFactory->create();
			$feedModel->checkUpdate();
		}
	}
}
