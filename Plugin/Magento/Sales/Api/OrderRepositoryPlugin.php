<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Plugin\Magento\Sales\Api;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Certisign\OrderCustomCode\Api\ConfigInterface;

class OrderRepositoryPlugin
{
    public function __construct(
        private readonly OrderExtensionFactory $orderExtensionFactory
    ) {}

    /**
     * Adiciona custom_code ao get order
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface $result
    ): OrderInterface {
        return $this->addCustomCodeToExtensionAttributes($result);
    }

    /**
     * Adiciona custom_code ao getList (collection)
     */
    public function afterGetList(
        OrderRepositoryInterface $subject,
        OrderSearchResultInterface $result
    ): OrderSearchResultInterface {
        foreach ($result->getItems() as $order) {
            $this->addCustomCodeToExtensionAttributes($order);
        }
        return $result;
    }

    private function addCustomCodeToExtensionAttributes(OrderInterface $order): OrderInterface
    {
        $extensionAttributes = $order->getExtensionAttributes();
        if ($extensionAttributes === null) {
            $extensionAttributes = $this->orderExtensionFactory->create();
        }

        $customCode = (string)$order->getData(ConfigInterface::CUSTOM_CODE_FIELD);

        $extensionAttributes->setCertisignCustomCode($customCode);
        $order->setExtensionAttributes($extensionAttributes);

        return $order;
    }
}
