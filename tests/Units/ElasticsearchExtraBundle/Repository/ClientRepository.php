<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Repository;

use atoum;
use mock\Elasticsearch\Client;

/**
 * Tests for ClientRepository
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class ClientRepository extends atoum
{
    public function testGetReturnsClient()
    {
        $this
            ->given($clients = ['my_client' => $this->newClient()])
            ->and($this->newTestedInstance($clients))
            ->if($client = $this->testedInstance->get('my_client'))
            ->then
                ->object($client)
                    ->isIdenticalTo($clients['my_client'])
        ;
            
    }
    
    private function newClient()
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');

        $client = new Client();
        
        $this->mockGenerator->unshuntParentClassCalls();
    
        return $client;
    }
    
    public function testGetReturnsNullIfNotSets()
    {
        $this
            ->given($clients = ['my_client' => $this->newClient()])
            ->and($this->newTestedInstance($clients))
            ->if($client = $this->testedInstance->get('not_a_client'))
            ->then
                ->variable($client)
                    ->isNull()
        ;
    }
}