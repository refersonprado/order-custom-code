<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Api;

interface ConfigInterface
{
    public const XML_PATH_ENABLED = 'certisign_order_custom_code/general/enabled';
    public const XML_PATH_PREFIX = 'certisign_order_custom_code/general/prefix';
    public const CUSTOM_CODE_FIELD = 'custom_code';

    /**
     * Function to check if module is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Function to get prefix text
     *
     * @return string
     */
    public function getPrefix(): string;
}
