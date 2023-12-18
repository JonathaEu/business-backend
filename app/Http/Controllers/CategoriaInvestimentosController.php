<?php

namespace App\Http\Controllers;

use App\Models\CategoriaInvestimentos;
use Exception;
use Illuminate\Http\Request;

class CategoriaInvestimentosController extends Controller
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
        $this->getID();
        try {
            $categoria_investimentos = CategoriaInvestimentos::where('users_id', $this->users_id)
                ->get();
            return response()->json([
                'status' => true,
                'categoria_investimentos' => $categoria_investimentos
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $categoriaInvestimentos = $request->categoria_investimentos;

            CategoriaInvestimentos::create([
                'categoria_investimentos' => $categoriaInvestimentos,
                'users_id' => $this->users_id,
            ]);
            return response()->json([
                'status' => true,
                'mensagem' => 'Categoria de Investimento Cadastrada com Sucesso'
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
    public function show(CategoriaInvestimentos $categoriaInvestimentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, CategoriaInvestimentos $categoriaInvestimentos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriaInvestimentos $categoriaInvestimentos)
    {
        //
    }
}
