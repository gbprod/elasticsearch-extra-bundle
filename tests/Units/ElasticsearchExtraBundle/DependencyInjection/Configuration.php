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
                [
                    'clients' => [
                        'my_client' => [
                        ],                        
                        'my_client_2' => [
                        ],
                    ]
                ]
            ])
            ->if($processed = $this->process($config))
            ->then
                ->array($processed['clients'])
                    ->isNotEmpty()
                    ->hasKey('my_client')
                ->array($processed['clients']['my_client'])
                    ->hasKey('indices')
                ->array($processed['clients']['my_client']['indices'])
                    ->isEqualTo([])
        ;
    }
 
 
    public function testIndexIsVariable()
    {
        $this
            ->given($this->newTestedInstance)
            ->and($config = [
                [
                    'clients' => [
                        'my_client' => [
                            'indices' => [
                                'index_1' => [
                                    'foo' => [
                                        'bar',
                                    ],
                                ],
                                'index_2' => [
                                    'fizz' => [
                                    ],
                                    'mapping' => [
                                    ],
                                ],
                            ]
                        ],
                    ]
                ]
            ])
            ->if($processed = $this->process($config))
            ->then
                ->array($processed['clients']['my_client']['indices'])
                    ->hasKey('index_1')
                ->array($processed['clients']['my_client']['indices']['index_1'])
                    ->isEqualTo([
                            'foo' => [
                                'bar',
                            ],
                        ]
                    )
        ;
    }
}