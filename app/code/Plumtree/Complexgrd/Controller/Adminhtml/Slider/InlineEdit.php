<?php
/**
 * Plumtree_Complexgrd extension
 *                     NOTICE OF LICENSE
 * 
 *                     This source file is subject to the Plumtree License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://www.plumtree.com/LICENSE.txt
 * 
 *                     @category  Plumtree
 *                     @package   Plumtree_Complexgrd
 *                     @copyright Copyright (c) 2016
 *                     @license   https://www.plumtree.com/LICENSE.txt
 */
namespace Plumtree\Complexgrd\Controller\Adminhtml\Slider;

abstract class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * JSON Factory
     * 
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * Slider Factory
     * 
     * @var \Plumtree\Complexgrd\Model\SliderFactory
     */
    protected $sliderFactory;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Plumtree\Complexgrd\Model\SliderFactory $sliderFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Plumtree\Complexgrd\Model\SliderFactory $sliderFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->jsonFactory   = $jsonFactory;
        $this->sliderFactory = $sliderFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        foreach (array_keys($postItems) as $sliderId) {
            /** @var \Plumtree\Complexgrd\Model\Slider $slider */
            $slider = $this->sliderFactory->create()->load($sliderId);
            try {
                $sliderData = $postItems[$sliderId];//todo: handle dates
                $slider->addData($sliderData);
                $slider->save();
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithSliderId($slider, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithSliderId($slider, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithSliderId(
                    $slider,
                    __('Something went wrong while saving the Slider.')
                );
                $error = true;
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Slider id to error message
     *
     * @param \Plumtree\Complexgrd\Model\Slider $slider
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithSliderId(\Plumtree\Complexgrd\Model\Slider $slider, $errorText)
    {
        return '[Slider ID: ' . $slider->getId() . '] ' . $errorText;
    }
}
