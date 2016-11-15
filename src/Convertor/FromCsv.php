<?php

namespace TomasFejfar\Json2Trados\Convertor;

class FromCsv
{
    protected $outputPath;

    protected $inputPath;

    protected $columnNumber;

    /**
     * FromCsv constructor.
     *
     * @param string $outputPath
     * @param string $inputPath
     * @param int $columnNumber
     */
    public function __construct(string $outputPath, string $inputPath, int $columnNumber = 2)
    {
        $this->outputPath = $outputPath;
        $this->inputPath = $inputPath;
        $this->columnNumber = $columnNumber;
    }

    public function convert(): bool
    {
        $reader = \League\Csv\Reader::createFromPath($this->inputPath);
        $reader->stripBom(true);
        $data = $reader->fetchAll();
        $result = new \stdClass();
        foreach ($data as $value) {
            $result->{$value[0]} = $value[$this->columnNumber];
        }
        return file_put_contents($this->outputPath, json_encode($result, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
}
