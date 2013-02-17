<?php

class Openstream_CustomListing_Block_Attribute extends Openstream_CustomListing_Block_Abstract
{
    protected function _getProductCollection()
    {
        if (($attributeCode = $this->getAttribute()) && ($attributeValue = $this->getValue())) {
            if (is_null($this->_productCollection)) {
                $this->_productCollection = Mage::getResourceModel('reports/product_collection');
                $this->_productCollection->addAttributeToFilter($attributeCode, array('eq' => $attributeValue))
                                         ->addAttributeToSelect('*')
                                         ->addStoreFilter();
            }
        }
        return parent::_getProductCollection();
    }
}