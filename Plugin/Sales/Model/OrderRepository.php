<?php

declare(strict_types=1);

namespace Kdev\CustomOrderNote\Plugin\Sales\Model;

use Kdev\CustomOrderNote\Api\CustomOrderNoteRepositoryInterface;
use Kdev\CustomOrderNote\Api\Data\CustomOrderNoteInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;

class OrderRepository
{
    public function __construct(
        private CustomOrderNoteRepositoryInterface $customOrderNoteRepository,
        private CustomOrderNoteInterfaceFactory $customOrderNoteFactory,
        private OrderExtensionFactory $extensionFactory,
    ) {}

    public function afterGet(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        OrderInterface $result
    ): OrderInterface {
        try {
            $customOrderNote = $this->customOrderNoteRepository->getByOrderId((int)$result->getEntityId());
        } catch (NoSuchEntityException $exception) {
            return $result;
        }

        $extensionAttributes = $result->getExtensionAttributes() ?? $this->extensionFactory->create();
        $extensionAttributes->setCustomOrderNote($customOrderNote->getValue());
        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }

    public function afterSave(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        OrderInterface $result,
        OrderInterface $entity
    ): OrderInterface {

        $note = $entity->getExtensionAttributes()?->getCustomOrderNote();
        if (!$note) {
            return $result;
        }

        $customOrderNote = $this->customOrderNoteFactory->create();
        $customOrderNote
            ->setOrderId((int)$result->getEntityId())
            ->setValue($note);

        $this->customOrderNoteRepository->save($customOrderNote);

        return $result;
    }
}
