<?php
class ECargo_Catalog_Block_Category_Featured extends Mage_Core_Block_Template{
	
	private $_canShowImage= false;
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function getCollection(){
		 $category = $this->getCurrentCategory();
		 $collection = $category->getChildrenCategories();
		 foreach ($collection as $item){
		 	$item->load($item->getId());
		 }
         return $collection;
	}
	public function canShowImage(){
		return $this->_canShowImage;
	}
	public function setCanShowImage($v){
		$this->_canShowImage = $v;
	}
	
	public function getCategoryImagePath($imageUrl){
		return Mage::getBaseUrl('media').'catalog/category/'.$imageUrl;
	}
	public function getCurrentCategory(){
		return Mage::registry('current_category');
	}
}