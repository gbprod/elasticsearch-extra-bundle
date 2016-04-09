<?php

namespace GBProd\ElasticsearchExtraBundle\Handler;

use Elasticsearch\Client;
use GBProd\ElasticsearchExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Handler to put index mappings command
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexMappingsHandler
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
    public function handle(Client $client, $index, $type)
    {
        $config = $this->configurationRepository->get($index);

        if ($this->isInvalid($config, $type)) {
            throw new \InvalidArgumentException();
        }

        $client
            ->indices()
            ->putMapping([
                'index' => $index,
                'type'  => $type,
                'body'  => [
                    $type => $config['mappings'][$type],
                ],
            ])
        ;
    }

    private function isInvalid($config, $type)
    {
        return null === $config
            || empty($type)
            || !isset($config['mappings'])
            || !isset($config['mappings'][$type])
        ;
    }
}
