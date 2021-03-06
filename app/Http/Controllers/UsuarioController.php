<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Telefone;
use Illuminate\Support\Facades\Log;
use App\Helper\Valida;

class UsuarioController extends Controller
{
    const ESTADOS = [
        'AC','AL','AP','AM','BA','CE','DF','ES','GO',
        'MA','MT','MS','MG','PA','PB','PR','PE','PI',
        'RJ','RN','RS','RO','RR','SC','SP','SE','TO'
    ];

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastro', ['estados' => self::ESTADOS]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $form = $request->all();
            $form = Valida::validaEntrada($form, ['cpf', 'email']);

            $usuario = new Usuario;
            $usuario->nome = $form['nome'];
            $usuario->email = $form['email'];
            $usuario->cpf = $form['cpf'];
            $usuario->logradouro = $form['logradouro'];
            $usuario->bairro = $form['bairro'];
            $usuario->cep = $form['cep'];
            $usuario->cidade = $form['cidade'];
            $usuario->estado = $form['estado'];

            if (!$usuario->save()) {
                throw new Exception("Erro ao criar Usuario");
            }

            Log::info('Usuario '.$usuario->id.' criado com sucesso!');
            $this->storeTelefones($form['telefone'], $usuario->id);

            // return $form;
            return view('assinatura', [
                'usuario' => Usuario::findOrFail($usuario->id),
                'plano' => \App\Plano::all()
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage() ."\r\n". $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * [storeTelefones description]
     * @param  array  $telefones
     * @param  int    $id_usuario
     * @return boolean
     */
    public function storeTelefones(array $telefones, $id_usuario)
    {
        try {
            if (empty($telefones)) {
                return false;
            }

            foreach ($telefones as $tel) {
                $telefone = new Telefone;
                $telefone->numero = $tel;
                $telefone->id_usuario = $id_usuario;

                if (!$telefone->save()) {
                    throw new Exception("Erro ao criar Telefone");
                }

                Log::info('Telefone '.$telefone->id.' criado com sucesso!');
            }

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage() ."\r\n". $e->getTraceAsString());
            throw $e;
        }
    }
}
