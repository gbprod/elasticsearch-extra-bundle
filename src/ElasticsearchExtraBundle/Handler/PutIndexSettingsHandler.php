<?php

namespace GBProd\ElasticsearchExtraBundle\Handler;

use Elasticsearch\Client;
use GBProd\ElasticsearchExtraBundle\Repository\ClientRepository;
use GBProd\ElasticsearchExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Handler to put index settings command
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexSettingsHandler
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
     * Handle index creation command
     *
     * @param Client $client
     * @param string $index
     */
    public function handle($client, $index)
    {
        $config = $this->configurationRepository->get($index);

        if (null === $client || null === $config) {
            throw new \InvalidArgumentException();
        }

        $client
            ->indices()
            ->putSettings([
                'index' => $index,
                'body'  => [
                    'settings' => $this->extractSettings($config),
                ],
            ])
        ;
    }
    
    /**
     * @return array
     */
    private function extractSettings($config)
    {
        if (isset($config['settings'])) {
            return $config['settings'];
        }

        return [];
    }
}
