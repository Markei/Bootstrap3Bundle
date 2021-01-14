<?php
/*
 * Copyright (c) 2016 Markei.nl
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Markei\Bootstrap3Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('markei_bootstrap3');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()
            ->scalarNode('src_bootstrap_css')
                ->defaultValue('%kernel.root_dir%/../vendor/twbs/bootstrap/dist/css/bootstrap.min.css')
                ->end()
            ->scalarNode('src_bootstrap_js')
                ->defaultValue('%kernel.root_dir%/../vendor/twbs/bootstrap/dist/js/bootstrap.min.js')
                ->end()
            ->scalarNode('src_bootstrap_fonts')
                ->defaultValue('%kernel.root_dir%/../vendor/twbs/bootstrap/fonts')
                ->end()
            ->scalarNode('src_jquery_js')
                ->defaultValue('%kernel.root_dir%/../vendor/components/jquery/jquery.min.js')
                ->end()
            ->scalarNode('dst_bootstrap_css')
                ->defaultValue('%kernel.root_dir%/../public/vendor/twbs/bootstrap/css/bootstrap.min.css')
                ->end()
            ->scalarNode('dst_bootstrap_js')
                ->defaultValue('%kernel.root_dir%/../public/vendor/twbs/bootstrap/js/bootstrap.min.js')
                ->end()
            ->scalarNode('dst_bootstrap_fonts')
                ->defaultValue('%kernel.root_dir%/../public/vendor/twbs/bootstrap/fonts')
                ->end()
            ->scalarNode('dst_jquery_js')
                ->defaultValue('%kernel.root_dir%/../public/vendor/twbs/bootstrap/js/jquery.min.js')
                ->end()
        ;

        return $treeBuilder;
    }
}
