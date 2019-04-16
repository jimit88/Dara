<?php
namespace Plumtree\CheckoutField\Block;

class LayoutProcess
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
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
    ['shippingAddress']['children']['shipping-address-fieldset']['children']['street'] = [
        'component' => 'Magento_Ui/js/form/components/group',
        'label' => __('Address'),
        'required' => true,
        'dataScope' => 'shippingAddress.street',
        'provider' => 'checkoutProvider',
        'sortOrder' => 60,
        'type' => 'group',
        'children' => [
            [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/input'
                ],
                'dataScope' => '0',
                'provider' => 'checkoutProvider',
                'validation' => true,
                
            ],
            [
                'component' => 'Magento_Ui/js/form/element/abstract',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/input'
                ],
                'dataScope' => '1',
                'provider' => 'checkoutProvider',
                'validation' => true,
                'label' => __('Apt, Suite, etc. (optional)')
            ],
           
            ]

        ];

         return $jsLayout;
     }
 }