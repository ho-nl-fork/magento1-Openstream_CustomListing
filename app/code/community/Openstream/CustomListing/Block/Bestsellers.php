<?php

class Openstream_CustomListing_Block_Bestsellers extends Openstream_CustomListing_Block_Abstract
{
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $this->_productCollection = Mage::getResourceModel('reports/product_collection');
            $this->_productCollection->addOrderedQty()
                                     ->addAttributeToSelect('*')
                                     ->addStoreFilter()
                                     ->setOrder('ordered_qty', 'desc');
        }
        return parent::_getProductCollection();
    }
}