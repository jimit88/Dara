<?php

namespace Mageplaza\BetterSlider\Model;
use Magento\Framework\DataObject\IdentityInterface;

class Banner extends \Magento\Framework\Model\AbstractModel implements IdentityInterface
{
    /**
     * Cache tag
     * 
     * @var string
     */
    const CACHE_TAG = 'mageplaza_betterslider_banner';

    /**
     * Cache tag
     * 
     * @var string
     */
    protected $_cacheTag = 'mageplaza_betterslider_banner';

    /**
     * Event prefix
     * 
     * @var string
     */
    protected $_eventPrefix = 'mageplaza_betterslider_banner';

    /**
     * Slider Collection
     * 
     * @var \Mageplaza\BetterSlider\Model\ResourceModel\Slider\Collection
     */
    protected $sliderCollection;

    /**
     * Slider Collection Factory
     * 
     * @var \Mageplaza\BetterSlider\Model\ResourceModel\Slider\CollectionFactory
     */

    protected $imageModel;


    /**
     * constructor
     * 
     * @param \Mageplaza\BetterSlider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Mageplaza\BetterSlider\Model\ResourceModel\Slider\CollectionFactory $sliderCollectionFactory,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,


        array $data = []
    )
    {
        $this->sliderCollectionFactory = $sliderCollectionFactory;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }


    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mageplaza\BetterSlider\Model\ResourceModel\Banner');
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * get entity default values
     *
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];
        $values['type'] = '';
        return $values;
    }
    /**
     * @return array|mixed
     */
    public function getSlidersPosition()
    {
        if (!$this->getId()) {
            return array();
        }
        $array = $this->getData('sliders_position');
        if (is_null($array)) {
            $array = $this->getResource()->getSlidersPosition($this);
            $this->setData('sliders_position', $array);
        }
        return $array;
    }

    /**
     * @return \Mageplaza\BetterSlider\Model\ResourceModel\Slider\Collection
     */
    public function getSelectedSlidersCollection()
    {
        if (is_null($this->sliderCollection)) {
            $collection = $this->sliderCollectionFactory->create();
            $collection->join(
                'mageplaza_betterslider_banner_slider',
                'main_table.slider_id=mageplaza_betterslider_banner_slider.slider_id AND mageplaza_betterslider_banner_slider.banner_id='.$this->getId(),
                ['position']
            );
            $collection->addFieldToFilter('status',1);

            $this->sliderCollection = $collection;
        }
        return $this->sliderCollection;
    }

    /**
     * get full banner url
     * @return string
     */
    public function getBannerUrl()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $baseUrl = $storeManager->getStore()->getBaseUrl();
        return $baseUrl . 'pub/media/mageplaza/betterslider/banner/image' . $this->getUploadFile();

    }

    public function getProducts(\Mageplaza\BetterSlider\Model\Banner $object)
    {
        $tbl = 'mageplaza_product_attachment_rel';///$this->getResource()->getTable(\Mageplaza\BetterSlider\Model\ResourceModel\Banner::TBL_ATT_PRODUCT);
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['product_id']
        )
        ->where(
            'banner_id = ?',
            (int)$object->getId()
        );
        return $this->getResource()->getConnection()->fetchCol($select);
    }
}
