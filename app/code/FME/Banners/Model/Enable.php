<?php

namespace FME\Banners\Model;


class Enable implements \Magento\Framework\Option\ArrayInterface
{ 
    public function toOptionArray()
    {
	

	
	$group = array();
	$group[] = array("value" => '--Select Status--', "label" => '--Select Status--');
	$group[] = array("value" => 1, "label" => "Enable");
	$group[] = array("value" => 0, "label" => "Disable");
 	$group = $group;
	
	return $group;
	
    }
}

