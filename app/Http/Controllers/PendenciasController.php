<?php

namespace App\Http\Controllers;

use App\Models\Pendencias;
use Exception;
use Illuminate\Http\Request;

class PendenciasController extends Controller
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
            $pendencias = Pendencias::where('users_id', $this->users_id)
                ->with('categoriaGastos')
                ->get();

            return response()->json([
                'status' => true,
                'pendencias' => $pendencias

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro no servidor',
                'erro' => $e->getMessage(), 500
            ]);
        }
    }

    public function PendenciasEmAberto()
    {
        try {
            $this->getID();
            $pendencias = Pendencias::where('users_id', $this->users_id)
                ->where('debito_total', 0)
                ->with('categoriaGastos')
                ->get();

            return response()->json([
                'status' => true,
                'pendenciasEmAberto' => $pendencias

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro no servidor',
                'erro' => $e->getMessage(), 500
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->getID();
            $categoria_gastos_id = $request->categoria_gastos_id;
            $valor_pendencia = $request->valor_pendencia;
            $quem_recebe = $request->quem_recebe;
            $data_pendencia = $request->data_pendencia;
            $descricao_pendencia = $request->descricao_pendencia;
            $parcelas = $request->parcelas;

            Pendencias::create([
                'categoria_gastos_id' => $categoria_gastos_id,
                'valor_total' => $valor_pendencia,
                'valor_atual' => $valor_pendencia,
                'quem_recebe' => $quem_recebe,
                'data_pendencia' => $data_pendencia,
                'descricao_pendencia' => $descricao_pendencia,
                'parcelas' => $parcelas,
                'users_id' => $this->users_id,
                'debito_total' => 0,
            ]);

            return response()->json([
                'status' => true,
                'mensagem' => 'Pendencia Registrada Com Sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro no servidor',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendencias $pendencias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $this->getID();
            $categoria_gastos_id = $request->categoria_gastos_id;
            $valor_pendencia = $request->valor_pendencia;
            $quem_recebe = $request->quem_recebe;
            $data_pendencia = $request->data_pendencia;
            $descricao_pendencia = $request->descricao_pendencia;
            $parcelas = $request->parcelas;

            Pendencias::where('id', $id)
                ->update([
                    'categoria_gastos_id' => $categoria_gastos_id,
                    'valor_pendencia' => $valor_pendencia,
                    'quem_recebe' => $quem_recebe,
                    'data_pendencia' => $data_pendencia,
                    'descricao_pendencia' => $descricao_pendencia,
                    'parcelas' => $parcelas,
                    'users_id' => $this->users_id,
                ]);

            return response()->json([
                'status' => true,
                'mensagem' => 'Pendencia Atualizada Com Sucesso',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro no servidor',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Pendencias::where('id', $id)->delete();

            return response()->json([
                'status' => true,
                'mensagem' => "Pendecia Removida Com Sucesso"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro no servidor',
                'erro' => $e->getMessage()
            ], 500);
        }
    }
}
