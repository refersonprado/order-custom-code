<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Block\Adminhtml\Order\View;

use Magento\Backend\Block\Template;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\Registry;
use Certisign\OrderCustomCode\Api\ConfigInterface;

class CustomCode extends Template
{
    /**
     * CustomCode constructor
     *
     * @param Template\Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        private readonly Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Get last order
     *
     * @return OrderInterface|null
     */
    public function getOrder(): ?OrderInterface
    {
        return $this->registry->registry('current_order');
    }

    /**
     * Get custom code field
     *
     * @return string
     */
    public function getCustomCode(): string
    {
        $order = $this->getOrder();
        return (string)$order?->getData(ConfigInterface::CUSTOM_CODE_FIELD);
    }
}
