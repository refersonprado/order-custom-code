<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Plugin\Magento\Sales\Api;

use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Certisign\OrderCustomCode\Model\CustomCodeApi;

class OrderRepositoryPluginGet
{
    /**
     * OrderRepositoryPluginGet constructor
     *
     * @param CustomCodeApi $customCodeApi
     */
    public function __construct(
        private readonly CustomCodeApi $customCodeApi,
    ) {
    }

    /**
     * Add custom_code to getList (collection)
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $result
     * @return OrderSearchResultInterface
     */
    public function afterGetList(
        OrderRepositoryInterface $subject,
        OrderSearchResultInterface $result
    ): OrderSearchResultInterface {
        foreach ($result->getItems() as $order) {
            $this->customCodeApi->addCustomCodeToExtensionAttributes($order);
        }
        return $result;
    }
}
