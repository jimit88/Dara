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

namespace Plumtree\Core\Model;

/**
 * Class Feed
 * @package Plumtree\Core\Model
 */
class Feed extends \Magento\AdminNotification\Model\Feed
{
	/**
	 * @inheritdoc
	 */
	const MAGEPLAZA_FEED_URL = 'www.plumtree.com/notifications.xml';

	/**
	 * @inheritdoc
	 */
	public function getFeedUrl()
	{
		$httpPath = $this->_backendConfig->isSetFlag(self::XML_USE_HTTPS_PATH) ? 'https://' : 'http://';
		if ($this->_feedUrl === null) {
			$this->_feedUrl = $httpPath . self::MAGEPLAZA_FEED_URL;
		}

		return $this->_feedUrl;
	}

	/**
	 * @inheritdoc
	 */
	public function getLastUpdate()
	{
		return $this->_cacheManager->load('mageplaza_notifications_lastcheck');
	}

	/**
	 * @inheritdoc
	 */
	public function setLastUpdate()
	{
		$this->_cacheManager->save(time(), 'mageplaza_notifications_lastcheck');

		return $this;
	}

}
