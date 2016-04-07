<?php

namespace GBProd\ElasticsearchExtraBundle\Handler;

use Elasticsearch\Client;
use GBProd\ElasticsearchExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Handler to delete index command
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class DeleteIndexHandler
{
    /**
     * @var IndexConfigurationRepository
     */
    private $configurationRepository;

    /**
     * @param IndexConfigurationRepository $configurationRepository
     */
    public function __construct(IndexConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    /**
     * Handle index deletion command
     *
     * @param Client $client
     * @param string $index
     */
    public function handle(Client $client, $index)
    {
        $config = $this->configurationRepository->get($index);

        if (null === $config) {
            throw new \InvalidArgumentException();
        }

        $client
            ->indices()
            ->delete([
                'index' => $index,
            ])
        ;
    }
}
