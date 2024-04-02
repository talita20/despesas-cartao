<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use function App\Helpers\checkDocument;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_document_valid()
    {
        $expected = '87484182427';
        $actual = checkDocument('87484182427');
        $this->assertEquals($expected, $actual);
    }
    
    public function test_document_invalid()
    {
        $this->assertFalse(checkDocument('00000000000'));
    }
    
    public function test_document_invalid_size()
    {
        $this->assertFalse(checkDocument('0000000000'));
    }
}
