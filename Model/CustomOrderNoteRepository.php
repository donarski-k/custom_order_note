<?php

declare(strict_types=1);

namespace Kdev\CustomOrderNote\Model;

use Kdev\CustomOrderNote\Api\CustomOrderNoteRepositoryInterface;
use Kdev\CustomOrderNote\Api\Data\CustomOrderNoteInterface;
use Kdev\CustomOrderNote\Model\ResourceModel\CustomOrderNote\CollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class CustomOrderNoteRepository implements CustomOrderNoteRepositoryInterface
{
    public function __construct(
        private \Kdev\CustomOrderNote\Model\ResourceModel\CustomOrderNote $resource,
        private CollectionFactory $collectionFactory
    ) {}

    /**
     * @throws CouldNotSaveException
     */
    public function save(CustomOrderNoteInterface $customOrderNote): CustomOrderNoteInterface
    {
        try {
            $this->resource->save($customOrderNote);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()), $exception);
        }
        return $customOrderNote;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getByOrderId(int $orderId): ?CustomOrderNoteInterface
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('order_id', $orderId);

        $customOrderNote = $collection->getFirstItem();

        if (!$customOrderNote->getNoteId()) {
            throw new NoSuchEntityException();
        }

        return $customOrderNote;
    }
}
