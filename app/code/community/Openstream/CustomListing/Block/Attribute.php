<?php

class Openstream_CustomListing_Block_Attribute extends Openstream_CustomListing_Block_Abstract
{
    protected function _getProductCollection()
    {
        if (($attribute_code = $this->getAttribute()) && ($attribute_value = $this->getValue())) {
            if (is_null($this->_productCollection)) {
                $this->_productCollection = Mage::getResourceModel('reports/product_collection');
                $this->_productCollection->addAttributeToFilter($attribute_code, array('eq' => $attribute_value))
                                         ->addAttributeToSelect('*')
                                         ->addStoreFilter();
            }
        }
        return $this->_productCollection;
    }
}