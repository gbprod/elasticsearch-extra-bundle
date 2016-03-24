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
     * @param string $clientId
     * @param string $indexId
     * 
     * @return Elasticsearch\Client
     */
    public function get($clientId, $indexId)
    {
        if (!isset($this->config[$clientId])) {
            return null;
        }
        
        if (!isset($this->config[$clientId]['indices'][$indexId])) {
            return null;
        }

        return $this->config[$clientId]['indices'][$indexId];
    }
}