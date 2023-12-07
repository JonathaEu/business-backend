<?php

namespace App\Http\Controllers;

use App\Models\emprestimos;
use Exception;
use Illuminate\Http\Request;

class EmprestimosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $emprestimos = Emprestimos::all();
            return response()->json(['status' => true, 'emprestimos' => $emprestimos], 200);
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
            $previsao_pagamento = $request->previsao_pagamento;
            $cliente_id = $request->cliente_id;

            emprestimos::create([
                'descricao_emprestimo' => $descricao,
                'valor_emprestimo' => $valor,
                'data_emprestimo' => $data,
                'previsao_emprestimo' => $previsao_pagamento,
                'cliente_id' => $cliente_id,
            ]);
            return response()->json(['status' => true, 'mensagem' => 'Emprestimo Cadastrado Com Sucesso'], 200);

        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(emprestimos $emprestimos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, emprestimos $emprestimos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(emprestimos $emprestimos)
    {
        //
    }
}
