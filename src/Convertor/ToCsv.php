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
    public function __construct($originalFilePath, $outputFilePath)
    {
        $this->originalFilePath = $originalFilePath;
        $this->outputFilePath = $outputFilePath;
    }

    /**
     * @param mixed $pretranslatedFilePath
     */
    public function setPretranslatedFilePath($pretranslatedFilePath)
    {
        $this->pretranslatedFilePath = $pretranslatedFilePath;
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
