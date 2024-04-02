<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\CardController;
use Tests\TestCase;

use function App\Helpers\checkFormatDate;

class CardTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_format_date_valid()
    {
        $this->assertTrue(checkFormatDate("01/25"));
    }

    public function test_format_date_invalid_month()
    {
        $this->assertFalse(checkFormatDate("13/25"));
    }
    
    public function test_format_date_invalid_year()
    {
        $this->assertFalse(checkFormatDate("01/23"));
    }
    
    public function test_format_date_empty()
    {
        $this->assertFalse(checkFormatDate(""));
    }

    public function test_getCardBalance_valid()
    {
        $expected = 5000;
        $actual = CardController::getCardBalance(1);
        $this->assertEquals($expected, $actual);
    }
}
