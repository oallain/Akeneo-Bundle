<?php

namespace Splash\Akeneo\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

class SplashAkeneoExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $container->setParameter('splash_akeneo',    array_merge($config, Yaml::parseFile(__DIR__.'/../Resources/config/products.yml')));
        
        //====================================================================//
        // Add Bundle Objects to Splash Parameters
        $Splash                 =   $container->getParameter('splash');
        $Splash["objects"][]    =   "Splash\Akeneo\Objects\Product";

        //====================================================================//
        // Add Bundle Widgets to Splash Parameters
//        $Splash["widgets"][]    =   "Splash\Local\Widgets\DefaultWidget";
        $Splash["widgets"][]    =   "Splash\Local\Widgets\SelfTest";

        //====================================================================//
        // Setup App Logo
        $Splash["infos"]["logo"]    =   "/bundles/pimui/images/logo.svg";
                
        //====================================================================//
        // Update Splash Bundle Parameters
        $container->setParameter('splash',$Splash);
        
    }
}