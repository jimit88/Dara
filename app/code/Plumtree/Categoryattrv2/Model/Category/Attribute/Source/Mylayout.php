<?php

namespace Plumtree\Categoryattrv2\Model\Category\Attribute\Source;
 
use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;
 
/**
 * Custom Attribute Renderer
 *
 * @author      Webkul Core Team <support@webkul.com>
 */
class Mylayout extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var OptionFactory
     */
    protected $optionFactory;
 
    /**
     * @param OptionFactory $optionFactory
     */
    /*public function __construct(OptionFactory $optionFactory)
    {
        $this->optionFactory = $optionFactory;  
        //you can use this if you want to prepare options dynamically  
    }*/
 
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        /* your Attribute options list*/
        $this->_options=[ ['label'=>'3 Columns', 'value'=>'0'],
                          ['label'=>'2 Columns', 'value'=>'1'],
                          ['label'=>'3 Column Editorial', 'value'=>'2'],
                         ];
        return $this->_options;
    }
	
	/*public function toOptionArray()
    {
        return [1 => 'test'];
    }*/
	
	/*public function getAllOptions()
    {
            $this->_options = [
                                ['label' => __('Label1'), 'value' => 'value1'],
                                ['label' => __('Label2'), 'value' => 'value2'],
                                ['label' => __('Label3'), 'value' => 'value3'],
                                ['label' => __('Label4'), 'value' => 'value4']

                                ];

        return $this->_options;
    }*/
 
    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
 
    /**
     * Retrieve flat column definition
     *
     * @return array
     */
    public function getFlatColumns()
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        return [
            $attributeCode => [
                'unsigned' => false,
                'default' => null,
                'extra' => null,
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'comment' => 'Custom Attribute Options  ' . $attributeCode . ' column',
            ],
        ];
    }
}