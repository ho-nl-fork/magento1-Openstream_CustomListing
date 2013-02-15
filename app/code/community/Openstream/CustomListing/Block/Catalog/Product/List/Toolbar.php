<?php

class Openstream_CustomListing_Block_Catalog_Product_List_Toolbar
    extends Mage_Catalog_Block_Product_List_Toolbar
{
    /**
     * Init Toolbar
     *
     */
    protected function _construct()
    {
        $this->_orderField  = Mage::getStoreConfig(
            Mage_Catalog_Model_Config::XML_PATH_LIST_DEFAULT_SORT_BY
        );

        $this->_availableOrder = $this->_getConfig()->getAttributeUsedForSortByArray();
        
        $listMode = $this->getData('list_mode') ?: Mage::getStoreConfig('catalog/frontend/list_mode');
        switch ($listMode) {
            case 'grid':
                $this->_availableMode = array('grid' => $this->__('Grid'));
                break;

            case 'list':
                $this->_availableMode = array('list' => $this->__('List'));
                break;

            case 'grid-list':
                $this->_availableMode = array('grid' => $this->__('Grid'), 'list' =>  $this->__('List'));
                break;

            case 'list-grid':
                $this->_availableMode = array('list' => $this->__('List'), 'grid' => $this->__('Grid'));
                break;
        }

        if (count($this->getModes()) <= 1) {
            $this->disableViewSwitcher();
        }

        $this->getDataSetDefault('show_toolbar', 1)
            ? $this->setTemplate('catalog/product/list/toolbar.phtml')
            : $this->setTemplate('catalog/product/list/toolbar-hidden.phtml');

    }
}