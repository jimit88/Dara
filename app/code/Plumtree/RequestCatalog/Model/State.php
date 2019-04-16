<?php

namespace Plumtree\RequestCatalog\Model;


class State implements \Magento\Framework\Option\ArrayInterface
{ 
    //Below function is supposed to return options.
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => 'United States'],
            ['value' => 2, 'label' => 'India'],
			['value' => 3, 'label' => 'Indiana']
        ];
    }
}