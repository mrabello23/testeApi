<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransacaoApi;
use App\Http\Resources\TransacaoApiResource;
use App\Helper\CreditCardValidate;
use App\Helper\ApiRestCall;
use Illuminate\Support\Facades\Log;
use Faker;

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

            if (!isset($data['numero']) || empty($data['numero'])) {
                throw new InvalidArgumentException('Parâmetro "numero" vazio ou não informado.');
            }

            if (!isset($data['vencimento']) || empty($data['vencimento'])) {
                throw new InvalidArgumentException('Parâmetro "vencimento" vazio ou não informado.');
            }

            if (!isset($data['codigo']) || empty($data['codigo'])) {
                throw new InvalidArgumentException('Parâmetro "codigo" vazio ou não informado.');
            }

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

            if (!$transacao->save()) {
                throw new Exception('Erro ao salvar transação.');
            }

            Log::info('Transação '.$transacao->id.' criada com sucesso! [Token: '.$transacao->token.' | Status: '.$transacao->status.']');

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
     * @return string
     */
    private function generateToken(array $dados)
    {
        $token = '';
        $token .= $dados['numero'] . '_';
        $token .= $dados['vencimento'] . '_';
        $token .= $dados['codigo'] . '_';
        $token .= date('YmdHis');

        return md5($token);
    }

    /**
     * [generateCreditCard description]
     * https://github.com/fzaninotto/Faker
     * @return array
     */
    private function generateCreditCard($valid = true)
    {
        $faker = Faker\Factory::create('pt_BR');
        $numero = $faker->creditCardNumber;

        if (!$valid) {
            $numero = 1122334455667788;
        }

        return [
            'tipo' => $faker->creditCardType,
            'numero' => $numero,
            'vencimento' => $faker->creditCardExpirationDateString,
            'codigo' => rand(100, 999)
        ];
    }

    public function generateCardAccept()
    {
        try {
            $creditCard = $this->generateCreditCard();

            $transacao = new TransacaoApi;
            $transacao->token = $this->generateToken($creditCard);
            $transacao->status = 'AUTORIZADO';

            if (!$transacao->save()) {
                throw new Exception('Erro ao salvar transação para cartão autorizado');
            }

            return response()->json([
                'success' => true,
                'cartao' => $creditCard
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage() ."\r\n". $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function generateCardRefuse()
    {
        try {
            $creditCard = $this->generateCreditCard(false);

            $transacao = new TransacaoApi;
            $transacao->token = $this->generateToken($creditCard);
            $transacao->status = 'RECUSADO';

            if (!$transacao->save()) {
                throw new Exception('Erro ao salvar transação para cartão recusado');
            }

            return response()->json([
                'success' => true,
                'cartao' => $creditCard
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage() ."\r\n". $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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
