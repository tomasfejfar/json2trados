<?php

namespace TomasFejfar\Json2Trados\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TomasFejfar\Json2Trados\Convertor\ToCsv;

class ToTrados extends Command
{
    const OPTION_PRETRANSLATED = 'pretranslated';

    const ARG_ORIGINAL = 'original';

    const ARG_OUTPUT = 'output';

    protected function configure()
    {
        $this
            ->setName('trados:to')
            ->setDescription('Convert json(s) to bilingual CSV for Trados')
            ->addArgument(self::ARG_ORIGINAL, InputArgument::REQUIRED, 'JSON file containing original (e.g.: "key" : "value_en")')
            ->addOption(self::OPTION_PRETRANSLATED, 'p', InputOption::VALUE_REQUIRED, 'JSON file containing translation (e.g.: "key" : "value_cs")')
            ->addArgument(self::ARG_OUTPUT, InputArgument::REQUIRED, 'File to output result to');;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $originalFilePath = $input->getArgument(self::ARG_ORIGINAL);
        if (!is_readable($originalFilePath)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a original file', $originalFilePath));
        }
        $outputFilePath = $input->getArgument(self::ARG_OUTPUT);
        if (is_file($outputFilePath) && (!is_writable($outputFilePath))) {
            throw new \InvalidArgumentException(sprintf('"%s" is not writable', $outputFilePath));
        }
        $convertor = new ToCsv($originalFilePath, $outputFilePath);

        $pretranslatedFilePath = $input->getOption(self::OPTION_PRETRANSLATED);
        if ($pretranslatedFilePath) {
            if (!is_readable($pretranslatedFilePath)) {
                throw new \InvalidArgumentException(sprintf('"%s" is not a pretranslatedFilePath file', $pretranslatedFilePath));
            }
            $convertor->setPretranslatedFilePath($pretranslatedFilePath);
        }
        $output->writeln(sprintf('<comment>Converting "%s" to "%s".</comment>', $originalFilePath, $outputFilePath));
        $convertor->convert();
        $output->writeln('<info>Conversion successful.</info>');
    }
}
