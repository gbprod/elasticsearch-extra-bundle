<?php

namespace GBProd\ElasticsearchExtraBundle\Repository;

use Elasticsearch\Client;

/**
 * Repository for clients
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class ClientRepository
{
    /**
     * @var array<Client>
     */
    private $clients;
    
    /**
     * @param array $clients
     */
    public function __construct(array $clients = array())
    {
        $this->clients = $clients; 
    }
    
    /**
     * Get client from his id
     * 
     * @param string $id
     * 
     * @return Elasticsearch\Client
     */
    public function get($id)
    {
        if (!isset($this->clients[$id])) {
            return null;
        }
        
        return $this->clients[$id];
    }
}