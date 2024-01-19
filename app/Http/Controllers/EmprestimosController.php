<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
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

    public function EmprestimosEspecificos($cliente_id)
    {
        try {
            $this->getID();
            $emprestimo = Emprestimos::where('users_id', $this->users_id)
                ->where('clientes_id', $cliente_id)
                ->with('clientes')
                ->get();

            return response()->json([
                'status' => true,
                'emprestimosEspecificos' => $emprestimo
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'erro no servidor',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }

    public function EmprestimosEmAbertoEspecifico($cliente_id)
    {
        try {
            $this->getID();
            $emprestimoAberto = Emprestimos::where('users_id', $this->users_id)
                ->where('clientes_id', $cliente_id)
                ->where('pago', 0)
                ->with('clientes')
                ->get();

            return response()->json([
                'status' => true,
                'emprestimosAbertosEspecificos' => $emprestimoAberto
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
            if (
                Emprestimos::create([
                    'descricao_emprestimo' => $descricao,
                    'valor_total' => $valor,
                    'valor_atual' => $valor,
                    'data_emprestimo' => $data,
                    'previsao_pagamento' => $previsao_pagamento,
                    'pago' => 0,
                    'metodo_emprestimo' => $metodo_emprestimo,
                    'clientes_id' => $clientes_id,
                    'users_id' => $this->users_id,
                ])
            ) {
                Clientes::where('id', $clientes_id)
                    ->increment('divida', $valor);
            }
            return response()->json(['status' => true, 'mensagem' => 'Emprestimo Cadastrado Com Sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $emprestimos = Emprestimos::where('id', $id)
                ->with('clientes')
                ->get();

            return response()->json(['emprestimos' => $emprestimos], 200);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], 500);
        }
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
                    'valor_total' => $valor,
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
            $cliente = Emprestimos::where('id', $id)
                ->pluck('clientes_id');

            $valor_emprestimo = Emprestimos::where('id', $id)
                ->pluck('valor_total');

            if (
                Emprestimos::where('id', $id)->delete()
            ) {
                Clientes::where('id', $cliente[0])
                    ->decrement('divida', $valor_emprestimo[0]);
            }
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
