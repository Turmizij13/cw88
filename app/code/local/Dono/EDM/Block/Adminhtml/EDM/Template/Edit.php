<?php
class Dono_EDM_Block_Adminhtml_Edm_Template_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	$this->_objectId = 'template_id';
        $this->_controller = 'adminhtml_edm_template';
		$this->_blockGroup = 'edm';
        parent::__construct();
        
        $this->_updateButton('save', 'label', Mage::helper('edm')->__('Save Template'));
        $this->_updateButton('delete', 'label', Mage::helper('edm')->__('Delete Template'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
    }


    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('template')&&Mage::registry('template')->getId()) {
            return Mage::helper('edm')->__("Edit Template  ID(%s)", $this->htmlEscape(Mage::registry('template')->getId()));
        }
        else {
            return Mage::helper('edm')->__('New Template');
        }
    }
}
