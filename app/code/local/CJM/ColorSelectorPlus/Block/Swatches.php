<?php

class CJM_ColorSelectorPlus_Block_Swatches extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('colorselectorplus/swatches.phtml');
        $this->_uploadSwatches();
    }
    
    protected function _uploadSwatches()
    {
   		$thePath = Mage::getBaseDir('media') . DS . 'colorselectorplus' . DS . 'swatches' . DS;
		$deleteMe = Mage::app()->getRequest()->getPost('colorselectorplus_swatch_delete');
        
		if ($deleteMe) {
      		foreach ($deleteMe as $optionId => $delete) {
           		if ($delete) {
                    @unlink($thePath . $optionId . '.jpg'); }
            }
        }
		
		if(isset($_FILES['colorselectorplus_swatch']) && isset($_FILES['colorselectorplus_swatch']['error'])) {
			foreach ($_FILES['colorselectorplus_swatch']['error'] as $optionId => $error) {
				try {
					$uploader = new Varien_File_Uploader('colorselectorplus_swatch['.$optionId.']');
					$uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
					$uploader->setAllowRenameFiles(false);
					$uploader->setFilesDispersion(false);
					$uploader->save($thePath, $optionId . '.jpg');
				}
				catch (Exception $e) {
 					Mage::getSingleton('adminhtml/session')->addError($this->__($e->getMessage()));
				}
			}
		}
    }
}