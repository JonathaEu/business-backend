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
    private int $users_id;

    public function getID()
    {
        // Atribua o ID do usuário autenticado à propriedade user_id.
        $this->users_id = auth()->user()->id;
    }
    public function index()
    {
        try {
            $this->getID();
            $clientes = Clientes::where('users_id', $this->users_id)
                ->get();
            return response()->json(['status' => true, 'clientes' => $clientes], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'erro' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cliente_nome = $request->nome;
        $cliente_divida = str_replace(',', '.', $request->input('divida'));
        $users_id = $request->users_id;

        try {
            Clientes::create([
                'nome' => $cliente_nome,
                'divida' => $cliente_divida,
                'users_id' => $users_id
            ]);
            return response()->json(['status' => true, 'mensagem' => 'Cliente cadastrado com sucesso'], 200);
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
            $clientes = Clientes::where('id', $id)
                ->get();
            return response()->json(['clientes' => $clientes], 200);
        } catch (Exception $e) {
            return response()->json(['erro' => $e], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clientes $clientes, $id)
    {
        $cliente_nome = $request->nome;
        $cliente_deve = str_replace(',', '.', $request->input('divida'));;

        try {
            $clientes->where('id', $id)
                ->update([
                    'nome' => $cliente_nome,
                    'divida' => $cliente_deve,
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
