<?php
class Dono_EDM_Helper_Data extends Mage_Core_Helper_Abstract{
	const REG_HTMML_FILE_EXPRESSION = '/^.+\.html$/i';
	public function getStatus(){
		return array('0' => 'Disabled','1' => 'Enabled');
	}
	public function getGroups(){
		$collection = Mage::getModel('edm/group')->getCollection();
		$collection->addFieldToFilter('status',1);
		$array = array();
		foreach ($collection as $group){
			$array[$group['group_id']] = $group['group_name'];
		}
		return $array;
	}
	public function getTemplates(){
		$collection = Mage::getModel('edm/template')->getCollection();
		$array = array();
		foreach ($collection as $template){
			$array[$template['template_id']] = $template['template_name'];
		}
		return $array;
	}
	public function getTemplateFiles(){
		return $this->retrieveTemplateFiles();
	}
	public function getYesno(){
		return array('0'=>'No','1'=>'Yes');
	}
	private function retrieveTemplateFiles(){
		$dir = Mage::getBaseDir('media').DS.'edm'.DS.'template';
		$files = scandir($dir);
		$array = array();
		foreach ($files as $file)
		{
			if(preg_match(self::REG_HTMML_FILE_EXPRESSION, $file))
			{
				array_push($array, array('label'=>$file,'value'=>$file));
			}
		}
		array_unshift($array, array('label'=>'Select an template..','value'=>''));
		return $array;
	}
	public function getTransport($id = null) {
			$username = Mage::getStoreConfig('edm_options/smtp/username', $id);
			$password = Mage::getStoreConfig('edm_options/smtp/password', $id);
			$host = Mage::getStoreConfig('edm_options/smtp/host', $id);
			$port = Mage::getStoreConfig('edm_options/smtp/port', $id);
			$ssl = Mage::getStoreConfig('edm_options/smtp/ssl', $id);
			//$auth = Mage::getStoreConfig('system/smtpsettings/authentication', $id);
			$auth = 'login';

			$config = array();

			if ($auth != "none") {
				$config['auth'] = $auth;
				$config['username'] = $username;
				$config['password'] = $password;
			}

			if ($port) {
				$config['port'] = $port;
			}

			if ($ssl != "none" ) {
				$config['ssl'] = $ssl;
			}
				
		$transport = new Zend_Mail_Transport_Smtp($host, $config);
		return $transport;
	}

}