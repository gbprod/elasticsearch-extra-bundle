<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Command;

use atoum;
use mock\Elasticsearch\Client;
use mock\GBProd\ElasticsearchExtraBundle\Handler\PutIndexSettingsHandler;
use mock\Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\DependencyInjection\Container;

/**
 * Tests for PutIndexSettingsCommandœ
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexSettingsCommand extends atoum
{
    public function testCreateIndexCallsHandler()
    {
        $this
            ->given($this->newTestedInstance)
                ->and($handler = $this->newPutIndexSettingsHandler())
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
                        ->withArguments($client, 'my_index')
                        ->once()
        ;
    }

    private function newPutIndexSettingsHandler()
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');

        $handler = new PutIndexSettingsHandler();

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

        $container->set('gbprod.elasticsearch_extra.put_index_settings_handler', $handler);
        $container->set('m6web_elasticsearch.client.my_client', $client);

        return $container;
    }
}
