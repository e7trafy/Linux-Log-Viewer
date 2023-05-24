<?php

use App\FileReader;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FileReaderTest extends TestCase
{
    private $testFilePath;

    protected function setUp(): void
    {

        // Set the path of the test file within the system's temporary directory
        $this->testFilePath = sys_get_temp_dir() . '/test_file.txt';

        // Create the test file with sample content
        $content = "Line 1\nLine 2\nLine 3\nLine 4\nLine 5";
        file_put_contents($this->testFilePath, $content);
    }

    protected function tearDown(): void
    {
        // Remove the test file after running the tests
        unlink($this->testFilePath);
    }

    public function testConstructorValidation()
    {
        // Test with a file path outside of the /var/log directory
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid file path. The file must be within the /var/log directory.');
        $fileReader = new FileReader('test_file.txt', 3);

        // Test with a non-existent file path in the /var/log directory
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid file path. The file must be within the /var/log directory.');
        $fileReader = new FileReader('/non_existent_file.txt', 3);
    }

    public function testGetLines()
    {
        $fileReader = new FileReader($this->testFilePath, 3);
        $expected_lines = [
            "Line 1",
            "Line 2",
            "Line 3",
        ];

        $actual_lines = $fileReader->getLines(1);
        $this->assertEquals($expected_lines, $actual_lines);

        $expected_lines = [
            "Line 4",
            "Line 5",
        ];

        $actual_lines = $fileReader->getLines(2);
        $this->assertEquals($expected_lines, $actual_lines);
    }

    public function testGetTotalPages()
    {
        $fileReader = new FileReader($this->testFilePath, 3);
        $this->assertEquals(2, $fileReader->getTotalPages());

        $fileReader = new FileReader($this->testFilePath, 5);
        $this->assertEquals(1, $fileReader->getTotalPages());
    }
}
