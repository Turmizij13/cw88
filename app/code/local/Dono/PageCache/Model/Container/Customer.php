<?php
/**
 * Container for cache lifetime equated with session lifetime
 */
class Dono_PageCache_Model_Container_Customer extends Dono_PageCache_Model_Container_Abstract
{
    /**
     * Save data to cache storage and set cache lifetime equal with customer session lifetime
     *
     * @param string $data
     * @param string $id
     * @param array $tags
     */
    protected function _saveCache($data, $id, $tags = array(), $lifetime = null)
    {
        $lifetime = Mage::getConfig()->getNode(Mage_Core_Model_Session_Abstract::XML_PATH_COOKIE_LIFETIME);
        return parent::_saveCache($data, $id, $tags, $lifetime);
    }
}
