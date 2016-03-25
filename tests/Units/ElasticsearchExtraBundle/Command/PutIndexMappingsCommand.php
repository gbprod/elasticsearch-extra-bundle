<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Command;

use atoum;
use mock\GBProd\ElasticsearchExtraBundle\Handler\PutIndexMappingsHandler;
use Symfony\Component\Console\Input\ArrayInput;
use mock\Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Tests for PutIndexMappingsCommand
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class PutIndexMappingsCommand extends atoum
{
    public function testCreateIndexCallsHandler()
    {
        $this
            ->given($this->newTestedInstance)
                ->and($handler = $this->newPutIndexMappingsHandler())
                ->and($container = $this->createContainer($handler))
                ->and($this->testedInstance->setContainer($container))
                ->and($input = new ArrayInput([
                    'client_id' => 'my_client', 
                    'index_id'  => 'my_index',
                ]))
                ->and($output = new OutputInterface())
            ->if($this->testedInstance->run($input, $output))
            ->then
                ->mock($handler)
                    ->call('handle')
                        ->withArguments('my_client', 'my_index')
                        ->once()
        ;
    }
    
    private function newPutIndexMappingsHandler()
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');
        
        $handler = new PutIndexMappingsHandler();
        
        $this->mockGenerator->unshuntParentClassCalls();
        
        return $handler;
    }
    
    public function createContainer($handler)
    {
        $container = new Container();
        $container->set(
            'gbprod.elasticsearch_extra.put_index_mappings_handler',
            $handler 
        );
        
        return $container;
    }
}