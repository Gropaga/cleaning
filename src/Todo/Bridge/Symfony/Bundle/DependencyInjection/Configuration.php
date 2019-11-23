<?php

declare(strict_types=1);

namespace CleaningCRM\Todo\Bridge\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('cleaningcms_todo');

        $treeBuilder
            ->getRootNode()
            ->children()
            ->end()
        ;

        return $treeBuilder;
    }
}
