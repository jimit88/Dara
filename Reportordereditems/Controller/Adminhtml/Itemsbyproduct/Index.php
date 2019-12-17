<?php
namespace Plumtree\Reportordereditems\Controller\Adminhtml\Itemsbyproduct;
use Magento\Reports\Model\Flag;
class Index  extends \Magento\Reports\Controller\Adminhtml\Report\Sales
{


    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $this->_initAction()->_setActiveMenu(
            'Plumtree_Reportordereditems::itemsbyproduct'
        )->_addBreadcrumb(
            __('Ordered Items'),
            __('Ordered Items')
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Ordered Items'));
        $this->_view->renderLayout();
    }

}
