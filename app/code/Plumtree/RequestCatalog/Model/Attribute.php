<?php

namespace Plumtree\RequestCatalog\Model;


class Attribute implements \Magento\Framework\Option\ArrayInterface
{ 
    //Below function is supposed to return options.
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => 'Completed Request']
            
        ];
    }
}