<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class JsonToCsv extends Command
{
    protected function configure()
    {
        $this
            ->setName('json2csv')
            ->setDescription('Convert two jsons to bilingual CSV')
            ->addArgument('original', InputArgument::REQUIRED, 'JSON with original (e.g.: "key" : "value_en")')
            ->addOption('translation', 't', InputOption::VALUE_REQUIRED, 'JSON with translation (e.g.: "key" : "value_cs")')
            ->addArgument('output', InputArgument::REQUIRED, 'File to output result to');
        ;
    }
}
