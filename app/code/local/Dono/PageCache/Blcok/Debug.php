<?php
/**
 * Front end helper block to highliht dynamic blocks
 */
class Dono_PageCache_Block_Debug extends Mage_Core_Block_Template
{
    /**
     * Set default debug template
     */
    public function __construct()
    {
        $this->setTemplate('pagecache/blockdebug.phtml');
    }
}
