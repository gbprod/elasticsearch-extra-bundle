<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\DependencyInjection;

use atoum;
use Symfony\Component\Config\Definition\Processor;

/**
 * Configuration
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class Configuration extends atoum
{
    public function testEmptyConfiguration()
    {
        
        $this
            ->given($this->newTestedInstance)
            ->and($config = [])
            ->if($processed = $this->process($config))
            ->then
                ->array($processed)
                    ->hasKey('clients')
                ->array($processed['clients'])
                    ->isEmpty()
        ;
    }
    
    protected function process($config)
    {
        $processor = new Processor();
        
        return $processor->processConfiguration(
            $this->testedInstance, 
            $config
        );
    }

    public function testEmptyIndicesConfiguration()
    {
        
        $this
            ->given($this->newTestedInstance)
            ->and($config = [
                'clients' => [
                    'my_client' => [
                        'indices' => [],
                    ],
                ]
            ])
            ->if($processed = $this->process($config))
            ->then
                ->array($processed)
                    ->hasKey('clients')
                ->array($processed['clients'])
                    ->isNotEmpty()
        ;
    }
    
}