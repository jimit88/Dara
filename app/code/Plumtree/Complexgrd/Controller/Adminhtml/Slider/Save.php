<?php
/**
 * Plumtree_Complexgrd extension
 *                     NOTICE OF LICENSE
 * 
 *                     This source file is subject to the Plumtree License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://www.plumtree.com/LICENSE.txt
 * 
 *                     @category  Plumtree
 *                     @package   Plumtree_Complexgrd
 *                     @copyright Copyright (c) 2016
 *                     @license   https://www.plumtree.com/LICENSE.txt
 */
namespace Plumtree\Complexgrd\Controller\Adminhtml\Slider;

class Save extends \Plumtree\Complexgrd\Controller\Adminhtml\Slider
{

    /**
     * JS helper
     * 
     * @var \Magento\Backend\Helper\Js
     */
    protected $jsHelper;

    /**
     * constructor
     * 
     * @param \Magento\Backend\Helper\Js $jsHelper
     * @param \Plumtree\Complexgrd\Model\SliderFactory $sliderFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\Helper\Js $jsHelper,
        \Plumtree\Complexgrd\Model\SliderFactory $sliderFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->jsHelper       = $jsHelper;
        parent::__construct($sliderFactory, $registry, $context);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
	
	$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/customoptioncreate.log');
	$logger = new \Zend\Log\Logger();
	$logger->addWriter($writer);
	$logger->info("start ========================== 0.1 ");
	// delete custom options for product
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	$productObject = $objectManager->get('Magento\Catalog\Model\Product');
	$pro_data = $this->getRequest()->getPost('slider');
	//echo '<pre>';
	//var_dump($this->getRequest()->getPost());
	
	
	$_delsku = array($pro_data['name']);
	if($pro_data){
	foreach($_delsku as $_del_sku){		
		
		$prod_uct = $productObject->loadByAttribute('sku', $_del_sku);
		$productId = $prod_uct->getEntityId();
		$product = $objectManager->create('\Magento\Catalog\Model\Product')->load($productId);
		//$productassign = $objectManager->create('\Magento\Catalog\Model\Product')->load($productId);
		
		if($product->getOptions() != ''){
			   foreach ($product->getOptions() as $opt){
						   $opt->delete();
					   }
					   $logger->info("saveeeeee ====== 0.2 ");
			   
			   $product->setHasOptions(0);
			   $logger->info("saveeeeee ====== 0.2.2 ");
			   //$product->save();
			   $logger->info("saveeeeee ====== 0.2.3 ");
		}
	}
	}
	$logger->info("saveeeeee ====== 0.2.0 ");
	// create custom option 
	
	$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
	$connection = $resource->getConnection();
	
	$tbt_product = $resource->getTableName('fme_banners');
	
	$data = array();
	$banners = $this->getRequest()->getPost('banners', -1);
	$c_opt_ids = $this->jsHelper->decodeGridSerializedInput($banners); 
	//var_dump($c_opt_ids);
	foreach($c_opt_ids as $k => $v){
		//echo '<br>'.$k.' ***** '.$v;
		//print_r($k);
		
		$sql_product = "Select * FROM " . $tbt_product." WHERE banners_id='".$k."'";
		$result_product = $connection->fetchAll($sql_product);
		if(isset($result_product['0']['target'])){
			$tlt = $result_product['0']['target'];
			$exploded_tlt = explode('-', $tlt);
			$_tlt = end($exploded_tlt);
			$data[] = array($pro_data['name'],'00',$_tlt,$v['position'],$result_product['0']['target'],$result_product['0']['title'],$result_product['0']['link'],'00',$result_product['0']['status']);	
$logger->info("saveeeeee ====== 0.3 ");			
		}
				
	}
	
	//echo '<pre> ************** 		data	*************************';
	//	print_r($data);
		

$hash = array();
$array_out = array();
foreach($data as $i_tem) {
   	$hash_key = $i_tem[2]; //.'|'.$i_tem[4];
   
	/*$hash_key = preg_replace('/\s* /', '', $hash_key);
	$hash_key = str_replace("-","",$hash_key);
	$hash_key = strtolower($hash_key);*/

    if(!array_key_exists($hash_key, $hash)) {
        $hash[$hash_key] = sizeof($array_out);
        array_push($array_out, array(
            'id' => $i_tem[2],
            'title' => $i_tem[4],
            'count' => 0,
        ));
		$logger->info("saveeeeee ====== 0.4 ");
    }
	$array_out[$hash[$hash_key]]['count'] += 1;
}

/*
echo '<pre> ************** 		array_out	*************************';
print_r($array_out);
echo '</pre>';*/
foreach($array_out as $arrayout){

	$i=1;
	if( $i<=$arrayout['count'] && $arrayout['id']  != ''){
		unset($values);
		$values = array();
		foreach($data as $item) {
			if($arrayout['id'] == $item[2] ){	
				$logger->info("saveeeeee ====== 0.5 ");
				///////// option add start

				$sku = $item['0']; // 'HW139620';
				

				$prod_uct = $productObject->loadByAttribute('sku', $sku);
				
				
				$productId = $prod_uct->getEntityId();
				$product = $objectManager->create('\Magento\Catalog\Model\Product')->load($productId);
				
								
				$values[] = array(
						'title'=>$item['5'],
						'price'=>'0'.$item['3'],
						'price_type'=>"fixed",
						'sku'=>$item['6'],
						'sort_order'=>0,
				);
				
				
				
				if($arrayout['count']==$i){
					
				unset($options);
				$options = array();
					//echo '<br>'.$item['2'];
					if (strpos($item['2'], 'abric') !== false) {
						$options = array(
				array(
						'sort_order'    => 0,
						'title'         => $item['2'],
						'type'          => "radio",
						'is_require'    => 0,
						'values'        => $values
				));
						}else if (strpos($item['2'], 'inish') !== false) {
						$options = array(
				array(
						'sort_order'    => 55,
						'title'         => $item['2'],
						'type'          => "radio",
						'is_require'    => 0,
						'values'        => $values
				));
						}else if (strpos($item['2'], 'head') !== false) {
						$options = array(
				array(
						'sort_order'    => 77,
						'title'         => $item['2'],
						'type'          => "radio",
						'is_require'    => 0,
						'values'        => $values
				));
						}else{
				$options = array(
				array(
						'sort_order'    => 90,
						'title'         => $item['2'],
						'type'          => "radio",
						'is_require'    => 0,
						'values'        => $values
				));
						}
				
				foreach ($options as $arrayOption) {
					 $product->setHasOptions(1);
					 $product->setCanSaveCustomOptions(true);
					 $product->getResource()->save($product);
					 
					 $logger->info("productId ======  ".$productId);
					 $logger->info("getStoreId ====== ".$product->getStoreId());
            
						$option = $objectManager->create('\Magento\Catalog\Model\Product\Option')
								->setProductId($product->getData('row_id'))
								->setStoreId($product->getStoreId())
								->addData($arrayOption);
						$logger->info("option ======  ".json_encode($option->getData()));
						
						$option->save();
						$logger->info("saveeeeee ====== 1 ");
						$product->addOption($option);
						$logger->info("saveeeeee ====== 2 ");
						$product->save();
						$logger->info("saveeeeee ====== 3 ");
				
				}
				
				unset($values);
				unset($options);
				}
				$i++;
				
				///////// option add end
			}
		
		} // data end
	}



}


//$productassign->save();

$cacheManager = $objectManager->get('\Magento\Framework\App\CacheInterface');
$cacheManager->clean('catalog_product_' . $productId);

//die;

	//////////////
	
	

        $data = $this->getRequest()->getPost('slider');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $slider = $this->initSlider();
            $slider->setData($data);
            $banners = $this->getRequest()->getPost('banners', -1);
            if ($banners != -1) {
                $slider->setBannersData($this->jsHelper->decodeGridSerializedInput($banners));
            }
            $this->_eventManager->dispatch(
                'plumtree_complexgrd_slider_prepare_save',
                [
                    'slider' => $slider,
                    'request' => $this->getRequest()
                ]
            );
            try {
				$logger->info("saveeeeee ====== 4 ");
                $slider->save();
                $this->messageManager->addSuccess(__('The options have been saved.'));
                $this->_session->setPlumtreeComplexgrdSliderData(false);
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        'plumtree_complexgrd/*/edit',
                        [
                            'slider_id' => $slider->getId(),
                            '_current' => true
                        ]
                    );
                    return $resultRedirect;
                }
                $resultRedirect->setPath('plumtree_complexgrd/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
				$logger->info("saveeeeee ====== 5 ");
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
				$logger->info("saveeeeee ====== 6 ");
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
				$logger->info("saveeeeee ====== 7 ");
                $this->messageManager->addException($e, __('Something went wrong while saving the Slider.'));
            }
            $this->_getSession()->setPlumtreeComplexgrdSliderData($data);
            $resultRedirect->setPath(
                'plumtree_complexgrd/*/edit',
                [
                    'slider_id' => $slider->getId(),
                    '_current' => true
                ]
            );
			$logger->info("saveeeeee ====== 8 ");
            return $resultRedirect;
        }
		$logger->info("saveeeeee ====== 9 ");
        $resultRedirect->setPath('plumtree_complexgrd/*/');
        return $resultRedirect;
    }
}
