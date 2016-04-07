<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Command;

use mock\Elasticsearch\Client;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\Container;
use atoum;
use mock\GBProd\ElasticsearchExtraBundle\Handler\CreateIndexHandler;
use mock\Symfony\Component\Console\Output\OutputInterface;

/**
 * Tests for CreateIndexCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CreateIndexCommand extends atoum
{
    public function testCreateIndexCallsHandler()
    {
        $this
            ->given($this->newTestedInstance)
                ->and($handler = $this->newCreateIndexHandler())
                ->and($client = $this->newClient())
                ->and($container = $this->createContainer($client, $handler))
                ->and($this->testedInstance->setContainer($container))
                ->and($input = new ArrayInput([
                    'index'    => 'my_index',
                    '--client' => 'my_client',
                ]))
                ->and($output = new OutputInterface())
            ->if($this->testedInstance->run($input, $output))
            ->then
                ->mock($handler)
                    ->call('handle')
                        ->withArguments($client, 'my_index')
                        ->once()
        ;
    }

    private function newCreateIndexHandler()
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');

        $handler = new CreateIndexHandler();

        $this->mockGenerator->unshuntParentClassCalls();

        return $handler;
    }

    private function newClient()
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');

        $client = new Client();

        $this->mockGenerator->unshuntParentClassCalls();

        return $client;
    }

    public function createContainer($client, $handler)
    {
        $container = new Container();

        $container->set('gbprod.elasticsearch_extra.create_index_handler', $handler);
        $container->set('m6web_elasticsearch.client.my_client', $client);

        return $container;
    }
}
