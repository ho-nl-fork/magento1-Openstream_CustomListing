<?php

class Openstream_CustomListing_Block_Category extends Openstream_CustomListing_Block_Abstract
{

    protected $_category;


    /**
     * @return Mage_Catalog_Model_Category
     */
    public function getCategory()
    {
        return $this->_category;
    }


    protected function _getProductCollection()
    {
        if ($this->getIdPath()) {
            $categoryIdPath = explode('/',$this->getIdPath());
            $this->setCategoryId($categoryIdPath[1]);
            $this->_category = Mage::getModel('catalog/category')->load($this->getCategoryId());
        }

        if (is_null($this->_productCollection)
            && $this->_category) {

            $this->_productCollection = Mage::getResourceModel('reports/product_collection');
            $this->_productCollection->addCategoryFilter($this->_category)
                                     ->addAttributeToSelect('*')
                                     ->addStoreFilter()
                                     ->addPriceData();

            $this->prepareSortableFieldsByCategory($this->_category);

            if (! Mage::helper('cataloginventory')->isShowOutOfStock()) {
                Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($this->_productCollection);
            }
        }


        return parent::_getProductCollection();
    }
}