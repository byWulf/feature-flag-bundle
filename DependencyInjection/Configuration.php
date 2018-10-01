<?php
declare(strict_types=1);

namespace Shopping\FeatureFlagBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('shopping_feature_flag');

        $rootNode
            ->children()
                ->arrayNode('providers')
                    ->children()
                        ->arrayNode('cookie')
                            ->canBeEnabled()
                            ->children()
                                ->arrayNode('values')
                                    ->useAttributeAsKey('featureFlag')
                                    ->scalarPrototype()
                                        ->isRequired()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('userAgent')
                            ->canBeEnabled()
                            ->children()
                                ->arrayNode('values')
                                    ->useAttributeAsKey('featureFlag')
                                    ->scalarPrototype()
                                        ->isRequired()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('dotEnv')
                            ->canBeEnabled()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}