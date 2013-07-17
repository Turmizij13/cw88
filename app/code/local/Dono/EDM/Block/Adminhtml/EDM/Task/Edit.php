<?php
class Dono_EDM_Block_Adminhtml_Edm_Task_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	$this->_objectId = 'task_id';
        $this->_controller = 'adminhtml_edm_task';
		$this->_blockGroup = 'edm';
        parent::__construct();
        
        $this->_updateButton('save', 'label', Mage::helper('edm')->__('Save Task'));
        $this->_updateButton('delete', 'label', Mage::helper('edm')->__('Delete Task'));

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
        if (Mage::registry('banner_data')&&Mage::registry('task')->getId()) {
            return Mage::helper('edm')->__("Edit Task  ID(%s)", $this->htmlEscape(Mage::registry('task')->getId()));
        }
        else {
            return Mage::helper('edm')->__('New Task');
        }
    }
}
