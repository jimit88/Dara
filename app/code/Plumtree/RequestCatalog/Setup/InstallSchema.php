<?php

namespace Plumtree\RequestCatalog\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
        
        
        
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
                
                
        $installer = $setup;
        $installer->startSetup();
                
                
        /**
                        * Create table 'requestcatalog'
                */
                
        $table = $installer->getConnection()->newTable($installer->getTable('jh_plumtree_requestcatalog'))
                                ->addColumn(
                                    'requestcatalog_id',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                                    null,
                                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                                    'Requestcatalog ID'
                                )
                                ->addColumn(
                                    'title',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    ['nullable' => true, 'default' => null],
                                    'Business'
                                )
                                ->addColumn(
                                    'first_name',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'First Name'
                                )
                                ->addColumn(
                                    'last_name',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'Last Name'
                                )
                                ->addColumn(
                                    'address',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'Street 1'
                                )
                                ->addColumn(
                                    'address2',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'Street 2'
                                )
                                ->addColumn(
                                    'email',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    null,
                                    [],
                                    'Email'
                                )
                                ->addColumn(
                                    'city',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'city'
                                )
                                ->addColumn(
                                    'region_id',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'State'
                                )
                                ->addColumn(
                                    'zip',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'Zip'
                                )
								->addColumn(
                                    'country_id',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    [],
                                    'Country'
                                )
								
								->addColumn(
                                    'requested_catalogs_complete',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    null,
                                    [],
                                    'catalog'
                                )
								
                                ->addColumn(
                                    'status',
                                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                                    255,
                                    ['nullable' => false, 'default' => 'New'],
                                    'Status'
                                );
                                
                               
                
                
        $installer->getConnection()->createTable($table);
                
        $installer->endSetup();
    }
}
