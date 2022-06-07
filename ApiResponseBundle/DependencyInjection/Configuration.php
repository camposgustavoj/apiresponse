<?php

namespace MJYDH\ApiResponseBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpKernel\Kernel;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('mjydh_apiresponse');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->scalarNode('ministerio')
                    ->defaultValue('MJyDH')
                    ->example('Nombre Ministerios')
                    ->info('Nombre del Ministerio')
                ->end()
                ->scalarNode('nombre')
                    ->defaultValue('Sectorial Informatica')
                    ->example('Sistema de Acceso')
                    ->info('Nombre del sistema que exporte el API')
                ->end()
                ->scalarNode('secretaria')
                    ->defaultValue('Sectorial Informatica')
                    ->example('Sectorial Informatica')
                    ->info('Nombre de la Secretaria a la que pertenece el sistema')
                ->end()
                ->scalarNode('version')
                    ->defaultValue('0.0.1')
                    ->example('*.*.*')
                    ->info('Versión del API que se expone')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
