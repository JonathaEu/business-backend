<?php

namespace App\Http\Controllers;

use App\Models\Investimentos;
use Exception;
use Illuminate\Http\Request;

class InvestimentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private int $users_id;

    public function getID()
    {
        // Atribua o ID do usuário autenticado à propriedade user_id.
        $this->users_id = auth()->user()->id;
    }

    public function index()
    {
        try {
            $this->getID();
            $investimentos = Investimentos::where('users_id', $this->users_id);
            return response()->json(['status' => true, 'investimentos' => $investimentos], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $descricao = $request->descricao;
            $valor = str_replace(',', '.', $request->valor);
            $data = $request->data;
            $categoria_investimento = $request->categoria_investimento;
            $nome_investimento = $request->nome_investimento;

            Investimentos::create([
                'descricao_investimento' => $descricao,
                'categoria_investimento' => $categoria_investimento,
                'users_id' => $this->users_id,
                'nome_investimento' => $nome_investimento,
                'valor_investimento' => $valor,
                'data_aporte' => $data,
            ]);
            return response()->json(['status' => true, 'mensagem' => 'Investimento Cadastrado Com Sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Investimentos $investimentos)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $descricao = $request->descricao;
            $valor = str_replace(',', '.', $request->valor);
            $data = $request->data;
            $categoria_investimento = $request->categoria_investimento;
            $nome_investimento = $request->nome_investimento;

            $investimentos = new Investimentos;

            $investimentos->where('id', $id)
                ->update([
                    'descricao_investimento' => $descricao,
                    'categoria_investimento' => $categoria_investimento,
                    'users_id' => $this->users_id,
                    'nome_investimento' => $nome_investimento,
                    'valor_investimento' => $valor,
                    'data_aporte' => $data,
                ]);
            return response()->json(['status' => true, 'mensagem' => 'Investimento Atualizado Com Sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Investimentos::where('id', $id)->delete();

            return response()->json([
                'status' => true,
                'mensagem' => 'Investimento Apagado dos Registros Com Sucesso!',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro no Servidor!',
                'erro' => $e->getMessage()
            ], 500);
        }
    }
}
