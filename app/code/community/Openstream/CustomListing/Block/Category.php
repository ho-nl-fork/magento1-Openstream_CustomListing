<?php

class Openstream_CustomListing_Block_Category extends Openstream_CustomListing_Block_Abstract
{

    protected $_category;

    public function getCacheLifetime()
    {
        return false;
    }

    public function getCacheKeyInfo()
    {
        // Fix caching when customlisting/category is added through widget layout updates
        return array_merge(parent::getCacheKeyInfo(), [
            $this->getNameInLayout(),
            $this->getIdPath(),
        ]);
    }

    public function getCacheTags()
    {
        // Also add category and widget cache tags since block output depends on those as well
        return array_merge(parent::getCacheTags(), [
            $this->getCategory()->getCacheTags(),
            Mage::getModel('widget/widget_instance')->getCacheTags()
        ]);
    }

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
