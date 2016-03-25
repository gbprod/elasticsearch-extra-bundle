<?php

namespace GBProd\ElasticsearchExtraBundle\Handler;

use GBProd\ElasticsearchExtraBundle\Repository\ClientRepository;
use GBProd\ElasticsearchExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Handler to put index mappings command
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexMappingsHandler
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
    public function handle($clientId, $indexId, $typeId)
    {
        $client = $this->clientRepository->get($clientId);
        $config = $this->configurationRepository->get($clientId, $indexId);

        if ($this->isInvalid($client, $config, $typeId)) {
            throw new \InvalidArgumentException();
        }
        
        $client
            ->indices()
            ->putMapping([
                'index' => $indexId,
                'type'  => $typeId,
                'body'  => [
                    $typeId => $config['mappings'][$typeId],
                ],
            ])
        ;
    }
    
    private function isInvalid($client, $config, $typeId)
    {
        return null === $client 
            || null === $config 
            || empty($typeId)
            || !isset($config['mappings'])
            || !isset($config['mappings'][$typeId])
        ;
    }
}
