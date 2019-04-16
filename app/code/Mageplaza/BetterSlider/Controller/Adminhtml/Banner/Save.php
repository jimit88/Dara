<?php

namespace Mageplaza\BetterSlider\Controller\Adminhtml\Banner;
/*
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\TestFramework\ErrorLog\Logger;
*/

class Save extends \Mageplaza\BetterSlider\Controller\Adminhtml\Banner
{
    /**
	extends \Magento\Backend\App\Action 
	extends \Mageplaza\BetterSlider\Controller\Adminhtml\Banner
     * Upload model
     * 
     * @var \Mageplaza\BetterSlider\Model\Upload
     */
    protected $uploadModel;

    /**
     * Image model
     * 
     * @var \Mageplaza\BetterSlider\Model\Banner\Image
     */
    protected $imageModel;

    /**
     * JS helper
     * 
     * @var \Magento\Backend\Helper\Js
     */
    protected $jsHelper;

    /**
     * constructor
     * 
     * @param \Mageplaza\BetterSlider\Model\Upload $uploadModel
     * @param \Mageplaza\BetterSlider\Model\Banner\Image $imageModel
     * @param \Magento\Backend\Helper\Js $jsHelper
     * @param \Mageplaza\BetterSlider\Model\BannerFactory $bannerFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Mageplaza\BetterSlider\Model\Upload $uploadModel,
        \Mageplaza\BetterSlider\Model\Banner\Image $imageModel,
        \Magento\Backend\Helper\Js $jsHelper,
        \Mageplaza\BetterSlider\Model\BannerFactory $bannerFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->uploadModel    = $uploadModel;
        $this->imageModel     = $imageModel;
        $this->jsHelper       = $jsHelper;
        parent::__construct($bannerFactory, $registry, $context);
    }

    /**
     * run the action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPost('banner');
		$_data = $this->getRequest()->getPostValue();
		/*echo '<pre>';
		var_dump($data);
		echo '<br>';
		echo '-------------------';
		echo '<br>';
		var_dump($_data);
		die;*/
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $data = $this->filterData($data);
            $banner = $this->initBanner();
            $banner->setData($data);

            $uploadFile = $this->uploadModel->uploadFileAndGetName('upload_file', $this->imageModel->getBaseDir(), $data);
			$uploadFile1 = $this->uploadModel->uploadFileAndGetName('upload_file1', $this->imageModel->getBaseDir(), $data);
			$uploadFile2 = $this->uploadModel->uploadFileAndGetName('upload_file2', $this->imageModel->getBaseDir(), $data);
			$uploadFile3 = $this->uploadModel->uploadFileAndGetName('upload_file3', $this->imageModel->getBaseDir(), $data);
			$uploadFile4 = $this->uploadModel->uploadFileAndGetName('upload_file4', $this->imageModel->getBaseDir(), $data);
			$uploadFile5 = $this->uploadModel->uploadFileAndGetName('upload_file5', $this->imageModel->getBaseDir(), $data);

            $banner->setUploadFile($uploadFile);
			$banner->setUploadFile1($uploadFile1);
			$banner->setUploadFile2($uploadFile2);
			$banner->setUploadFile3($uploadFile3);
			$banner->setUploadFile4($uploadFile4);
			$banner->setUploadFile5($uploadFile5);
			
            $sliders = $this->getRequest()->getPost('sliders', -1);
            if ($sliders != -1) {
                $banner->setSlidersData($this->jsHelper->decodeGridSerializedInput($sliders));
            }
            $this->_eventManager->dispatch(
                'mageplaza_betterslider_banner_prepare_save',
                [
                    'banner' => $banner,
                    'request' => $this->getRequest()
                ]
            );
			
			$model = $this->_objectManager->create('Mageplaza\BetterSlider\Model\Products');
			$model->setData($_data);
            try {
				$this->saveProducts($model, $_data);
			/*echo '<pre>';
			echo '<br>';
			var_dump($banner->getData());
			die;*/
			
                $banner->save();
                $this->messageManager->addSuccess(__('The Banner has been saved.'));
                $this->_session->setMageplazaBetterSliderBannerData(false);
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath(
                        'mageplaza_betterslider/*/edit',
                        [
                            'banner_id' => $banner->getId(),
                            '_current' => true
                        ]
                    );
                    return $resultRedirect;
                }
                $resultRedirect->setPath('mageplaza_betterslider/*/');
                return $resultRedirect;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Banner.'.$e->getMessage()));
            }
            $this->_getSession()->setMageplazaBetterSliderBannerData($data);
            $resultRedirect->setPath(
                'mageplaza_betterslider/*/edit',
                [
                    'banner_id' => $banner->getId(),
                    '_current' => true
                ]
            );
            return $resultRedirect;
        }
        $resultRedirect->setPath('mageplaza_betterslider/*/');
        return $resultRedirect;
    }

    /**
     * filter values
     *
     * @param array $data
     * @return array
     */
    protected function filterData($data)
    {
        if (isset($data['status'])) {
            if (is_array($data['status'])) {
                $data['status'] = implode(',', $data['status']);
            }
        }
        return $data;
    }
	
	 public function saveProducts($model, $post)
    {
        // Attach the attachments to contact
        if (isset($post['products'])) {
            $productIds = $this->jsHelper->decodeGridSerializedInput($post['products']);
			

            try {
                $oldProducts = (array) $model->getProducts($model);
                $newProducts = (array) $productIds;
				/*
				echo '<pre>';
				var_dump($oldProducts);
				echo '<br>------';
				var_dump($newProducts);
				die;
				*/
				$da_ta = $this->getRequest()->getPost('banner');
				
				if(isset($da_ta['banner_id'])){

                $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();

                $table = 'mageplaza_product_attachment_rel'; // $this->_resources->getTableName(\Webspeaks\ProductsGrid\Model\ResourceModel\Contact::TBL_ATT_PRODUCT);
                $insert = array_diff($newProducts, $oldProducts);
                $delete = array_diff($oldProducts, $newProducts);
				
				/*
				echo '<pre>';
				var_dump($model->getData());
				echo 'oldProducts';
				var_dump($oldProducts);
				echo '<br>---newProducts---';
				var_dump($newProducts);
				echo '<br>---delete---';
				var_dump($delete);
				die;*/

                if ($delete) {
                    $where = ['banner_id = ?' => $da_ta['banner_id'], 'product_id IN (?)' => $delete];
                    $connection->delete($table, $where);
                }

                if ($insert) {
                    $data = [];
                    foreach ($insert as $product_id) {
                        $data[] = ['banner_id' => $da_ta['banner_id'], 'product_id' => (int)$product_id];
                    }
					
				/*echo '<pre>';
				$da_ta = $this->getRequest()->getPost('banner');
				var_dump($da_ta['banner_id']);
				echo '<br>------';
				var_dump($table);
				echo '<br>------';
				var_dump($data);
				die;*/
				
                    $connection->insertMultiple($table, $data);
				}
                }
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the contact.'));
            }
        }

    }
}
