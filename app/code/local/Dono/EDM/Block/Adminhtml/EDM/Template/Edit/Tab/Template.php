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
class Dono_EDM_Block_Adminhtml_Edm_Template_Edit_Tab_Template extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $product = Mage::registry('template');

        $form = new Varien_Data_Form();
        
        $fieldset = $form->addFieldset('edm_template', array('legend'=>Mage::helper('edm')->__('Template Detail')));

        $fieldset->addField('template_name', 'text', array(
			'name' => 'template_name',
			'label' => Mage::helper('edm')->__('template_name'),
			'title' => Mage::helper('edm')->__('template_name'),
			'tabindex' => 1,
			'required' => true
		));
        $fieldset->addField('template_file', 'select', array(
			'name' => 'template_file',
			'label' => Mage::helper('edm')->__('template_file'),
			'title' => Mage::helper('edm')->__('template_file'),
			'tabindex' => 1,
			'required' => true,
        	'values'=>$this->helper('edm')->getTemplateFiles()
		));
        $this->setForm($form);
    }
}
