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

class Delete extends \Plumtree\Complexgrd\Controller\Adminhtml\Slider
{
    /**
     * execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('slider_id');
        if ($id) {
            $name = "";
            try {
                /** @var \Plumtree\Complexgrd\Model\Slider $slider */
                $slider = $this->sliderFactory->create();
                $slider->load($id);
                $name = $slider->getName();
                $slider->delete();
                $this->messageManager->addSuccess(__('The Slider has been deleted.'));
                $this->_eventManager->dispatch(
                    'adminhtml_plumtree_complexgrd_slider_on_delete',
                    ['name' => $name, 'status' => 'success']
                );
                $resultRedirect->setPath('plumtree_complexgrd/*/');
                return $resultRedirect;
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_plumtree_complexgrd_slider_on_delete',
                    ['name' => $name, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                $resultRedirect->setPath('plumtree_complexgrd/*/edit', ['slider_id' => $id]);
                return $resultRedirect;
            }
        }
        // display error message
        $this->messageManager->addError(__('Slider to delete was not found.'));
        // go to grid
        $resultRedirect->setPath('plumtree_complexgrd/*/');
        return $resultRedirect;
    }
}
