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
 * @package     Mage_Sales
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Flat sales order grid collection
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Dono_Sales_Model_Resource_Order_Grid_Collection extends Mage_Sales_Model_Resource_Order_Grid_Collection
{
	public function addTrackingData(){
		foreach ($this->getItems() as $item){
			/* @var $item  Mage_Sales_Model_Order */
			$col = Mage::getModel('sales/order_status_history')->getCollection();
			/* @var $col  Mage_Sales_Model_Resource_Order_Status_History_Collection */
			$col->addFieldToFilter('parent_id',array('eq'=>$item->getId()));
			$handle  = $col->getItemByColumnValue('status', 'handle');
			$delivered = $col->getItemByColumnValue('status', 'delivered');
			$processing = $col->getItemByColumnValue('status', 'processing');
			if($handle&&$handle instanceof Mage_Sales_Model_Order_Status_History){
				$item->setData('handle_at',$handle->getCreatedAt());
			}
			if($delivered&&$delivered instanceof Mage_Sales_Model_Order_Status_History){
				$item->setData('delivered_at',$delivered->getCreatedAt());
			}
			if($processing&&$processing instanceof Mage_Sales_Model_Order_Status_History){
				$item->setData('shipping_at',$processing->getCreatedAt());
			}
			$tracknums = array();
			$shipmentCollection = Mage::getResourceModel('sales/order_shipment_collection')
									->setOrderFilter($item)->load();
			$carrierCode = array();
			foreach ($shipmentCollection as $shipment){
				/* @var $shipment  Mage_Sales_Model_Order_Shipment */
				foreach($shipment->getAllTracks() as $tracknum)
				{
					$carrierCode[$tracknum->getCarrierCode()] = Mage::app()->getStore()->getConfig('carriers/'.$tracknum->getCarrierCode().'/courier_link');	
					$tracknums[]=$tracknum->getNumber();
				}
			}
			$item->setData('tracking_number',implode(',', $tracknums));
			$item->setData('courier_link',implode(',', $carrierCode));
		}
		return $this;
	}
}
