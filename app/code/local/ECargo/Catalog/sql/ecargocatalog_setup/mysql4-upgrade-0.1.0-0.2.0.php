<?php
$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_category', 't_w_h', array(
                        'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Thumbnail Width Height',
                        'input'             => 'text',
                        'class'             => '',
                        //'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'default'           => '200x300',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => true,
                        'unique'            => false,
                    ));
$installer->endSetup();