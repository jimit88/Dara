<?php

namespace Plumtree\Delproissue\Model\ResourceModel;

class Quote extends \Magento\Quote\Model\ResourceModel\Quote
{
	public function substractProductFromQuotes($product)
    {
        $productId = (int)$product->getId();
        if (!$productId) {
            return $this;
        }
        $connection = $this->getConnection();
        $subSelect = $connection->select();

        // FIX force the new value for items_count to be > 0 and respect the column attribute UNSIGNED
        $conditionCheck = $connection->quoteIdentifier('q.items_count') . " > 0";
        $conditionTrue = $connection->quoteIdentifier('q.items_count') . ' - 1';
        $ifSql = "IF (" . $conditionCheck . "," . $conditionTrue . ", 0)";

        $subSelect->from(
            false,
            [
                'items_qty' => new \Zend_Db_Expr(
                    $connection->quoteIdentifier('q.items_qty') . ' - ' . $connection->quoteIdentifier('qi.qty')
                ),
                //'items_count' => new \Zend_Db_Expr($connection->quoteIdentifier('q.items_count') . ' - 1')
                'items_count' => new \Zend_Db_Expr($ifSql)
            ]
        )->join(
            ['qi' => $this->getTable('quote_item')],
            implode(
                ' AND ',
                [
                    'q.entity_id = qi.quote_id',
                    'qi.parent_item_id IS NULL',
                    $connection->quoteInto('qi.product_id = ?', $productId)
                ]
            ),
            []
        );

        $updateQuery = $connection->updateFromSelect($subSelect, ['q' => $this->getTable('quote')]);

        $connection->query($updateQuery);

        return $this;
    }
}