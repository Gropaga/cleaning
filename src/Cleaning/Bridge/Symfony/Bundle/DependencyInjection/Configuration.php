<?php

declare(strict_types=1);

namespace CleaningCRM\Cleaning\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {

        dd(123);

        $treeBuilder = new TreeBuilder('cleaningcms_cleaning');

        $treeBuilder
            ->getRootNode()
            ->children()
            ->end()
        ;

        return $treeBuilder;
    }
}
