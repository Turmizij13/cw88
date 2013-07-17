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
class Dono_EDM_Block_Adminhtml_Edm_Task_Edit_Tab_Task extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $product = Mage::registry('task');

        $form = new Varien_Data_Form();
        
        $fieldset = $form->addFieldset('edm_task', array('legend'=>Mage::helper('catalog')->__('Task Detail')));

        $fieldset->addField('task_name', 'text', array(
			'name' => 'task_name',
			'label' => Mage::helper('edm')->__('Task Name'),
			'title' => Mage::helper('edm')->__('Task Name'),
			//'class'		=> 'banner_field',
			'tabindex' => 1,
			'required' => true
		));
        $fieldset->addField('template_id', 'select', array(
			'name' => 'template_id',
			'label' => Mage::helper('edm')->__('Template'),
			'title' => Mage::helper('edm')->__('Template'),
			'tabindex' => 1,
			'required' => true,
        	'values'=>$this->helper('edm')->getTemplates()
		));
		
        $fieldset->addField('group_id', 'select', array(
			'name' => 'group_id',
			'label' => Mage::helper('edm')->__('Group'),
			'title' => Mage::helper('edm')->__('Group'),
			//'class'		=> 'banner_field',
			'tabindex' => 1,
			'required' => true,
        	'values'  => $this->helper('edm')->getGroups()
		));
		
        $fieldset->addField('execute_time', 'date', array(
			'name' => 'execute_time',
			'label' => Mage::helper('edm')->__('Execution Time'),
			'title' => Mage::helper('edm')->__('Execution Time'),
			'time'      =>    true,
			'image' => $this->getSkinUrl('images/grid-cal.gif'),
			'format' => Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM),
			'tabindex' => 1,
			'required' => true
		));
		
        $fieldset->addField('status', 'select', array(
			'name' => 'status',
			'label' => Mage::helper('edm')->__('Status'),
			'title' => Mage::helper('edm')->__('Status'),
			//'class'		=> 'banner_field',
			'tabindex' => 1,
			'required' => true,
        	'values' => $this->helper('edm')->getStatus(),
		));
		
		
        $this->setForm($form);
    }
}
