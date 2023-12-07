<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Exception;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $clientes = Clientes::all();
            return response()->json(['status' => true, 'clientes' => $clientes], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 200);
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
        $cliente_nome = $request->nome;
        $cliente_deve = str_replace(',', '.', $request->input('deve'));;

        try {
            Clientes::create([
                'nome' => $cliente_nome,
                'deve' => $cliente_deve,
            ]);
            return response()->json(['status' => true, 'mensagem' => 'Cliente cadastrado com sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Clientes $clientes)
    {
        //
    }

    /**
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clientes $clientes, $id)
    {
        $cliente_nome = $request->nome;
        $cliente_deve = str_replace(',', '.', $request->input('deve'));;

        try {
            $clientes->where('id', $id)
                ->update([
                    'nome' => $cliente_nome,
                    'deve' => $cliente_deve,
                ]);
            return response()->json(['status' => true, 'mensagem' => 'Cliente Atualizado Com Sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clientes $clientes, $id)
    {
        try {
            $clientes->where('id', $id)
                ->delete();
            return response()->json(['status' => true, 'mensagem' => 'Cliente Removido Com Sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }
}
