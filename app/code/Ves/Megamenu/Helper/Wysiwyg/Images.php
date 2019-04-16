<?php
/**
 * Venustheme
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Venustheme.com license that is
 * available through the world-wide-web at this URL:
 * http://www.venustheme.com/license-agreement.html
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Venustheme
 * @package    Ves_Megamenu
 * @copyright  Copyright (c) 2017 Venustheme (http://www.venustheme.com/)
 * @license    http://www.venustheme.com/LICENSE-1.0.html
 */

namespace Ves\Megamenu\Helper\Wysiwyg;
use Magento\Framework\App\Filesystem\DirectoryList;

class Images extends \Magento\Cms\Helper\Wysiwyg\Images
{
	/*public function getImageHtmlDeclaration($filename, $renderAsTag = false)
	{
		if ($renderAsTag == 'venustheme'){
			$fileurl = $this->getCurrentUrl() . $filename;
			$mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
			$mediaPath = str_replace($mediaUrl, '', $fileurl);
			return $fileurl;
		} else {
			//return parent::getImageHtmlDeclaration($filename, $renderAsTag);
			$fileurl = $this->getCurrentUrl() . $filename;
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $mediaPath = str_replace($mediaUrl, '', $fileurl);
        $directive = sprintf('{{media url="%s"}}', $mediaPath);
        if ($renderAsTag) {
            //$html = sprintf('<img src="%s" alt="" />', $this->isUsingStaticUrlsAllowed() ? $fileurl : $directive);
			$html = sprintf('<img src="%s" alt="" />', $fileurl);
        } else {
            if ($this->isUsingStaticUrlsAllowed()) {
                $html = $fileurl; // $mediaPath;
            } else {
                $directive = $this->urlEncoder->encode($directive);
                //$html = $this->_backendData->getUrl('cms/wysiwyg/directive', ['___directive' => $directive]);
				//$html = $mediaUrl.'wysiwyg/'. $filename;
				//$html = $mediaUrl.$mediaPath;
				//$html = htmlspecialchars($mediaPath);
				//$html = '/media/wysiwyg/'.$filename;
				$html = $fileurl;
				//$html = html_entity_decode($directive);
            }
        }
        return $html;
		}
	}*/

}
