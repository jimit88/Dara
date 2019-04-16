<?php
namespace Plumtree\Paymentevent\Observer;

use Magento\Framework\Event\ObserverInterface; 
use Magento\Framework\Event\Observer as EventObserver; 

class Checkoutpredispatchobserver implements ObserverInterface 
{
	protected $_request;
	public function __construct(
		\Magento\Framework\App\RequestInterface $request
	)
	{
		$this->_request = $request;
	}
	
  public function execute(\Magento\Framework\Event\Observer $observer)
  {
     //$order= $observer->getData('order');
	 //$order->doSomething(); product = $observer->getEvent()->getProduct();
	  
	 		
		////////////////////
		/*$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/call-from-bold.log');
		$logger = new \Zend\Log\Logger();
		$logger->addWriter($writer);
		$logger->info('Your text message  '.date("Y-m-d H:i:s"));*/
		
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();

		$customerSession = $objectManager->get('Magento\Customer\Model\Session');
		
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
        $shippingAddress = $cart->getQuote()->getShippingAddress();
		
		
		$request = $objectManager->get('\Magento\Framework\App\Request\Http');
		if($request->getFullActionName()=="checkout_index_index"){
			
		

		if($customerSession->isLoggedIn()) {

		}else{
			
			/*$post = $this->_request->getPost();
			echo '<pre>';
			var_dump($post);
			die;*
			$logger->info('data  '. json_encode( $post ));*/
		
		$chk_1 = '';
		if(isset($_COOKIE['chk_1'])){
			$chk_1 = $_COOKIE['chk_1'];
		}
		
		$user_e = '';
		if(isset($_COOKIE['user_e'])){
			$user_e = $_COOKIE['user_e'];
		}
		
		$chk_psw_val = '';
		if(isset($_COOKIE['chk_psw_val'])){
			$chk_psw_val = $_COOKIE['chk_psw_val'];
		}
		
		/*$logger->info('chk_1  '.$chk_1);
		$logger->info('user_e  '.$user_e);
		$logger->info('chk_psw_val  '.$chk_psw_val);
		$logger->info('-------------------------------------');*/
		
		$decode = base64_decode($chk_1);
		
		$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
		$websiteId = $storeManager->getWebsite()->getWebsiteId();
		
		$CustomerModel = $objectManager->create('Magento\Customer\Model\Customer');
		$CustomerModel->setWebsiteId($websiteId);
		$CustomerModel->loadByEmail($user_e);
		
		
		/*echo '<pre>';
		var_dump($CustomerModel->getData());
		echo '</pre>';*/
		$userId = $CustomerModel->getId();
			
			//$billingAddress = $order->getBillingAddress();
			$_fname = $shippingAddress->getData('firstname');
			$_lname = $shippingAddress->getData('lastname');

				/*echo '<br>$userId==='.$userId;
				echo "<br>getCustomerIsGuest===".$order->getCustomerIsGuest(); 
				echo "<br>getCustomerGroupId===".$order->getCustomerGroupId(); */
		if($chk_psw_val==1){
		if(!$userId && $user_e && $decode){
			//$logger->info('create account and redirect on checkout page');
			 //$redirectUrl = $this->_cartHelper->getCartUrl();
             //$observer->getControllerAction()->getResponse()->setRedirect($redirectUrl);
			
			$customerFactory = $objectManager->get('\Magento\Customer\Model\CustomerFactory');
			$websiteId = $storeManager->getWebsite()->getWebsiteId();
			$store = $storeManager->getStore();
			$storeId = $store->getStoreId();
		
			$customer = $customerFactory->create();
			$customer->setWebsiteId($websiteId); 
			$customer->setEmail($user_e); 
			$customer->setFirstname($_fname); 
			$customer->setLastname($_lname);
			
			if($chk_1!="" && $_fname!=""){
				
			$customer->setPassword($decode);
			$customer->save();
			$customer->sendNewAccountEmail();
			
			////// add address to customer start
			$addresss = $objectManager->get('\Magento\Customer\Model\AddressFactory');
			$address = $addresss->create();
			$address->setCustomerId($customer->getId())
			->setFirstname($_fname)
			->setLastname($_lname)
			->setCountryId($shippingAddress->getData('country_id'))
			->setPostcode($shippingAddress->getData('postcode'))
			->setCity($shippingAddress->getData('city'))
			->setRegion($shippingAddress->getData('region'))
			->setRegionId($shippingAddress->getData('region_id'))
			->setTelephone($shippingAddress->getData('telephone'))
			->setFax($shippingAddress->getData('fax'))
			->setCompany($shippingAddress->getData('company'))
			->setStreet($shippingAddress->getData('street'))
			->setIsDefaultBilling('1')
			->setIsDefaultShipping('1')
			->setSaveInAddressBook('1');
			$address->save();
			////// add address to customer end
			
			
			$CustomerModel->setWebsiteId($websiteId);
			$CustomerModel->loadByEmail($user_e);	
			$customerSession = $objectManager->create('Magento\Customer\Model\Session');
			$customerSession->setCustomerAsLoggedIn($CustomerModel);
			
			unset($_COOKIE['chk_1']);
			setcookie('chk_1', '', time() - 3600, '/');
			
			unset($_COOKIE['user_e']);
			setcookie('user_e', '', time() - 3600, '/');
			
			unset($_COOKIE['chk_psw_val']);
			setcookie('chk_psw_val', '', time() - 3600, '/');
			
			
			
			//$redirectUrl = $storeManager->getStore()->getBaseUrl();
			$urlInterface = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\UrlInterface');
			$redirectUrl = $urlInterface->getCurrentUrl()."#payment";

			//$logger->info('redirect url: '.$redirectUrl );
			$observer->getControllerAction()->getResponse()->setRedirect($redirectUrl);
			//exit();
			}
			
			
		}
		}
		////////////////


     return $this;
		}
  
		}
  }
}