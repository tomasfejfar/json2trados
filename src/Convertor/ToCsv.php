<?php

namespace TomasFejfar\Json2Trados\Convertor;

class ToCsv
{
    protected $originalFilePath;

    protected $outputFilePath;

    protected $pretranslatedFilePath;

    /**
     * ToCsv constructor.
     *
     * @param $originalFilePath
     * @param $outputFilePath
     */
    public function __construct(string $originalFilePath, string $outputFilePath)
    {
        $this->originalFilePath = $originalFilePath;
        $this->outputFilePath = $outputFilePath;
    }

    /**
     * @param mixed $pretranslatedFilePath
     */
    public function setPretranslatedFilePath($pretranslatedFilePath)
    {
        if (!is_readable($pretranslatedFilePath)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a pretranslatedFilePath file', $pretranslatedFilePath));
        }
        $this->pretranslatedFilePath = $pretranslatedFilePath;
    }

    /**
     * @param string $originalFilePath
     */
    public function setOriginalFilePath(string $originalFilePath)
    {
        if (!is_readable($originalFilePath)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a original file', $originalFilePath));
        }
        $this->originalFilePath = $originalFilePath;
    }

    /**
     * @param string $outputFilePath
     */
    public function setOutputFilePath(string $outputFilePath)
    {
        if (is_file($outputFilePath) && (!is_writable($outputFilePath))) {
            throw new \InvalidArgumentException(sprintf('"%s" is not writable', $outputFilePath));
        }
        $this->outputFilePath = $outputFilePath;
    }

    public function convert()
    {
        $original = (array) json_decode(file_get_contents($this->originalFilePath));
        $translation = [];
        if ($this->pretranslatedFilePath) {
            $translation = (array) json_decode(file_get_contents($this->pretranslatedFilePath));
        }

        $result = [];
        foreach ($original as $key => $value) {
            $result[$key] = [
                'key' => $key,
                'original' => $value,
                'translation' => $translation[$key] ?? ' ',
            ];
        }

        $writer = \League\Csv\Writer::createFromPath($this->outputFilePath, 'w+');
        $writer->insertAll($result);
        return true;
    }
}
