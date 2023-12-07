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
    public function index()
    {
        try {
            $investimentos = Investimentos::all();
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

            Investimentos::create([
                'descricao_investimento' => $descricao,
                'valor_investimento' => $valor,
                'data_investimento' => $data,
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
     * Show the form for editing the specified resource.
     */
    public function edit(Investimentos $investimentos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Investimentos $investimentos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Investimentos $investimentos)
    {
        //
    }
}
