<?php

namespace Plumtree\FullActionNameAlert\Model\ResourceModel\Region;

class Collection extends \Magento\Directory\Model\ResourceModel\Region\Collection
{
   
    public function toOptionArray()
    {
        $options = [];
        $propertyMap = [
            'value' => 'region_id',
            'title' => 'default_name',
            'country_id' => 'country_id',
        ];

        foreach ($this as $item) {
            $option = [];
            foreach ($propertyMap as $code => $field) {
                $option[$code] = $item->getData($field);
            }
            $option['label'] = $item->getName();
            $options[] = $option;
        }

        if (count($options) > 0) {
            array_unshift(
                $options,
                ['title' => null, 'value' => null, 'label' => __('Please select')]
            );
        }
        return $options;
    }
}
