<?php

class Openstream_CustomListing_Block_Category extends Openstream_CustomListing_Block_Abstract
{
    protected function _getProductCollection()
    {
        if ($this->getIdPath()) {
            $categoryIdPath = explode('/',$this->getIdPath());
            $this->setCategoryId($categoryIdPath[1]);
        }

        if (is_null($this->_productCollection)
            && $category = Mage::getModel('catalog/category')->load($this->getCategoryId())) {

            $this->_productCollection = Mage::getResourceModel('reports/product_collection');
            $this->_productCollection->addCategoryFilter($category)
                                     ->addAttributeToSelect('*')
                                     ->addStoreFilter();

            Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($this->_productCollection);

            $this->prepareSortableFieldsByCategory($category);

            if (! Mage::helper('cataloginventory')->isShowOutOfStock()) {
                Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($this->_productCollection);
            }
        }


        return parent::_getProductCollection();
    }
}
