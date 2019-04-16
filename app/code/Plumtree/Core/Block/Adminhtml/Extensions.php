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

namespace Plumtree\Core\Block\Adminhtml;

/**
 * Class Extensions
 */
class Extensions extends \Magento\Framework\View\Element\Template
{
	/**
	 * @var \Magento\Framework\Module\FullModuleList
	 */
	private $moduleList;

	/**
	 * @var \Magento\Framework\App\CacheInterface
	 */
	protected $_cache;

	/**
	 * Extensions constructor.
	 * @param \Magento\Framework\View\Element\Template\Context $context
	 * @param \Magento\Framework\Module\FullModuleList $moduleList
	 * @param array $data
	 */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\Module\FullModuleList $moduleList,
		array $data = []
	)
	{
		parent::__construct($context, $data);

		$this->moduleList = $moduleList;
		$this->_cache     = $context->getCache();
	}

	/**
	 * @return array
	 */
	public function getInstalledModules()
	{
		$mageplza_modules = array();
		foreach ($this->moduleList->getAll() as $moduleName => $info) {
			if (strpos($moduleName, 'Plumtree') !== false) {
				$mageplza_modules[$moduleName] = $info['setup_version'];
			}
		}

		return $mageplza_modules;
	}

	/**
	 * @return bool|mixed|string
	 */
	public function getAvailableModules()
	{
		$url    = 'https://www.plumtree.com/api/getVersions.json';
		$result = $this->_cache->load('mageplaza_extensions');
		if ($result) {
			try {
				$jsonData = file_get_contents($url);
			} catch (\Exception $e) {
				return false;
			}
			$this->_cache->save($jsonData, 'mageplaza_extensions');
			$result = $this->_cache->load('mageplaza_extensions');
		}
		$result = json_decode($result, true); //true return array otherwise object

		return $result;
	}
}
