<?php
/**
 * @category  Impact
 * @package   Impact_PixelIntegration
 * @author    Impact
 * @copyright Copyright (c) Impact Tech, Inc (http://www.impact.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License
 */

namespace Impact\PixelIntegration\Block;

class InvokeEvents extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Impact\PixelIntegration\Helper\Data
     */
    protected $_helperData;

    /**
     * @var \Magento\Customer\Model\SessionFactory
     */
    protected $_customerSessionFactory;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $_request;


    /**
     * Current action name
     * 
     * @var string
     */
    protected $_currentActionName;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\SessionFactory $customerSessionFactory
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Sales\Model\OrderFactory $orderFactory,
     * @param \Magento\Catalog\Model\ProductFactory $productFactory,
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory,
     * @param \Impact\PixelIntegration\Helper\Data $helperData
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\SessionFactory $customerSessionFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Impact\PixelIntegration\Helper\Data $helperData)
	{
        $this->_helperData = $helperData;
        $this->_customerSessionFactory = $customerSessionFactory;
        $this->_orderFactory = $orderFactory;
        $this->_productFactory = $productFactory;
        $this->_categoryFactory = $categoryFactory;
        $this->_checkoutSession = $checkoutSession;
        $this->_request = $request;
        $this->_currentActionName = $this->_request->getFullActionName();
		parent::__construct($context);
	}

    /**
     * Used in .phtml file and checks if module is enabled.
     *
     * @return boolean
     */
	public function isEnabled()
	{
        return $this->_helperData->getGeneralConfig('enable');
    }
    
    /**
     * Returns event to invoke depending on if order success page or not
     *
     * @return string
     */
    public function getEventToInvoke(){
        if($this->_currentActionName==="checkout_onepage_success" || $this->_currentActionName==="onepagecheckout_index_success"){
            return "order";
        }
        return "identify";
    }

    /**
     * Checks whether to invoke identify or not
     *
     * @return string
     */
    public function checkShouldInvokeIdentify()
    {
        if($this->getEventToInvoke()==="identify"){
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Checks if order status is valid to send to Impact
     * (depends on "Stores > Cofiguration > Impact > Pixel Integration > Order Status")
     *
     * @return boolean
     */
    public function checkShouldSendOrder()
    {
        $orderId = $this->_checkoutSession->getLastOrderId();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $order = $this->_orderFactory->create()->load($orderId);
        $sendStatus = $this->_helperData->getGeneralConfig('order_status');
        if(strtolower($order->getStatus())!=="complete")
        {
            return !$sendStatus;
        }
        return true;
    }

    /**
     * Returns the Impact event tracker id
     *
     * @return string
     */
    public function getEventTrackerId()
    {
        return $this->_helperData->getGeneralConfig('sale_tracker_id');
    }
    
    /**
     * Returns the data layer containg applicalble data to generated the js data layer in /phtml files. 
     *
     * @return string
     */
    public function getDataLayer()
	{
        $event = $this->getEventToInvoke();
        $dataLayer = (object)null;
        
        $dataLayer->customerid = "";
        $dataLayer->customeremail = "";
        $customer = $this->_customerSessionFactory->create();
        if($customer->isLoggedIn()) {
            $dataLayer->customerid = $customer->getId();
            $dataLayer->customeremail = sha1($customer->getEmail());
        }

        if($event=="order")
        {
            $orderId = $this->_checkoutSession->getLastOrderId();
            $order = $this->_orderFactory->create()->load($orderId);
            $orders = $this->_orderFactory->create()->getCollection()->addFieldToFilter('customer_id', $dataLayer->customerid);

            $order_count = $orders->count();

            $dataLayer->orderId = $orderId;
            $dataLayer->customerStatus = ($order_count>0)?"RETURNING":"NEW";
            $dataLayer->currencyCode = $order->getOrderCurrencyCode();
            $dataLayer->orderShipping = (!empty($order->getShippingAmount()))?round($order->getShippingAmount(),2):"0.00";
            $dataLayer->orderTax = (!empty($order->getTaxAmount()))?round($order->getTaxAmount(),2):"0.00";
            $dataLayer->orderDiscount = (!empty($order->getDiscountAmount()))?round($order->getDiscountAmount(),2):"0.00";
            $dataLayer->orderDiscount = round(abs($dataLayer->orderDiscount),2);
            $dataLayer->orderPromoCode = (!empty($order->getCouponCode()))?$order->getCouponCode():"";
            $dataLayer->items = array();

            foreach ($order->getAllVisibleItems() as $item)
            {
                $categoryIds = "";
                $temp = (object)null;
                $product_id = $item->getProductId();
                $product = $this->_productFactory->create()->load($product_id);
                $categoryIds = $product->getCategoryIds();
                
                $category_names = "";
                if(count($categoryIds)>0)
                {
                    if(count($categoryIds) ){
                        $firstCategoryId = $categoryIds[0];
                        $_category = $this->_categoryFactory->create()->load($firstCategoryId);
                        $category_names = $_category->getName();
                    }
                }

                $temp->category = $category_names;
                $temp->sku = $item->getSku();
                $temp->name = $item->getName();
                $temp->quantity = round($item->getQtyOrdered(),0);
                $temp->subTotal =  round($item->getRowTotal(),2);
                $dataLayer->items[] = $temp;
            }
        }
        return json_encode($dataLayer);
    }
}