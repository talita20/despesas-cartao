<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use function App\Helpers\checkTypeDocument;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function test_document_cpf_valid()
    {
        $this->assertTrue(checkTypeDocument('87484182427'));
    }
    
    public function test_document_cpf_invalid()
    {
        $this->assertFalse(checkTypeDocument('00000000000'));
    }
    
    public function test_document_cpf_invalid_size()
    {
        $this->assertFalse(checkTypeDocument('0000000000'));
    }
    
    public function test_document_cpf_empty()
    {
        $this->assertFalse(checkTypeDocument(''));
    }
    
    public function test_document_cnpj_valid()
    {
        $this->assertTrue(checkTypeDocument('17985413000175'));
    }
    
    public function test_document_cnpj_invalid()
    {
        $this->assertFalse(checkTypeDocument('00000000000000'));
    }
    
    public function test_document_cnpj_invalid_size()
    {
        $this->assertFalse(checkTypeDocument('000000000000000'));
    }
    
    public function test_document_cnpj_empty()
    {
        $this->assertFalse(checkTypeDocument(''));
    }
}
