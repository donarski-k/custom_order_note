<?php

declare(strict_types=1);

namespace Kdev\CustomOrderNote\Plugin\Quote\Model\Quote;

class Address
{
    public function beforeBeforeSave(\Magento\Quote\Model\Quote\Address $address): null
    {
        $note = $address->getExtensionAttributes()?->getCustomOrderNote();
        if (null !== $note) {
            $address->setData('custom_order_note', $note);
        }

        return null;
    }
}
