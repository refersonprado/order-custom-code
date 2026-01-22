<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Model;

use Certisign\OrderCustomCode\Api\ConfigInterface;
use DateTimeImmutable;

class CodeGenerator
{
    /**
     * CodeGenerator constructor
     *
     * @param ConfigInterface $config
     */
    public function __construct(
        private readonly ConfigInterface $config
    ) {
    }

    /**
     * Generate custom code identifier based on order data
     *
     * @param string $createdAt
     * @param string $incrementId
     * @param float|int $totalQty
     * @return string
     * @throws \DateMalformedStringException
     */
    public function generate(string $createdAt, string $incrementId, float|int $totalQty): string
    {
        $date = new DateTimeImmutable($createdAt);
        $prefix = $this->config->getPrefix() ?: 'VAL';

        return sprintf(
            '%s-%s-%s-%d',
            $prefix,
            $date->format('Ym'),
            $incrementId,
            (int) $totalQty
        );
    }
}
