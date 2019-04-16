<?php

namespace Plumtree\FullActionNameAlert\Helper\Magento\Cms\Wysiwyg;


use Magento\Framework\App\Filesystem\DirectoryList;

class Images extends \Magento\Cms\Helper\Wysiwyg\Images
{
	public function getImageHtmlDeclaration($filename, $renderAsTag = false)
    {
        $fileurl = $this->getCurrentUrl() . $filename;
        $mediaUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $mediaPath = str_replace($mediaUrl, '', $fileurl);
        $directive = sprintf('{{media url="%s"}}', $mediaPath);
        if ($renderAsTag) {
            $html = sprintf('<img src="%s" alt="" />', $this->isUsingStaticUrlsAllowed() ? $fileurl : $directive);
        } else {
            if ($this->isUsingStaticUrlsAllowed()) {
                $html = $fileurl; // $mediaPath;
            } else {
                $directive = $this->urlEncoder->encode($directive);
                //$html = $this->_backendData->getUrl('cms/wysiwyg/directive', ['___directive' => $directive]);
				$html = $mediaUrl.'wysiwyg---3221/'. $filename;
            }
        }
        return $html;
    }
	
}
	
	