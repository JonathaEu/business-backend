<?php

namespace App\Http\Controllers;

use App\Models\Investimentos;
use App\Models\Rendimentos;
use Exception;
use Illuminate\Http\Request;

class RendimentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private int $users_id;

    public function getID()
    {
        $this->users_id = auth()->user()->id;
    }
    public function index()
    {
        try {
            $this->getID();
            $investimentosRendimentos = Investimentos::where('users_id', $this->users_id)
                ->with('rendimentos')
                ->with('categoriaInvestimentos')
                ->get();
            $rendimentos = [];
            $teste = [];
            foreach ($investimentosRendimentos as $IR) {
                $nome_investimento = $IR->nome_investimento;
                foreach ($IR->rendimentos as $rendimento) {
                    $json = [
                        "id" => $rendimento->id,
                        "nome_investimento" => $nome_investimento,
                        // "categoria_investimentos" => $categoria_investimentos,
                        "investimento_id" => $rendimento->investimentos_id,
                        "valor_rendimento" => $rendimento->valor_rendimento,
                        "data_rendimento" => $rendimento->data_rendimento,
                    ];
                    array_push($rendimentos, $json);
                }
            }

            return response()->json([
                'status' => true,
                'rendimentos' => $rendimentos,
                // 'teste' => $teste
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'erro no servidor',
                'erro' => $e->getMessage()
            ], 500);
        }

    }

    public function store(Request $request)
    {
        try {
            Rendimentos::create([
                'investimentos_id' => $request->investimentos_id,
                'valor_rendimento' => $request->valor_rendimento,
                'data_rendimento' => $request->data_rendimento,
            ]);

            return response()->json([
                'status' => true,
                'mensagem' => 'Rendimento Registrado Com Sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'erro no servidor',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rendimentos $rendimentos)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            Rendimentos::where('id', $id)
                ->update([
                    'investimentos_id' => $request->investimentos_id,
                    'valor_rendimento' => $request->valor_rendimento,
                    'data_rendimento' => $request->data_rendimento,
                ]);

            return response()->json([
                'status' => true,
                'mensagem' => 'Rendimento Atualizado Com Sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'erro no servidor',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rendimentos $rendimentos)
    {
        //
    }
}
