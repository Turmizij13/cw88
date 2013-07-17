<?php
/**
 * Cart sidebar container
 */
class Dono_PageCache_Model_Container_Sidebar_Cart extends Dono_PageCache_Model_Container_Advanced_Quote
{
    const CACHE_TAG_PREFIX = 'cartsidebar';

    /**
     * Get identifier from cookies
     *
     * @return string
     */
    protected function _getIdentifier()
    {
        return $this->_getCookieValue(Dono_PageCache_Model_Cookie::COOKIE_CART, '')
            . $this->_getCookieValue(Dono_PageCache_Model_Cookie::COOKIE_CUSTOMER, '');
    }

    /**
     * Render block content
     *
     * @return string
     */
    protected function _renderBlock()
    {
        $block = $this->_getPlaceHolderBlock();
        $renders = $this->_placeholder->getAttribute('item_renders');
        $block->deserializeRenders($renders);
        return $block->toHtml();
    }
}
