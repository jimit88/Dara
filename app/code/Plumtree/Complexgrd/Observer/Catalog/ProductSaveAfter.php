<?php


namespace Plumtree\Complexgrd\Observer\Catalog;

class ProductSaveAfter implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ){
		$_product = $observer->getProduct();

		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tbt_coptn_val = $resource->getTableName('catalog_product_option_type_value');
		
		$sql_coptn_val = "SELECT * FROM `".$tbt_coptn_val."` WHERE `sku` = '".$_product->getSku()."'";
		$result_coptn_val = $connection->fetchAll($sql_coptn_val);

		if($sql_coptn_val){
			if($_product->getStatus()==1){
				foreach($result_coptn_val as $_result_coptn_val){
					$connection->query("UPDATE `".$tbt_coptn_val."` SET `complex_option` = '1' WHERE `option_type_id` = ".$_result_coptn_val['option_type_id'].";");
				}
			}else{
				foreach($result_coptn_val as $_result_coptn_val){
					$connection->query("UPDATE `".$tbt_coptn_val."` SET `complex_option` = '0' WHERE `option_type_id` = ".$_result_coptn_val['option_type_id'].";");
				}
			}
			
		}


	}
}
