<?php
/**
 * SFC - Featured Catagories Extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to support@storefrontconsulting.com so we can send you a copy immediately.
 *
 *
 * @package    SFC_FeaturedCategories
 * @copyright  (C)Copyright 2010 StoreFront Consulting, Inc (http://www.StoreFrontConsulting.com/)
 * @author     Garth Brantley
 *
 * History
 *  2010-05-12 - GHB - Rewriten to use Mage_Catalog_Model_Resource_Eav_Mysql4_Setup::addAttribute method
 *
 */

/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_category', 'extra_product_desc', array(
                        'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Extra Product Desc.',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'donocatalog/entity_attribute_source_file',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => false,
                        'default'           => '',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => true,
                        'unique'            => false,
                    ));
$installer->endSetup();
