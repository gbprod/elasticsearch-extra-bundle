<?php

namespace GBProd\ElasticsearchExtraBundle\Repository;

/**
 * Repository for index configuration
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class IndexConfigurationRepository
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     * Get client from his name
     *
     * @param string $index
     *
     * @return Elasticsearch\Client
     */
    public function get($index)
    {
        if (!isset($this->config[$index])) {
            return null;
        }

        return $this->config[$index];
    }
}
