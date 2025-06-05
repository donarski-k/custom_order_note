<?php

declare(strict_types=1);

namespace Kdev\CustomOrderNote\Model\ResourceModel\CustomOrderNote;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(
            \Kdev\CustomOrderNote\Model\CustomOrderNote::class,
            \Kdev\CustomOrderNote\Model\ResourceModel\CustomOrderNote::class
        );
    }
}
