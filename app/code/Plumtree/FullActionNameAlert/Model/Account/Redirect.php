<?php
namespace Plumtree\FullActionNameAlert\Model\Account;

use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\Redirect as ResultRedirect;
use Magento\Framework\Controller\Result\Forward as ResultForward;
use Magento\Framework\Url\DecoderInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Stdlib\CookieManagerInterface;

 
class Redirect  extends \Magento\Customer\Model\Account\Redirect
{
      const LOGIN_REDIRECT_URL = 'login_redirect';

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var DecoderInterface
     */
    protected $urlDecoder;

    /**
     * @var CustomerUrl
     */
    protected $customerUrl;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var CookieManagerInterface
     */
    protected $cookieManager;

    /**
     * @param RequestInterface $request
     * @param Session $customerSession
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $url
     * @param DecoderInterface $urlDecoder
     * @param CustomerUrl $customerUrl
     * @param ResultFactory $resultFactory
     */
    public function __construct(
        RequestInterface $request,
        Session $customerSession,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        UrlInterface $url,
        DecoderInterface $urlDecoder,
        CustomerUrl $customerUrl,
        ResultFactory $resultFactory
    ) {
        $this->request = $request;
        $this->session = $customerSession;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->url = $url;
        $this->urlDecoder = $urlDecoder;
        $this->customerUrl = $customerUrl;
        $this->resultFactory = $resultFactory;
    }

    /**
     * Retrieve redirect
     *
     * @return ResultRedirect|ResultForward
     */
    public function getRedirect()
    {
        $this->updateLastCustomerId();
        $this->prepareRedirectUrl();

        /** @var ResultRedirect|ResultForward $result */
        if ($this->session->getBeforeRequestParams()) {
            $result = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
            $result->setParams($this->session->getBeforeRequestParams())
                ->setModule($this->session->getBeforeModuleName())
                ->setController($this->session->getBeforeControllerName())
                ->forward($this->session->getBeforeAction());
        } else {
            $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $result->setUrl($this->session->getBeforeAuthUrl(true));
        }
        return $result;
    }
   
protected function aroundrocessLoggedCustomer()
    {
	
	$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/login-redirect-plugin2.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);

            $logger->info("Info");
	

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
    $storeManager->getStore()->getBaseUrl();


        // Set default redirect URL for logged in customer
		//$this->applyRedirect($this->customerUrl->getAccountUrl());
        $this->applyRedirect($storeManager->getStore()->getBaseUrl());

        if (!$this->scopeConfig->isSetFlag(
            CustomerUrl::XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD,
            ScopeInterface::SCOPE_STORE
        )
        ) {
            $referer = $this->request->getParam(CustomerUrl::REFERER_QUERY_PARAM_NAME);
            if ($referer) {
                $referer = $this->urlDecoder->decode($referer);
                if ($this->url->isOwnOriginUrl()) {
                    $this->applyRedirect($referer);
                }
            }
        } elseif ($this->session->getAfterAuthUrl()) {
            $this->applyRedirect($this->session->getAfterAuthUrl(true));
        }
    }
   	 
	protected function aroundProcessLoggedCustomer()
    {
	
	$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/login-redirect-model.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);

            $logger->info("Info");
	

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
    $storeManager->getStore()->getBaseUrl();


        // Set default redirect URL for logged in customer
		//$this->applyRedirect($this->customerUrl->getAccountUrl());
        $this->applyRedirect($storeManager->getStore()->getBaseUrl());

        if (!$this->scopeConfig->isSetFlag(
            CustomerUrl::XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD,
            ScopeInterface::SCOPE_STORE
        )
        ) {
            $referer = $this->request->getParam(CustomerUrl::REFERER_QUERY_PARAM_NAME);
            if ($referer) {
                $referer = $this->urlDecoder->decode($referer);
                if ($this->url->isOwnOriginUrl()) {
                    $this->applyRedirect($referer);
                }
            }
        } elseif ($this->session->getAfterAuthUrl()) {
            $this->applyRedirect($this->session->getAfterAuthUrl(true));
        }
    }
	
	protected function processLoggedCustomer()
    {
	
	$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/login-redirect-model.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);

            $logger->info("Info");
	

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
    $storeManager->getStore()->getBaseUrl();


        // Set default redirect URL for logged in customer
		//$this->applyRedirect($this->customerUrl->getAccountUrl());
        $this->applyRedirect($storeManager->getStore()->getBaseUrl());

        if (!$this->scopeConfig->isSetFlag(
            CustomerUrl::XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD,
            ScopeInterface::SCOPE_STORE
        )
        ) {
            $referer = $this->request->getParam(CustomerUrl::REFERER_QUERY_PARAM_NAME);
            if ($referer) {
                $referer = $this->urlDecoder->decode($referer);
                if ($this->url->isOwnOriginUrl()) {
                    $this->applyRedirect($referer);
                }
            }
        } elseif ($this->session->getAfterAuthUrl()) {
            $this->applyRedirect($this->session->getAfterAuthUrl(true));
        }
    }

	private function applyRedirect($url)
    {
        $this->session->setBeforeAuthUrl($url);
    }
 
    }