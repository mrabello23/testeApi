<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assinatura;
use App\Helper\ApiRestCall;
use Illuminate\Support\Facades\Log;

class AssinaturaController extends Controller
{
    /**
     * Display all resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assinatura = Assinatura::all();
        return view('', $assinatura);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assinatura = Assinatura::findOrFail($id);
        return view('', $assinatura);
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
            $transacao = (isset($form['transacao']) ? $form['transacao'] : null);

            if (!$transacao) {
                $api = ApiRestCall::postCall(url('/api/autorizar-pagamento'), [
                    'numero' => $form['numero'],
                    'vencimento' => $form['vencimento'],
                    'codigo' => $form['codigo']
                ]);

                $transacao = json_decode($api, true);
            }

            if (!$transacao['codigo'] || !$transacao['status']) {
                throw new Exception('Erro ao registrar a transação na API.');
            }

            $assinatura = new Assinatura;
            $assinatura->codigo = $transacao['codigo'];
            $assinatura->status = $transacao['status'];
            $assinatura->cartao = $form['numero'];
            $assinatura->vencimento = $form['vencimento'];
            $assinatura->cod_cartao = $form['codigo'];
            $assinatura->id_usuario = $form['usuario'];
            $assinatura->id_plano = $form['plano'];

            if (!$assinatura->save()) {
                throw new Exception('Erro ao finalizar a assinatura.');
            }

            return view('assinatura-finalizada', [
                'usuario' => \App\Usuario::findOrFail($form['usuario']),
                'plano' => \App\Plano::findOrFail($form['plano']),
                'transacao' => $transacao,
                'assinatura' => $assinatura,
                'success' => true
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage() ."\r\n". $e->getTraceAsString());

            return view('assinatura-finalizada', [
                'transacao' => $transacao,
                'numero' => $form['numero'],
                'vencimento' => $form['vencimento'],
                'codigo' => $form['codigo'],
                'usuario' => $form['usuario'],
                'plano' => $form['plano'],
                'success' => false
            ]);
        }
    }

    public function generateCardAccept()
    {
        return ApiRestCall::getCall(url('/api/gerar-autorizado'), []);
    }

    public function generateCardRefuse()
    {
        return ApiRestCall::getCall(url('/api/gerar-recusado'), []);
    }

    public function generateCardRandom()
    {
        return ApiRestCall::getCall(url('/api/gerar-aleatorio'), []);
    }
}
