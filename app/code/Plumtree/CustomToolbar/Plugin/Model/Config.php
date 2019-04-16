<?php
namespace Plumtree\CustomToolbar\Plugin\Model;
use Magento\Store\Model\StoreManagerInterface;
class Config 
{
    protected $_storeManager;

public function __construct(
    StoreManagerInterface $storeManager
) {
    $this->_storeManager = $storeManager;

}

/**
 * Adding custom options and changing labels
 *
 * @param \Magento\Catalog\Model\Config $catalogConfig
 * @param [] $options
 * @return []
 */
public function afterGetAttributeUsedForSortByArray(\Magento\Catalog\Model\Config $catalogConfig, $options)
{
    $urlInterface = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\UrlInterface');
    $search_pg = $urlInterface->getCurrentUrl();

        $options['position'] = __('Curated');
        $options['name'] = __('A to Z');
        if (!strpos($search_pg, 'catalogsearch') !== false) {
        $options['price_asc'] = __('Price: Low to High');
        $options['price_desc'] = __('Price: High to Low');
        }
        $options['created_at'] = __('Newest');
        unset($options['price']);
        return $options;
}
}