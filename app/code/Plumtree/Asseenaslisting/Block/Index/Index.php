<?php

namespace Plumtree\Asseenaslisting\Block\Index;


class Index extends \Magento\Framework\View\Element\Template {
	
	/*protected $_filesystem ;*/
    protected $_imageFactory;
 

    public function __construct(
			\Magento\Catalog\Block\Product\Context $context,
			/*\Magento\Framework\Filesystem $filesystem,*/         
       		\Magento\Framework\Image\AdapterFactory $imageFactory ,
			array $data = []
		) {

        parent::__construct($context, $data);
		/*$this->_filesystem = $filesystem;  */             
        $this->_imageFactory = $imageFactory;

    }


    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
	
	public function resize($img_path, $image, $width = null, $height = null)
    {
        $absolutePath = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath('mageplaza/betterslider/banner/image').$img_path.'/'.$image;

        $imageResized = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath('mageplaza/betterslider/banner/image/resized').$img_path.'/'.$image;         
        //create image factory...
        $imageResize = $this->_imageFactory->create();         
        $imageResize->open($absolutePath);
        $imageResize->constrainOnly(TRUE);         
        $imageResize->keepTransparency(TRUE);         
        $imageResize->keepFrame(FALSE);         
        $imageResize->keepAspectRatio(TRUE);         
        $imageResize->resize($width,$height);  
        //destination folder                
        $destination = $imageResized ;    
        //save image      
        $imageResize->save($destination);         

        $resizedURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'mageplaza/betterslider/banner/image/resized'.$img_path.'/'.$image;
        return $resizedURL;
  } 

}