<?php

declare(strict_types=1);

namespace Kdev\CustomOrderNote\Api\Data;

interface CustomOrderNoteInterface
{
    public const NOTE_ID = 'note_id';
    public const ORDER_ID = 'order_id';
    public const VALUE = 'value';

    public function getNoteId(): ?int;

    public function getOrderId(): int;

    public function setOrderId(int $orderId): self;

    public function getValue(): string;

    public function setValue(string $value): self;
}
