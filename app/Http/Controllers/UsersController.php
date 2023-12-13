<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $renda = str_replace(',', '.', $request->renda);

        try {
            User::create([
                "name" => $name,
                "email" => $email,
                "password" => $password,
                "renda" => $renda,
            ]);
            return response()->json([
                'status' => false,
                'mensagem' => 'Cadastro Realizado Com Sucesso',
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
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
