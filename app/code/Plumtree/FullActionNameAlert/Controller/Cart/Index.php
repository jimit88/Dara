<?php

namespace Plumtree\FullActionNameAlert\Controller\Cart;

class Index extends \Magento\Checkout\Controller\Cart\Index 
{

//$resultPage->getConfig()->getTitle()->set(__('Shopping Bag'));

public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Shopping Bag'));
        return $resultPage;
    }

}