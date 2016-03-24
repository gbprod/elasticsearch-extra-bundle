<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Handler;

use atoum;
use mock\Elasticsearch\Client;
use mock\Elasticsearch\Namespaces\IndicesNamespace;
use mock\GBProd\ElasticsearchExtraBundle\Repository\ClientRepository;
use mock\GBProd\ElasticsearchExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Tests for DeleteIndexHandler
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class DeleteIndexHandler extends atoum
{
    public function testHandle()
    {
        $this
            ->given($config = ['my' => ['awesome' => 'config']])
                ->and($indices = $this->newIndices())
                ->and($client = $this->newClient($indices))
                ->and($clientRepository = $this->newClientRepository('my_client', $client))
                ->and($configRepository = $this->newConfigRepository('my_client', 'my_index', $config))
                ->and($this->newTestedInstance($clientRepository, $configRepository))
            ->if($this->testedInstance->handle('my_client', 'my_index'))
            ->then
                ->mock($indices)
                    ->call('delete')
                        ->withArguments([
                                'index' => 'my_index',
                            ]
                        )
                        ->once()
        ;
    }
    
    private function newIndices()
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');

        return new IndicesNamespace();
    }
    
    private function newClient($indices)
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');

        $client = new Client();
        
        $this->calling($client)->indices = function() use ($indices) {
            return $indices;
        };
        
        return $client;
    }
    
    private function newClientRepository($clientId, $client)
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');

        $clientRepository = new ClientRepository();
        
        $this->calling($clientRepository)->get = 
            function($id) use ($clientId, $client) {
                if ($id == $clientId) {
                    return $client;
                }
                
                return null;
            }
        ;

        $this->mockGenerator->unshuntParentClassCalls();

        return $clientRepository;
    }
    
    private function newConfigRepository($clientId, $indexId, $config)
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');

        $configRepository = new IndexConfigurationRepository();
        
        $this->calling($configRepository)->get = 
            function($clientIdParam, $indexIdParam) use ($clientId, $indexId, $config) {
                if ($clientId == $clientIdParam && $indexId == $indexIdParam) {
                    return $config;
                }
                
                return null;
            }
        ;

        $this->mockGenerator->unshuntParentClassCalls();
        
        return $configRepository;
    }
    
    public function testHandleThrowExceptionIfNoClient()
    {
        $this
            ->given($config = ['my' => ['awesome' => 'config']])
                ->and($indices = $this->newIndices())
                ->and($client = $this->newClient($indices))
                ->and($clientRepository = $this->newClientRepository('my_client', null))
                ->and($configRepository = $this->newConfigRepository('my_client', 'my_index', $config))
                ->and($this->newTestedInstance($clientRepository, $configRepository))
            ->exception(function() {
                    $this->testedInstance->handle('my_client', 'my_index');
                })
                ->isInstanceOf(\InvalidArgumentException::class)
        ;
    }
}