<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Helper\CreditCardValidate;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_aprovar_transacao()
    {
        $this->assertTrue(true);
    }

    public function test_recusar_transacao()
    {
        $this->assertTrue(true);
    }

    public function test_gerar_cartao_aprovado()
    {
        $response = $this->get(env('APP_URL') . '/api/gerar-autorizado');
        $response->assertStatus(200);

        $dataJson = $response->getContent();
        $dataArray = json_decode($dataJson, true);
        $check = (bool) CreditCardValidate::luhnCheck($dataArray['cartao']['numero']);

        $this->assertTrue($check);
    }

    // public function test_gerar_cartao_recusado()
    // {
    //     $response = $this->get(env('APP_URL') . '/api/gerar-recusado');
    //     $response->assertStatus(200);

    //     $dataJson = $response->getContent();
    //     $dataArray = json_decode($dataJson, true);
    //     $check = (bool) CreditCardValidate::luhnCheck($dataArray['cartao']['numero']);

    //     $this->assertFalse($check);
    // }
}
