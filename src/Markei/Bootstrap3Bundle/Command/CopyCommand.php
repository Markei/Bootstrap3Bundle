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

namespace Markei\Bootstrap3Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Console\Command\Command;

/**
 * This command copy the Bootstrap 3 files to the web directory
 *
 * @author maartendekeizer
 * @copyright Markei.nl
 */
class CopyCommand extends Command
{
    private $params = [];

    public function __construct(array $params)
    {
        parent::__construct('markei:bootstrap3:copy');
        $this->params = $params;
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();

        $output->writeln('// Copy Bootstrap 3 files');

        $continue = $this->checkSourceFiles($this->params, $output);
        if ($continue === false) {
            return;
        }

        $continue = $this->createDestinationDirectories($this->params, $output);
        if ($continue === false) {
            return;
        }

        $continue = $this->copyFiles($this->params, $output);
        if ($continue === false) {
            return;
        }
    }

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $this->setDescription('Copy the Bootstrap 3 files to the web directory');
    }

    /**
     * Check if all source files and/or directories exists
     * @param array $params
     * @param OutputInterface $output
     */
    protected function checkSourceFiles(array $params, OutputInterface $output)
    {
        $fs = new Filesystem();

        $listOfSourceFiles = [
            $params['src_bootstrap_css'],
            $params['src_bootstrap_js'],
            $params['src_bootstrap_fonts'],
            $params['src_jquery_js'],
        ];

        $output->writeln('');
        $output->writeln('Check if source files and directories exists');
        $output->writeln('');
        $error = false;

        foreach ($listOfSourceFiles as $sourceFile) {
            $output->write(' ' . $sourceFile);
            if ($fs->exists($sourceFile) === false) {
                $error = true;
                $output->writeln(' <error>FAIL</error>');
            } else {
                $output->writeln(' <info>OK</info>');
            }
        }


        if ($error === true) {
            $output->writeln(' <error>[ERROR]</error> Not all sources exists, please fix this first');
            return false;
        }

        $output->writeln('');
        $output->writeln(' <info>[OK]</info> All source files and directories exists');
        $output->writeln('');
        return true;
    }

    /**
     * Create destination directories if not exists
     * @param array $params
     * @param OutputInterface $output
     */
    protected function createDestinationDirectories(array $params, OutputInterface $output)
    {
        $fs = new Filesystem();

        $listOfDestinationDirectories = [
            dirname($params['dst_bootstrap_css']),
            dirname($params['dst_bootstrap_js']),
            $params['dst_bootstrap_fonts'],
            dirname($params['dst_jquery_js']),
        ];

        $output->writeln('');
        $output->writeln('Create destination directories');
        $output->writeln('');
        $error = false;

        // creating destination directories
        foreach ($listOfDestinationDirectories as $destinationDirectory) {
            $output->write(' ' . $destinationDirectory);
            if ($fs->exists($destinationDirectory) === false) {
                $output->write(' <comment>create</comment>');
                try {
                    $fs->mkdir($destinationDirectory);
                    $output->writeln(' <info>OK</info>');
                } catch (IOException $e) {
                    $error = true;
                    $output->writeln(' <error>' . $e->getMessage() . '</error>');
                }
            } else {
                $output->writeln(' <info>OK</info>');
            }
        }

        if ($error === true) {
            $output->writeln(' <error>[ERROR]</error> Not all destination directories can be created, please fix this first');
            return false;
        }

        $output->writeln('');
        $output->writeln(' <info>[OK]</info> All destination directories exists');
        $output->writeln('');
        return true;
    }

    /**
     * Copy the files
     * @param array $params
     * @param OutputInterface $output
     */
    protected function copyFiles(array $params, OutputInterface $output)
    {
        $fs = new Filesystem();

        $listOfFilesToCopy = [
            // dst => src
            $params['dst_bootstrap_css'] => $params['src_bootstrap_css'],
            $params['dst_bootstrap_js'] => $params['src_bootstrap_js'],
            $params['dst_jquery_js'] => $params['src_jquery_js'],
        ];
        $fontFileFinder = Finder::create()->files()->name('*.eot')->name('*.ttf')->name('*.woff')->name('*.woff2')->name('*.svg')->in($params['src_bootstrap_fonts']);
        foreach ($fontFileFinder as $fontFile) {
            $listOfFilesToCopy[$params['dst_bootstrap_fonts'] . DIRECTORY_SEPARATOR . $fontFile->getFileName()] = $fontFile->getPathName();
        }

        $output->writeln('');
        $output->writeln('Copy files');
        $output->writeln('');
        $error = false;

        foreach ($listOfFilesToCopy as $dst => $src) {
            $output->writeln(' Copy: ' . basename($dst));
            $output->writeln('  from: ' . $src);
            $output->writeln('  to: ' . $dst);
            try {
                $fs->copy($src, $dst, true);
                $output->writeln('  <info>OK</info>');
            } catch (IOException $e) {
                $output->writeln('  <error>ERROR</error> ' . $e->getMessage());
            } catch (FileNotFoundException $e) {
                $output->writeln('  <error>ERROR</error> ' . $e->getMessage());
            }
        }

        return true;
    }
}
