<?php
/**
 * Url processing helper
 */
class Dono_PageCache_Helper_Url
{
    /**
     * Retrieve unique marker value
     *
     * @return string
     */
    protected static function _getSidMarker()
    {
        return '{{' . chr(1) . chr(2) . chr(3) . '_SID_MARKER_' . chr(3) . chr(2) . chr(1) . '}}';
    }

    /**
     * Replace all occurrences of session_id with unique marker
     *
     * @param  string $content
     * @return bool
     */
    public static function replaceSid(&$content)
    {
        if (!$content) {
            return false;
        }
        /** @var $session Mage_Core_Model_Session */
        $session = Mage::getSingleton('core/session');
        $replacementCount = 0;
        $content = str_replace(
            $session->getSessionIdQueryParam() . '=' . $session->getSessionId(),
            $session->getSessionIdQueryParam() . '=' . self::_getSidMarker(),
            $content, $replacementCount);
        return ($replacementCount > 0);
    }

    /**
     * Restore session_id from marker value
     *
     * @param  string $content
     * @return bool
     */
    public static function restoreSid(&$content, $sidValue)
    {
        if (!$content) {
            return false;
        }
        $replacementCount = 0;
        $content = str_replace(self::_getSidMarker(), $sidValue, $content, $replacementCount);
        return ($replacementCount > 0);
    }

    /**
     * Calculate UENC parameter value and replace it
     *
     * @param string $content
     * @return string
     */
    public static function replaceUenc($content)
    {
        $urlHelper = new Mage_Core_Helper_Url;
        $search = '/\/(' . Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED . ')\/[^\/]*\//';
        $replace = '/$1/' . $urlHelper->getEncodedUrl() . '/';
        $content = preg_replace($search, $replace, $content);
        return $content;
    }
}
