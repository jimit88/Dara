<?php
namespace Magecomp\Matrixrate\Block\Adminhtml\System\Config\Form\Field;

class Export extends \Magento\Framework\Data\Form\Element\AbstractElement
{
    protected $_backendUrl;

    public function __construct(
        \Magento\Framework\Data\Form\Element\Factory $factoryElement,
        \Magento\Framework\Data\Form\Element\CollectionFactory $factoryCollection,
        \Magento\Framework\Escaper $escaper,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        array $data = []
    ) {
        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
        $this->_backendUrl = $backendUrl;
    }

    public function getElementHtml()
    {
        $buttonBlock = $this->getForm()->getParent()->getLayout()->createBlock('Magento\Backend\Block\Widget\Button');

        $params = ['website' => $buttonBlock->getRequest()->getParam('website')];

        $url = $this->_backendUrl->getUrl("matrixrate/export/exportrates", $params);
        $data = [
            'label' 	=> __('Export CSV'),
            'onclick'	=> "setLocation('".$url."' )",
            'class'		=> '',
        ];

        $html = $buttonBlock->setData($data)->toHtml();
        return $html;
    }
}