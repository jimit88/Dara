<?php
namespace Magecomp\Matrixrate\Model\System\Config\Source\Shipping;

class Matrixrate implements \Magento\Framework\Option\ArrayInterface
{
	protected $_tablerateFactory;

	public function __construct(
    		\Magento\Framework\Model\Context $context,
    		\Magento\Framework\Registry $registry,
    		\Magento\Framework\App\Config\ScopeConfigInterface $config,
    		\Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
    		\Magecomp\Matrixrate\Model\Carrier\MatrixrateFactory $tablerateFactory,
    		\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
    		\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
    		array $data = []
    ) {
    	$this->_tablerateFactory = $tablerateFactory;
    }


    public function toOptionArray()
    {
		$tableRate = $this->_tablerateFactory->create();
        $arr = [];
        foreach ($tableRate->getCode('condition_name') as $k=>$v) {
            $arr[] = ['value'=>$k, 'label'=>$v];
        }
        return $arr;
    }
}
