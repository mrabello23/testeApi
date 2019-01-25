<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Helper\CreditCardValidate;
use App\Helper\ApiRestCall;
use App\Http\Controllers\ApiController;
use App\TransacaoApi;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_autorizar_transacao()
    {
        $responseGerarCartao = $this->get(env('APP_URL') . '/api/gerar-autorizado');
        $responseGerarCartao->assertOk();

        $dataArray1 = json_decode($responseGerarCartao->getContent(), true);

        $responseSalvar = $this->post(env('APP_URL') . '/api/autorizar-pagamento', $dataArray1['cartao']);
        $responseSalvar->assertOk();

        $dataArray2 = json_decode($responseSalvar->getContent(), true);

        $this->assertArrayHasKey('status', $dataArray2);
        $this->assertEquals('AUTORIZADO', $dataArray2['status']);
    }

    public function test_recusar_transacao()
    {
        $responseGerarCartao = $this->get(env('APP_URL') . '/api/gerar-recusado');
        $responseGerarCartao->assertOk();

        $dataArray1 = json_decode($responseGerarCartao->getContent(), true);

        $responseSalvar = $this->post(env('APP_URL') . '/api/autorizar-pagamento', $dataArray1['cartao']);
        $responseSalvar->assertOk();

        $dataArray2 = json_decode($responseSalvar->getContent(), true);

        $this->assertArrayHasKey('status', $dataArray2);
        $this->assertEquals('RECUSADO', $dataArray2['status']);
    }

    public function test_chamar_api_via_post()
    {
        $api = ApiRestCall::postCall(env('APP_URL') . '/api/autorizar-pagamento', [
            'numero' => '1234567891234567',
            'vencimento' => '12/2025',
            'codigo' => '999'
        ]);

        $dataArray = json_decode($api, true);
        $this->assertDatabaseHas('transacoes', ['token' => $dataArray['codigo'], 'status' => $dataArray['status']]);
    }

    public function test_chamar_api_via_get()
    {
        $api = ApiRestCall::getCall(env('APP_URL') . '/api/gerar-autorizado', []);
        $dataArray = json_decode($api, true);

        $this->assertArrayHasKey('cartao', $dataArray);
        $this->assertTrue($dataArray['success']);
    }

    public function test_gerar_cartao_que_sera_aprovado()
    {
        $response = $this->get(env('APP_URL') . '/api/gerar-autorizado');
        $response->assertOk();

        $dataArray = json_decode($response->getContent(), true);
        $check = (bool) CreditCardValidate::luhnCheck($dataArray['cartao']['numero']);

        $this->assertTrue($check);
    }

    public function test_gerar_cartao_que_sera_recusado()
    {
        $response = $this->get(env('APP_URL') . '/api/gerar-recusado');
        $response->assertOk();

        $dataArray = json_decode($response->getContent(), true);
        $check = (bool) CreditCardValidate::luhnCheck($dataArray['cartao']['numero']);

        $this->assertFalse($check);
    }
}
