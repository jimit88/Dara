/**
 * Plumtree
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Plumtree.com license that is
 * available through the world-wide-web at this URL:
 * https://www.plumtree.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Plumtree
 * @package     Plumtree_Core
 * @copyright   Copyright (c) 2016 Plumtree (http://www.plumtree.com/)
 * @license     https://www.plumtree.com/LICENSE.txt
 */

var config = {
    paths: {
        'plumtree/core/jquery/popup': 'Plumtree_Core/js/jquery.magnific-popup.min',
        'plumtree/core/owl.carousel': 'Plumtree_Core/js/owl.carousel.min',
        'plumtree/core/bootstrap': 'Plumtree_Core/js/bootstrap.min',
        mpIonRangeSlider: 'Plumtree_Core/js/ion.rangeSlider.min',
        touchPunch: 'Plumtree_Core/js/jquery.ui.touch-punch.min'
    },
    shim: {
        "plumtree/core/jquery/popup": ["jquery"],
        "plumtree/core/owl.carousel": ["jquery"],
        "plumtree/core/bootstrap": ["jquery"],
        mpIonRangeSlider: ["jquery"],
        touchPunch: ['jquery', 'jquery/ui']
    }
};
