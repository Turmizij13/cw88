<?php

class CJM_ColorSelectorPlus_Helper_Data extends Mage_Core_Helper_Abstract
{	
	public function getImageName($image_src)
	{
			$parts = explode("/", $image_src);
			$theName = $parts[count($parts) - 1]; 
			$theName_parts = explode(".", $theName);
			$imageName = $theName_parts[0];
			return $imageName;
	}
	
	public function getUsesSwatchAttribs($_product)
	{
		$swatch_attributes = Mage::helper('colorselectorplus')->getSwatchAttributes();
		$confAttributes = $_product->getTypeInstance(true)->getConfigurableAttributesAsArray($_product);
        foreach($confAttributes as $confAttribute):				
			$thecode = $confAttribute["attribute_code"];
			if(in_array($thecode, $swatch_attributes)) {
				return 'yes';} 
		endforeach;
		
		return 'no';	
	}
	
	public function getConfigQueryString($_options, $confAttributes)
	{
		$swatch_attributes = Mage::helper('colorselectorplus')->getSwatchAttributes();
		$query = array();
		
		foreach($confAttributes as $confAttribute) :
			if(in_array($confAttribute['attribute_code'], $swatch_attributes))
			{ 
				$attributeCode = $confAttribute['attribute_code'];
				$attributeName = $confAttribute['label'];
					
				foreach($_options as $_option) :
					if($attributeName == $_option['label']) {
						$attributeoption = $_option['value']; }
				endforeach;
						
				if($attributeoption) {
					$query[$attributeCode] = $attributeoption; }
			}
		endforeach;	 
		
		return '?'.http_build_query($query);
	}
	
	public function getSortedByPosition($array)
	{
        $new = '';
        $new1 = '';
        foreach ($array as $k=>$na)
            $new[$k] = serialize($na);
        $uniq = array_unique($new);
        foreach($uniq as $k=>$ser)
            $new1[$k] = unserialize($ser);
        if(isset($new1)){
        	return $new1; }
        else {
        	return '';}
    }
	
	public function getAssociatedOptions($product, $att)
	{
		$swatch_attributes = Mage::helper('colorselectorplus')->getSwatchAttributes();
		$confAttributes = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
        $availattribs = array();
		$thecode = '';
		$html = '';  
       	
		foreach ($confAttributes as $confAttribute) {
			$thecode = $confAttribute["attribute_code"];
			if(in_array($thecode, $swatch_attributes))
			{
				$attributeCode = $confAttribute['attribute_code'];
				$attributeName = $confAttribute['label'];
				$options = $confAttribute["values"];
				
				foreach($options as $option) {
					$string = $option["label"];
					$label = trim(substr($string, 0, strpos("$string#", "#")));
					$optvalue = $option["value_index"]; 
					$availattribs['value'][] = $optvalue;
					$availattribs['label'][] = $label;;							
               	}
			}
		}
		
		if($availattribs) {
			$count = count($availattribs['value']);
		} else {
			$count = 0; }
		
		if($count < 1) {
			$html .= '<select class="'.$att.'" id="'.$att.'__value_id__" name="'.$att.'[__value_id__]" disabled="disabled" style="width:100px;">'; }
		else {
			$html .= '<select class="'.$att.'" id="'.$att.'__value_id__" name="'.$att.'[__value_id__]" style="width:100px;">';
			if($att == 'cjm_moreviews') {
				$html .= '<option value="">';
				$html .= Mage::helper('colorselectorplus')->__('*Always Visible*');
				$html .= '</option>'; 
				$html .= '<option value="none">';
				$html .= Mage::helper('colorselectorplus')->__('*None*');
				$html .= '</option>'; }
			else {
				$html .= '<option value="">&nbsp;</option>'; }
			for($s = 0; $s < $count; $s++) {
    			$html .= '<option value="'.$availattribs['value'][$s].'">'.$availattribs['label'][$s].'</option>'; }
			$html .= '</select><br />'; 
		}

		return $html;	
	}
	
	public function getMoreViews($_product)
	{
		$html = '';
		$html_first = '';
		$onloads = '';
		$defaults = '';
		$defaultmoreviews = 0;
		$product_base = Mage::helper('colorselectorplus')->decodeImages($_product);
		
		if($product_base):
			$swatch_attributes = Mage::helper('colorselectorplus')->getSwatchAttributes();
			$confAttributes = $_product->getTypeInstance(true)->getConfigurableAttributesAsArray($_product);
			$images = $product_base['image'];
			
			foreach($images as $key => $image):
				if($product_base['defaultimg'][$key] == 1 && $product_base['morev'][$key] != ''):
					$defaultmoreviews = 1;
					$product_image = $product_base['image'][$key];
					$product_thumb = $product_base['thumb'][$key];
					$product_label = $product_base['label'][$key];
					$onloads .= '<li><a href="'.$product_image.'" onclick="$(\'image\').src = this.href; return false;"><img src="'.$product_thumb.'" width="60" height="60" alt="'.$product_label.'" title="'.$product_label.'" /></a></li>';	
				elseif($product_base['morev'][$key] == ''):
					$defaultmoreviews = 1;
					$product_image = $product_base['image'][$key];
					$product_thumb = $product_base['thumb'][$key];
					$product_label = $product_base['label'][$key];
					$defaults .= '<li><a href="'.$product_image.'" onclick="$(\'image\').src = this.href; return false;"><img src="'.$product_thumb.'" width="60" height="60" alt="'.$product_label.'" title="'.$product_label.'" /></a></li>';
				endif;
			endforeach;
			
			if($defaultmoreviews == 1) {
				$html_first = '<ul id="ul-moreviews"><h2 id="moreviews-title">'.Mage::helper('colorselectorplus')->__('More Views').'</h2>'; }
			else {
				$html_first = '<ul id="ul-moreviews"><h2 id="moreviews-title" style="display:none;">'.Mage::helper('colorselectorplus')->__('More Views').'</h2>'; }
			
			$html = $html_first .= $html;
			
			if($onloads){
				$html .= '<div id="onload-moreviews" style="">'.$onloads.'</div>'; }
			else {
				$html .= '<div id="onload-moreviews" style="display:none;">'.$onloads.'</div>'; }
			
			if($defaults){
				$html .= '<div id="default-moreviews" style="">'.$defaults.'</div>'; }
			else {
				$html .= '<div id="default-moreviews" style="display:none;">'.$defaults.'</div>'; }
		
			foreach($confAttributes as $confAttribute):				
				$thecode = $confAttribute["attribute_code"];
				if(in_array($thecode, $swatch_attributes)): 
					$options = $confAttribute["values"];
					foreach($options as $option):
						$value = $option['value_index'];
						$html .= '<div id="moreview'.$value.'" class="vivian-view" style="display:none">';
						foreach($images as $key => $image):
							if($product_base['morev'][$key] == $value):
								$product_image = $product_base['image'][$key];
								$product_thumb = $product_base['thumb'][$key];
								$product_label = $product_base['label'][$key];
								$html .= '<li><a href="'.$product_image.'" onclick="$(\'image\').src = this.href; return false;"><img src="'.$product_thumb.'" width="60" height="60" alt="'.$product_label.'" title="'.$product_label.'" /></a></li>';
							endif;
						endforeach;
						$html .= '</div>';
               		endforeach;
				endif;
			endforeach;
		
			$html .= '</ul>';
			return $html;
		else:
			return '';
		endif;
	}
	
	public function getMoreViewsZoom($_product)
	{
		$html = '';
		$html_first = '';
		$onloads = '';
		$defaults = '';
		$defaultmoreviews = 0;
		$product_base = Mage::helper('colorselectorplus')->decodeImages($_product);
		
		if($product_base):
			$swatch_attributes = Mage::helper('colorselectorplus')->getSwatchAttributes();
			$confAttributes = $_product->getTypeInstance(true)->getConfigurableAttributesAsArray($_product);
			$images = $product_base['image'];
			
			foreach($images as $key => $image):
				if($product_base['defaultimg'][$key] == 1 && $product_base['morev'][$key] != ''):
					$defaultmoreviews = 1;
					$product_image = $product_base['image'][$key];
					$product_thumb = $product_base['thumb'][$key];
					$product_label = $product_base['label'][$key];
					$product_image_name = Mage::helper('colorselectorplus')->getImageName($product_image);
					$onloads .= '<li><img src="'.$product_thumb.'" width="110" height="110" alt="'.$product_label.'" title="'.$product_label.'" onclick="zoomSwitch(\''.$product_image_name.'\')" /></li>';	
				elseif($product_base['morev'][$key] == ''):
					$defaultmoreviews = 1;
					$product_image = $product_base['image'][$key];
					$product_thumb = $product_base['thumb'][$key];
					$product_label = $product_base['label'][$key];
					$product_image_name = Mage::helper('colorselectorplus')->getImageName($product_image);
					$defaults .= '<li><img src="'.$product_thumb.'" width="110" height="110" alt="'.$product_label.'" title="'.$product_label.'" onclick="zoomSwitch(\''.$product_image_name.'\')" /></li>';
				endif;
			endforeach;
			
			if($defaultmoreviews == 1) {
				$html_first = '<ul id="ul-moreviews"><h2 id="moreviews-title">'.Mage::helper('colorselectorplus')->__('More Views').'</h2>'; }
			else {
				$html_first = '<ul id="ul-moreviews"><h2 id="moreviews-title" style="display:none;">'.Mage::helper('colorselectorplus')->__('More Views').'</h2>'; }
			
			$html = $html_first .= $html;
			
			if($onloads){
				$html .= '<div id="onload-moreviews" style="">'.$onloads.'</div>'; }
			else {
				$html .= '<div id="onload-moreviews" style="display:none;">'.$onloads.'</div>'; }
			
			if($defaults){
				$html .= '<div id="default-moreviews" style="">'.$defaults.'</div>'; }
			else {
				$html .= '<div id="default-moreviews" style="display:none;">'.$defaults.'</div>'; }
		
			foreach($confAttributes as $confAttribute):				
				$thecode = $confAttribute["attribute_code"];
				if(in_array($thecode, $swatch_attributes)): 
					$options = $confAttribute["values"];
					foreach($options as $option):
						$value = $option['value_index'];
						$html .= '<div id="moreview'.$value.'" class="vivian-view" style="display:none">';
						foreach($images as $key => $image):
							if($product_base['morev'][$key] == $value):
								$product_image = $product_base['image'][$key];
								$product_thumb = $product_base['thumb'][$key];
								$product_label = $product_base['label'][$key];
								$product_image_name = Mage::helper('colorselectorplus')->getImageName($product_image);
								$html .= '<li><img src="'.$product_thumb.'" width="110" height="110" alt="'.$product_label.'" title="'.$product_label.'" onclick="zoomSwitch(\''.$product_image_name.'\')" /></li>';
							endif;
						endforeach;
						$html .= '</div>';
               		endforeach;
				endif;
			endforeach;
		
			$html .= '</ul>';
			return $html;
		else:
			return '';
		endif;
	}
	
	public function getQueryString($_product)
	{
		$swatch_attributes = Mage::helper('colorselectorplus')->getSwatchAttributes();
		$query = array();
		$configurable_product = Mage::getModel('catalog/product_type_configurable');
		$parentIdArray = $configurable_product->getParentIdsByChild($_product->getId());
			
		if($_product->getTypeId() == 'simple' && isset($parentIdArray[0])) {
			foreach($_product->getAttributes() as $_attribute):
				if(in_array($_attribute->getAttributeCode(), $swatch_attributes))
				{ 
					$attributename = $_attribute->getAttributeCode();
					$attributeoption = Mage::getModel('catalog/product')->load($_product->getId())->getAttributeText($attributename);
					if($attributeoption) {
						$query[$attributename] = $attributeoption; }
				}
			endforeach;	 
		}
		
		if($query) {
			return $query; }
		
		return '';
	}
	
	public function getSwatchList()
	{
		$swatch_attributes = Mage::helper('colorselectorplus')->getSwatchAttributes();
		$html = '';
		
		$count = count($swatch_attributes);
		
		for($i = 0; $i < $count; $i++) {
			
			if($i == $count-1) {
				$html .= $swatch_attributes[$i];
			} else {
				$html .= $swatch_attributes[$i].'&nbsp;&#8226;&nbsp;';
			}
		}
		return $html;
	}
	
	public function getSwatchAttributes()
	{
		$swatch_attributes = array();
		$swatchattributes = Mage::getStoreConfig('color_selector_plus/colorselectorplusgeneral/colorattributes',Mage::app()->getStore());
		$swatch_attributes = explode(",", $swatchattributes);
		
		 foreach($swatch_attributes as &$attribute) {
         	$attribute = Mage::getModel('eav/entity_attribute')->load($attribute)->getAttributeCode();
		 }
		 unset($attribute);
	
		return $swatch_attributes;
	}
	
	public function getSwatchSize($theCode)
	{
		if($theCode == 'list'):
			$swatchsize = str_replace(" ", "", Mage::getStoreConfig('color_selector_plus/colorselectorplusgeneral/listsize', Mage::app()->getStore()));
			if (!$swatchsize){
				$swatchsize = '12x12';}
			if(preg_match("/x/i", $swatchsize)){
				return $swatchsize;}
			else {
				return $swatchsize.'x'.$swatchsize;}
			return $swatchsize;
		elseif($theCode == 'shopby'):
			$swatchsize = str_replace(" ", "", Mage::getStoreConfig('color_selector_plus/colorselectorplusgeneral/layersize', Mage::app()->getStore()));
			if (!$swatchsize){
				$swatchsize = '15x15';}
			if(preg_match("/x/i", $swatchsize)){
				return $swatchsize;}
			else {
				return $swatchsize.'x'.$swatchsize;}
			return $swatchsize;
		elseif($theCode != 'null'):
			$swatchsize = str_replace(" ", "", Mage::getStoreConfig('color_selector_plus/swatchsizes/swatchsize_'.$theCode.'_swatchsizes', Mage::app()->getStore()));
			if($swatchsize){
				if(preg_match("/x/i", $swatchsize)){
					return $swatchsize;}
				else {
					return $swatchsize.'x'.$swatchsize;}
			} else {
				$swatchsize = str_replace(" ", "", Mage::getStoreConfig('color_selector_plus/colorselectorplusgeneral/size',Mage::app()->getStore()));
				if (!$swatchsize){
					$swatchsize = '25x25';}
				if(preg_match("/x/i", $swatchsize)){
					return $swatchsize;}
				else {
					return $swatchsize.'x'.$swatchsize;}
				return $swatchsize;
			}
		else:
			$swatchsize = str_replace(" ", "", Mage::getStoreConfig('color_selector_plus/colorselectorplusgeneral/size',Mage::app()->getStore()));
			if (!$swatchsize){
				$swatchsize = '25x25';}
			if(preg_match("/x/i", $swatchsize)){
				return $swatchsize;}
			else {
				return $swatchsize.'x'.$swatchsize;}
			return $swatchsize;
		endif;
	}
	
	public function findColorImage($value, $arr, $key)
	{
		$found = '';
		if(isset($arr[$key])) {
 			$total = count($arr[$key]);
			if($total>0)
 			{
				for($i=0; $i<$total;$i++)
 				{
					if($value == ucwords($arr[$key][$i]))//if it matches the color listed in the attribute
 					{
 						$found = $arr['image'][$i];//return the image src
					}
 				}
 			}
		}
 		return $found;
	}
	
	public function decodeImages($_product)
	{
		$_gallery = $_product->getMediaGalleryImages();
		
		if(count($_gallery) > 1):
		
			$imgIdsBase = array();
			$imgIdsMoreViews = array();
			$product_base = array();
			
			$cjm_colorselector_base = unserialize($_product->getData('cjm_imageswitcher'));
			$cjm_colorselector_more = unserialize($_product->getData('cjm_moreviews'));

			if($cjm_colorselector_base && $cjm_colorselector_more):
				
				foreach($cjm_colorselector_base as $cjm_colorselectorItem => $cjm_colorselectorVal):
					$imgIdsBase[$cjm_colorselectorItem]['colorval'] = $cjm_colorselectorVal;
				endforeach;
				
				foreach($cjm_colorselector_more as $cjm_colorselectorItem => $cjm_colorselectorVal):
					$imgIdsMoreViews[$cjm_colorselectorItem]['moreviews'] = $cjm_colorselectorVal;
				endforeach;
				
				foreach ($_gallery as $_image ):
 					$product_base['color'][] 		= strval($imgIdsBase[$_image['value_id']]['colorval']);
					$product_base['image'][] 		= strval(Mage::helper('catalog/image')->init($_product, 'image', $_image->getFile()));
					$product_base['thumb'][] 		= strval(Mage::helper('catalog/image')->init($_product, 'thumbnail', $_image->getFile())->resize(110));
					$product_base['morev'][] 		= strval($imgIdsMoreViews[$_image['value_id']]['moreviews']);
					$product_base['label'][] 		= $_image['label'];
					$product_base['defaultimg'][] 	= $_image['defaultimg'];
				endforeach;
			
			endif;
		
			return $product_base;
		
		else:
			
			return '';
		
		endif;	
	}
	
	public function getSwatchUrl($optionId)
    {
        $uploadDir = Mage::getBaseDir('media') . DIRECTORY_SEPARATOR . 
                                                    'colorselectorplus' . DIRECTORY_SEPARATOR . 'swatches' . DIRECTORY_SEPARATOR;
        if (file_exists($uploadDir . $optionId . '.jpg'))
        {
            return Mage::getBaseUrl('media') . '/' . 'colorselectorplus' . '/' . 'swatches' . '/' . $optionId . '.jpg';
        }
        return '';
    }
    /**
	 * 
	 * Enter description here ...
	 * @param unknown_type $_product
	 * @param unknown_type $attrs
	 * @author henryzxj from donostudio
	 * @email  henry@donostudio.com
	 * @website www.donostudio.com
	 * @website www.donodeal.com
	 * @date	2013-06-20 16:23
	 * @update  2013-06-22 11:30
	 * @desc	if the product does not choose any image as base image
	 * 			then default option-id will not found
	 * 			if the base-image not the same as base-image-attr,
	 * 			then default option-id will be the last non-null-value
	 */
	private function getBaseAttrImageIfNonDefault($product){
		/**
    	 * attributeCode media_gallery
    	 * attributeId   88
    	 * entityTypeId  4(product)
    	 * 
    	 */
		if(!$product) return false;
		$attrCode = 'media_gallery';
		$imageswitcher = unserialize($product->getData('cjm_imageswitcher'));
		if(!$imageswitcher) return false;
    	$baseImage = $product->getImage();
		if(!$baseImage) return false;
    	$mediaModel = Mage::getResourceModel('catalog/product_attribute_backend_media');
    	/* @var $mMedia  CJM_ColorSelectorPlus_Model_Catalog_Resource_Product_Attribute_Backend_Media */
    	$obj = new Varien_Object();
    	$mediaModel->load($obj,$baseImage,'value');
    	if($obj){
			if(array_key_exists($obj->getValueId(), $imageswitcher)){
				$valueId = $obj->getValueId();
				$optionId = $imageswitcher[$valueId];
				if(!$optionId){
					foreach (array_reverse($imageswitcher) as $key=>$value) if($value) break;
					$optionId = $value;	
				}
				return $optionId;
			}else{
				foreach (array_reverse($imageswitcher) as $key=>$value) if($value) break;
				return $value;
			}
    	}
    	return false;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $_product
	 * @param unknown_type $attrs
	 * @author henryzxj from donostudio
	 * @email  henry@donostudio.com
	 * @website www.donostudio.com
	 * @website www.donodeal.com
	 * @date	2013-06-20 16:23
	 */
	public function getBaseImageByAttr(Mage_Catalog_Model_Product $_product,$attrs){
		$attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'color');
		$label = $attribute->getFrontendLabel();
		foreach ($attrs as $attr) if($attr['label']===$label) break;
		$_product->load($_product->getId());
		$imageswitcher = unserialize($_product->getData('cjm_imageswitcher'));
		/* @var $attribute  Mage_Catalog_Model_Resource_Eav_Attribute */
		if($attribute->usesSource()){
			$options = $attribute->getSource()->getAllOptions(false);
		}
		if(!$options) return false;
		foreach ($options as $option) if($option['label']===$attr['value']) break;
		if(!$option) return false;
		$idx = array_search($option['value'], $imageswitcher);
		if(!$idx) return false;
		$mediaModel = Mage::getResourceModel('catalog/product_attribute_backend_media');
    	/* @var $mMedia  CJM_ColorSelectorPlus_Model_Catalog_Resource_Product_Attribute_Backend_Media */
    	$obj = new Varien_Object();
    	$mediaModel->load($obj,$idx,'value_id');
    	if(!$obj) return false;
    	return $obj->getValue();
	}
	public function getSwatchHtml($attributeCode, $atid, $_product)
	{
		$storeId = Mage::app()->getStore();
		$frontendlabel = 'null';
		$urloption = '';
		$html = '';
		$cnt = 1;
		$_option_vals = array();				
		$_colors = array();
		$hide = Mage::getStoreConfig('color_selector_plus/colorselectorplusgeneral/hidedropdown', $storeId);
		$frontText = Mage::getStoreConfig('color_selector_plus/colorselectorplusgeneral/dropdowntext', $storeId);
		$swatchsize = Mage::helper('colorselectorplus')->getSwatchSize($attributeCode);
		$sizes = explode("x", $swatchsize);
        $width = $sizes[0];
        $height = $sizes[1];
        
        if(isset($_GET[$attributeCode])) {
        	$urloption = $_GET[$attributeCode]; 
        }else{
        	$optionId = $this->getBaseAttrImageIfNonDefault($_product);
        }
		
		if($hide == 0) {
			$html = $html.'<div id="color-swatches" class="swatchesContainerPadded"><ul id="ul-attribute'.$atid.'">'; }
		else {
			$html = $html.'<div id="color-swatches" class="swatchesContainer"><ul id="ul-attribute'.$atid.'">'; }			
                				
        $_collection = Mage::getResourceModel('eav/entity_attribute_option_collection')->setPositionOrder('asc')->setAttributeFilter($atid)->setStoreFilter(0)->load();
		/* @var $_collection  Mage_Eav_Model_Resource_Entity_Attribute_Option_Collection */
		foreach( $_collection->toOptionArray() as $_cur_option ) {
			$_option_vals[$_cur_option['value']] = array(
				'internal_label' => $_cur_option['label'],
				'order' => $cnt
			);
			$cnt++;
        }
		
		$configAttributes = $_product->getTypeInstance(true)->getConfigurableAttributesAsArray($_product);
    	
    	foreach($configAttributes as $attribute) { 
			if($attribute['attribute_code'] == $attributeCode) {
				
				foreach($attribute["values"] as $value) {
         			array_push($_colors, array(
         				'id' => $value['value_index'],
         				'frontlabel' => $value['store_label'],
         				'adminlabel' => $_option_vals[$value['value_index']]['internal_label'],
         				'order' => $_option_vals[$value['value_index']]['order'],
         				'code' => $attributeCode,
         			));
         		}
         		break;
         	}
     	}
				
		$_color_swatch = Mage::helper('colorselectorplus')->getSortedByPosition($_colors);
		$_color_swatch = array_values($_color_swatch);
		
		foreach ($_color_swatch as $key => $val) { 
   			 $sortSingle[$key] = $_color_swatch[$key]['order']; } 

		asort ($sortSingle); 
		reset ($sortSingle); 
		
		while (list ($singleKey, $singleVal) = each ($sortSingle)) { 
    		$newArr[] = $_color_swatch[$singleKey]; } 

		$_color_swatch = $newArr;
		
		foreach($_color_swatch as $_inner_option_id)
 		{	
			$theId = $_inner_option_id['id'];
			$adminLabel = $_inner_option_id['adminlabel'];
			$altText = $_inner_option_id['frontlabel'];
			$code = $_inner_option_id['code'];
			$lowerAltText = strtolower($altText); 
			$extCls = " vivian-opt-{$code} opt-{$lowerAltText}";
			if($frontText == 0) {
				$frontendlabel = $altText; }
			else {
				$frontendlabel = 'null'; }
			
			preg_match_all('/((#?[A-Za-z0-9]+))/', $adminLabel, $matches);
							
			if ( count($matches[0]) > 0 )
			{
				$color_value = $matches[1][count($matches[0])-1];
				$findme = '#';
				$pos = strpos($color_value, $findme);
				
				$product_base = Mage::helper('colorselectorplus')->decodeImages($_product);			
				$product_image = Mage::helper('colorselectorplus')->findColorImage($theId, $product_base, 'color'); //returns url for base image
				
				if(Mage::getStoreConfig('color_selector_plus/zoom/enabled')):
					$imageName = Mage::helper('colorselectorplus')->getImageName($product_image);
				else:
					$imageName = 'nozoom';
				endif;
				if($urloption==$altText||($optionId&&$optionId==$_inner_option_id['id']))
				{	
					$html = $html.'<script type="text/javascript">Event.observe';
					$html = $html."(window, 'load', function() {";
					$html = $html."colorSelected('attribute".$atid."','".$theId."','".$product_image."','".$frontendlabel."','".$imageName."');});</script>";
				}
				
              	if (Mage::helper('colorselectorplus')->getSwatchUrl($theId)):
					$swatchimage = Mage::helper('colorselectorplus')->getSwatchUrl($theId);
					$html = $html.'<li class="swatchContainer'.$extCls.'">';
					$html = $html.'<img src="'.$swatchimage.'" id="'.$theId.'" class="swatch" alt="'.$altText.'" width="'.$width.'px" height="'.$height.'px" title="'.$altText.'" ';
					$html = $html.'onclick="colorSelected';
					$html = $html."('attribute".$atid."','".$theId."','".$product_image."','".$frontendlabel."','".$imageName."')";
					$html = $html.'" /><i></i>';
					$html = $html.'</li>';
				elseif($pos !== false):
              		$html = $html.'<li class="swatchContainer'.$extCls.'">';
					$html = $html.'<div id="'.$theId.'" title="'.$altText.'" class="swatch" style="background-color:'.$color_value.'; width:'.$width.'px; height:'.$height.'px;" ';
					$html = $html.' onclick="colorSelected';
					$html = $html."('attribute".$atid."','".$theId."','".$product_image."','".$frontendlabel."','".$imageName."')";
					$html = $html.'">';
					$html = $html.'</div></li>';
				else:
					$swatchimage = Mage::helper('colorselectorplus')->getSwatchUrl('empty');
					$html = $html.'<li class="swatchContainer'.$extCls.'">';
					$html = $html.'<div  id="'.$theId.'" class="swatch"';
					$html = $html.'onclick="colorSelected';
					$html = $html."('attribute".$atid."','".$theId."','".$product_image."','".$frontendlabel."','".$imageName."')";
					$html = $html.'" ><label>'.$frontendlabel.'</label></div><i></i>';
					$html = $html.'</li>';
				endif;
			}
 		}
		$html = $html.'</ul></div>';
		return $html;	
	}
	
	public function getSwatchImg($option)
    {
        return Mage::helper('colorselectorplus')->getSwatchUrl($option->getId());
    }
	
	public function getAttribOptions()
    {
   		$optionCollection = Mage::getResourceModel('eav/entity_attribute_option_collection')->setAttributeFilter(Mage::registry('entity_attribute')->getId())->setPositionOrder('asc', true)->load();
        return $optionCollection;
    }
	
	public function gettheUrl()
    {
       $pageURL = 'http';
 		
 		if(isset($_SERVER["HTTPS"])) {
 			if ($_SERVER["HTTPS"] == "on") {
				$pageURL .= "s";}
		}
 		
 		$pageURL .= "://";
 		
 		if ($_SERVER["SERVER_PORT"] != "80") {
  			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 		} else {
  			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 		}
		
		return $pageURL;
    }
    
	public function getShopByHtml($_item,$noImg=false)
	{
		$html = '';
		$swatch_attributes = Mage::helper('colorselectorplus')->getSwatchAttributes();
		$ss = Mage::helper('colorselectorplus/data')->getSwatchSize('shopby');
		$sizes = explode("x", $ss);
        $width = $sizes[0];
        $height = $sizes[1];
		$theAttribute = $_item['code'];
		$theUrl = $_item['url'];
		$theImage = $_item['image'];
		$theBGcolor = $_item['bgcolor'];
		
		if($_item['label']&&preg_match('/^(.*)\s+#[0-9A-Fa-f]{6}/i', $_item['label'],$matches)){
			$theLabel = $matches[1].$_item['count'];
		}else{
			$theLabel = $_item['label'].$_item['count'];
		}
		
		if(in_array($theAttribute, $swatch_attributes) && Mage::getStoreConfig('color_selector_plus/colorselectorplusgeneral/showonlayer',Mage::app()->getStore()) == 1):
			if($noImg){
				$html = '<a href="'.$theUrl.'" class="swatch-shopby-text">'.$theLabel.'</a>';
			}else{
				if($theImage != ''):
        			$html = '<a href="'.$theUrl.'"><img class="swatch-shopby" src="'.$theImage.'" title="'.$theLabel.'" alt="'.$theLabel.'" style="width:'.$width.'px; height:'.$height.'px;"></a>';
	      		elseif($theBGcolor != ''):
	       			$html = '<a href="'.$theUrl.'">';
					$html .= '<div class="swatch-shopby" style="background-color:'.$theBGcolor.'; width:'.$width.'px; height:'.$height.'px;" title="'.$theLabel.'"></div>';
					$html .= '</a>';
				else:
					$html = '<a href="'.$theUrl.'" class="swatch-shopby-text">'.$theLabel.'</a>';
				endif;			
			}
		else:
			$html =  '<a href="'.$theUrl.'">'.$_item['label'].'</a>'.$_item['count'];
		endif;
		
		return $html;
	}
	
	// TO DO -- DISPLAYS SELECT BOXES FOR EACH SWATCH ATTRIBUTE
	//public function getAssociatedOptions($product)
//	{
//		$swatch_attributes = Mage::helper('colorselectorplus')->getSwatchAttributes();
//		$confAttributes = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
//      $availattribs = array();
//		$thecode = '';
//		$thename = '';
//		$html = '';   	
//		
//		foreach ($confAttributes as $confAttribute) {
//			$thename = $confAttribute["label"];
//			$thecode = $confAttribute["attribute_code"];
//			if(in_array($thecode, $swatch_attributes))
//			{
//           		$html .= '<label>'.$thename.'</label>';
//				$html .= '<select class="imageSwitch" id="imageSwitch__value_id__" name="imageSwitch[__value_id__]" style="width:100px;">';
//				$html .= '<option value="">&nbsp;</option>';
//              	$options = $confAttribute["values"];
//				foreach($options as $option) {
//    				$string = $option["label"];
//					$result = trim(substr($string, 0, strpos("$string#", "#")));
//					$availattribs[] = $result;
//                    $html .= '<option value="'.$result.'">'.$result.'</option>';
//				}
//				$html .= '</select><br />';
//			}
//		}
//		
//		return $html;	
//	}
}