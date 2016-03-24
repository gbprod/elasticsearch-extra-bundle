<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\Command;

use atoum;
use mock\GBProd\ElasticsearchExtraBundle\Handler\DeleteIndexHandler;
use Symfony\Component\Console\Input\ArrayInput;
use mock\Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Container;

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
                ->and($container = $this->createContainer($handler))
                ->and($this->testedInstance->setContainer($container))
                ->and($input = new ArrayInput([
                    'client_id' => 'my_client', 
                    'index_id'  => 'my_index',
                    '--force'   => true,
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
    
    private function newDeleteIndexHandler()
    {
        $this->mockGenerator->shuntParentClassCalls();
        $this->mockGenerator->orphanize('__construct');
        
        $handler = new DeleteIndexHandler();
        
        $this->mockGenerator->unshuntParentClassCalls();
        
        return $handler;
    }
    
    public function createContainer($handler)
    {
        $container = new Container();
        $container->set(
            'gbprod.elasticsearch_extra.delete_index_handler',
            $handler 
        );
        
        return $container;
    }
    
    public function testDeleleDoesnotCallHandlerIfNotForced()
    {
        $this
            ->given($this->newTestedInstance)
                ->and($handler = $this->newDeleteIndexHandler())
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
                        ->never()
        ;
    }
}