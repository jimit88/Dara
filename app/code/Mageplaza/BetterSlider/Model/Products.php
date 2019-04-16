<?php
 
namespace Mageplaza\BetterSlider\Model;

use Magento\Framework\DataObject\IdentityInterface;

class Products extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{

    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'ws_products_grid';

    /**
     * @var string
     */
    protected $_cacheTag = 'ws_products_grid';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'ws_products_grid';
	
	protected $bannerCollection;
	
	protected $bannerCollectionFactory;
	
	
    public function __construct(
        \Mageplaza\BetterSlider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    )
    {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mageplaza\BetterSlider\Model\ResourceModel\Products');
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getProducts(\Mageplaza\BetterSlider\Model\Products $object)
    {
		//echo '<pre>';
		$banner_data = $object->getData('banner');
		if($banner_data){
		if(isset($banner_data['banner_id'])){
        $tbl = 'mageplaza_product_attachment_rel'; //$this->getResource()->getTable(\Mageplaza\BetterSlider\Model\ResourceModel\Products::TBL_ATT_PRODUCT);
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['product_id']
        )
        ->where(
            'banner_id = ?',
            $banner_data['banner_id']
        );
		return $this->getResource()->getConnection()->fetchCol($select);
		}
		}else{
			return;			
		}
		//echo 'hiiii:---'.$select;
		//die;
		
        
    }
}
