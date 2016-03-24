<?php

namespace GBProd\ElasticsearchExtraBundle\Handler;

use GBProd\ElasticsearchExtraBundle\Repository\ClientRepository;
use GBProd\ElasticsearchExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Handler for create index command
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CreateIndexHandler
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * @var IndexConfigurationRepository
     */
    private $configurationRepository;

    /**
     * @param ClientRepository             $clientRepository
     * @param IndexConfigurationRepository $configurationRepository
     */
    public function __construct(
        ClientRepository $clientRepository,
        IndexConfigurationRepository $configurationRepository
    ) {
        $this->clientRepository        = $clientRepository;
        $this->configurationRepository = $configurationRepository;
    }

    /**
     * Handle index creation command
     *
     * @param string $clientId
     * @param string $indexId
     */
    public function handle($clientId, $indexId)
    {
        $client = $this->clientRepository->get($clientId);
        $config = $this->configurationRepository->get($clientId, $indexId);

        if (null === $client || null === $config) {
            throw new \InvalidArgumentException();
        }

        $client
            ->indices()
            ->create([
                'index' => $indexId,
                'body'  => $config,
            ])
        ;
    }
}