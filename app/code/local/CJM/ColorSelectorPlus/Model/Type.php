<?php
class CJM_ColorSelectorPlus_Model_Type
{
	public function toOptionArray()
    {
        return array(
            array('value'=>'standard', 'label'=>Mage::helper('colorselectorplus')->__('Standard')),
            array('value'=>'innerzoom', 'label'=>Mage::helper('colorselectorplus')->__('Inner Zoom')),
            array('value'=>'reverse', 'label'=>Mage::helper('colorselectorplus')->__('Reverse'))
        );
    }
}
