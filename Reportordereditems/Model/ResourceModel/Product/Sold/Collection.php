<?php
namespace Plumtree\Reportordereditems\Model\ResourceModel\Product\Sold;
use Magento\Framework\DB\Select;
class Collection extends \Magento\Reports\Model\ResourceModel\Product\Sold\Collection
{

    /**
     * Join fields
     *
     * @param string $fromDate
     * @param string $toDate
     * @return $this
     */
    protected function _joinFields($fromDate = '', $toDate = '')
    {
        $this->groupByProductGroup($fromDate, $toDate);
           // ->addOrdersCount()
            //->addAttributeToFilter('created_at', array('from' => $fromDate, 'to' => $toDate, 'datetime' => true));
        return $this;
    }

    /**
     * Set Date range to collection
     *
     * @param int $from
     * @param int $to
     * @return $this
     */
    public function setDateRange($fromDate, $toDate)
    {
        $this->_reset()->_joinFields($fromDate, $toDate);
        //$this->getSelect()->__toString();
        //echo "********".$this->getSelect();
        //die;
        return $this;
    }
    

    /**
     * groupByCustomerGroup
     *
     * @param string $fromDate
     * @param string $toDate
     * @return $this
     */
    public function groupByProductGroup($fromDate = '', $toDate = '')
    {
        /*$this->getSelect()->join(array('customer_group' => 'customer_group' ), 'customer_group.customer_group_id = main_table.customer_group_id', array('customer_group.customer_group_code'))
            ->where('main_table.customer_group_id IS NOT NULL')
            ->group('main_table.customer_group_id');*/

        $connection = $this->getConnection();
        $orderTableAliasName = $connection->quoteIdentifier('order');

        $orderJoinCondition = [
            $orderTableAliasName . '.entity_id = order_items.order_id',
            $connection->quoteInto("{$orderTableAliasName}.state <> ?", \Magento\Sales\Model\Order::STATE_CANCELED),
        ];

        if ($fromDate != '' && $toDate != '') {
            //echo "88888"; die;
            $fieldName = $orderTableAliasName . '.created_at';
            $orderJoinCondition[] = $this->prepareBetweenSql($fieldName, $fromDate, $toDate);
        }

        $this->getSelect()->reset()->from(
            ['order_items' => $this->getTable('sales_order_item')],
            [
                'ordered_qty' => 'order_items.qty_ordered',
                'order_items_name' => 'order_items.name',
                'order_items_sku' => 'order_items.sku'
            ]
        )->joinInner(
            ['order' => $this->getTable('sales_order')],
            implode(' AND ', $orderJoinCondition),
            []
        )->where(
            'order_items.parent_item_id IS NULL'
        )->having(
            'order_items.qty_ordered > ?',
            0
        )->columns(
            'SUM(order_items.qty_ordered) as ordered_qty'
        )->group(
            'order_items.product_id'
        );

        /*
         * Allow Analytic functions usage
         */
        $this->_useAnalyticFunction = true;

        return $this;
    }

    /**
     * Set store filter to collection
     *
     * @param array $storeIds
     * @return $this
     */
    
    public function setStoreIds($storeIds)
    {
        /*if ($storeIds) {
            $this->addAttributeToFilter('store_id', ['in' => (array)$storeIds]);
            //$this->addSumAvgTotals(1)->orderByOrdersCount();
        } else {
            //$this->addSumAvgTotals()->orderByOrdersCount();
        }*/

        return $this;
    }
}
