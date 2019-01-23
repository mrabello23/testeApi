<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssinaturaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function salvar_assinatura()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function buscar_assinatura_por_id()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function pribido_salvar_assinatura_sem_salvar_transacao_na_api()
    {
        $this->assertTrue(true);
    }
}
