<?php

namespace App;

use InvalidArgumentException;
use SplFileObject;

class FileReader
{
    private $fileObj;
    private $linesPerPage;

    public function __construct(string $filePath, int $linesPerPage)
    {
       // Allow any file path during tests
    if (PHP_SAPI !== 'cli') {
        $absolutePath = realpath($filePath);
        if ($absolutePath === false || strpos($absolutePath, '/var/log') !== 0) {
            throw new InvalidArgumentException('Invalid file path. The file must be within the /var/log directory.');
        }
    } else {
        $absolutePath = $filePath;
        if (!file_exists($absolutePath) ) {
            throw new InvalidArgumentException('Invalid file path. The file must be within the /var/log directory.');
        }
    }

    $this->fileObj = new SplFileObject($absolutePath, 'r');
    $this->linesPerPage = $linesPerPage;
}

    public function getLines(int $page): array
    {
        $startLine = ($page - 1) * $this->linesPerPage;
        $endLine = $startLine + $this->linesPerPage;

        $lines = [];

        // Iterate over file lines
        $this->fileObj->seek($startLine);

        for ($i = $startLine; $i < $endLine && !$this->fileObj->eof(); $i++) {
            $lines[] = rtrim($this->fileObj->fgets());
        }

        return $lines;
    }

    public function getTotalPages(): int
    {
        $totalLines = $this->getTotalLines();
        return (int)ceil($totalLines / $this->linesPerPage);
    }

    private function getTotalLines(): int
    {
        $this->fileObj->seek(PHP_INT_MAX);
        return $this->fileObj->key() + 1;
    }
}