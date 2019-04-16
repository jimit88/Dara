<?php

namespace Plumtree\Storepickaddress\Model\Catalog\Product\Type;

class Giftcard extends \Magento\GiftCard\Model\Catalog\Product\Type\Giftcard
{

    protected function _checkGiftcardFields($buyRequest, $isPhysical, $amount)
    {

        if ($amount === null) {
            //throw new \Magento\Framework\Exception\LocalizedException(__('Please specify a gift card amount.'));
        }
        if (!$buyRequest->getGiftcardRecipientName()) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Please specify a recipient name.'));
        }
        if (!$buyRequest->getGiftcardSenderName()) {
            throw new \Magento\Framework\Exception\LocalizedException(__('Please specify a sender name.'));
        }

        if (!$isPhysical) {
            if (!$buyRequest->getGiftcardRecipientEmail()) {
                throw new \Magento\Framework\Exception\LocalizedException(__('Please specify a recipient email.'));
            }
            if (!$buyRequest->getGiftcardSenderEmail()) {
                throw new \Magento\Framework\Exception\LocalizedException(__('Please specify a sender email.'));
            }
        }
    }

}
