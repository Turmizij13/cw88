<?php

/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer = $this;

$installer->startSetup();
/**
 * Create table 'edm/task'
 */
$installer->run("DROP TABLE IF EXISTS `{$installer->getTable('edm/task')}`");
$table = $installer->getConnection()
    ->newTable($installer->getTable('edm/task'))
    ->addColumn('task_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true
        ), 'task id')
    ->addColumn('task_name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 100, array(
    		'nullable'  => false,
        ), 'task name')
    ->addColumn('template_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
        ), 'template id')
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 10, array(
        ), 'group id')
    ->addColumn('excute_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'excute time')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, 2, array(
        ), 'status 1 pending,2 processing,3 success,4 error')
    ->addIndex($installer->getIdxName('edm/task', array('task_id')),
        array('task_id'))
    ->addIndex($installer->getIdxName('edm/task', array('task_name')),
        array('task_name'))
    ->addIndex($installer->getIdxName('edm/task', array('template_id')),
        array('template_id'))
    ->addIndex($installer->getIdxName('edm/task', array('group_id')),
        array('group_id'))
    ->addIndex($installer->getIdxName('edm/task', array('excute_time')),
        array('excute_time'))
    ->addForeignKey($installer->getFkName('edm/task', 'group_id', 'edm/group', 'group_id'), 'group_id', $installer->getTable('edm/group'), 'group_id',Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('edm/task', 'template_id', 'edm/template', 'template_id'), 'template_id', $installer->getTable('edm/template'), 'template_id',Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('edm template');
$installer->getConnection()->createTable($table);
$installer->endSetup();
