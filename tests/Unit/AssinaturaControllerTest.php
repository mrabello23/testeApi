<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\AssinaturaController;
use App\Assinatura;
use App\Usuario;
use App\Plano;

class AssinaturaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_salvar_assinatura()
    {
        $response = $this->post(env('APP_URL') . '/save-assinatura', [
            'transacao' => [
                'codigo' => '6as4d89as4das4d65as4d65as4d89as4',
                'status' => 'AUTORIZADO',
            ],
            'numero' => '1234567891234567',
            'vencimento' => '12/2025',
            'codigo' => '999',
            'usuario' => factory(Usuario::class)->create(['id' => 5000])->id,
            'plano' => factory(Plano::class)->create(['id' => 6000])->id,
        ]);

        $this->assertDatabaseHas('assinaturas', ['codigo' => '6as4d89as4das4d65as4d65as4d89as4']);
    }

    public function test_pribido_salvar_assinatura_sem_salvar_transacao_na_api()
    {
        $response = $this->post(env('APP_URL') . '/save-assinatura', ['codigo' => '10000']);
        $response->assertStatus(500);

        $this->assertDatabaseMissing('assinaturas', ['codigo' => '10000']);
    }

    public function test_pribido_salvar_assinatura_sem_dados_cartao()
    {
        $response = $this->post(env('APP_URL') . '/save-assinatura', ['transacao' => [''], 'codigo' => '10000']);
        $this->assertDatabaseMissing('assinaturas', ['codigo' => '10000']);
    }
}
