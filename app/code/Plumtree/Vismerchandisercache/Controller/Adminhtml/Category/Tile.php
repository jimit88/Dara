<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Plumtree\Vismerchandisercache\Controller\Adminhtml\Category;

class Tile extends \Magento\VisualMerchandiser\Controller\Adminhtml\Category\Tile
{

    /**
     * @var string
     */
    protected $blockClass = 'Plumtree\Vismerchandisercache\Block\Adminhtml\Category\Merchandiser\Tileptg';
    						//'Magento\VisualMerchandiser\Block\Adminhtml\Category\Merchandiser\Tile';

    /**
     * @var string
     */
    protected $blockName = 'tile';
}
