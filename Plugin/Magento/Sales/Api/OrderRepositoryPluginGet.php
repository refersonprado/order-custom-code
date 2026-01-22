<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Plugin\Magento\Sales\Api;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Certisign\OrderCustomCode\Model\CustomCodeApi;

class OrderRepositoryPluginGet
{
    /**
     * OrderRepositoryPluginGetList constructor
     *
     * @param CustomCodeApi $customCodeApi
     */
    public function __construct(
        private readonly CustomCodeApi $customCodeApi,
    ) {
    }

    /**
     * Add custom_code to get order
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $result
     * @return OrderInterface
     */
    public function afterGet(
        OrderRepositoryInterface $subject,
        OrderInterface $result
    ): OrderInterface {
        return $this->customCodeApi->addCustomCodeToExtensionAttributes($result);
    }
}
