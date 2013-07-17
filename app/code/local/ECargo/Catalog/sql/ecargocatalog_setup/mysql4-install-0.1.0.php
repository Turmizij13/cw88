<?php
$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_category', 'is_featured_category', array(
                        'type'              => 'int',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Is Category Featured',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => true,
                        'unique'            => false,
                    ));
$installer->endSetup();
