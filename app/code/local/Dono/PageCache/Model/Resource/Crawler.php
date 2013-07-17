<?php
class Dono_PageCache_Model_Resource_Crawler extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Internal constructor
     *
     */
    protected function _construct()
    {
        $this->_init('core/url_rewrite', 'url_rewrite_id');
    }

    /**
     * Get statement for iterating store urls
     *
     * @param int $storeId
     * @return Zend_Db_Statement
     */
    public function getUrlStmt($storeId)
    {
        $table = $this->getTable('core/url_rewrite');
        $select = $this->_getReadAdapter()->select()
            ->from($table, array('store_id', 'request_path'))
            ->where('store_id = :store_id')
            ->where('is_system=1');
        return $this->_getReadAdapter()->query($select, array(':store_id' => $storeId));
    }

    /**
     * Retrieve URLs paths that must be visited by crawler
     *
     * @param  $storeId
     * @return array
     */
    public function getUrlsPaths($storeId)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from($this->getTable('core/url_rewrite'), array('request_path'))
            ->where('store_id=?', $storeId)
            ->where('is_system=1');
        return $adapter->fetchCol($select);
    }
}
