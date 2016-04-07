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
                ->arrayNode('indices')
                    ->defaultValue([])
                    ->prototype('array')
                        ->prototype('variable')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

