<?php

namespace Plumtree\Categoryattrv2\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


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



        if (version_compare($context->getVersion(), '3.0.1' , '<')) {
 

            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
 
			$eavSetup->addAttribute(
				\Magento\Catalog\Model\Category::ENTITY,
				'new_arrival',
				[
					'type' => 'int',
					'label' => 'New Arrival',
					'input' => 'boolean',
					'source'   => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
					'visible'  => true,
					'default'  => '',
					'required' => false,
					'sort_order' => 4,					
					'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,					
					'group' => 'Custom',
					'is_used_in_grid' => true,
					'is_visible_in_grid' => true,
					'is_filterable_in_grid' => true,
					'visible_on_front' => true,
                    'used_in_product_listing' => true,
					
				]);
        } 
        $setup->endSetup();
    }
}