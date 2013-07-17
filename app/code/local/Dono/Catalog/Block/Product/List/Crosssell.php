<?php
class Dono_Catalog_Block_Product_List_Crosssell extends Mage_Catalog_Block_Product_Abstract{
	/**
	 * Default MAP renderer type
	 *
	 * @var string
	 */
	protected $_mapRenderer = 'msrp_item';

	/**
	 * Crosssell item collection
	 *
	 * @var Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Link_Product_Collection
	 */
	protected $_itemCollection;

	/**
	 * Prepare crosssell items data
	 *
	 * @return Mage_Catalog_Block_Product_List_Crosssell
	 */
	protected function _prepareData()
	{
		$product = Mage::registry('product');
		/* @var $product Mage_Catalog_Model_Product */
		$pdCategory = $product->getCategory();
		/* @var $pdCategory Mage_Catalog_Model_Category */
		if(!$pdCategory) return $this;
		$this->_itemCollection = $pdCategory->getProductCollection();
		$this->_itemCollection->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes());
		$this->_itemCollection->setPage(1, 6);
		
		Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_itemCollection);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($this->_itemCollection);

		$this->_itemCollection->load();

		foreach ($this->_itemCollection as $product) {
			$product->setDoNotUseCategoryId(true);
		}

		return $this;
	}

	/**
	 * Before rendering html process
	 * Prepare items collection
	 *
	 * @return Mage_Catalog_Block_Product_List_Crosssell
	 */
	protected function _beforeToHtml()
	{
		$this->_prepareData();
		return parent::_beforeToHtml();
	}

	/**
	 * Retrieve crosssell items collection
	 *
	 * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Link_Product_Collection
	 */
	public function getItems()
	{
		return $this->_itemCollection;
	}
}