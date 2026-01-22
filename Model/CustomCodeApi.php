<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Model;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Certisign\OrderCustomCode\Api\ConfigInterface;

class CustomCodeApi
{
    /**
     * CustomCodeApi constructor
     *
     * @param OrderExtensionFactory $orderExtensionFactory
     */
    public function __construct(
        private readonly OrderExtensionFactory $orderExtensionFactory
    ) {
    }

    /**
     * Add custom_code in webapi
     *
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function addCustomCodeToExtensionAttributes(OrderInterface $order): OrderInterface
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
