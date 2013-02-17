<?php

class Openstream_CustomListing_Model_Widget_Source_Attributes
{
    public function toOptionArray()
    {
        /* @var $attributes Mage_Catalog_Model_Resource_Product */
        $attributes = Mage::getModel('catalog/product')->getResource()
            ->loadAllAttributes()->getAttributesByCode();


        $result = array(array('value' => '', 'label' => ''));

        foreach ($attributes as $attribute) {
            /* @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */

            if ($attribute->getIsVisible())
            {
                $result[] = array(
                    'value' => $attribute->getAttributeCode(),
                    'label' => $attribute->getFrontendLabel()
                );
            }

        }

        return $result;
    }
}
