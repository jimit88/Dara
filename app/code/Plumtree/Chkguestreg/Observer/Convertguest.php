<?php
namespace Plumtree\Chkguestreg\Observer;

class Convertguest implements \Magento\Framework\Event\ObserverInterface
{
  
 	protected $_logger;
    protected $_orderFactory; 
    protected $accountManagement;
    protected $_objectManager;
    protected $orderCustomerService;
	
	protected $customerRegistry;
	protected $customerRepository;
	
	protected $encryptor;
    protected $customerAccountManagement;
    protected $_messageManager;
    protected $responseFactory;
    protected $url;

 
    public function __construct(\Psr\Log\LoggerInterface $loggerInterface,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Customer\Api\AccountManagementInterface $accountManagement,
        \Magento\Sales\Api\OrderCustomerManagementInterface $orderCustomerService,
		\Magento\Customer\Model\CustomerRegistry $customerRegistry,
    	\Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\ObjectManager\ObjectManager $objectManager,
		\Magento\Framework\Encryption\EncryptorInterface $encryptor,
        \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement,
        \Magento\Framework\Message\ManagerInterface $messageManager,
		\Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url) {
 
        $this->_logger = $loggerInterface;
        $this->_orderFactory = $orderFactory;
        $this->accountManagement = $accountManagement;
        $this->orderCustomerService = $orderCustomerService;
		$this->_customerRegistry   = $customerRegistry;
    	$this->_CustomerRepositoryInterface = $customerRepository;
        $this->_objectManager = $objectManager;
 		
		$this->encryptor = $encryptor;
        $this->customerAccountManagement = $customerAccountManagement;
        $this->_messageManager = $messageManager;
        $this->responseFactory = $responseFactory;
        $this->url = $url;
 
    }
 
    public function execute(\Magento\Framework\Event\Observer $observer ) {/* 
 
		
        $orderIds = $observer->getEvent()->getOrderIds();
        $orderdata =array();
        if (count($orderIds)) {
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

			$customerSession = $objectManager->get('Magento\Customer\Model\Session');

			if($customerSession->isLoggedIn()) {

			}else{
            $orderId = $orderIds[0];
            $order = $this->_orderFactory->create()->load($orderId);
					
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			$tbt_customer_entity = $resource->getTableName('customer_entity');
			$sql_customer_entity = "Select entity_id FROM " . $tbt_customer_entity." WHERE `email` = '".$order->getCustomerEmail()."'";
			
			$result = $connection->fetchAll($sql_customer_entity);
			
			if(empty($result)){
				
            /*Convert guest to customer* /
            if ($order->getEntityId() && $this->accountManagement->isEmailAvailable($order->getEmailAddress())) {
				
				

				
	               $this->orderCustomerService->create($orderId);
				   
				   $chk_1 = '';
					if(isset($_COOKIE['chk_1'])){
					$chk_1 = $_COOKIE['chk_1'];
					}
					
					$decode = base64_decode($chk_1);
				   
				   	$customer = $observer->getEvent()->getCustomer();
				}
			}
            
            /*END* / 
			}
        }
		
	*/}
 
}