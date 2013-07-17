<?php
class Dono_EDM_Block_Adminhtml_Edm_Customer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('emdTemplateGrid');
        $this->setDefaultSort('template_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        $this->setVarNameFilter('template_filter');
    }

    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareCollection()
    {
        $store = $this->_getStore();
        $collection = Mage::getModel('edm/customer')->getCollection()
            ->addFieldToSelect('*');
			
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('customer_id',
            array(
                'header'=> Mage::helper('edm')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'customer_id',
        ));
        $this->addColumn('email',
            array(
                'header'=> Mage::helper('edm')->__('Email'),
                'index' => 'email',
        ));

        $this->addColumn('firstname',
            array(
                  'header'=> Mage::helper('edm')->__('firstname'),
                  'index' => 'firstname',
        ));
        
        $this->addColumn('lastname',
            array(
                  'header'=> Mage::helper('edm')->__('lastname'),
                  'index' => 'lastname',
        ));
        
        $this->addColumn('group_id',
            array(
                  'header'=> Mage::helper('edm')->__('Group'),
                  'index' => 'group_id',
        ));
        
        $this->addColumn('is_subscribed',
            array(
                  'header'=> Mage::helper('edm')->__('is_subscribed'),
                  'index' => 'is_subscribed',
        ));
        
        $this->addColumn('status',
            array(
                  'header'=> Mage::helper('edm')->__('status'),
                  'index' => 'status',
        ));
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('catalog')->__('Delete'),
             'url'  => $this->getUrl('*/*/massDelete'),
             'confirm' => Mage::helper('catalog')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('catalog/product_status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('catalog')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('catalog')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));

        if (Mage::getSingleton('admin/session')->isAllowed('catalog/update_attributes')){
            $this->getMassactionBlock()->addItem('attributes', array(
                'label' => Mage::helper('catalog')->__('Update Attributes'),
                'url'   => $this->getUrl('*/catalog_product_action_attribute/edit', array('_current'=>true))
            ));
        }

        Mage::dispatchEvent('adminhtml_catalog_product_grid_prepare_massaction', array('block' => $this));
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array(
            'store'=>$this->getRequest()->getParam('store'),
            'id'=>$row->getId())
        );
    }
}
