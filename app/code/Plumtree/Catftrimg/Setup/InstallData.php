<?php
/* app/code/Plumtree/Catftrimg/Setup/InstallData.php */
 
namespace Plumtree\Catftrimg\Setup;
 
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
 
/**
 * @codeCoverageIgnore
 */ 
class InstallData implements InstallDataInterface {

	/**
	 * @var \Magento\Eav\Setup\EavSetupFactory
	 */
	private $eavSetupFactory;

	/**
	 * Constructor
	 * 
	 * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
	 */
	public function __construct(EavSetupFactory $eavSetupFactory)
	{
		$this->eavSetupFactory = $eavSetupFactory;
	}

	/**
	 * {@inheritdoc}
	 */
	public function install(
		ModuleDataSetupInterface $setup,
		ModuleContextInterface $context
	)
	{
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

		$eavSetup->addAttribute(
		    \Magento\Catalog\Model\Category::ENTITY,
		    'category_content1',
		    [
		        'type' => 'text',
		        'label' => 'Content1',
		        'input' => 'textarea',
		        'sort_order' => 100,
		        'source' => '',
		        'global' => 1,
		        'visible' => true,
		        'required' => false,
		        'user_defined' => false,
		        'default' => null,
		        'group' => 'General Information',
		        'backend' => ''
		    ]
		);
		$eavSetup->addAttribute(
		    \Magento\Catalog\Model\Category::ENTITY,
		    'category_content2',
		    [
		        'type' => 'text',
		        'label' => 'Content2',
		        'input' => 'textarea',
		        'sort_order' => 100,
		        'source' => '',
		        'global' => 1,
		        'visible' => true,
		        'required' => false,
		        'user_defined' => false,
		        'default' => null,
		        'group' => 'General Information',
		        'backend' => ''
		    ]
		);
		$eavSetup->addAttribute(
		    \Magento\Catalog\Model\Category::ENTITY,
		    'category_featured',
		    [
		        'type' => 'text',
		        'label' => 'Featured Content',
		        'input' => 'textarea',
		        'sort_order' => 100,
		        'source' => '',
		        'global' => 1,
		        'visible' => true,
		        'required' => false,
		        'user_defined' => false,
		        'default' => null,
		        'group' => 'General Information',
		        'backend' => ''
		    ]
		);
		$eavSetup->addAttribute(
		    \Magento\Catalog\Model\Category::ENTITY,
		    'category_content3',
		    [
		        'type' => 'text',
		        'label' => 'Content3',
		        'input' => 'textarea',
		        'sort_order' => 100,
		        'source' => '',
		        'global' => 1,
		        'visible' => true,
		        'required' => false,
		        'user_defined' => false,
		        'default' => null,
		        'group' => 'General Information',
		        'backend' => ''
		    ]
		);
	}
}