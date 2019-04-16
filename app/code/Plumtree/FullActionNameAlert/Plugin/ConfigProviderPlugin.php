<?php 

namespace Plumtree\FullActionNameAlert\Plugin;


class ConfigProviderPlugin extends \Magento\Framework\Model\AbstractModel
{

    public function afterGetConfig(\Magento\Checkout\Model\DefaultConfigProvider $subject, array $result)
    {
/*
       echo '<pre>hiiiiiiiiii';
	   var_dump($result->getData());
	   die;*/
	    /*$items = $result['totalsData']['items'];

        for($i=0;$i<count($items);$i++){
        $items[$i]['sku'] = "dgd";

        }

        $result['totalsData']['items'] = $items;
        return $result;*/
		
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tableName = $resource->getTableName('gift_message'); 

	    $items = $result['totalsData']['items'];

        for($i=0;$i<count($items);$i++){

            $quoteId = $items[$i]['item_id'];
            $quote = $objectManager->create('\Magento\Quote\Model\Quote\Item')->load($quoteId);
			
			 if ($quoteId) {            
					$itemOptionCount = count($result['totalsData']['items']);
					/*$quoteItems = $this->quoteItemRepository->getList($quoteId);
					$isbnOptions = array();
					foreach ($quoteItems as $index => $quoteItem) {
						$quoteItemId = $quoteItem['item_id'];
						$isbnOptions[$quoteItemId] = $quoteItem['isbn'];               
					}*/
	

					$quoteParentId = $result['totalsData']['items'][$i]['item_id'];
					$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
					$productId = $result['quoteItemData'][$i]['product']['entity_id'];
					$productObj = $objectManager->create('\Magento\Catalog\Model\Product')->load($productId);
	
					$productFlavours = $productObj->getResource()->getAttribute('sku')->getFrontend()->getValue($productObj);         
					if($productFlavours == 'No' || $productFlavours == 'NA'){
					   $productFlavours = '';
					}
					if($quote->getData('gift_message_id')){
				
					$sql = "SELECT * FROM ".$tableName." WHERE gift_message_id=".$quote->getData('gift_message_id')." LIMIT 1;";				
					$gift_result = $connection->fetchAll($sql);
					
					$result['quoteItemData'][$i]['flavor'] = $productFlavours;
					$result['quoteItemData'][$i]['recipient'] = $gift_result['0']['recipient'];
					$result['quoteItemData'][$i]['sender'] = $gift_result['0']['sender'];
					$result['quoteItemData'][$i]['message'] = $gift_result['0']['message'];
					}
					json_encode($result);
			}

			/*if($quote->getData('gift_message_id')){
				
				$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/quote--3.log');
				$logger = new \Zend\Log\Logger();
				$logger->addWriter($writer);	
				$logger->info($quote->getData());
				
				$sql = "SELECT * FROM ".$tableName." WHERE gift_message_id=".$quote->getData('gift_message_id')." LIMIT 1";				
				$gift_result = $connection->fetchAll($sql);
				
				
				
				$items[$i]['gift_smg_to'] =  $gift_result['0']['recipient'];
				$items[$i]['gift_smg_frm'] = $gift_result['0']['sender'];
				$items[$i]['gift_smg'] = $gift_result['0']['message'];
			
			}*/
			
            /*$productId = $quote->getProductId();
            $product = $objectManager->create('\Magento\Catalog\Model\Product')->load($productId);
            $productFlavours = $product->getResource()->getAttribute('color')->getFrontend()->getValue($product);         
            if($productFlavours == 'No' || $productFlavours == 'NA'){
                $productFlavours = '';
            }
            $items[$i]['color'] = $productFlavours;*/
			
			
			
			
        }
        $result['totalsData']['items'] = $items;
        return $result;
    }
	

}