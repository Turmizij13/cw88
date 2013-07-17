<?php
class Dono_Sales_Block_Adminhtml_Sales_Order extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {	
        $this->_controller = 'adminhtml_sales_order';
        $this->_blockGroup = 'donosales';
        $this->_headerText = Mage::helper('sales')->__('Orders');
        $this->_addButtonLabel = Mage::helper('sales')->__('Create New Order');
        parent::__construct();
        if (!Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/create')) {
            $this->_removeButton('add');
        }
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/sales_order_create/start');
    }

}
