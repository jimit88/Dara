<?php
/***
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Plumtree\Visualmerchandiser\Block\Adminhtml\Category\Merchandiser;

class Tile extends \Magento\VisualMerchandiser\Block\Adminhtml\Category\Merchandiser\Tile
{
    protected function _construct()
    {
        $this->setModuleName('Magento_VisualMerchandiser');
        parent::_construct();
    }

    protected function _prepareCollection()
    {
        $this->_products->setCacheKey($this->getPositionCacheKey());
        $collection = $this->_products->getCollectionForGrid(
            (int) $this->getRequest()->getParam('id', 0)
        );

        $collection = $this->_products->applyCachedChanges($collection);

        $collection->clear();
        $this->setCollection($collection);

        $this->_preparePage();

        $idx = ($collection->getCurPage() * $collection->getPageSize()) - $collection->getPageSize();

        foreach ($collection as $item) {
            $item->setPosition($idx);
            $idx++;
        }

        //$this->_products->savePositions($collection);
        return $this;
    }
}