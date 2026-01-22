<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Certisign\OrderCustomCode\Api\ConfigInterface;
use Certisign\OrderCustomCode\Model\CodeGenerator;
use Psr\Log\LoggerInterface;

class FillOrderCustomCode implements ObserverInterface
{
    /**
     * FillOrderCustomCode constructor
     *
     * @param ConfigInterface $config
     * @param CodeGenerator $codeGenerator
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ConfigInterface $config,
        private readonly CodeGenerator $codeGenerator,
        private readonly LoggerInterface $logger
    ) {
    }

    public function execute(Observer $observer): void
    {
        if (!$this->config->isEnabled()) {
            return;
        }

        try {
            /** @var OrderInterface|null $order */
            $order = $observer->getEvent()->getOrder();

            if (!$order) {
                return;
            }

            $existingCode = (string)$order->getData(ConfigInterface::CUSTOM_CODE_FIELD);
            if ($existingCode !== '') {
                return;
            }

            $identifier = $this->codeGenerator->generate(
                (string)$order->getCreatedAt(),
                (string)$order->getIncrementId(),
                $order->getTotalQtyOrdered()
            );

            $order->setData(ConfigInterface::CUSTOM_CODE_FIELD, $identifier);

        } catch (\Throwable $e) {
            $this->logger->critical('Certisign_OrderCustomCode Error: ' . $e->getMessage(), [
                'exception' => $e,
                'order_id' => $observer->getEvent()->getOrder()?->getIncrementId()
            ]);
        }
    }
}
