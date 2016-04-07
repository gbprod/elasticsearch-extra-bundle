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
                    ->hasKey('indices')
                ->array($processed['indices'])
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
                    'indices' => [
                        'my_index' => [
                        ],
                        'my_index_2' => [
                        ],
                    ]
                ]
            ])
            ->if($processed = $this->process($config))
            ->then
                ->array($processed['indices'])
                    ->isNotEmpty()
                    ->hasKey('my_index')
                    ->hasKey('my_index_2')
        ;
    }


    public function testIndexIsVariable()
    {
        $this
            ->given($this->newTestedInstance)
            ->and($config = [
                [
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
                ]
            ])
            ->if($processed = $this->process($config))
            ->then
                ->array($processed['indices'])
                    ->hasKey('index_1')
                ->array($processed['indices']['index_1'])
                    ->isEqualTo([
                            'foo' => [
                                'bar',
                            ],
                        ]
                    )
        ;
    }
}
