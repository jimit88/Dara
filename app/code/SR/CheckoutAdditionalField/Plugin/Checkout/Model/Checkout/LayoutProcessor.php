<?php
namespace SR\CheckoutAdditionalField\Plugin\Checkout\Model\Checkout;


class LayoutProcessor
{
    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerSession = $objectManager->get('Magento\Customer\Model\Session');
		if(!$customerSession->isLoggedIn()) {
   

		$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-shipping-method-form']['children']['createaccount_ttl'] = [
            'component' => 'Magento_Ui/js/form/components/html',
			'content' => __('<div class="create-account-ttl"><span class="msg1">create an account (Optional)</span>
<span  class="msg2">Set a password to create a jaysonhome.com account.</span></div>'),
			'template' => 'ui/content/content',
            'dataScope' => '0',
            'sortOrder' => 230
        ];
		
		$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-shipping-method-form']['children']['password_1'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/password',
                'id' => 'password_1'
            ],
            'dataScope' => 'shippingAddress.password_1',
            'label' => 'Password',
            'provider' => 'checkoutProvider',
            'visible' => true,
            /*'validation' => ['required-entry' => false, "min_text_len‌​gth" => 7, "max_text_length" => 20],*/
			'validation' => ['validate-no-empty' => false,'validate-password' => true,'min_text_len‌​gth' => 7, 'max_text_length' => 20,],
            'sortOrder' => 250,
            'id' => 'password_1'
        ];
		
		$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-shipping-method-form']['children']['password_case_lbl'] = [
            'component' => 'Magento_Ui/js/form/components/html',
			'content' => __('<div class="password-case">Password is case sensitive. 7-20 characters. Use letters and numbers.</div>'),
			'template' => 'ui/content/content',
            'dataScope' => '0',
            'sortOrder' => 252
        ];
		
		
		$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-shipping-method-form']['children']['password_2'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/password',
                'id' => 'password_2'
            ],
            'dataScope' => 'shippingAddress.password_2',
            'label' => 'Re-enter Password',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => ['validate-no-empty' => false, 'equalTo'=>'[name="password_1"]', 'validate-password2'=> true , "min_text_len‌​gth" => 7, "max_text_length" => 20],
            'sortOrder' => 255,
            'id' => 'password_2'
        ];
		
		
		$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-shipping-method-form']['children']['shippingmethod_ttl'] = [
            'component' => 'Magento_Ui/js/form/components/html',
			'content' => __('<div class="step-title-new">Shipping Methods</div>'),
			'template' => 'ui/content/content',
            'dataScope' => '0',
            'sortOrder' => 280
        ];
	}
        return $jsLayout;
    }
}