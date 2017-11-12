<?php namespace Minhbang\File\Tests;

use Minhbang\File\Tests\Stubs\TestCase;

/**
 * Class HelpersTest
 * @package Minhbang\File\Tests
 * @author Minh Bang
 */
class HelpersTest extends TestCase
{
    public function testGetPath()
    {
        $this->assertEquals('abc', mb_get_path('abc'));
        $this->assertEquals(realpath(base_path()), mb_get_path('base:'));
        $this->assertEquals(realpath(public_path('upload')), mb_get_path('public:upload'));
        $this->assertEquals(__DIR__ . "/Stubs/public/upload", mb_get_path('public:upload'));
        $this->assertEquals(__DIR__ . "/Stubs/public/upload", mb_get_path('upload:'));
        $this->assertEquals(__DIR__ . "/Stubs/data", mb_get_path('data:'));
    }

    public function testUploadPath(){
        $this->assertEquals(__DIR__ . "/Stubs/public/upload", upload_path());
        $this->assertEquals(__DIR__ . "/Stubs/public/upload/abc", upload_path('abc'));
    }
    public function testDataPath(){
        $this->assertEquals(__DIR__ . "/Stubs/data", data_path());
        $this->assertEquals(__DIR__ . "/Stubs/data/abc", data_path('abc'));
    }
}