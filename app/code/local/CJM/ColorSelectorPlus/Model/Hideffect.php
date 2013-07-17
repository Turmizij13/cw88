<?php
class CJM_ColorSelectorPlus_Model_Hideffect
{
	public function toOptionArray()
    {
        return array(
            array('value'=>'hide', 'label'=>Mage::helper('colorselectorplus')->__('Hide')),
            array('value'=>'fadeout', 'label'=>Mage::helper('colorselectorplus')->__('Fade Out'))
        );
    }
}
