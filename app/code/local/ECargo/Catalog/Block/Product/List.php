<?php
class ECargo_Catalog_Block_Product_List extends Mage_Catalog_Block_Product_List{
	/**
	 * Retrieve list toolbar HTML
	 *
	 * @return string
	 */
	public function getToolbarHtml($position=null)
	{
		$html = '';
		if($position==='top'){
			$html = $this->getChild('toolbar')
						->setPosition($position)
						->toHtml();
		}else if($position==='bottom'){
			$html = $this->getChild('toolbar')
						 ->setPosition($position)
						 ->setShowSortby(false)
						 ->disableViewSwitcher()
						 ->toHtml();
		}else{
			$html = $this->getChild('toolbar')->setPosition($position)->toHtml();
		}
		return $html;
	}
}
