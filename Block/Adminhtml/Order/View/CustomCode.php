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
    public function __construct(
        Template\Context $context,
        private readonly Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getOrder(): ?OrderInterface
    {
        return $this->registry->registry('current_order');
    }

    public function getCustomCode(): string
    {
        $order = $this->getOrder();
        return (string)$order?->getData(ConfigInterface::CUSTOM_CODE_FIELD);
    }
}
