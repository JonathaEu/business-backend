<?php

namespace App\Http\Controllers;

use App\Models\Emprestimos;
use Exception;
use Illuminate\Http\Request;

class EmprestimosController extends Controller
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
            $Emprestimos = Emprestimos::where('users_id', $this->users_id)
                ->with('clientes')
                ->get();
            return response()->json(['status' => true, 'Emprestimos' => $Emprestimos], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }

    }

    public function EmprestimosEmAberto()
    {
        try {
            $this->getID();
            $emprestimoAberto = Emprestimos::where('users_id', $this->users_id)
                ->where('pago', 0)
                ->with('clientes')
                ->get();

            return response()->json([
                'status' => true,
                'Emprestimos' => $emprestimoAberto
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'erro no servidor',
                'erro' => $e->getMessage(),
            ], 500);
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
            $previsao_pagamento = $request->previsao_pagamento;
            $clientes_id = $request->clientes_id;
            $metodo_emprestimo = $request->metodo_emprestimo;
            $this->getID();

            Emprestimos::create([
                'descricao_emprestimo' => $descricao,
                'valor_emprestimo' => $valor,
                'data_emprestimo' => $data,
                'previsao_pagamento' => $previsao_pagamento,
                'pago' => 0,
                'metodo_emprestimo' => $metodo_emprestimo,
                'clientes_id' => $clientes_id,
                'users_id' => $this->users_id,
            ]);
            return response()->json(['status' => true, 'mensagem' => 'Emprestimo Cadastrado Com Sucesso'], 200);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Emprestimos $Emprestimos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $descricao = $request->descricao;
            $valor = str_replace(',', '.', $request->valor);
            $data = $request->data;
            $previsao_pagamento = $request->previsao_pagamento;
            $clientes_id = $request->clientes_id;
            $metodo_emprestimo = $request->metodo_emprestimo;
            $this->getID();

            $emprestimos = new Emprestimos;

            $emprestimos->where('id', $id)
                ->update([
                    'descricao_emprestimo' => $descricao,
                    'valor_emprestimo' => $valor,
                    'data_emprestimo' => $data,
                    'previsao_pagamento' => $previsao_pagamento,
                    'clientes_id' => $clientes_id,
                    'metodo_emprestimo' => $metodo_emprestimo,
                ]);

            return response()->json([
                'status' => true,
                'mensagem' => 'Empréstimo Atualizado Com Sucesso!',
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
    public function destroy($id)
    {
        try {
            Emprestimos::where('id', $id)->delete();

            return response()->json([
                'status' => true,
                'mensagem' => 'Empréstimo Deletado Com Sucesso'
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
