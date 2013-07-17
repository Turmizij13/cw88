<?php
class CJM_ColorSelectorPlus_Model_Showeffect
{
	public function toOptionArray()
    {
        return array(
            array('value'=>'show', 'label'=>Mage::helper('colorselectorplus')->__('Show')),
            array('value'=>'fadein', 'label'=>Mage::helper('colorselectorplus')->__('Fade In'))
        );
    }
}
