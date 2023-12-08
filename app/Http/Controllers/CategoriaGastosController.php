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
    public function index()
    {
        try {
            $categoria_gastos = CategoriaGastos::all();
            return response()->json(['status' => true, 'categoria_gastos' => $categoria_gastos], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $categoria_gastos = $request->categoria_gastos;

        try {
            CategoriaGastos::create([
                'nome' => $categoria_gastos,
            ]);
            return response()->json(['status' => true, 'mensagem' => 'Categoria de Gasto cadastrado com sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(CategoriaGastos $categoriaGastos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoriaGastos $categoriaGastos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoriaGastos $categoriaGastos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriaGastos $categoriaGastos)
    {
        //
    }
}
