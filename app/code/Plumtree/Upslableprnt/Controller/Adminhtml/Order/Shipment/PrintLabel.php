<?php

namespace Plumtree\Upslableprnt\Controller\Adminhtml\Order\Shipment;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class PrintLabel extends \Magento\Shipping\Controller\Adminhtml\Order\Shipment\PrintLabel
{
	
    public function execute()
    {
        try {
            $this->shipmentLoader->setOrderId($this->getRequest()->getParam('order_id'));
            $this->shipmentLoader->setShipmentId($this->getRequest()->getParam('shipment_id'));
            $this->shipmentLoader->setShipment($this->getRequest()->getParam('shipment'));
            $this->shipmentLoader->setTracking($this->getRequest()->getParam('tracking'));
            $shipment = $this->shipmentLoader->load();
            $labelContent = $shipment->getShippingLabel();
			/*echo '<pre>';
			var_dump($shipment->getData());
			die;*/
            if ($labelContent) {
                $pdfContent = null;
                if (stripos($labelContent, '%PDF-') !== false) {
                    $pdfContent = $labelContent;
					
					$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/upslbl-lblgenerate_1.log');
					
					/*
                    $pdf = new \Zend_Pdf();
                    $page = $this->labelGenerator->_createPdfPageFromImageString($labelContent);
                    if (!$page) {
                        $this->messageManager->addError(
                            __(
                                'We don\'t recognize or support the file extension in this shipment: %1.',
                                $shipment->getIncrementId()
                            )
                        );
                    }
                    $pdf->pages[] = $page;
                    $pdfContent = $pdf->render();*/
                
				
                } else {
					$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/upslbl-lblgenerate_2.log');
                    $pdf = new \Zend_Pdf();
                    $page = $this->labelGenerator->createPdfPageFromImageString($labelContent);
                    if (!$page) {
                        $this->messageManager->addError(
                            __(
                                'We don\'t recognize or support the file extension in this shipment: %1.',
                                $shipment->getIncrementId()
                            )
                        );
                    }
                    $pdf->pages[] = $page;
                    $pdfContent = $pdf->render();
                }

                return $this->_fileFactory->create(
                    'ShippingLabel(' . $shipment->getIncrementId() . ').pdf',
                    $pdfContent,
                    DirectoryList::VAR_DIR,
                    'application/pdf'
                );
            }
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
            $this->messageManager->addError(__('An error occurred while creating shipping label.'));
        }
        $this->_redirect(
            'adminhtml/order_shipment/view',
            ['shipment_id' => $this->getRequest()->getParam('shipment_id')]
        );
    }
}