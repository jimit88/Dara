<?php 

namespace Plumtree\FullActionNameAlert\Plugin\Model\Category\Attribute\Source;
 
class Mode 
{
    public function afterGetAllOptions(
        \Magento\Catalog\Model\Category\Attribute\Source\Mode $subject,
        $result
    ) {
        $result[] = ['value' => 'BUYERSPICKS', 'label' => 'Description as block with categories'];
		$result[] = ['value' => 'BUYERSPICKSCOLLECTION', 'label' => 'Image/Title/Description with products'];
        return $result;
    }
} 
