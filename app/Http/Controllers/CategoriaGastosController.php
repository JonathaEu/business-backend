<?php

namespace App\Http\Controllers;

use App\Models\CategoriaGastos;
use Exception;
use Illuminate\Http\Request;

class CategoriaGastosController extends Controller
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
            $categoria_gastos = CategoriaGastos::where('users_id', $this->users_id)
                ->get();
            return response()->json(['status' => true, 'categoria_gastos' => $categoria_gastos], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->getID();
            $categoriaGastos = $request->categoria_gastos;

            CategoriaGastos::create([
                'categoria_gastos' => $categoriaGastos,
                'users_id' => $this->users_id,
            ]);
            return response()->json([
                'status' => true,
                'mensagem' => 'Tipo de Gasto Cadastrado com Sucesso'
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
    public function show(CategoriaGastos $categoriaGastos)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {
            $this->getID();
            $categoriaGastos = $request->categoria_gastos;

            CategoriaGastos::where('id', $id)
                ->update([
                    'categoria_gastos' => $categoriaGastos,
                    'users_id' => $this->users_id,
                ]);
            return response()->json([
                'status' => true,
                'mensagem' => 'Tipo de Gasto Atualizado com Sucesso'
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
            CategoriaGastos::where('id', $id)
                ->delete();
            return response()->json(['status' => true, 'mensagem' => 'Categoria de Gasto Removida Com Sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }
}
