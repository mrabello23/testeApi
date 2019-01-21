<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransacaoApi;
use App\Http\Resources\TransacaoApiResource;
use App\Helper\CreditCardValidate;
use App\Helper\ApiRestCall;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transacao = TransacaoApi::all();
        return TransacaoApiResource::collection($transacao);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transacao = TransacaoApi::findOrFail($id);
        return new TransacaoApiResource($transacao);
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
            $data = $request->all();

            $msg = 'Transação foi recusada pela operadora.';
            $success = false;
            $status = 'RECUSADO';

            if (CreditCardValidate::luhnCheck($data['numero'])) {
                $msg = 'Transação foi autorizada pela operadora';
                $success = true;
                $status = 'AUTORIZADO';
            }

            $token = $this->generateToken($data);

            $transacao = new TransacaoApi;
            $transacao->token = $token;
            $transacao->status = $status;
            $transacao->save();

            return response()->json([
                'success' => $success,
                'message' => $msg,
                'codigo' => $token,
                'status' => $status
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage() ."\r\n". $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * [generateToken description]
     * @param  array  $dados [description]
     * @return [type]        [description]
     */
    public function generateToken(array $dados)
    {
        $token = '';
        $token .= $dados['numero'] . '_';
        $token .= $dados['vencimento'] . '_';
        $token .= $dados['codigo'] . '_';
        $token .= date('YmdHis');

        return md5($token);
    }

    public function generateCreditCard()
    {
        $api = ApiRestCall::postCall(
            'https://www.4devs.com.br/ferramentas_online.php',
            [
                'acao' => 'gerar_cc',
                'pontuacao' => 'N',
                'bandeira' => 'master'
            ]
        );

        preg_match_all('/id=\".*<span/m', $api, $matches);


        $retorno = [];

        $indice = [
            'cartao_numero' => 'numero',
            'data_validade' => 'vencimento',
            'codigo_seguranca' => 'codigo'
        ];

        foreach ($matches[0] as $key => $value) {
            preg_match('/".*?[ "]/m', $value, $matchKey);
            $k = current($matchKey);
            $k = trim(str_replace('"', '', $k));

            preg_match('/>.*</m', $value, $match);
            $v = current($match);
            $v = trim(str_replace('>', '', str_replace('<', '', $v)));

            $retorno[$indice[$k]] = $v;
        }

        return $retorno;
    }

    public function generateCardAccept()
    {
        $creditCard = $this->generateCreditCard();

        $transacao = new TransacaoApi;
        $transacao->token = $this->generateToken($creditCard);
        $transacao->status = 'AUTORIZADO';
        $transacao->save();

        return response()->json([
            'success' => true,
            'cartao' => $creditCard
        ], 200);
    }

    public function generateCardRefuse()
    {
        $creditCard = [
            'numero' => mt_rand(1111, 2222) . mt_rand(3333, 4444) . mt_rand(5555, 6666) . mt_rand(7777, 8888),
            'vencimento' => '01/9999',
            'codigo' => '666'
        ];

        $transacao = new TransacaoApi;
        $transacao->token = $this->generateToken($creditCard);
        $transacao->status = 'RECUSADO';
        $transacao->save();

        return response()->json([
            'success' => true,
            'cartao' => $creditCard
        ], 200);
    }

    public function generateCardRandom()
    {
        $validate = mt_rand(1, 6);

        if ($validate > 3) {
            return $this->generateCardAccept();
        }

        return $this->generateCardRefuse();
    }
}
