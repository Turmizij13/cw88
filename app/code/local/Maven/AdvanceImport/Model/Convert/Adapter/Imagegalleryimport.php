<?php
class Maven_AdvanceImport_Model_Convert_Adapter_Imagegalleryimport
    extends Maven_AdvanceImport_Model_Convert_Adapter_Abstract
	{	
		public function import($importData,Mage_Catalog_Model_Product $product)
		{
			
			$baseDir = Mage::getBaseDir('media').'/import';
			$gallery = $importData['gallery'];
			if(isset($gallery)&&$gallery){
				$gallery = preg_split('/(;|\n|;\n)/',$gallery);
				foreach ($gallery as $image){
					$product->addImageToMediaGallery($baseDir.$image, null, false, false);
				}
			}
			$product->addImageToMediaGallery($baseDir.$importData['image'], null, false, false);
			$product->addImageToMediaGallery($baseDir.$importData['small_image'], null, false, false);
			$product->addImageToMediaGallery($baseDir.$importData['thumbnail'], null, false, false);
			$items = $product->getMediaGalleryImages()->toArray();
			$items = $items['items'];
			$item = (current($items));
			$product->setData('image',$item['file']);
			$product->setData('small_image',$item['file']);
			$product->setData('thumbnail',$item['file']);
			$mediaGallery = $product->getMediaGallery();
			
		    $mediaGallery['value']= array(
		    	'image'=>$product->getImage(),
		    	'small_image'=>$product->getSmallImage(),
		    	'thumbnail'=>$product->getThumbnail(),
		    );
		    //'{"image":"'.$product->getImage().'","small_image":"'.$product->getSmallImage().'","thumbnail":"'.$product->getThumbnail().'"}';
		    $product->setMediaGallery($mediaGallery);
		    /* @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
		    $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'color');
			if ($attribute->usesSource()) {
 			   $options = $attribute->getSource()->getAllOptions(false);
			}
			if(!isset($importData['category_ids'])&&$importData['categories']){
				$categoryModel = Mage::getSingleton('catalog/category');
				/* @var Mage_Catalog_Model_Category */
				$categories = explode(',', $importData['categories']);
				$arr = array();
				foreach ($categories as $cate){
					$arr[] = $categoryModel->loadByAttribute('name',$cate)->getId();
				}
				if(count($arr)){
					$product->setCategoryIds(implode(',', $arr));
				}
			}
		}
	}
?>