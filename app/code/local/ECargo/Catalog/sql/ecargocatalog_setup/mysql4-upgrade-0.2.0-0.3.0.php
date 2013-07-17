<?php
$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'show_on_wall', array(
                        'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Display On Wall',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'default'           => false,
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => true,
                        'unique'            => false,
                    ));
$installer->endSetup();