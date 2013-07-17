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
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales orders grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Dono_Sales_Block_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Retrieve collection class
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'sales/order_grid_collection';
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
        parent::_prepareCollection();
        $collection->addTrackingData();
        return $this;
    }

    protected function _prepareColumns()
    {

        $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'increment_id',
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Order Date'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));
		$this->addColumn('handle_at', array(
            'header' => Mage::helper('sales')->__('Handle Date'),
            'index' => 'handle_at',
            'type' => 'datetime',
			'sortable'=>false,
			'filter' => false,
            'width' => '100px',
        ));
		$this->addColumn('shipping_at', array(
            'header' => Mage::helper('sales')->__('Shipment Date'),
            'index' => 'shipping_at',
            'type' => 'datetime',
			'sortable'=>false,
			'filter' => false,
            'width' => '100px',
        ));
		$this->addColumn('delivered_at', array(
            'header' => Mage::helper('sales')->__('Delivered Date'),
            'index' => 'delivered_at',
            'type' => 'datetime',
			'sortable'=>false,
			'filter' => false,
            'width' => '100px',
        ));

        $this->addColumn('base_grand_total', array(
            'header' => Mage::helper('sales')->__('Order Total'),
            'index' => 'base_grand_total',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));
        $this->addColumn('courier_link', array(
            'header' => Mage::helper('sales')->__('Courier Link'),
            'index' => 'courier_link',
            'type'  => 'text',
            'width'  => '100px',
        	'sortable'=>false,
        	'filter' => false,
            'currency' => 'base_currency_code',
        ));
        $this->addColumn('tracking_number', array(
            'header' => Mage::helper('sales')->__('Tracking Number'),
            'index' => 'tracking_number',
            'type'  => 'text',
        	'sortable'=>false,
        	'filter' => false,
        	'width' => '100px',
            'currency' => 'base_currency_code',
        ));

        
        $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));

    
        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
    	return $this;
    }

    public function getRowUrl($row)
    {
    	return false;
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
        }
        return false;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

}
