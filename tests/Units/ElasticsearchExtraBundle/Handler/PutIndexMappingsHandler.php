<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Handler;

use atoum;
use mock\Elasticsearch\Client;
use mock\Elasticsearch\Namespaces\IndicesNamespace;
use mock\GBProd\ElasticsearchExtraBundle\Repository\ClientRepository;
use mock\GBProd\ElasticsearchExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Tests for PutIndexMappingssHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexMappingsHandler extends atoum
{
    public function testHandle()
    {
        $config = [
            'mappings' => [
                'my_type' => ['config'],
                'my_type_2' => ['config'],
            ],
            'foo' => 'bar',
        ];

        $this
            ->given($config)
                ->and($indices = $this->newIndices())
                ->and($client = $this->newClient($indices))
                ->and($configRepository = $this->newConfigRepository('my_index', $config))
                ->and($this->newTestedInstance($configRepository))
            ->if($this->testedInstance->handle($client, 'my_index', 'my_type'))
            ->then
                ->mock($indices)
                    ->call('putMapping')
                        ->withArguments(
                            [
                                'index' => 'my_index',
                                'type'  => 'my_type',
                                'body'  => [
                                    'my_type' => ['config'],
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

    private function newConfigRepository($index, $config)
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');

        $configRepository = new IndexConfigurationRepository();

        $this->calling($configRepository)->get =
            function($indexParam) use ($index, $config) {
                if ($index == $indexParam) {
                    return $config;
                }

                return null;
            }
        ;

        $this->mockGenerator->unshuntParentClassCalls();

        return $configRepository;
    }
}
