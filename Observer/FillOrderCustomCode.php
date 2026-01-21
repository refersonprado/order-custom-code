<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Observer;

use DateTimeImmutable;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;

class FillOrderCustomCode implements ObserverInterface
{
    private const PREFIX = 'VAL';
    private const FIELD_CUSTOM_CODE = 'custom_code';

    public function execute(Observer $observer): void
    {
        /** @var OrderInterface|null $order */
        $order = $observer->getEvent()->getOrder();

        if (!$order) {
            return;
        }

        if ((string)$order->getData(self::FIELD_CUSTOM_CODE) !== '') {
            return;
        }

        $createdAt = (string)$order->getCreatedAt();

        $date = new DateTimeImmutable($createdAt);

        $formattedDate = $date->format('Ym');
        $incrementId = (string)$order->getIncrementId();
        $totalItems = (int)((float)$order->getTotalQtyOrdered());

        $identifier = sprintf(
            '%s-%s-%s-%d',
            self::PREFIX,
            $formattedDate,
            $incrementId,
            $totalItems
        );

        $order->setData(self::FIELD_CUSTOM_CODE, $identifier);
    }
}
