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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MarkeiBootstrap3Extension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('markei_bootstrap3.src_bootstrap_css', $config['src_bootstrap_css']);
        $container->setParameter('markei_bootstrap3.src_bootstrap_js', $config['src_bootstrap_js']);
        $container->setParameter('markei_bootstrap3.src_bootstrap_fonts', $config['src_bootstrap_fonts']);
        $container->setParameter('markei_bootstrap3.src_jquery_js', $config['src_jquery_js']);
        $container->setParameter('markei_bootstrap3.dst_bootstrap_css', $config['dst_bootstrap_css']);
        $container->setParameter('markei_bootstrap3.dst_bootstrap_js', $config['dst_bootstrap_js']);
        $container->setParameter('markei_bootstrap3.dst_bootstrap_fonts', $config['dst_bootstrap_fonts']);
        $container->setParameter('markei_bootstrap3.dst_jquery_js', $config['dst_jquery_js']);
    }
}
