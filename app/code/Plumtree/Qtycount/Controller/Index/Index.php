<?php


namespace Plumtree\Qtycount\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
			
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$_qty = 0;	
		/*
		$cart = $objectManager->get('\Magento\Checkout\Model\Cart');
		$helper = $this->helper('\Magento\Checkout\Helper\Cart');
		echo '<br>*'.$helper->getSummaryCount();
		
		echo '<br>**'.$totalQuantity = $cart->getQuote()->getItemsQty();
		if($totalQuantity){
			
		$result = explode('.',$totalQuantity);
		$_qty = $result[0];
		}else{
		$_qty = 0;	
		}*/
		$customerSession = $objectManager->create('Magento\Checkout\Model\Session');
		$quote_id_1 = $customerSession->getData('quote_id_1');
		
		
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$tbl_quote = $resource->getTableName('quote');
		
		$sql_qry_getmsg = "SELECT items_qty FROM ".$tbl_quote." WHERE entity_id ='".$quote_id_1."' ";
		$get_qty = $connection->fetchAll($sql_qry_getmsg);
		
		//echo '<br>___'.$get_qty['0']['items_qty'];
		if($get_qty){
		$result = explode('.',$get_qty['0']['items_qty']);
		$_qty = $result[0];
		}
		
		
            return $this->jsonResponse($_qty);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return $this->jsonResponse($e->getMessage());
        }
    }

    /**
     * Create json response
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}
