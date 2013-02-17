<?php

class Openstream_CustomListing_Block_Specials extends Openstream_CustomListing_Block_Abstract
{
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $this->_productCollection = Mage::getResourceModel('reports/product_collection');
            $this->_productCollection->addAttributeToFilter('special_price', array('gt' => 0))
                ->addAttributeToFilter(array(
                array('attribute' => 'special_from_date', 'lt' => new Zend_Db_Expr('NOW()')),
                array('attribute' => 'special_from_date', 'null' => '')
            ), null, 'left')
                ->addAttributeToFilter(array(
                array('attribute' => 'special_to_date', 'gt' => new Zend_Db_Expr('NOW()')),
                array('attribute' => 'special_to_date', 'null' => '')
            ), null, 'left')
                ->addAttributeToSelect('*')
                ->addStoreFilter();
        }
        return parent::_getProductCollection();
    }
}