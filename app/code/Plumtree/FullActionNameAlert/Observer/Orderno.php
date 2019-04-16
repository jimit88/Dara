<?php 

namespace Plumtree\FullActionNameAlert\Observer;

class Orderno implements \Magento\Framework\Event\ObserverInterface
{ 
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
	
	$directory = $objectManager->get('\Magento\Framework\Filesystem\DirectoryList');
	$csvexportpath = $directory->getRoot().'/'.$objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('datasync/export_inventory/sync_export_sales_order_filepath');


	$orderNo = $observer->getEvent()->getOrder()->getIncrementId();
	if (file_exists($csvexportpath.'/'.$orderNo.".txt")) {
		$detailsFile = fopen($csvexportpath.'/'.$orderNo.".txt","w") or die("error"); 
	}
	return;
    }
}