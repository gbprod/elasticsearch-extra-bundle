<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Command;

use mock\Elasticsearch\Client;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\Container;
use atoum;
use mock\GBProd\ElasticsearchExtraBundle\Handler\DeleteIndexHandler;
use mock\Symfony\Component\Console\Output\OutputInterface;

/**
 * Tests for CreateIndexCommand
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class DeleteIndexCommand extends atoum
{
    public function testDeleleIndexCallsHandler()
    {
        $this
            ->given($this->newTestedInstance)
                ->and($handler = $this->newDeleteIndexHandler())
                ->and($client = $this->newClient())
                ->and($container = $this->createContainer($client, $handler))
                ->and($this->testedInstance->setContainer($container))
                ->and($input = new ArrayInput([
                    '--client' => 'my_client',
                    'index'    => 'my_index',
                    '--force'  => true,
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

    private function newDeleteIndexHandler()
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');

        $handler = new DeleteIndexHandler();

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

        $container->set('gbprod.elasticsearch_extra.delete_index_handler', $handler);
        $container->set('m6web_elasticsearch.client.my_client', $client);

        return $container;
    }

    public function testDeleleDoesnotCallHandlerIfNotForced()
    {
        $this
            ->given($this->newTestedInstance)
                ->and($handler = $this->newDeleteIndexHandler())
                ->and($client = $this->newClient())
                ->and($container = $this->createContainer($client, $handler))
                ->and($this->testedInstance->setContainer($container))
                ->and($input = new ArrayInput([
                    '--client' => 'my_client',
                    'index'    => 'my_index',
                ]))
                ->and($output = new OutputInterface())
            ->if($this->testedInstance->run($input, $output))
            ->then
                ->mock($handler)
                    ->call('handle')
                        ->never()
        ;
    }
}
