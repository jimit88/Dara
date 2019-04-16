<?php

namespace FME\Banners\Model;


class Group implements \Magento\Framework\Option\ArrayInterface
{ 
    //Below function is supposed to return options.
    public function toOptionArray()
    {
	
	$objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
	$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
	$connection = $resource->getConnection();
	$tableName = $resource->getTableName('complexoptiongroup_complexoptiongroup');
	
    $result1 = $connection->fetchAll("SELECT DISTINCT name FROM ".$tableName." ORDER BY name ASC");

	
	$group = array();
	$group[] = array("value" => '--Select Options--', "label" => '--Select Options--');
	foreach($result1 as $_result1){
		$group[] = array("value" => $_result1['name'], "label" => $_result1['name']);
	}
 	$group = $group;
	/*echo '<pre>';
	print_r($group);
	echo '</pre>';
	*/
	
	return $group;
//	return $result1;
        /*return [
            ['label'=>'--Select Options--', 'value'=>'0'],
			['value' => 'M - Cushion Fill', 'label' => 'M - Cushion Fill'],
			['value' => 'L - Cushion Fill', 'label' => 'L - Cushion Fill'],
			['value' => 'B - Cushion Fill', 'label' => 'B - Cushion Fill'],
			['value' => 'S - Cushion Fill', 'label' => 'S - Cushion Fill'],
			['value' => 'M - Nailheads', 'label' => 'M - Nailheads'],
			['value' => 'L - Nailheands', 'label' => 'L - Nailheands'],
			['value' => 'B - Nailheads', 'label' => 'B - Nailheads'],
			['value' => 'S - Nailheads', 'label' => 'S - Nailheads'],
			['value' => 'M - Wood Finish', 'label' => 'M - Wood Finish'],
			['value' => 'L - Wood Finish', 'label' => 'L - Wood Finish'],
			['value' => 'B - Wood Finish', 'label' => 'B - Wood Finish'],
			['value' => 'S - Wood Finish', 'label' => 'S - Wood Finish'],
			['value' => 'L - Fabrics', 'label' => 'L - Fabrics'],
			['value' => 'M - Fabrics', 'label' => 'M - Fabrics'],
			['value' => 'B - Fabrics', 'label' => 'B - Fabrics'],
			['value' => 'S - Fabrics', 'label' => 'S - Fabrics'],
			['value' => 'R - Fabrics', 'label' => 'R - Fabrics'],
			['value' => 'R - Wood Finish', 'label' => 'R - Wood Finish'],
			['value' => 'R - Nailheads', 'label' => 'R - Nailheads'],
			['value' => 'R - Cushion Fill', 'label' => 'R - Cushion Fill'],
			['value' => 'A - Fabric', 'label' => 'A - Fabric']
        ];*/
    }
}

