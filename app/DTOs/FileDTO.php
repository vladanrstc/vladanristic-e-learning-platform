<?php

namespace App\DTOs;

class FileDTO {

    /**
     * @var string
     */
    private string $fullFileName;

    /**
     * @var string
     */
    private string $fileContents;

    /**
     * @param string $fullFileName
     * @param string $fileContents
     */
    public function __construct(string $fullFileName, string $fileContents)
    {
        $this->fullFileName = $fullFileName;
        $this->fileContents = $fileContents;
    }

    /**
     * @return string
     */
    public function getFullFileName(): string
    {
        return $this->fullFileName;
    }

    /**
     * @param string $fullFileName
     */
    public function setFullFileName(string $fullFileName): void
    {
        $this->fullFileName = $fullFileName;
    }

    /**
     * @return string
     */
    public function getFileContents(): string
    {
        return $this->fileContents;
    }

    /**
     * @param string $fileContents
     */
    public function setFileContents(string $fileContents): void
    {
        $this->fileContents = $fileContents;
    }

}
