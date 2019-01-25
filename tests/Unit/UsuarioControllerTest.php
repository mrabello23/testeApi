<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\UsuarioController;
use App\Usuario;

class UsuarioControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_salvar_usuario()
    {
        $response = $this->post(env('APP_URL') . '/save-usuario', [
            'nome' => 'Mock Usuario Test',
            'email' => 'test@email.com.br',
            'cpf' => '888.999.777-66',
            'logradouro' => 'Rua teste da silva',
            'bairro' => 'Centro',
            'cep' => '00000-000',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
            'telefone' => [
                '(11) 98888-1111',
                '(11) 92222-5555'
            ]
        ]);

        $this->assertDatabaseHas('usuarios', ['email' => 'test@email.com.br', 'cpf' => '888.999.777-66']);

        $this->assertDatabaseHas('telefones', ['numero' => '(11) 98888-1111']);
        $this->assertDatabaseHas('telefones', ['numero' => '(11) 92222-5555']);
    }

    public function test_proibido_cadastrar_usuario_sem_email_ou_cpf()
    {
        $response = $this->post(env('APP_URL') . '/save-usuario', [
            'nome' => 'Mock Usuario Test',
            'email' => '',
            'cpf' => '',
            'logradouro' => 'Rua teste da silva',
            'bairro' => 'Centro',
            'cep' => '00000-000',
            'cidade' => 'São Paulo',
            'estado' => 'SP'
        ]);

        $response->assertStatus(500);
        $this->assertDatabaseMissing('usuarios', ['email' => '', 'cpf' => '']);
    }

    public function test_salvar_telefones_para_um_usuario()
    {
        $user = factory(Usuario::class)->create(['id' => 5000]);
        (new UsuarioController)->storeTelefones(['(11) 99999-0000'], $user->id);

        $this->assertDatabaseHas('telefones', ['numero' => '(11) 99999-0000', 'id_usuario' => 5000]);
    }
}
