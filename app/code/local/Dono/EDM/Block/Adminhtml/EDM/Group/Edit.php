<?php
class Dono_EDM_Block_Adminhtml_Edm_Group_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	$this->_objectId = 'group_id';
        $this->_controller = 'adminhtml_edm_group';
		$this->_blockGroup = 'edm';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('edm')->__('Save Group'));
        $this->_updateButton('delete', 'label', Mage::helper('edm')->__('Delete Group'));
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
        if (Mage::registry('group')&&Mage::registry('group')->getId()) {
            return Mage::helper('edm')->__("Edit Group  ID(%s)", $this->htmlEscape(Mage::registry('group')->getId()));
        }
        else {
            return Mage::helper('edm')->__('New Group');
        }
    }
}
