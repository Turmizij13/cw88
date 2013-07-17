<?php
class Dono_EDM_Block_Adminhtml_Edm_Customer_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
    	$this->_objectId = 'customer_id';
        $this->_controller = 'adminhtml_edm_customer';
		$this->_blockGroup = 'edm';
        parent::__construct();
        
        $this->_updateButton('save', 'label', Mage::helper('edm')->__('Save Customer'));
        $this->_updateButton('delete', 'label', Mage::helper('edm')->__('Delete Customer'));

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
        if (Mage::registry('customer')&&Mage::registry('customer')->getId()) {
            return Mage::helper('edm')->__("Edit customer  ID(%s)", $this->htmlEscape(Mage::registry('customer')->getId()));
        }
        else {
            return Mage::helper('edm')->__('New customer');
        }
    }
}
