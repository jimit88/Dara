<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace FME\Banners\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\CustomOptions as OriginalCustomOptions;
use Magento\Ui\Component\Container;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Model\ProductOptions\ConfigInterface;
use Magento\Catalog\Model\Config\Source\Product\Options\Price as ProductOptionsPrice;
use Magento\Framework\UrlInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Ui\Component\Modal;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\ActionDelete;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\DataType\Media;
use Magento\Ui\Component\Form\Element\DataType\Number;
use Magento\Framework\Locale\CurrencyInterface;

class CustomOptions extends OriginalCustomOptions{
    /**
     * Get config for "Option Type" field
     *
     * @param int $sortOrder
     * @return array
     */
    const BUTTON_COMPLEX_IMPORT = 'button_complex_import';
    const FIELD_IMAGE_UPLOAD_NAME = 'image';
    const FIELD_IMAGE_DISPLAY_NAME = 'store_image';
    const FIELD_IMAGE_DELETE_NAME = 'delete_image';
    const FIELD_COMPLECX_NAME = '';
    const IMPORT_COMPLEX_OPTIONS_MODAL = 'banners_listing';
    const CUSTOM_COMPLEX_OPTIONS_LISTING = 'banners_import';
    protected function getHeaderContainerConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => null,
                        'formElement' => Container::NAME,
                        'componentType' => Container::NAME,
                        'template' => 'ui/form/components/complex',
                        'sortOrder' => $sortOrder,
                        'content' => __('Custom options let customers choose the product variations they want.'),
                    ],
                ],
            ],
            'children' => [
                static::BUTTON_COMPLEX_IMPORT => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'title' => __('Import Complex Options'),
                                'formElement' => Container::NAME,
                                'componentType' => Container::NAME,
                                'component' => 'Magento_Ui/js/form/components/button',
                                'actions' => [
                                    [
                                        'targetName' => 'ns=' . static::FORM_NAME . ', index=options',
                                        'actionName' => 'clearDataProvider'
                                    ],
                                    [
                                        'targetName' => 'ns=' . static::FORM_NAME . ', index='
                                            . static::IMPORT_COMPLEX_OPTIONS_MODAL,
                                        'actionName' => 'openModal',
                                    ],
                                    [
                                        'targetName' => 'ns=' . static::CUSTOM_COMPLEX_OPTIONS_LISTING
                                            . ', index=' . static::CUSTOM_COMPLEX_OPTIONS_LISTING,
                                        'actionName' => 'render',
                                    ],
                                ],
                                'displayAsLink' => true,
                                'sortOrder' => 10,
                            ],
                        ],
                    ],
                ],
                static::BUTTON_IMPORT => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'title' => __('Import Options'),
                                'formElement' => Container::NAME,
                                'componentType' => Container::NAME,
                                'component' => 'Magento_Ui/js/form/components/button',
                                'actions' => [
                                    [
                                        'targetName' => 'ns=' . static::FORM_NAME . ', index=options',
                                        'actionName' => 'clearDataProvider'
                                    ],
                                    [
                                        'targetName' => 'ns=' . static::FORM_NAME . ', index='
                                            . static::IMPORT_OPTIONS_MODAL,
                                        'actionName' => 'openModal',
                                    ],
                                    [
                                        'targetName' => 'ns=' . static::CUSTOM_OPTIONS_LISTING
                                            . ', index=' . static::CUSTOM_OPTIONS_LISTING,
                                        'actionName' => 'render',
                                    ],
                                ],
                                'displayAsLink' => true,
                                'sortOrder' => 10,
                            ],
                        ],
                    ],
                ],
                static::BUTTON_ADD => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'title' => __('Add Option'),
                                'formElement' => Container::NAME,
                                'componentType' => Container::NAME,
                                'component' => 'Magento_Ui/js/form/components/button',
                                'sortOrder' => 20,
                                'actions' => [
                                    [
                                        'targetName' => 'ns = ${ $.ns }, index = ' . static::GRID_OPTIONS_NAME,
                                        'actionName' => 'processingAddChild',
                                    ]
                                ]
                            ]
                        ],
                    ],
                ],
            ],
        ];
    }
//    protected function getSelectTypeGridConfig($sortOrder)
//    {
//        return [
//            'arguments' => [
//                'data' => [
//                    'config' => [
//                        'title' => __('ADD'),
//                        'formElement' => Container::NAME,
//                        'componentType' => Container::NAME,
//                        'component' => 'Magento_Ui/js/form/components/button',
//                        'actions' => [
//                            [
//                                'targetName' => 'ns=' . static::FORM_NAME . ', index=options',
//                                'actionName' => 'clearDataProvider'
//                            ],
//                            [
//                                'targetName' => 'ns=' . static::FORM_NAME . ', index='
//                                    . static::IMPORT_COMPLEX_OPTIONS_MODAL,
//                                'actionName' => 'openModal',
//                            ],
//                            [
//                                'targetName' => 'ns=' . static::CUSTOM_COMPLEX_OPTIONS_LISTING
//                                    . ', index=' . static::CUSTOM_COMPLEX_OPTIONS_LISTING,
//                                'actionName' => 'render',
//                            ],
//                        ],
//                    ],
//                ],
//
//            ],
//            'children' => [
//                'record' => [
//                    'arguments' => [
//                        'data' => [
//                            'config' => [
//                                'componentType' => Container::NAME,
//                                'component' => 'Magento_Ui/js/dynamic-rows/record',
//                                'positionProvider' => static::FIELD_SORT_ORDER_NAME,
//                                'isTemplate' => true,
//                                'is_collection' => true,
//                            ],
//                        ],
//                    ],
//                    'children' => [
//                        static::FIELD_TITLE_NAME => $this->getTitleFieldConfig(10),
//                        static::FIELD_PRICE_NAME => $this->getPriceFieldConfig(20),
//                        static::FIELD_PRICE_TYPE_NAME => $this->getPriceTypeFieldConfig(30, ['fit' => true]),
//                        static::FIELD_SKU_NAME => $this->getSkuFieldConfig(40),
//                        static::FIELD_SORT_ORDER_NAME => $this->getPositionFieldConfig(50),
////                        static::FIELD_IMAGE_DELETE_NAME => $this->getIsDeleteImgFieldConfig(60),
////                        static::FIELD_IMAGE_DISPLAY_NAME => $this->getImgDisplayConfig(70),
// //                       static::FIELD_IMAGE_UPLOAD_NAME => $this->getImgConfig(5),
//                        static::FIELD_IS_DELETE => $this->getIsDeleteFieldConfig(90)
//                    ]
//                ]
//            ]
//        ];
//    }


    protected function getImgConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'title' => __('Import Options'),
                        'formElement' => Container::NAME,
                        'componentType' => Container::NAME,
                        'component' => 'Magento_Ui/js/form/components/button',
                        'actions' => [
                            [
                                'targetName' => 'ns=' . static::FORM_NAME . ', index=options',
                                'actionName' => 'clearDataProvider'
                            ],
                            [
                                'targetName' => 'ns=' . static::FORM_NAME . ', index='
                                    . static::IMPORT_OPTIONS_MODAL,
                                'actionName' => 'openModal',
                            ],
                            [
                                'targetName' => 'ns=' . static::CUSTOM_OPTIONS_LISTING
                                    . ', index=' . static::CUSTOM_OPTIONS_LISTING,
                                'actionName' => 'render',
                            ],
                        ],
                        'sortOrder' => $sortOrder,
                        'validation' => [
                            'required-entry' => false
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Get config for "Required" field
     *
     * @param int $sortOrder
     * @return array
     */
    protected function getIsDeleteImgFieldConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Delete Image'),
                        'componentType' => Field::NAME,
                        'formElement' => Checkbox::NAME,
                        'dataScope' => static::FIELD_IMAGE_DELETE_NAME,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                        'value' => '0',
                        'valueMap' => [
                            'true' => '1',
                            'false' => '0'
                        ],
                    ],
                ],
            ],
        ];
    }


    protected function getImgDisplayConfig($sortOrder)
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Image Path'),
                        'componentType' =>  Field::NAME,
                        'formElement' => Input::NAME,
                        'dataScope' => static::FIELD_IMAGE_DISPLAY_NAME,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                        'validation' => [
                            'required-entry' => false
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getCommonContainerConfig($sortOrder)
    {
        $commonContainer = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Container::NAME,
                        'formElement' => Container::NAME,
                        'component' => 'Magento_Ui/js/form/components/group',
                        'breakLine' => false,
                        'showLabel' => false,
                        'additionalClasses' => 'admin__field-group-columns admin__control-group-equal',
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
            'children' => [
                static::FIELD_OPTION_ID => $this->getOptionIdFieldConfig(10),
                static::FIELD_TITLE_NAME => $this->getTitleFieldConfig(
                    20,
                    [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'label' => __('Option Title'),
                                    'component' => 'Magento_Catalog/component/static-type-input',
                                    'valueUpdate' => 'input',
                                    'imports' => [
                                        'optionId' => '${ $.provider }:${ $.parentScope }.option_id'
                                    ]
                                ],
                            ],
                        ],
                    ]
                ),
                static::FIELD_TYPE_NAME => $this->getTypeFieldConfig(30),
//                static::FIELD_IMAGE_UPLOAD_NAME => $this->getImgConfig(60),
//                static::FIELD_IMAGE_DISPLAY_NAME => $this->getImgDisplayConfig(55),
//                static::FIELD_IMAGE_DELETE_NAME => $this->getIsDeleteImgFieldConfig(50),
                static::FIELD_IS_REQUIRE_NAME => $this->getIsRequireFieldConfig(40)
            ]
        ];

        if ($this->locator->getProduct()->getStoreId()) {
            $useDefaultConfig = [
                'service' => [
                    'template' => 'Magento_Catalog/form/element/helper/custom-option-service',
                ]
            ];
            $titlePath = $this->arrayManager->findPath(static::FIELD_TITLE_NAME, $commonContainer, null)
                . static::META_CONFIG_PATH;
            $commonContainer = $this->arrayManager->merge($titlePath, $commonContainer, $useDefaultConfig);
        }

        return $commonContainer;
    }
    protected function getTypeFieldConfig($sortOrder)
    {

        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Option Type'),
                        'componentType' => Field::NAME,
                        'formElement' => Select::NAME,
                        'component' => 'Magento_Catalog/js/custom-options-type',
                        'elementTmpl' => 'ui/grid/filters/elements/ui-select',
                        'selectType' => 'optgroup',
                        'dataScope' => static::FIELD_TYPE_NAME,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                        'options' => $this->getProductOptionTypes(),
                        'disableLabel' => true,
                        'multiple' => false,
                        'selectedPlaceholders' => [
                            'defaultPlaceholder' => __('-- Please select --'),
                        ],
                        'validation' => [
                            'required-entry' => true
                        ],
                        'groupsConfig' => [
                            'text' => [
                                'values' => ['field', 'area'],
                                'indexes' => [
                                    static::CONTAINER_TYPE_STATIC_NAME,
                                    static::FIELD_PRICE_NAME,
                                    static::FIELD_PRICE_TYPE_NAME,
                                    static::FIELD_SKU_NAME,
                                    static::FIELD_MAX_CHARACTERS_NAME
                                ]
                            ],
                            'file' => [
                                'values' => ['file'],
                                'indexes' => [
                                    static::CONTAINER_TYPE_STATIC_NAME,
                                    static::FIELD_PRICE_NAME,
                                    static::FIELD_PRICE_TYPE_NAME,
                                    static::FIELD_SKU_NAME,
                                    static::FIELD_FILE_EXTENSION_NAME,
                                    static::FIELD_IMAGE_SIZE_X_NAME,
                                    static::FIELD_IMAGE_SIZE_Y_NAME
                                ]
                            ],
                            'select' => [
                                'values' => ['drop_down', 'radio', 'checkbox', 'multiple','fabric','wood_finish','nail_head','cushion_fill'],
                                'indexes' => [
                                    static::GRID_TYPE_SELECT_NAME
                                ]
                            ],
                            'data' => [
                                'values' => ['date', 'date_time', 'time'],
                                'indexes' => [
                                    static::CONTAINER_TYPE_STATIC_NAME,
                                    static::FIELD_PRICE_NAME,
                                    static::FIELD_PRICE_TYPE_NAME,
                                    static::FIELD_SKU_NAME
                                ]
                            ]
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getImportComplexOptionsModalConfig()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Modal::NAME,
                        'dataScope' => '',
                        'provider' => static::FORM_NAME . '.product_form_data_source',
                        'options' => [
                            'title' => __('Select Options'),
                            'buttons' => [
                                [
                                    'text' => __('Import'),
                                    'class' => 'action-primary',
                                    'actions' => [
                                        [
                                            'targetName' => 'index = ' . static::CUSTOM_COMPLEX_OPTIONS_LISTING,
                                            'actionName' => 'save'
                                        ],
                                        'closeModal'
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'children' => [
                static::CUSTOM_OPTIONS_LISTING => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'autoRender' => false,
                                'componentType' => 'insertListing',
                                'dataScope' => static::CUSTOM_OPTIONS_LISTING,
                                'externalProvider' => static::CUSTOM_OPTIONS_LISTING . '.'
                                    . static::CUSTOM_OPTIONS_LISTING . '_data_source',
                                'selectionsProvider' => static::CUSTOM_OPTIONS_LISTING . '.'
                                    . static::CUSTOM_OPTIONS_LISTING . '.product_columns.ids',
                                'ns' => static::CUSTOM_OPTIONS_LISTING,
                                'render_url' => $this->urlBuilder->getUrl('mui/index/render'),
                                'realTimeLink' => true,
                                'behaviourType' => 'edit',
                                'externalFilterMode' => false,
                                'currentProductId' => $this->locator->getProduct()->getId(),
                                'dataLinks' => [
                                    'imports' => false,
                                    'exports' => true
                                ],
                                'exports' => [
                                    'currentProductId' => '${ $.externalProvider }:params.current_product_id'
                                ]
                            ],
                        ],
                    ],
                ],
                static::CUSTOM_COMPLEX_OPTIONS_LISTING => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'autoRender' => false,
                                'componentType' => 'insertListing',
                                'dataScope' => static::CUSTOM_COMPLEX_OPTIONS_LISTING,
                                'externalProvider' => static::CUSTOM_COMPLEX_OPTIONS_LISTING . '.'
                                    . static::CUSTOM_COMPLEX_OPTIONS_LISTING . '_data_source',
                                'selectionsProvider' => static::CUSTOM_COMPLEX_OPTIONS_LISTING . '.'
                                    . static::CUSTOM_COMPLEX_OPTIONS_LISTING ,
                                'ns' => static::CUSTOM_COMPLEX_OPTIONS_LISTING,
                                'render_url' => $this->urlBuilder->getUrl('mui/index/render'),
                                'realTimeLink' => true,
                                'behaviourType' => 'edit',
                                'externalFilterMode' => false,
//                                'currentProductId' => $this->locator->getProduct()->getId(),
                                'dataLinks' => [
                                    'imports' => false,
                                    'exports' => true
                                ],
                                'exports' => [
//                                    'currentProductId' => '${ $.externalProvider }:params.current_product_id'
                                ]
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function createCustomOptionsPanel()
    {
        $this->meta = array_replace_recursive(
            $this->meta,
            [
                static::GROUP_CUSTOM_OPTIONS_NAME => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Customizable Options'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => static::GROUP_CUSTOM_OPTIONS_SCOPE,
                                'collapsible' => true,
                                'sortOrder' => $this->getNextGroupSortOrder(
                                    $this->meta,
                                    static::GROUP_CUSTOM_OPTIONS_PREVIOUS_NAME,
                                    static::GROUP_CUSTOM_OPTIONS_DEFAULT_SORT_ORDER
                                ),
                            ],
                        ],
                    ],
                    'children' => [
                        static::CONTAINER_HEADER_NAME => $this->getHeaderContainerConfig(10),
                        static::FIELD_ENABLE => $this->getEnableFieldConfig(20),
                        static::GRID_OPTIONS_NAME => $this->getOptionsGridConfig(30)
                    ]
                ]
            ]
        );

        $this->meta = array_merge_recursive(
            $this->meta,
            [
                static::IMPORT_OPTIONS_MODAL => $this->getImportOptionsModalConfig(),
                static::IMPORT_COMPLEX_OPTIONS_MODAL => $this->getImportComplexOptionsModalConfig(),
            ]
        );

        return $this;
    }
}