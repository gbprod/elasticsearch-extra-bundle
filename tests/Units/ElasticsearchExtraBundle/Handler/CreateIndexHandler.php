<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Handler;

use atoum;
use mock\Elasticsearch\Client;
use mock\Elasticsearch\Namespaces\IndicesNamespace;
use mock\GBProd\ElasticsearchExtraBundle\Repository\ClientRepository;
use mock\GBProd\ElasticsearchExtraBundle\Repository\IndexConfigurationRepository;

/**
 * Tests for CreateIndexHandler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CreateIndexHandler extends atoum
{
    public function testHandle()
    {
        $this
            ->given($config = ['my' => ['awesome' => 'config']])
                ->and($indices = $this->newIndices())
                ->and($client = $this->newClient($indices))
                ->and($configRepository = $this->newConfigRepository('my_index', $config))
                ->and($this->newTestedInstance($configRepository))
            ->if($this->testedInstance->handle($client, 'my_index'))
            ->then
                ->mock($indices)
                    ->call('create')
                        ->withArguments(
                            [
                                'index' => 'my_index',
                                'body'  => $config,
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
