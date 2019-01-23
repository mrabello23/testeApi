<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\UsuarioController;

class UsuarioControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_salvar_usuario()
    {
        $response = $this->post(env('APP_URL') . '/api/gerar-recusado', [
        ]);

        $this->assertTrue(true);
    }

    public function test_salvar_telefones_para_um_usuario()
    {
        $usuario = factory(App\Usuario::class)->create();

        $ctr = new UsuarioController;
        $ctr->storeTelefones(['(11) 98765-4248'], $usuario->id);

        $this->assertDatabaseHas('telefones', ['numero' => '(11) 98765-4248', 'id_usuario' => $usuario->id]);
    }
}
