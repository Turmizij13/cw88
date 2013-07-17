<?php
/**
 * Viewed products container
 */
class Dono_PageCache_Model_Container_Viewedproducts extends Dono_PageCache_Model_Container_Abstract
{
    const COOKIE_NAME = 'VIEWED_PRODUCT_IDS';

    /**
     * Get viewed product ids from cookie
     *
     * @return array
     */
    protected function _getProductIds()
    {
        $result = $this->_getCookieValue(self::COOKIE_NAME, array());
        if ($result) {
            $result = explode(',', $result);
        }
        return $result;
    }

    /**
     * Get cache identifier
     *
     * @return string
     */
    protected function _getCacheId()
    {
        $cacheId = $this->_placeholder->getAttribute('cache_id');
        $productIds = $this->_getProductIds();
        if ($cacheId && $productIds) {
            sort($productIds);
            $cacheId = 'CONTAINER_' . md5($cacheId . implode('_', $productIds)
                . $this->_getCookieValue(Mage_Core_Model_Store::COOKIE_CURRENCY, ''));
            return $cacheId;
        }
        return false;
    }

    /**
     * Render block content
     *
     * @return string
     */
    protected function _renderBlock()
    {
        $block = $this->_getPlaceHolderBlock();
        $block->setProductIds($this->_getProductIds());
        Mage::dispatchEvent('render_block', array('block' => $block, 'placeholder' => $this->_placeholder));
        return $block->toHtml();
    }

    /**
     * Save information about last viewed products
     *
     * @param array $productIds
     * @return Dono_PageCache_Model_Container_Viewedproducts
     */
    protected function _registerProductsView($productIds)
    {
        return $this;
    }
}
