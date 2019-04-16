<?php
namespace Magecomp\Matrixrate\Model\System\Config\Backend\Shipping;

use Magento\Framework\Model\AbstractModel;

class Matrixrate extends \Magento\Framework\App\Config\Value
{
	protected $_tablerateFactory;

	public function __construct(
    		\Magento\Framework\Model\Context $context,
    		\Magento\Framework\Registry $registry,
    		\Magento\Framework\App\Config\ScopeConfigInterface $config,
    		\Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
    		\Magecomp\Matrixrate\Model\ResourceModel\Carrier\MatrixrateFactory $tablerateFactory,
    		\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
    		\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
    		array $data = []
    ) {
    	$this->_tablerateFactory = $tablerateFactory;
    	parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    public function afterSave()
    {
        $tableRate = $this->_tablerateFactory->create();
        $tableRate->uploadAndImport($this);
        return parent::afterSave();
    }
}

