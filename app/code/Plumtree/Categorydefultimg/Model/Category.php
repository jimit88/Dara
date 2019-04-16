<?php

namespace Plumtree\Categorydefultimg\Model;

class Category extends \Magento\Catalog\Model\Category
{

	public function getImageUrl($attributeCode = 'image')
    {
        $url = false;
        $image = $this->getData($attributeCode);
        if ($image) {
            if (is_string($image)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . 'catalog/category/' . $image;
            } else {
               /* throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url**======*.')
                );*/
            }
        }

        return $url;
    }
}

