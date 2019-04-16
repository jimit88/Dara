<?php

namespace Plumtree\Categoryattrv2\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
 
/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
 
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
 
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        if (version_compare($context->getVersion(), '1.0.0') < 0){





		$eavSetup -> removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'contentv1');

		
			$eavSetup -> addAttribute(\Magento\Catalog\Model\Category :: ENTITY, 'contentv1', [
                        'type' => 'text',
                        'label' => 'contentv1',
                        'input' => 'textarea',
						'required' => false,
                        'sort_order' => 110,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                        'wysiwyg_enabled' => true,
                        'is_html_allowed_on_front' => false,
                        'group' => 'General Information',
						"default" => "",
						"class"    => "",
						"note"       => ""
			]
			);
					
	
	

		$eavSetup -> removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'contentv2');

		
			$eavSetup -> addAttribute(\Magento\Catalog\Model\Category :: ENTITY, 'contentv2', [
                        'type' => 'text',
                        'label' => 'contentv2',
                        'input' => 'textarea',
						'required' => false,
                        'sort_order' => 120,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                        'wysiwyg_enabled' => true,
                        'is_html_allowed_on_front' => false,
                        'group' => 'General Information',
						"default" => "",
						"class"    => "",
						"note"       => ""
			]
			);
					
	
	

		$eavSetup -> removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'featuredimgv2');

		
			$eavSetup -> addAttribute(\Magento\Catalog\Model\Category :: ENTITY, 'featuredimgv2', [
                        'type' => 'varchar',
                        'label' => 'featuredimgv2',
                        'input' => 'image',
                        'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
						'required' => false,
                        'sort_order' => 130,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                        'group' => 'General Information',
						"default" => "",
						"class"    => "",
						"note"       => ""
			]
			);
					
	
	

		$eavSetup -> removeAttribute(\Magento\Catalog\Model\Category::ENTITY, 'mylayout');

		
			$eavSetup -> addAttribute(\Magento\Catalog\Model\Category :: ENTITY, 'mylayout', [
                        'type' => 'int',
                        'label' => 'mylayout',
                        'input' => 'select',
                        'source' => 'Plumtree\Categoryattrv2\Model\Category\Attribute\Source\Mylayout',
						'required' => false,
                        'sort_order' => 140,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                        'group' => 'General Information',
						"default" => "",
						"class"    => "",
						"note"       => ""
			]
			);
					
	
	



		}

    }
}