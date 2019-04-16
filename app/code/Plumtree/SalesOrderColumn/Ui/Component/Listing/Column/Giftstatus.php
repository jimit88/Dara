<?php 

namespace Plumtree\SalesOrderColumn\Ui\Component\Listing\Column;

use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Api\SearchCriteriaBuilder;

class Giftstatus extends Column
{
    protected $_orderRepository;
    protected $_searchCriteria;
	
    public function __construct(
		ContextInterface $context,
		UiComponentFactory $uiComponentFactory,
		OrderRepositoryInterface $orderRepository,
		SearchCriteriaBuilder $criteria,
		array $components = [],
		array $data = []
	) {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteria  = $criteria;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)	
    {
		
		$objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tbt_product = $resource->getTableName('sales_order_item');
		
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
				
				$sql_product = "Select gift_message_id FROM " . $tbt_product." WHERE order_id='".$item["entity_id"]."'";
				$result_product = $connection->fetchAll($sql_product);
				foreach($result_product as $_result1){
					if ( $_result1['gift_message_id'] ) {
						$message = "Yes";
					}
					else {					
						$message = "No";
					}
					$item[$this->getData('name')] = $message;				
				}
	
            }
        }
        return $dataSource;
    }
}
?>