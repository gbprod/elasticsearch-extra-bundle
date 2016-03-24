<?php

namespace GBProd\Tests\Units\ElasticsearchExtraBundle\DependencyInjection;

use atoum;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use GBProd\ElasticsearchExtraBundle\Handler\CreateIndexHandler;
use GBProd\ElasticsearchExtraBundle\Repository\ClientRepository;
use GBProd\ElasticsearchExtraBundle\Repository\IndexConfigurationRepository;
use Elasticsearch\Client;

/**
 * Tests for Extension class
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class ElasticsearchExtraExtension extends atoum
{
    public function testLoadCreateServices()
    {
        $container = new ContainerBuilder();
        $this
            ->given($extension = $this->newTestedInstance)
            ->if($extension->load([], $container))
            ->then
                ->object($container->get('gbprod.elasticsearch_extra.create_index_handler'))
                    ->isInstanceOf(CreateIndexHandler::class)
            ->then
                ->object($container->get('gbprod.elasticsearch_extra.client_repository'))
                    ->isInstanceOf(ClientRepository::class)
            ->then
                ->object($container->get('gbprod.elasticsearch_extra.index_configuration_repository'))
                    ->isInstanceOf(IndexConfigurationRepository::class)
        ;
    }
    
    public function testLoadSetIndexConfigurations()
    {
        $configs = [
            [
                'clients' => [
                    'my_client' => [
                        'indices' => [
                            'my_index' => []
                        ]
                    ]
                ]
            ]
        ];
        
        $container = new ContainerBuilder();
        $this
            ->given($extension = $this->newTestedInstance)
            ->if($extension->load($configs, $container))
            ->then
                ->array(
                    $container
                    ->getDefinition('gbprod.elasticsearch_extra.index_configuration_repository')
                    ->getArgument(0)
                )
                    ->isEqualTo([
                        'my_client' => [
                            'indices' => [
                                'my_index' => []
                            ]
                        ]
                    ])
        ;
    }
    
    public function testLoadSetClients()
    {
        $configs = [
            [
                'clients' => [
                    'my_client' => [
                        'indices' => [
                            'my_index' => []
                        ]
                    ],
                    'my_client_2' => [
                        'indices' => [
                            'my_index_2' => []
                        ]
                    ]
                ]
            ]
        ];
        
        $container = new ContainerBuilder();
        $container->register(
            'm6web_elasticsearch.client.my_client',
            Client::class
        );
        
        $this
            ->given($extension = $this->newTestedInstance)
            ->if($extension->load($configs, $container))
            ->then
                ->array(
                    $argument = $container
                        ->getDefinition('gbprod.elasticsearch_extra.client_repository')
                        ->getArgument(0)
                    )
                    ->isNotEmpty()
                ->object($argument[0])
                    ->isInstanceOf(Reference::class)
                ->string($argument[0]->__toString())
                    ->isEqualTo('m6web_elasticsearch.client.my_client')
                ->object($argument[1])
                    ->isInstanceOf(Reference::class)
                ->string($argument[1]->__toString())
                    ->isEqualTo('m6web_elasticsearch.client.my_client_2')
        ;
    }
}