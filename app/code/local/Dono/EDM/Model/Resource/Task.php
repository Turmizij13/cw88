<?php
class Dono_EDM_Model_Resource_Task extends Mage_Core_Model_Resource_Db_Abstract{
	protected function _construct()
	{
		$this->_init('edm/task', 'task_id');
	}
}