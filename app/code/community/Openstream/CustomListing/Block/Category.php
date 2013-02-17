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

            $this->prepareSortableFieldsByCategory($category);
        }

        return parent::_getProductCollection();
    }
}