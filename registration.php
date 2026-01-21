<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Certisign_OrderCustomCode',
    __DIR__
);
