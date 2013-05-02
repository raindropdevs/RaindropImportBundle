<?php

namespace Raindrop\ImportBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('raindrop_import');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->scalarNode('tmp_upload_dir')->defaultValue('/tmp')->cannotBeEmpty()->end()
                ->scalarNode('web_upload_dir')->defaultValue('%kernel.root_dir%/../web')->cannotBeEmpty()->end()
                ->scalarNode('resource_extension')->defaultValue('csv')->cannotBeEmpty()->end()
                ->scalarNode('config_extension')->defaultValue('yml')->cannotBeEmpty()->end()
                ->scalarNode('media_extension')->defaultValue('zip')->cannotBeEmpty()->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
