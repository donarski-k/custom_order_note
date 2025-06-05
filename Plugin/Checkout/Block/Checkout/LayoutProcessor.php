<?php

declare(strict_types=1);

namespace Kdev\CustomOrderNote\Plugin\Checkout\Block\Checkout;

class LayoutProcessor
{
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, array $jsLayout): array
    {
        $customOrderNoteField = [
            'component' => 'Magento_Ui/js/form/element/textarea',
            'config'    => [
                'template'     => 'ui/form/field',
                'elementTmpl'  => 'ui/form/element/textarea',
                'id'           => 'custom_order_note',
                'customScope'  => 'shippingAddress.extension_attributes',
            ],
            'dataScope' => 'shippingAddress.extension_attributes.custom_order_note',
            'label'     => __('Custom Order Note'),
            'provider'  => 'checkoutProvider',
            'visible'   => true,
            'sortOrder' => 250,
            'validation'=> []
        ];

        $fieldset = & $jsLayout['components']['checkout']
        ['children']['steps']
        ['children']['shipping-step']
        ['children']['shippingAddress']
        ['children']['shipping-address-fieldset']
        ['children'];

        $fieldset['custom_order_note'] = $customOrderNoteField;

        return $jsLayout;
    }
}
