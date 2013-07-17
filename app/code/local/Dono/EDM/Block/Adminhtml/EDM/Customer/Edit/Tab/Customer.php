<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml product edit price block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Dono_EDM_Block_Adminhtml_Edm_Customer_Edit_Tab_Customer extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $product = Mage::registry('customer');

        $form = new Varien_Data_Form();
        
        $fieldset = $form->addFieldset('edm_customer', array('legend'=>Mage::helper('edm')->__('Customer Detail')));

        $fieldset->addField('email', 'text', array(
			'name' => 'email',
			'label' => Mage::helper('edm')->__('email'),
			'title' => Mage::helper('edm')->__('email'),
			'tabindex' => 1,
			'required' => true
		));
        $fieldset->addField('firstname', 'text', array(
			'name' => 'firstname',
			'label' => Mage::helper('edm')->__('firstname'),
			'title' => Mage::helper('edm')->__('firstname'),
			'tabindex' => 1,
			'required' => true
		));
        $fieldset->addField('lastname', 'text', array(
			'name' => 'lastname',
			'label' => Mage::helper('edm')->__('lastname'),
			'title' => Mage::helper('edm')->__('lastname'),
			'tabindex' => 1,
			'required' => true
		));
		
        $fieldset->addField('group_id', 'select', array(
			'name' => 'group_id',
			'label' => Mage::helper('edm')->__('Group'),
			'title' => Mage::helper('edm')->__('Group'),
			'tabindex' => 1,
			'required' => true,
        	'values'  => $this->helper('edm')->getGroups()
		));
		
        $fieldset->addField('is_subscribed', 'select', array(
			'name' => 'is_subscribed',
			'label' => Mage::helper('edm')->__('is_subscribed'),
			'title' => Mage::helper('edm')->__('is_subscribed'),
			'tabindex' => 1,
			'required' => true,
        	'values' =>$this->helper('edm')->getYesno(),
		));
		
        $fieldset->addField('status', 'select', array(
			'name' => 'status',
			'label' => Mage::helper('edm')->__('Status'),
			'title' => Mage::helper('edm')->__('Status'),
			'tabindex' => 1,
			'required' => true,
        	'values' => $this->helper('edm')->getStatus(),
		));
		
		
        $this->setForm($form);
    }
}
