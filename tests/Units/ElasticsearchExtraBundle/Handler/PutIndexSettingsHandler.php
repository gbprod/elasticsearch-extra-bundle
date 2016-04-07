<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Handler;

use atoum;
use mock\Elasticsearch\Client;
use mock\Elasticsearch\Namespaces\IndicesNamespace;
use mock\GBProd\ElasticsearchExtraBundle\Repository\ClientRepository;
use mock\GBProd\ElasticsearchExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Tests for PutIndexSettingsHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexSettingsHandler extends atoum
{
    public function testHandle()
    {
        $config = [
            'settings' => [
                'awesome' => 'config'
                ],
            'foo' => 'bar',
        ];

        $this
            ->given($config)
                ->and($indices = $this->newIndices())
                ->and($client = $this->newClient($indices))
                ->and($configRepository = $this->newConfigRepository($client, 'my_index', $config))
                ->and($this->newTestedInstance($configRepository))
            ->if($this->testedInstance->handle($client, 'my_index'))
            ->then
                ->mock($indices)
                    ->call('putSettings')
                        ->withArguments(
                            [
                                'index' => 'my_index',
                                'body'  => [
                                    'settings' => ['awesome' => 'config']
                                ],
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
}
