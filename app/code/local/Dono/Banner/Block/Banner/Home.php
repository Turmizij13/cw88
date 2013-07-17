<?php
class Dono_Banner_Block_Banner_Home extends Mage_Core_Block_Template{
	const XML_BANNER_SETTING_ITEMS		= 'design/banner_setting/item';
	const XML_BANNER_SETTING_BASEURL	= 'design/banner_setting/baseurl';
	public function getBanners(){
		$banners = Mage::app()->getStore()->getConfig(self::XML_BANNER_SETTING_ITEMS);
		if(!$banners){
			return null;
		}
		$banners = unserialize($banners);
		return $banners;
	}
	public function canShow(){
		return !!$this->getBanners();
	}
	public function getImage($image){
		$baseUrl = Mage::app()->getStore()->getConfig(self::XML_BANNER_SETTING_BASEURL);
		return $baseUrl.$image['image'];
	}
	public function getPosition($image){
		$position = 1;
		if(isset($image['position'])){
			$position = $image['position'];
		}
		return $position;
	}
}