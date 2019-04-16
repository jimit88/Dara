<?php 
namespace Plumtree\FullActionNameAlert\Block\Product\View\Options\Type; 
use Magento\Catalog\Block\Product;
class Select extends \Magento\Catalog\Block\Product\View\Options\Type\Select
{
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\Pricing\Helper\Data $pricingHelper,
		\Magento\Catalog\Helper\Data $catalogData,
		array $data = []
	)
	{
		parent::__construct($context, $pricingHelper, $catalogData, $data);
	}
		
      public function getValuesHtml()
    {
	
	//$objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
	//$productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
	
	$variable = $objectManager->create('Magento\Variable\Model\Variable');
    $cus_pro_dis = $variable->loadByCode('cus_pro_dis')->getPlainValue();
			
	$productObject = $objectManager->get('Magento\Catalog\Model\Product');
	$FormKey = $objectManager->get('Magento\Framework\Data\Form\FormKey'); 
	$_imageHelper = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Catalog\Helper\Image');
	

	$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
	$connection = $resource->getConnection();
	$tbt_fme_banners = $resource->getTableName('fme_banners');
	$sql_fme_banners = "Select * FROM " . $tbt_fme_banners;
	$result_fme_banners = $connection->fetchAll($sql_fme_banners);
	$enablesku = array();
	$enablegroup = array();
	foreach($result_fme_banners as $_result_fme_banners){
		/*echo '<pre>';
		var_dump($_result_fme_banners);
		echo '</pre>';*/
		$zname_clean = preg_replace('/\s*/', '', $_result_fme_banners['target']);
		$zname_clean = strtolower($zname_clean);
		$zname_clean = str_replace('-', '', $zname_clean);

		$_enablesku = preg_replace('/\s*/', '', $_result_fme_banners['link'].$_result_fme_banners['status']);
		$_enablesku = strtolower($_enablesku);
		$enablesku[] = $_enablesku;
		$enablegroup[] = $zname_clean;	//$_result_fme_banners['target']; 	
		
	}
	/*
echo '<pre>';
var_dump($enablesku);
echo '</pre>';*/

	$listBlock = $objectManager->get('\Magento\Catalog\Block\Product\ListProduct');
	
	$store = $objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore();
	
	$_sku = '';
	$product = '';
	$productdata = '';
	$order_swatch = '';
	$pro_popup = '';
	$swatch_add = '';
	$addToCartUrl = '';
					
        $_option = $this->getOption();
        $configValue = $this->getProduct()->getPreconfiguredValues()->getData('options/' . $_option->getId());
        $store = $this->getProduct()->getStore();

        $this->setSkipJsReloadPrice(1);
        // Remove inline prototype onclick and onchange events

        if ($_option->getType() == \Magento\Catalog\Model\Product\Option::OPTION_TYPE_DROP_DOWN ||
            $_option->getType() == \Magento\Catalog\Model\Product\Option::OPTION_TYPE_MULTIPLE
        ) {
            $require = $_option->getIsRequire() ? ' required' : '';
            $extraParams = '';
            $select = $this->getLayout()->createBlock(
                'Magento\Framework\View\Element\Html\Select'
            )->setData(
                [
                    'id' => 'select_' . $_option->getId(),
                    'class' => $require . ' product-custom-option admin__control-select'
                ]
            );
            if ($_option->getType() == \Magento\Catalog\Model\Product\Option::OPTION_TYPE_DROP_DOWN) {
                $select->setName('options[' . $_option->getid() . ']')->addOption('', __('-- Please Select --'));
            } else {
                $select->setName('options[' . $_option->getid() . '][]');
                $select->setClass('multiselect admin__control-multiselect' . $require . ' product-custom-option');
            }
            foreach ($_option->getValues() as $_value) {
                $priceStr = $this->_formatPrice(
                    [
                        'is_percent' => $_value->getPriceType() == 'percent',
                        'pricing_value' => $_value->getPrice($_value->getPriceType() == 'percent'),
                    ],
                    false
                );
                $select->addOption(
                    $_value->getOptionTypeId(),
                    $_value->getTitle() . ' ' . strip_tags($priceStr) . '',
                    ['price' => $this->pricingHelper->currencyByStore($_value->getPrice(true), $store, false)]
                );
            }
            if ($_option->getType() == \Magento\Catalog\Model\Product\Option::OPTION_TYPE_MULTIPLE) {
                $extraParams = ' multiple="multiple"';
            }
            if (!$this->getSkipJsReloadPrice()) {
                $extraParams .= ' onchange="opConfig.reloadPrice()"';
            }
            $extraParams .= ' data-selector="' . $select->getName() . '"';
            $select->setExtraParams($extraParams);

            if ($configValue) {
                $select->setValue($configValue);
            }

            return $select->getHtml();
        }

        if ($_option->getType() == \Magento\Catalog\Model\Product\Option::OPTION_TYPE_RADIO ||
            $_option->getType() == \Magento\Catalog\Model\Product\Option::OPTION_TYPE_CHECKBOX
        ) {
            $selectHtml = '<div class="options-list nested" id="options-' . $_option->getId() . '-list">';
            $require = $_option->getIsRequire() ? ' required' : '';
            $arraySign = '';
            switch ($_option->getType()) {
                case \Magento\Catalog\Model\Product\Option::OPTION_TYPE_RADIO:
                    $type = 'radio';
                    $class = 'radio admin__control-radio';
                    if (!$_option->getIsRequire()) {/*
                        $selectHtml .= '<div class="field choice admin__field admin__field-option">' .
                            '<input type="radio" id="options_' .
                            $_option->getId() .
                            '" class="' .
                            $class .
                            ' product-custom-option" name="options[' .
                            $_option->getId() .
                            ']"' .
                            ' data-selector="options[' . $_option->getId() . ']"' .
                            ($this->getSkipJsReloadPrice() ? '' : ' onclick="opConfig.reloadPrice()"') .
                            ' value="" checked="checked" /><label class="label admin__field-label" for="options_' .
                            $_option->getId() .
                            '"><span>' .
                            __('None') . '</span></label></div>';
                    */}
                    break;
                case \Magento\Catalog\Model\Product\Option::OPTION_TYPE_CHECKBOX:
                    $type = 'checkbox';
                    $class = 'checkbox admin__control-checkbox';
                    $arraySign = '[]';
                    break;
            }
            $count = 1;
			
			
			$softittle = array();
			foreach ($_option->getValues() as $_value) {
				$softittle[] = $_value->getTitle();
			}
			//sort($softittle);
			
			$com_opt = 0;
			$com_opt_title = '';
			foreach ($softittle as $key => $value){
				if (strpos($value, 'customer') !== false) {
					unset($softittle[$key]);
					$com_opt = 1;
					$com_opt_title = $value;
				}
				if (strpos($value, 'Customer') !== false) {
					unset($softittle[$key]);
					$com_opt = 1;
					$com_opt_title = $value;
				}
			}
			
			if($com_opt==1){
			array_push($softittle,$com_opt_title);
			}
					/*echo '<pre>';
					print_r($enablegroup);
					echo '</pre>';*/
					
					$_zname_clean = preg_replace('/\s*/', '', $_option->getTitle());
					$_zname_clean = strtolower($_zname_clean);
					
					
					/////////////
					$input = preg_quote($_zname_clean, '~'); // don't forget to quote input string!
					$data = $enablegroup;
					$result = null;
					$result = preg_grep('~' . $input . '~', $data);
					/*echo '<pre>';
					print_r($result);
					echo '</pre>';*/
					///////////
					
			foreach($softittle as $_softittle){
            	foreach ($_option->getValues() as $_value) {
					/*if($_value->getComplexOption()==1){*/
					//$_k_e_y = $_value->getSku()."____1";
					
					$_k_e_y = preg_replace('/\s*/', '', $_value->getSku().'1');
					$_k_e_y = strtolower($_k_e_y);
					
					
					//$_val_u = $_option->getTitle();
					if($result){ 
					/*if(array_search($_k_e_y, $enablesku,false)){ */
					$_input = preg_quote($_k_e_y, '~'); // don't forget to quote input string!
					$_data = $enablesku;
					$_result = null;
					$_result = preg_grep('~' . $_input . '~', $_data);
					if($_result){
						//continue;
					
					
		
				if($_softittle == $_value->getTitle()){
                $count++;
				
			/*echo '<pre>';
			var_dump($_value->getData());
			echo '</pre>';*/
			
                /*$priceStr = $this->_formatPrice(
                    [
                        'is_percent' => $_value->getPriceType() == 'percent',
                        'pricing_value' => $_value->getPrice($_value->getPriceType() == 'percent'),
                    ]
                );*/
				$discount_percent = $cus_pro_dis;
				$pri_ce = $_value->getPrice()*$discount_percent/100;
				$p_rice = $_value->getPrice()-$pri_ce;
			
				$priceStr = $this->_formatPrice(
                    [
                        'is_percent' => $_value->getPriceType() == 'percent',
                        'pricing_value' => $p_rice,
                    ]
                );

                $htmlValue = $_value->getOptionTypeId();
                if ($arraySign) {
                    $checked = is_array($configValue) && in_array($htmlValue, $configValue) ? 'checked' : '';
                } else {
                    $checked = $configValue == $htmlValue ? 'checked' : '';
                }

                $dataSelector = 'options[' . $_option->getId() . ']';
                if ($arraySign) {
                    $dataSelector .= '[' . $htmlValue . ']';
                }
								
				$_sku = $_value->getSku();
				//$product = $productRepository->get($_sku); 
				if($productObject->getIdBySku($_sku)) {
				$product = $productObject->loadByAttribute('sku', $_sku);

				
				if($product){
				
				
				if (strpos($_option->getTitle(), 'abric') !== false) {
				
				if($_value->getSku()=='customers-own-material'){
				$order_swatch = '';//'<a class="weltpixel_quickview_button_v2 weltpixel-quickview " data-quickview-url="'.$this->_storeManager->getStore()->getBaseUrl().'weltpixel_quickview/catalog_product/view/id/'.$product->getId().'/?remove_add_btn=yes" href="javascript:void(0);"><span  class="zoom-alink"><img src="'.$this->getViewFileUrl('images/icon-zoom.png').'" alt="Demo"></span></a>';
				}else{
				$order_swatch = '<a class="weltpixel_quickview_button_v2 weltpixel-quickview " data-quickview-url="'.$this->_storeManager->getStore()->getBaseUrl().'weltpixel_quickview/catalog_product/view/id/'.$product->getId().'/?remove_add_btn=no" href="javascript:void(0);"><span  class="zoom-alink"><img src="'.$this->getViewFileUrl('images/icon-zoom.png').'" alt="Demo"></span></a>';
				}
				}else{
				if (!strpos($_option->getTitle(), 'ushion') !== false) {
				$order_swatch = '<a class="weltpixel_quickview_button_v2 weltpixel-quickview " data-quickview-url="'.$this->_storeManager->getStore()->getBaseUrl().'weltpixel_quickview/catalog_product/view/id/'.$product->getId().'/?remove_add_btn=yes" href="javascript:void(0);"><span  class="zoom-alink"><img src="'.$this->getViewFileUrl('images/icon-zoom.png').'" alt="Demo"></span></a>';
				}
				
				}
				/*$order_swatch = '<a class="weltpixel_quickview_button_v2 weltpixel-quickview " data-quickview-url="'.$this->_storeManager->getStore()->getBaseUrl().'weltpixel_quickview/catalog_product/view/id/'.$product->getId().'/?remove_add_btn=yes" href="javascript:void(0);"><span  class="zoom-alink"><img src="'.$this->getViewFileUrl('images/icon-zoom.png').'" alt="Demo"></span></a>';*/
				
				if (strpos($_option->getTitle(), 'abric') !== false) {
				
				$addToCartUrl =  $listBlock->getAddToCartUrl($product);
				
				//$swatch_add = '<br><div class="product-from-'.$product->getId().'"><form data-role="tocart-form1" id="product-from-'.$product->getId().'" class="product-from" action="'.$addToCartUrl.'" method="post"> <input name="form_key" type="hidden" value="'.$FormKey->getFormKey().'">  <div class="btn">    <button type="submit" title="Add to Cart" class="action tocart primary">    <span>order swatch</span>     </button>    </div>   </form></div>';
					$sty_le = '';
					if($_value->getSku()=='customers-own-material'){
						$sty_le = 'style="visibility: hidden;"';
					}
				$swatch_add = '<br><div class="product-from-'.$product->getId().' product-from">  <div class="btn" '.$sty_le.'>    <button type="button" title="Add to Cart" onClick="submitDetailsForm('.$product->getId().');" class="action tocart primary">    <span>request swatch</span>     </button>    </div> </div>';
				}
				}
				
				if($product){
				//$product->getProductUrl()
				$imageUrl = $_imageHelper->init($product, 'image', ['type'=>'image'])->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize('176','176')->getUrl();				
				//$store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'catalog/product' . $product->getImage();
				
				//$pro_form = '<form data-role="tocart-form" action="'.$addToCartUrl.' " style="display:none;" method="post"><button type="submit"  title="add to bag"  style="display:none;" class="action tocart primary"><span>add to bag</span> </form> ';
				
				$pro_form = '';
				
				$productdata = $pro_form.'<div class="pro-ing"><img src="'.$imageUrl.'" style="width: 105px;" class="pro-ing"></div>';
				
				
				$pro_popup = '<div class="custom-option-zoom myswatch-'.$_value->getOptionTypeId().'" id="myswatch-'.$_value->getOptionTypeId().'" style="display:none;"> <div class="pro-ing-popup"><img src="'.$imageUrl.'" class="pro-ing"> <div class="pro-name">Name<br>'.$product->getName().'</div> <div class="pro-dscription">dscription<br>'.$product->getDescription().'</div> <br><a href="'.$product->getProductUrl().'">order free swatch</a></div> </div>';
				}
				
				
				//$product = $productRepository->get($_value->getSku()); Demo Product 1

				
                $selectHtml .= '<div class="field choice admin__field admin__field-option' .
                    $require .
                    '">' .
                    '<input type="' .
                    $type .
                    '" class="' .
                    $class .
                    ' ' .
                    $require .
                    ' product-custom-option"' .
                    ($this->getSkipJsReloadPrice() ? '' : ' onclick="opConfig.reloadPrice()"') .
                    ' name="options[' .
                    $_option->getId() .
                    ']' .
                    $arraySign .
                    '" id="options_' .
                    $_option->getId() .
                    '_' .
                    $count .
                    '" value="' .
                    $htmlValue .
                    '" ' .
                    $checked .
                    ' data-selector="' . $dataSelector . '"' .
                    ' price="' .
                    $this->pricingHelper->currencyByStore($_value->getPrice(true), $store, false) .
                    '" />' .
                    '<label class="label admin__field-label" for="options_' .
                    $_option->getId() .
                    '_' .
                    $count .
                    '">'.$productdata.$order_swatch.'<span class="sw-tit">' .
                    $_value->getTitle() .
                    '</span><span class="co-price"> ' .
                    str_replace('+', '', $priceStr) .
                    '</span></label>'.$swatch_add.$pro_popup;
                $selectHtml .= '</div>';
				
				
				}
				}
			}
					}
					// end if
				/*} end getComplexOption */
            }
			}
			
            $selectHtml .= '</div>';

            return $selectHtml;
        }
    }
	
}