<?php

namespace TomasFejfar\Json2Trados\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TomasFejfar\Json2Trados\Convertor\FromCsv;
use TomasFejfar\Json2Trados\Convertor\ToCsv;

class FromTrados extends Command
{
    const OPTION_COLUMN_NUMBER = 'column-number';

    const ARG_INPUT = 'input';

    const ARG_OUTPUT = 'output';

    protected function configure()
    {
        $this
            ->setName('trados:from')
            ->setDescription('Convert CSV from Trados back to JSON')
            ->addOption(self::OPTION_COLUMN_NUMBER, 'c', InputOption::VALUE_REQUIRED, 'Column with translation to generate (1st column is 0)', 2)
            ->addArgument(self::ARG_INPUT, InputArgument::REQUIRED, 'Translated CSV from trados')
            ->addArgument(self::ARG_OUTPUT, InputArgument::REQUIRED, 'File to output result to');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputPath = $input->getArgument(self::ARG_INPUT);
        if (!is_readable($inputPath)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not readable', $inputPath));
        }

        $columnNumber = $input->getOption(self::OPTION_COLUMN_NUMBER);
        if (!is_numeric($columnNumber) || $columnNumber < 0) {
            throw new \InvalidArgumentException(sprintf('"%s" must be greater than zero', $columnNumber));
        }

        $outputPath = $input->getArgument(self::ARG_OUTPUT);
        if (is_file($outputPath) && (!is_writable($outputPath))) {
            throw new \InvalidArgumentException(sprintf('"%s" is not writable', $outputPath));
        }
        $convertor = new FromCsv($outputPath, $inputPath, $columnNumber);
        $output->writeln(sprintf('<comment>Converting "%s" to "%s".</comment>', $inputPath, $outputPath));
        $convertor->convert();
        $output->writeln('<info>Conversion successful.</info>');
    }
}
