<?php

$installer = $this;
$installer->startSetup();
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->addAttribute('catalog_product', 'cjm_imageswitcher', array(

    'group'         				=> 'Images',
    'input'         				=> 'text',
    'type'          				=> 'text',
    'label'         				=> 'Image Switch Code',
    'backend'       				=> '',
	'frontend'						=> '',
    'visible'       				=> false,
    'required'      				=> false,
    'user_defined' 					=> false,
    'searchable' 					=> false,
    'filterable' 					=> false,
    'comparable'    				=> false,
    'visible_on_front' 				=> false,
    'visible_in_advanced_search'  	=> false,
    'is_html_allowed_on_front' 		=> false,
	'apply_to'          			=> 'configurable',
    'global'        				=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
	'note'							=> 'Do Not Edit!'
));

$setup->addAttribute('catalog_product', 'cjm_moreviews', array(

    'group'         				=> 'Images',
    'input'         				=> 'text',
    'type'          				=> 'text',
    'label'         				=> 'More Views Code',
    'backend'       				=> '',
	'frontend'						=> '',
    'visible'       				=> false,
    'required'      				=> false,
    'user_defined' 					=> false,
    'searchable' 					=> false,
    'filterable' 					=> false,
    'comparable'    				=> false,
    'visible_on_front' 				=> false,
    'visible_in_advanced_search'  	=> false,
    'is_html_allowed_on_front' 		=> false,
	'apply_to'          			=> 'configurable',
    'global'        				=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
	'note'							=> 'Do Not Edit!'
));

$tableName = Mage::getSingleton('core/resource')->getTableName('catalog_product_entity_media_gallery_value');

$installer->run("ALTER TABLE  `".$tableName."` ADD  `defaultimg` TINYINT( 4 ) UNSIGNED NOT NULL DEFAULT  '0'");
$installer->endSetup();