<?php
class Dono_Sales_Adminhtml_Order_AggregatorController extends Mage_Adminhtml_Controller_Action{
	/**
	 * Init layout, menu and breadcrumb
	 *
	 * @return Mage_Adminhtml_Sales_OrderController
	 */
	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('sales/order')
		->_addBreadcrumb($this->__('Sales'), $this->__('Sales'))
		->_addBreadcrumb($this->__('Orders'), $this->__('Orders'));
		return $this;
	}
	/**
	 * Orders grid
	 */
	public function indexAction()
	{
		$this->_title($this->__('Sales'))->_title($this->__('Orders'));
		$this->_initAction()
		->renderLayout();

	}


	/**
	 * Order grid
	 */
	public function gridAction()
	{
		$this->loadLayout(false);
		$this->renderLayout();
	}
	
    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName   = 'orders_aggregator.csv';
        $grid       = $this->getLayout()->createBlock('donosales/adminhtml_sales_order_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
}