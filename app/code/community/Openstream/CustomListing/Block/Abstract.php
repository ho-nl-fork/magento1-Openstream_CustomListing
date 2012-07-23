<?php

class Openstream_CustomListing_Block_Abstract extends Mage_Catalog_Block_Product_List
    implements Mage_Widget_Block_Interface
{
    protected function _beforeToHtml()
    {
        $blockName = $this->getToolbarBlockName();
        if (!$blockName) {
            $blockName = 'product_list_toolbar';
            $this->setToolbarBlockName($blockName);
            $this->getLayout()->createBlock($this->_defaultToolbarBlock, $blockName)
                ->setTemplate('catalog/product/list/toolbar.phtml')
                ->setChild(
                    $blockName . '_pager',
                    $this->getLayout()->createBlock('page/html_pager', $blockName . '_pager')
                );
        }
        return parent::_beforeToHtml();
    }
}