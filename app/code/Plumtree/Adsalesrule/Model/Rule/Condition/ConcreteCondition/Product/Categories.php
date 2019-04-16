<?php

namespace Plumtree\Adsalesrule\Model\Rule\Condition\ConcreteCondition\Product;

class Categories extends \Magento\AdvancedSalesRule\Model\Rule\Condition\ConcreteCondition\Product\Categories

{

 	public function getFilterGroups()
    {
        if ($this->filterGroups === null) {
            $this->filterGroups = [];
            if (!$this->isFilterable()) {
                return $this->filterGroups;
            }
			if($this->categories){
            foreach ($this->categories as $category) {
                /** @var FilterInterface $filter */
                $filter = $this->filterHelper->createFilter();
                $filter->setFilterText(self::FILTER_TEXT_PREFIX . $category)
                    ->setWeight(1)
                    ->setFilterTextGeneratorClass(self::FILTER_TEXT_GENERATOR_CLASS)
                    ->setFilterTextGeneratorArguments(json_encode([]));
                /** @var FilterGroupInterface $filterGroup */
                $filterGroup = $this->filterGroupFactory->create();
                $filterGroup->setFilters([$filter]);
                $this->filterGroups[] = $filterGroup;
            }
			}
        }

        return $this->filterGroups;
    }
	
}