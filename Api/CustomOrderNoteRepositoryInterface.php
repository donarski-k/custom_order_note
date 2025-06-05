<?php

declare(strict_types=1);

namespace Kdev\CustomOrderNote\Api;

use Kdev\CustomOrderNote\Api\Data\CustomOrderNoteInterface;

interface CustomOrderNoteRepositoryInterface
{
    public function save(CustomOrderNoteInterface $customOrderNote): CustomOrderNoteInterface;

    public function getByOrderId(int $orderId): ?CustomOrderNoteInterface;
}
