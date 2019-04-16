<?php
/**
 * Plumtree_Complexgrd extension
 *                     NOTICE OF LICENSE
 * 
 *                     This source file is subject to the Plumtree License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://www.plumtree.com/LICENSE.txt
 * 
 *                     @category  Plumtree
 *                     @package   Plumtree_Complexgrd
 *                     @copyright Copyright (c) 2016
 *                     @license   https://www.plumtree.com/LICENSE.txt
 */
namespace Plumtree\Complexgrd\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * install tables
     *
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('plumtree_complexgrd_banner')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('plumtree_complexgrd_banner')
            )
            ->addColumn(
                'banner_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Banner ID'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'Banner Name'
            )
            ->addColumn(
                'upload_file',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Banner Upload File'
            )
            ->addColumn(
                'url',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [],
                'Banner Url'
            )
            ->addColumn(
                'type',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [],
                'Banner Type'
            )
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64k',
                [],
                'Banner Status'
            )

            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Banner Created At'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Banner Updated At'
            )
            ->setComment('Banner Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('plumtree_complexgrd_banner'),
                $setup->getIdxName(
                    $installer->getTable('plumtree_complexgrd_banner'),
                    ['name','upload_file','url'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name','upload_file','url'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        if (!$installer->tableExists('plumtree_complexgrd_slider')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('plumtree_complexgrd_slider')
            )
            ->addColumn(
                'slider_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Slider ID'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'Slider Name'
            )
            ->addColumn(
                'description',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64k',
                [],
                'Slider Description'
            )
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [],
                'Slider Status'
            )
            ->addColumn(
                'config_serialized',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                '64k',
                [],
                'Slider Config'
            )

            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Slider Created At'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Slider Updated At'
            )
            ->setComment('Slider Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('plumtree_complexgrd_slider'),
                $setup->getIdxName(
                    $installer->getTable('plumtree_complexgrd_slider'),
                    ['name','description','config_serialized'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name','description','config_serialized'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        if (!$installer->tableExists('plumtree_complexgrd_banner_slider')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('plumtree_complexgrd_banner_slider'));
            $table->addColumn(
                'slider_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false,
                    'primary'   => true,
                ],
                'Slider ID'
            )
            ->addColumn(
                'banner_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false,
                    'primary'   => true,
                ],
                'Banner ID'
            )
            ->addColumn(
                'position',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false,
                    'default' => '0'
                ],
                'Position'
            )
            ->addIndex(
                $installer->getIdxName('plumtree_complexgrd_banner_slider', ['slider_id']),
                ['slider_id']
            )
            ->addIndex(
                $installer->getIdxName('plumtree_complexgrd_banner_slider', ['banner_id']),
                ['banner_id']
            )
            ->addForeignKey(
                $installer->getFkName(
                    'plumtree_complexgrd_banner_slider',
                    'slider_id',
                    'plumtree_complexgrd_slider',
                    'slider_id'
                ),
                'slider_id',
                $installer->getTable('plumtree_complexgrd_slider'),
                'slider_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName(
                    'plumtree_complexgrd_banner_slider',
                    'banner_id',
                    'plumtree_complexgrd_banner',
                    'banner_id'
                ),
                'banner_id',
                $installer->getTable('plumtree_complexgrd_banner'),
                'banner_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE,
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )
            ->addIndex(
                $installer->getIdxName(
                    'plumtree_complexgrd_banner_slider',
                    [
                        'slider_id',
                        'banner_id'
                    ],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                [
                    'slider_id',
                    'banner_id'
                ],
                [
                    'type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ]
            )
            ->setComment('Slider To Banner Link Table');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
