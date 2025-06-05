<?php

declare(strict_types=1);

namespace Kdev\CustomOrderNote\Plugin\Sales\Model;

use Kdev\CustomOrderNote\Api\CustomOrderNoteRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\QuoteRepository;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;

class Order
{
    public function __construct(
        private QuoteRepository $quoteRepository,
        private OrderExtensionFactory $extensionFactory,
        private CustomOrderNoteRepositoryInterface $customOrderNoteRepository,
    ) {}

    public function afterPlace(
        \Magento\Sales\Model\Order $subject,
        \Magento\Sales\Model\Order $result,
    ): \Magento\Sales\Model\Order {

        $note = $this->getNote($result);

        if (!$note) {
            return $result;
        }

        $extensionAttributes = $result->getExtensionAttributes() ?? $this->extensionFactory->create();
        $extensionAttributes->setCustomOrderNote($note);

        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }

    private function getNote(OrderInterface $subject): ?string
    {
        $quote = $this->quoteRepository->get($subject->getQuoteId());

        return $quote?->getShippingAddress()?->getCustomOrderNote();
    }

    public function afterLoad(
        \Magento\Sales\Model\Order $subject,
        \Magento\Sales\Model\Order $result,
        int $orderId
    ): \Magento\Sales\Model\Order {

        try {
            $customOrderNote = $this->customOrderNoteRepository->getByOrderId($orderId);
        } catch (NoSuchEntityException $exception) {
            return $result;
        }

        $extensionAttributes = $result->getExtensionAttributes() ?? $this->extensionFactory->create();
        $extensionAttributes->setCustomOrderNote($customOrderNote->getValue());
        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }
}
