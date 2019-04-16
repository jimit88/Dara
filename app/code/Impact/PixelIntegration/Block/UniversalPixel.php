<?php
/**
 * @category  Impact
 * @package   Impact_PixelIntegration
 * @author    Impact
 * @copyright Copyright (c) Impact Tech, Inc (http://www.impact.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License
 */

namespace Impact\PixelIntegration\Block;

class UniversalPixel extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Impact\PixelIntegration\Helper\Data
     */
    protected $_helperData;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Impact\PixelIntegration\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Impact\PixelIntegration\Helper\Data $helperData)
	{
        $this->_helperData = $helperData;
		parent::__construct($context);
	}

    /**
     * Used in .phtml file and checks if module is enabled.
     *
     * @return boolean
     */
	public function isEnabled()
	{
        return $this->_helperData->getGeneralConfig('enable');
    }
    
    /**
     * Returns UTT source script name
     *
     * @return string
     */
	public function getSource()
	{
        return $this->_helperData->getGeneralConfig('utt_source');
    }
}