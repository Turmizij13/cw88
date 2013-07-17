<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product list toolbar
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class ECargo_Catalog_Block_Product_List_Toolbar extends Mage_Catalog_Block_Product_List_Toolbar
{
		
	/**
	 * Render pagination HTML
	 *
	 * @return string
	 */
	public function getPagerHtml($position=null)
	{
		
		$pagerBlock = $this->getChild('product_list_toolbar_pager');
		
		if ($pagerBlock instanceof Varien_Object) {
			/* @var $pagerBlock Mage_Page_Block_Html_Pager */
			$pagerBlock->setAvailableLimit($this->getAvailableLimit());

			$pagerBlock->setUseContainer(false)
			->setShowPerPage(false)
			->setShowAmounts(false)
			->setLimitVarName($this->getLimitVarName())
			->setPageVarName($this->getPageVarName())
			->setLimit($this->getLimit())
			->setFrameLength(Mage::getStoreConfig('design/pagination/pagination_frame'))
			->setJump(Mage::getStoreConfig('design/pagination/pagination_frame_skip'))
			->setCollection($this->getCollection())
			->setPosition($position);
			return $pagerBlock->toHtml();
		}
		return '';
	}
}
