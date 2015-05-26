<?php

namespace Invit\SeoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class InvitSeoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        //$configuration = new Configuration();
        //$config = $this->processConfiguration($configuration, $configs);

        $config = $configs[0];

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $definition = $container->getDefinition('invit.seo.page');

        if(isset($config['title_main'])){
            $definition->addMethodCall('setMainTitle', array($config['title_main']));
        }
        $definition->addMethodCall('setTranslationDomain', array($config['translation_domain']));

        $container->setParameter('invit.seo.page.encoding', $config['encoding']);
        $container->setParameter('invit.seo.page.metas_translatable', $config['metas_translatable']);
        $container->setParameter('invit.seo.page.metas', $config['metas']);
        $container->setParameter('invit.seo.page.title_translatable', $config['title']);
    }
}
