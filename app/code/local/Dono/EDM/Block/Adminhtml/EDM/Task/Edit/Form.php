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
 * Jmx_Jmw_Block_Adminhtml_Jmwproduct_Edit_Form
 *
 * @category   Jmx
 * @package    Jmx_Jmw
 * @author     Henryzxj <henryzxj1989@gmail.com www.super-ec.com>
 * @date	   2012-09-07
 */
class Dono_EDM_Block_Adminhtml_Edm_Task_Edit_Form extends Mage_Adminhtml_Block_Widget_Form{
	protected function _prepareForm(){
		$model = Mage::registry('edm');
		$form = new Varien_Data_Form(array(
						'id' => 'edm_task_edit_form',
						'action' => $this->getUrl('*/*/save',''),
						'method' => 'post',
						'enctype' => 'multipart/form-data'
						)
				);
		$form->setUseContainer(true);
		$this->setForm($form);
		return parent::_prepareForm();
	}
}