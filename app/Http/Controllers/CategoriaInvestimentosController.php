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
                ->select(
                    'id as value',
                    'categoria_investimentos as label'
                )
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
            $this->getID();
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
    public function update(Request $request, $id)
    {
        try {
            $this->getID();
            $categoriaInvestimentos = $request->categoria_investimentos;

            CategoriaInvestimentos::where('id', $id)
                ->update([
                    'categoria_investimentos' => $categoriaInvestimentos,
                    'users_id' => $this->users_id,
                ]);
            return response()->json([
                'status' => true,
                'mensagem' => 'Categoria de Investimento Atualizado com Sucesso'
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
            CategoriaInvestimentos::where('id', $id)->delete();
            return response()->json([
                'status' => true,
                'mensagem' => 'Categoria de Investimento Excluída com Sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Falha no Servidor',
                'erro' => $e->getMessage()
            ], 500);
        }
    }
}
