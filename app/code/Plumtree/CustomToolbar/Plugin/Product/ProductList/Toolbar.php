<?php

namespace Plumtree\CustomToolbar\Plugin\Product\ProductList;
class Toolbar
{
    
	public function setCollection($collection) {
	
	 if($this->getCurrentOrder()=="bestseller")
        {
              $collection->getSelect()->joinLeft( 
                'sales_order_item', 
                'e.entity_id = sales_order_item.product_id', 
                array('qty_ordered'=>'SUM(sales_order_item.qty_ordered)')) 
                ->group('e.entity_id') 
                ->order('qty_ordered '.$this->getCurrentDirectionReverse());
        }

    $this->_collection = $collection;
		
    $this->_collection = $collection;

    $this->_collection->setCurPage($this->getCurrentPage());

    // we need to set pagination only if passed value integer and more that 0
    $limit = (int)$this->getLimit();
    if ($limit) {
        $this->_collection->setPageSize($limit);
    }


    // switch tra i tipi di ordinamento

    // echo '<pre>';
    // var_dump($this->getAvailableOrders());
    // die;

    if ($this->getCurrentOrder()) {


        // Costruisco la custom query
        switch ($this->getCurrentOrder()) {

            case 'created_at':

                if ( $this->getCurrentDirection() == 'desc' ) {

                    $this->_collection
                        ->getSelect()
                        ->order('e.created_at DESC');


                } elseif ( $this->getCurrentDirection() == 'asc' ) {

                    $this->_collection
                        ->getSelect()
                        ->order('e.created_at ASC');

                }

                break;

            default:

                $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
                break;

        }

    }


    // echo '<pre>';
    // var_dump($this->getCurrentOrder());
    // var_dump((string) $this->_collection->getSelect());
    // die;


    return $this;

	}
	
	public function getCurrentDirectionReverse() {
            if ($this->getCurrentDirection() == 'asc') {
                return 'desc';
            } elseif ($this->getCurrentDirection() == 'desc') {
                return 'asc';
            } else {
                return $this->getCurrentDirection();
            }
	}
	
	/**
     * Plugin
     *
     * @param \Magento\Catalog\Block\Product\ProductList\Toolbar $subject
     * @param \Closure $proceed
     * @param \Magento\Framework\Data\Collection $collection
     * @return \Magento\Catalog\Block\Product\ProductList\Toolbar
     */
    public function aroundSetCollection(
        \Magento\Catalog\Block\Product\ProductList\Toolbar $subject,
        \Closure $proceed,
        $collection
    ) {
        $currentOrder = $subject->getCurrentOrder();
        $result = $proceed($collection);

        if ($currentOrder) {
            if ($currentOrder == 'price_desc') {
                $subject->getCollection()->setOrder('price', 'desc');
            } elseif ($currentOrder == 'price_asc') {
                $subject->getCollection()->setOrder('price', 'asc');
            }
        }

        return $result;
    }
}