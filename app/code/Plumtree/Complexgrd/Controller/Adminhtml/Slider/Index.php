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

class Index extends \Magento\Backend\App\Action
{
    /**
     * Page result factory
     * 
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Page factory
     * 
     * @var \Magento\Backend\Model\View\Result\Page
     */
    protected $resultPage;

    /**
     * constructor
     * 
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
		/////////
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
		$productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		
		$tbt_product = $resource->getTableName('catalog_product_entity');
		$sql_product = "Select * FROM " . $tbt_product;
		$result_product = $connection->fetchAll($sql_product);
		
		
		$tbt_com_product = $resource->getTableName('plumtree_complexgrd_slider');
		$sql_com_product = "Select * FROM " . $tbt_com_product;
		$result_com_product = $connection->fetchAll($sql_com_product);
		
		
		//$connection->query("SET FOREIGN_KEY_CHECKS = 0");
		//$connection->query('TRUNCATE TABLE '.$tbt_com_product);
		/*	echo 'hiii<br>';
		echo count($result_product).' ***** 	'. count($result_com_product);
		die;*/
		
		$proId = array();
		$proId_exist = array();
		if(count($result_product) != count($result_com_product)){
			foreach($result_product as $_result_product){				
				$proId[] = $_result_product['sku'];		 // sku	
			}
			foreach($result_com_product as $_result_product){				
				$proId_exist[] = $_result_product['name'];		//sku	
			}
		
		$pro_insert = array_diff($proId,$proId_exist);
		$pro_del = array_diff($proId_exist,$proId);
		/*echo '<pre>';
		var_dump($pro_insert);
		echo '<br>';
		var_dump($pro_del);*/
		if (!empty($pro_del)) {
		foreach($pro_del as $_pro_del){
			$_pro_op_t_del = "DELETE FROM ".$tbt_com_product." WHERE  name = '".$_pro_del."'";
			$connection->query($_pro_op_t_del);
		}
		}

		
			foreach($result_product as $_result_product){
				if (in_array($_result_product['sku'], $pro_insert)){

	
				$productObj = $productRepository->get($_result_product['sku']);
				
				$pro_name = $productObj->getName();
				$_pro_name = str_replace("'","\'",$pro_name);
				
				$insrt_sku = str_replace("'","\'",$_result_product['sku']);
		//INSERT INTO `jh_plumtree_complexgrd_slider` (`slider_id`, `name`, `description`, `status`, `config_serialized`, `created_at`, `updated_at`) VALUES (NULL, 'customers-own-mate\'ria\'l', NULL, NULL, NULL, NULL, NULL);
				$sql_add_product = "INSERT INTO " . $tbt_com_product . "  (`slider_id`, `name`, `description`, `status`, `config_serialized`, `created_at`, `updated_at`) VALUES ('".$_result_product['entity_id']."', '".$insrt_sku."', '".$_pro_name."', '2', '".$insrt_sku."', NULL, NULL);";
				$connection->query($sql_add_product);
				}
			}
		}
		
		
		/////// product opotion 
		
		$tbt_fme_banners = $resource->getTableName('fme_banners');
		$sql_fme_banners = "Select * FROM " . $tbt_fme_banners;
		$result_fme_banners = $connection->fetchAll($sql_fme_banners);
		
		
		$tbt_com_product_opt = $resource->getTableName('plumtree_complexgrd_banner');
		$sql_com_product_opt = "Select * FROM " . $tbt_com_product_opt;
		$result_com_product_opt = $connection->fetchAll($sql_com_product_opt);
		
		
		$bannerId = array();
		$bannerId_exist = array();
		 
		if(count($result_fme_banners) != count($result_com_product_opt)){
			foreach($result_fme_banners as $_result_fme_banners){				
				$bannerId[] = $_result_fme_banners['banners_id'];		 // banners_id	
			}
			foreach($result_com_product_opt as $_result_fme_banners){				
				$bannerId_exist[] = $_result_fme_banners['banner_id'];		//banners_id	
			}
			
		$pro_opt_insert = array_diff($bannerId,$bannerId_exist);

		/*$pro_opt_del = array_diff($bannerId_exist,$bannerId);
		foreach($pro_opt_del as $_pro_opt_del){
			$_pro_opt_del = "DELETE FROM ".$tbt_com_product_opt." WHERE  banner_id = ".$_pro_opt_del."";
			$connection->query($_pro_opt_del);
		}*/
		//echo '<pre>';
		/*var_dump($pro_opt_insert);
		DELETE FROM `jh_fme_banners` WHERE `jh_fme_banners`.`banners_id` = 1"
		die;*/
		
			foreach($result_fme_banners as $_result_fme_banners){
				if (in_array($_result_fme_banners['banners_id'], $pro_opt_insert)){
		//var_dump($_result_fme_banners);
		//die;
		$insrt_title = str_replace("'","\'",$_result_fme_banners['title']);
		$insrt_link = str_replace("'","\'",$_result_fme_banners['link']);
		$insrt_target = str_replace("'","\'",$_result_fme_banners['target']);
		
				$sql_add_product = "INSERT INTO  " . $tbt_com_product_opt . "   (`banner_id`, `name`, `upload_file`, `url`, `type`, `status`, `created_at`, `updated_at`) VALUES ('".$_result_fme_banners['banners_id']."', '".$insrt_title."', '".$insrt_link."', '".$insrt_target."', '".$_result_fme_banners['attribute_id']."', NULL, NULL, NULL);";
				$connection->query($sql_add_product);
				
//INSERT INTO `jh_plumtree_complexgrd_banner` (`banner_id`, `name`, `upload_file`, `url`, `type`, `status`, `created_at`, `updated_at`) VALUES ('2449', 'rr', 'dd', 'ff', '2', NULL, NULL, NULL);
				}
			}
		}
		
		$sql_update_status = "UPDATE ".$tbt_com_product_opt." LEFT JOIN ".$tbt_fme_banners." ON ".$tbt_com_product_opt.".banner_id = ".$tbt_fme_banners.".banners_id  SET  ".$tbt_com_product_opt.".status = ".$tbt_fme_banners.".status ,".$tbt_com_product_opt.".url = ".$tbt_fme_banners.".target ";
		$connection->query($sql_update_status);
		
		
		
		////////
        $this->setPageData();
        return $this->getResultPage();
    }
    /**
     * instantiate result page object
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page
     */
    public function getResultPage()
    {
        if (is_null($this->resultPage)) {
            $this->resultPage = $this->resultPageFactory->create();
        }
        return $this->resultPage;
    }
    /**
     * set page data
     *
     * @return $this
     */
    protected function setPageData()
    {
        $resultPage = $this->getResultPage();
        //$resultPage->setActiveMenu('Plumtree_Complexgrd::slider');
        $resultPage->getConfig()->getTitle()->prepend((__('Products')));
        return $this;
    }
}