<?php

namespace Cedric\RecaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

/**
 * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
 */

public function getConfigTreeBuilder()
{
    $treeBuilder = new TreeBuilder('recaptcha');

    $treeBuilder->getRootNode()
        ->children()
            ->scalarNode('key')
                ->isRequired()        
            ->end()
            ->scalarNode('secret')
                ->isRequired()        
            ->end()  
        ->end()    
    ;
    
    return $treeBuilder;
}

}