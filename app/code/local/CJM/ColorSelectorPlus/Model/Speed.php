<?php
class CJM_ColorSelectorPlus_Model_Speed
{
	public function toOptionArray()
    {
        return array(
            array('value'=>'fast', 'label'=>Mage::helper('colorselectorplus')->__('Fast')),
            array('value'=>'slow', 'label'=>Mage::helper('colorselectorplus')->__('Slow'))
        );
    }
}
