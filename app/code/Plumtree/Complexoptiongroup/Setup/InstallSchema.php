<?php
/**
 * Copyright © 2015 Plumtree. All rights reserved.
 */

namespace Plumtree\Complexoptiongroup\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
	
        $installer = $setup;

        $installer->startSetup();

		/**
         * Create table 'complexoptiongroup_complexoptiongroup'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('complexoptiongroup_complexoptiongroup')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'complexoptiongroup_complexoptiongroup'
        )
		->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'Name'
        )
		/*{{CedAddTableColumn}}}*/
		
		
        ->setComment(
            'Plumtree Complexoptiongroup complexoptiongroup_complexoptiongroup'
        );
		
		$installer->getConnection()->createTable($table);
		/*{{CedAddTable}}*/

        $installer->endSetup();

    }
}
