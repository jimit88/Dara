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
namespace Plumtree\Complexgrd\Block\Adminhtml\Slider\Edit\Tab;

class Banner extends \Magento\Backend\Block\Widget\Grid\Extended implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Banner collection factory
     * 
     * @var \Plumtree\Complexgrd\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $bannerCollectionFactory;

    /**
     * Registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * Banner factory
     * 
     * @var \Plumtree\Complexgrd\Model\BannerFactory
     */
    protected $bannerFactory;

    /**
     * constructor
     * 
     * @param \Plumtree\Complexgrd\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Plumtree\Complexgrd\Model\BannerFactory $bannerFactory
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param array $data
     */
	 
	 protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getCollection()) {
            // create pager block for collection 
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'my.custom.pager'
            );
            // // assign collection to pager we can set 8 per page
            $pager->setLimit(50)->setCollection($this->getCollection());
            $this->setChild('pager', $pager);// set pager block in layout
        }
        return $this;
    }
	
    public function __construct(
        \Plumtree\Complexgrd\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Plumtree\Complexgrd\Model\BannerFactory $bannerFactory,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        array $data = []
    )
    {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->coreRegistry            = $coreRegistry;
        $this->bannerFactory           = $bannerFactory;
        parent::__construct($context, $backendHelper, $data);
    }


    /**
     * Set grid params
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId('banner_grid');
		//$this->setPagerVisibility(false);
       /* $this->setDefaultSort('position');*/
        $this->setDefaultDir('DES');
		$this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        /*if ($this->getSlider()->getId()) {
            $this->setDefaultFilter(['in_banners'=>1]);
        }*/
    }

    /**
     * prepare the collection

     * @return $this
     */
    protected function _prepareCollection()
    {
        $collection = $this->bannerCollectionFactory->create();
        if ($this->getSlider()->getId()) {
            $constraint = 'related.slider_id='.$this->getSlider()->getId();
        } else {
            $constraint = 'related.slider_id=0';
        }
        $collection->getSelect()->joinLeft(
            array('related' => $collection->getTable('plumtree_complexgrd_banner_slider')),
            'related.banner_id=main_table.banner_id AND '.$constraint,
            array('position')
        );
		$collection->getSelect()->where('main_table.url IS NOT NULL OR main_table.url != ""');
		
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    /**
     * @return $this
     */
    protected function _prepareMassaction()
    {
        return $this;
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_banners',
            [
                'header_css_class'  => 'a-center',
                'type'   => 'checkbox',
                'name'   => 'in_banner',
                'values' => $this->_getSelectedBanners(),
                'align'  => 'center',
                'index'  => 'banner_id'
            ]
        );
        $this->addColumn(
            'banner_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'banner_id',
                'type' => 'number',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'title',
            [
                'header' => __('Name'),
                'index' => 'name',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );
		
        $this->addColumn(
            'position',
            [
                'header' => __('Price'),
                'name'   => 'position',
                'width'  => 60,
                'type'   => 'number',				
				/*'column_css_class'=>'no-display',
    			'header_css_class'=>'no-display',*/
                'validate_class' => 'validate-number',
                'index' => 'position',
                'editable'  => true,
            ]
        );
		
		/*$this->addColumn(
            'status',
            [
                'header' => __('status'),
                'index' => 'status',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );*/
		$this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name',
				'type'      => 'options',
				'options'   => $this->toOptionArrayStatus(),
		        
            ]
        );
		
		$this->addColumn(
            'url',
            [
                'header' => __('Group'),
                'index' => 'url',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name',
				'type'      => 'options',
				'options'   => $this->toOptionArray(),
		        
            ]
        );
		
		/*$this->addColumn(
            'url1',
            [
                'header' => __('Group'),
                'index' => 'url',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );*/
		
		

        return $this;
    }
	
	
	public function toOptionArrayStatus()
    {
		$group = array(
                    '' => 'Select Status',
					'0' => 'Disabled',
                    '1' => 'Enabled',
                );
		
		
		return $group;
    }
	public function toOptionArray()
    {
       /* $group = array(
                    'M - Cushion Fill' => 'M - Cushion Fill',
                    'L - Cushion Fill' => 'L - Cushion Fill',
                );*/
		$objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tableName = $resource->getTableName('complexoptiongroup_complexoptiongroup');
		
		$result1 = $connection->fetchAll("SELECT DISTINCT name FROM ".$tableName." ORDER BY name ASC");
		//$group = array();
		foreach($result1 as $_result1){
			//$group[] = array("value" => $_result1['name']);
			$group[$_result1['name']] = $_result1['name'];
		}
		
		
		return $group;
    }
	
	/*protected function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => 'label1'],
            ['value' => 2, 'label' => 'label2']
        ];
    }*/

    /**
     * Retrieve selected Banners

     * @return array
     */
    protected function _getSelectedBanners()
    {
        $banners = $this->getSliderBanners();
        if (!is_array($banners)) {
            $banners = $this->getSlider()->getBannersPosition();
            return array_keys($banners);
        }
        return $banners;
    }

    /**
     * Retrieve selected Banners

     * @return array
     */
    public function getSelectedBanners()
    {
        $selected = $this->getSlider()->getBannersPosition();
        if (!is_array($selected)) {
            $selected = [];
        } else {
            foreach ($selected as $key => $value) {
                $selected[$key] = ['position' => $value];
            }
        }
        return $selected;
    }

    /**
     * @param \Plumtree\Complexgrd\Model\Banner|\Magento\Framework\Object $item
     * @return string
     */
    public function getRowUrl($item)
    {
        return '#';
    }

    /**
     * get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl(
            '*/*/bannersGrid',
            [
                'slider_id' => $this->getSlider()->getId()
            ]
        );
    }

    /**
     * @return \Plumtree\Complexgrd\Model\Slider
     */
    public function getSlider()
    {
        return $this->coreRegistry->registry('plumtree_complexgrd_slider');
    }

    /**
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_banners') {
            $bannerIds = $this->_getSelectedBanners();
            if (empty($bannerIds)) {
                $bannerIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('main_table.banner_id', ['in'=>$bannerIds]);
            } else {
                if ($bannerIds) {
                    $this->getCollection()->addFieldToFilter('main_table.banner_id', ['nin'=>$bannerIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getTabLabel()
    {
        return __('Complex Options');
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getTabUrl()
    {
        return $this->getUrl('plumtree_complexgrd/slider/banners', ['_current' => true]);
    }

    /**
     * @return string
     */
    public function getTabClass()
    {
        return 'ajax only';
    }
}