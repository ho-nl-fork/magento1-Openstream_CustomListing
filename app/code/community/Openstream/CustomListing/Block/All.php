<?php

class Openstream_CustomListing_Block_All extends Openstream_CustomListing_Block_Abstract
{
    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $this->_productCollection = Mage::getResourceModel('reports/product_collection');
            $this->_productCollection->addAttributeToSelect('*')
                                     ->addStoreFilter();

            /* @var $productVisibility Mage_Catalog_Model_Product_Visibility */
            $productVisibility = Mage::getSingleton('catalog/product_visibility');
            $productVisibility->addVisibleInCatalogFilterToCollection($this->_productCollection);
        }

        return $this->_productCollection;
    }
}