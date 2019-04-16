<?php

namespace Plumtree\Upgradeattribute\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

 
class UpgradeData implements UpgradeDataInterface
{
    private $eavSetupFactory;
 
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
 
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        /** @var EavSetup $eavSetup */
        $eavSetup= $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->updateAttribute(
            'textarea',
            'category_content1',
            [
               'is_wysiwyg_enabled' => true
            ]
        );
		$eavSetup->updateAttribute(
            'textarea',
            'category_content2',
            [
               'is_wysiwyg_enabled' => true
            ]
        );
		$eavSetup->updateAttribute(
            'textarea',
            'category_content3',
            [
               'is_wysiwyg_enabled' => true
            ]
        );
         $setup->endSetup();
    }


}