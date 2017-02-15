<?php
namespace SqlCs\Configuration;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class SqlCsConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sql_cs');

        $rootNode
            ->children()
                ->arrayNode('table')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('maxlength')
                        ->defaultValue(25)
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;


        return $treeBuilder;
    }
}
