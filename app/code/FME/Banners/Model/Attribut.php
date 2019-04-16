<?php

namespace FME\Banners\Model;


class Attribut implements \Magento\Framework\Option\ArrayInterface
{ 
    //Below function is supposed to return options.
    public function toOptionArray()
    {
        return [
            ['label'=>'--Select Options--', 'value'=>'0'],
			['value' => 1, 'label' => 'Fabric'],
            ['value' => 2, 'label' => 'Cushion Fill'],
			['value' => 3, 'label' => 'Nail Head'],
			['value' => 4, 'label' => 'Wood Finish']			
        ];
    }
}

