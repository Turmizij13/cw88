<?php
class ECargo_Catalog_Block_Product_View_Description extends Mage_Catalog_Block_Product_View_Description{
	const INTEGER_MAX_SEARCH_DEEP = 5;
	/**
	 * 
	 * get common product description
	 * @todo	get non-shoes-category common description
	 * @deprecated after 1.7.3
	 */
	public function getCommonProductDescription(){
		$html = '';
		$product = $this->getProduct();
		/* @var $product Mage_Catalog_Model_Product */
		$category = $product->getCategory();
		/* @var $category Mage_Catalog_Model_Category */
		if(!$category) return '';
		if(!$category->getData('extra_product_desc')){
			$counter = self::INTEGER_MAX_SEARCH_DEEP;
			while ($counter&&$category){
				$category = $category->getParentCategory();
				if($category->getData('extra_product_desc')){
					break;
				}
				$counter--;
			}
		}
		if($file=$category->getData('extra_product_desc')){
			$url = Mage::getBaseUrl('media').'/wysiwyg/pd_size_chart/'.$file;
			$size = getimagesize($url);
			$height = $size&&isset($size[1])?$size[1]:300;
			$html = '<div style="width:100%;height:'.$height.'px;background:url('.$url.') no-repeat scroll center center transparent"></div>';
		}
		
		return $html;
	}
	
}