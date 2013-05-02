<?php

namespace Raindrop\ImportBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RaindropImportExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('raindrop_import.tmp_upload_dir', $config['tmp_upload_dir']);
        $container->setParameter('raindrop_import.web_upload_dir', $config['web_upload_dir']);
        $container->setParameter('raindrop_import.resource_extension', $config['resource_extension']);
        $container->setParameter('raindrop_import.config_extension', $config['config_extension']);
        $container->setParameter('raindrop_import.media_extension', $config['media_extension']);
    }
}
