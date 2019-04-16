<?php
namespace Plumtree\Upslableprnt\Model\Shipping;


use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\RequestInterface;

use Magento\Shipping\Model\Shipping\LabelGenerator as LabelGeneratorcore;

class LabelGenerator extends LabelGeneratorcore
{
	public function createPdfPageFromImageString($imageString)
    {
		$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/upslbl-lblgenerate.log');
		
        /** @var \Magento\Framework\Filesystem\Directory\Write $directory */
        $directory = $this->filesystem->getDirectoryWrite(
            DirectoryList::TMP
        );
        $directory->create();
        $image = @imagecreatefromstring($imageString);
        if (!$image) {
            return false;
        }
		

		$xSize = 6 * 72;
		$ySize = 4 * 72;
        /*$xSize = imagesx($image);
        $ySize = imagesy($image);*/
        $page = new \Zend_Pdf_Page($xSize, $ySize);		
       

        imageinterlace($image, 0);
        $tmpFileName = $directory->getAbsolutePath(
            'shipping_labels_' . uniqid(\Magento\Framework\Math\Random::getRandomNumber()) . time() . '.png'
        );
		
        imagepng($image, $tmpFileName);
        $pdfImage = \Zend_Pdf_Image::imageWithPath($tmpFileName);				
		$page->drawImage($pdfImage, 0, 0, $xSize, $ySize);
        
		//$page->drawImage($pdfImage, 0, 0, $xSize, $ySize);
        $directory->delete($directory->getRelativePath($tmpFileName));
        if (is_resource($image)) {
            imagedestroy($image);
        }
        return $page;
    }
	
	
}