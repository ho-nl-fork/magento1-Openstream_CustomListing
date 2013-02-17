<?php

class Openstream_CustomListing_Model_Widget_Source_ListMode
    extends Mage_Adminhtml_Model_System_Config_Source_Catalog_ListMode
{
    public function toOptionArray()
    {
        $optionArray = parent::toOptionArray();
        array_unshift($optionArray, array('value'=>'', 'label'=>Mage::helper('adminhtml')->__('Use Config Settings')));

        return $optionArray;
    }
}
