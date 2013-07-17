<?php
class Dono_PageCache_RequestController extends Mage_Core_Controller_Front_Action
{
    /**
     * Request processing action
     */
    public function processAction()
    {
        $processor  = Mage::getSingleton('dono_pagecache/processor');
        $content    = Mage::registry('cached_page_content');
        $containers = Mage::registry('cached_page_containers');
        $cacheInstance = Dono_PageCache_Model_Cache::getCacheInstance();
        foreach ($containers as $container) {
            $container->applyInApp($content);
        }
        $this->getResponse()->appendBody($content);
        // save session cookie lifetime info
        $cacheId = $processor->getSessionInfoCacheId();
        $sessionInfo = $cacheInstance->load($cacheId);
        if ($sessionInfo) {
            $sessionInfo = unserialize($sessionInfo);
        } else {
            $sessionInfo = array();
        }
        $session = Mage::getSingleton('core/session');
        $cookieName = $session->getSessionName();
        $cookieInfo = array(
            'lifetime' => $session->getCookie()->getLifetime(),
            'path'     => $session->getCookie()->getPath(),
            'domain'   => $session->getCookie()->getDomain(),
            'secure'   => $session->getCookie()->isSecure(),
            'httponly' => $session->getCookie()->getHttponly(),
        );
        if (!isset($sessionInfo[$cookieName]) || $sessionInfo[$cookieName] != $cookieInfo) {
            $sessionInfo[$cookieName] = $cookieInfo;
            // customer cookies have to be refreshed as well as the session cookie
            $sessionInfo[Dono_PageCache_Model_Cookie::COOKIE_CUSTOMER] = $cookieInfo;
            $sessionInfo[Dono_PageCache_Model_Cookie::COOKIE_CUSTOMER_GROUP] = $cookieInfo;
            $sessionInfo[Dono_PageCache_Model_Cookie::COOKIE_CUSTOMER_LOGGED_IN] = $cookieInfo;
            $sessionInfo = serialize($sessionInfo);
            $cacheInstance->save($sessionInfo, $cacheId, array(Dono_PageCache_Model_Processor::CACHE_TAG));
        }
    }
}
