<?php

class Openstream_CustomListing_Model_Resource_Product_Collection extends Mage_Reports_Model_Resource_Product_Collection
{
    function addOrderedQty($from = '', $to = '')
    {
        $adapter              = $this->getConnection();
        $compositeTypeIds     = Mage::getSingleton('catalog/product_type')->getCompositeTypes();
        $orderTableAliasName  = $adapter->quoteIdentifier('order');

        $orderJoinCondition   = array(
            $orderTableAliasName . '.entity_id = order_items.order_id',
            $adapter->quoteInto("{$orderTableAliasName}.state <> ?", Mage_Sales_Model_Order::STATE_CANCELED),

        );

        $productJoinCondition = array(
            $adapter->quoteInto('(e.type_id NOT IN (?))', $compositeTypeIds),
            'e.entity_id = order_items.product_id',
            $adapter->quoteInto('e.entity_type_id = ?', $this->getProductEntityTypeId())
        );

        if ($from != '' && $to != '') {
            $fieldName            = $orderTableAliasName . '.created_at';
            $orderJoinCondition[] = $this->_prepareBetweenSql($fieldName, $from, $to);
        }
        if ($this->isEnabledFlat()) {
            $this->getSelect()->reset()
                ->from(
                array('order_items' => $this->getTable('sales/order_item')),
                array(
                    'ordered_qty' => 'SUM(order_items.qty_ordered)',
                    'order_items_name' => 'order_items.name'
                ))
                ->joinInner(
                array('order' => $this->getTable('sales/order')),
                implode(' AND ', $orderJoinCondition),
                array())
                ->joinLeft(
                array('e' => $this->getResource()->getFlatTableName()),
                "e.entity_id = order_items.product_id"
            )
                ->where('parent_item_id IS NULL')
                ->group('order_items.product_id')
                ->having('SUM(order_items.qty_ordered) > ?', 0);
        } else {
            $this->getSelect()->reset()
                ->from(
                array('order_items' => $this->getTable('sales/order_item')),
                array(
                    'ordered_qty' => 'SUM(order_items.qty_ordered)',
                    'order_items_name' => 'order_items.name'
                ))
                ->joinInner(
                array('order' => $this->getTable('sales/order')),
                implode(' AND ', $orderJoinCondition),
                array())
                ->joinLeft(
                array('e' => $this->getProductEntityTableName()),
                implode(' AND ', $productJoinCondition),
                array(
                    'entity_id' => 'order_items.product_id',
                    'entity_type_id' => 'e.entity_type_id',
                    'attribute_set_id' => 'e.attribute_set_id',
                    'type_id' => 'e.type_id',
                    'sku' => 'e.sku',
                    'has_options' => 'e.has_options',
                    'required_options' => 'e.required_options',
                    'created_at' => 'e.created_at',
                    'updated_at' => 'e.updated_at'
                ))
                ->where('parent_item_id IS NULL')
                ->group('order_items.product_id')
                ->having('SUM(order_items.qty_ordered) > ?', 0);
        }
        return $this;
    }
}