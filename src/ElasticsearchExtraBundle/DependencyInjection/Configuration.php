<?php

namespace GBProd\ElasticsearchExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 * 
 * @author gbprod <contact@gb-prod.fr>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('elasticsearch_extra_bundle');
        
        $rootNode
            ->children()
                ->scalarNode('default_client')->end()
                ->arrayNode('clients')
                    ->useAttributeAsKey('id')
                    ->prototype('array')
                    ->children()
                        ->arrayNode('indices')
                            ->prototype('variable')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}