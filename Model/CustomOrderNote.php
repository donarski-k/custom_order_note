<?php

declare(strict_types=1);

namespace Kdev\CustomOrderNote\Model;

use Kdev\CustomOrderNote\Api\Data\CustomOrderNoteInterface;
use Magento\Framework\Model\AbstractModel;

class CustomOrderNote extends AbstractModel implements CustomOrderNoteInterface
{
    protected function _construct(): void
    {
        $this->_init(ResourceModel\CustomOrderNote::class);
    }

    public function getNoteId(): ?int
    {
        return $this->getData(self::NOTE_ID) ? (int)$this->getData(self::NOTE_ID) : null;
    }

    public function getOrderId(): int
    {
        return $this->getData(self::ORDER_ID);
    }

    public function setOrderId(int $orderId): CustomOrderNoteInterface
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    public function getValue(): string
    {
        return $this->getData(self::VALUE);
    }

    public function setValue(string $value): CustomOrderNoteInterface
    {
        return $this->setData(self::VALUE, $value);
    }
}
