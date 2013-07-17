<?php

/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer = $this;

$installer->startSetup();
/**
 * Create table 'edm/template'
 */
$installer->run("DROP TABLE IF EXISTS `{$installer->getTable('edm/template')}`");
$table = $installer->getConnection()
    ->newTable($installer->getTable('edm/template'))
    ->addColumn('template_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true
        ), 'template id')
    ->addColumn('template_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, array(
    		'nullable'  => false,
        ), 'template name')
    ->addColumn('template_file', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, array(
        ), 'template file')
    ->addIndex($installer->getIdxName('edm/template', array('template_id')),
        array('template_id'))
    ->addIndex($installer->getIdxName('edm/template', array('template_name')),
        array('template_name'))
    ->addIndex($installer->getIdxName('edm/template', array('template_file')),
        array('template_file'))
    ->setComment('edm template');
$installer->getConnection()->createTable($table);
$installer->endSetup();
