<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Block\Success;

use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;

class CustomCode extends Template
{
    /**
     * CustomCode constructor
     *
     * @param Context $context
     * @param CheckoutSession $checkoutSession
     * @param OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        private readonly CheckoutSession $checkoutSession,
        private readonly OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get custom_code from order
     *
     * @return string
     */
    public function getCustomCode(): string
    {
        $order = $this->getLastOrder();
        return (string)$order?->getData('custom_code');
    }

    /**
     * Get last order
     *
     * @return OrderInterface|null
     */
    private function getLastOrder(): ?OrderInterface
    {
        $orderId = (int) $this->checkoutSession->getLastOrderId();
        if (!$orderId) {
            return null;
        }

        try {
            return $this->orderRepository->get($orderId);
        } catch (\Throwable) {
            return null;
        }
    }
}
