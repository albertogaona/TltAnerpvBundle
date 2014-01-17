<?php

namespace Tlt\AnerpvBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TltAnerpvExtension extends Extension
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
        
        if (!isset($config['key']))
        {
        	throw new \InvalidArgumentException('tlt_anerpv: Debe proporcionar la opcion "key"');
        	
        }
        $container->setParameter('tlt_anerpv.key', $config['key']);
        if (isset($config['base_uri']))
        {
        	$container->setParameter('tlt_anerpv.base_uri', $config['base_uri']);
        }
    }
}
