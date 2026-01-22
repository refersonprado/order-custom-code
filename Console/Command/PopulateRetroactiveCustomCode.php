<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Referson Prado <prado.referson@gmail.com>
 * @copyright   2026 Referson Prado
 */
declare(strict_types=1);

namespace Certisign\OrderCustomCode\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\ResourceConnection;
use Certisign\OrderCustomCode\Api\ConfigInterface;
use Certisign\OrderCustomCode\Model\CodeGenerator;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;

class PopulateRetroactiveCustomCode extends Command
{
    private const BATCH_SIZE = 1000;

    /**
     * PopulateRetroactiveCustomCode constructor
     *
     * @param ResourceConnection $resource
     * @param ConfigInterface $config
     * @param State $state
     * @param CodeGenerator $codeGenerator
     * @param string|null $name
     */
    public function __construct(
        private readonly ResourceConnection $resource,
        private readonly ConfigInterface $config,
        private readonly State $state,
        private readonly CodeGenerator $codeGenerator,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('certisign:order:populate-custom-code')
            ->setDescription('Fill in the custom_code field for bulk old orders.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            try {
                $this->state->setAreaCode(Area::AREA_GLOBAL);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
            }

            $connection = $this->resource->getConnection();
            $tableName = $this->resource->getTableName('sales_order');
            $customCodeField = ConfigInterface::CUSTOM_CODE_FIELD;

            $select = $connection->select()
                ->from($tableName, ['entity_id', 'created_at', 'increment_id', 'total_qty_ordered'])
                ->where("$customCodeField IS NULL OR $customCodeField = ''");

            $orders = $connection->fetchAll($select);
            $total = count($orders);

            if ($total === 0) {
                $output->writeln("<info>No pending orders found.</info>");
                return Command::SUCCESS;
            }

            $output->writeln("<comment>Processing $total orders...</comment>");

            $count = 0;
            $updatedAt = (new \DateTime())->format('Y-m-d H:i:s');

            foreach (array_chunk($orders, self::BATCH_SIZE) as $batch) {
                foreach ($batch as $orderData) {
                    $orderQty = (int)$orderData['total_qty_ordered'];

                    $identifier = $this->codeGenerator->generate(
                        $orderData['created_at'],
                        $orderData['increment_id'],
                        $orderQty
                    );

                    $connection->update(
                        $tableName,
                        [
                            $customCodeField => $identifier,
                            'updated_at'     => $updatedAt
                        ],
                        ['entity_id = ?' => $orderData['entity_id']]
                    );
                    $count++;
                }
                $output->writeln("Batch processed: $count / $total");
            }

            $output->writeln("<info>Success! $count orders updated.</info>");
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $output->writeln("<error>Error: " . $e->getMessage() . "</error>");
            return Command::FAILURE;
        }
    }
}
