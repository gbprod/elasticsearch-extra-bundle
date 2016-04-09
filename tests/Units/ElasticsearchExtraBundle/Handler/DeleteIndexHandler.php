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
                ->and($this->newTestedInstance())
            ->if($this->testedInstance->handle($client, 'my_index'))
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
}
