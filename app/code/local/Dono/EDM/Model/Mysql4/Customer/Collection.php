<?php
class Dono_EDM_Model_Mysql4_Customer_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
	public function _construct()
	{
		$this->_init('edm/customer');
	}
}