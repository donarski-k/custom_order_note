<?php

declare(strict_types=1);

namespace Kdev\CustomOrderNote\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomOrderNote extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('custom_order_note', 'note_id');
    }
}
