<?php

namespace App\Http\Controllers;

use App\Models\PagamentosUsuarios;
use App\Models\Pendencias;
use Exception;
use Illuminate\Http\Request;

class PagamentosUsuariosController extends Controller
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
            $pagamentosUsuarios = PagamentosUsuarios::where('users_id', $this->users_id)
                ->with('pendencias')
                ->get();

            return response()->json([
                'status' => true,
                'pagamentos_usuarios' => $pagamentosUsuarios
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'falha no servidor',
                'erro' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->getID();

            $valor_pendencias = Pendencias::where('id', $request->pendencias_id)
                ->pluck('valor_total');

            $resultado_calc = $valor_pendencias[0] - $request->valor_pagamento;

            if (
                PagamentosUsuarios::create([
                    'users_id' => $this->users_id,
                    'pendencias_id' => $request->pendencias_id,
                    'valor_pagamento' => $request->valor_pagamento,
                    'debito_total' => $request->debito_total,
                    'descricao_pagamento' => $request->descricao_pagamento,
                    'data_pagamento' => $request->data_pagamento,
                    'metodo_pagamento' => $request->metodo_pagamento,
                    'juros' => $request->juros,
                    'numero_parcela' => $request->numero_parcela,
                ])
            ) {
                Pendencias::where('id', $request->pendencias_id)
                    ->update([
                        'valor_atual' => $resultado_calc
                    ]);
            }
            return response()->json([
                'status' => true,
                'mensagem' => 'Pagamento Registrado Com Sucesso',
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
    public function show(PagamentosUsuarios $pagamentosUsuarios)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $this->getID();
            $valor_pendencias = Pendencias::where('id', $request->pendencias_id)
                ->pluck('valor_total');

            $resultado_calc = $valor_pendencias[0] - $request->valor_pagamento;

            if (
                PagamentosUsuarios::where('id', $id)
                ->update([
                    'users_id' => $this->users_id,
                    'pendencias_id' => $request->pendencias_id,
                    'valor_pagamento' => $request->valor_pagamento,
                    'debito_total' => $request->debito_total,
                    'descricao_pagamento' => $request->descricao_pagamento,
                    'data_pagamento' => $request->data_pagamento,
                    'metodo_pagamento' => $request->metodo_pagamento,
                    'juros' => $request->juros,
                    'numero_parcela' => $request->numero_parcela,
                ])
            ) {
                Pendencias::where('id', $request->pendencias_id)
                    ->update([
                        'valor_atual' => $resultado_calc
                    ]);
            }

            return response()->json([
                'status' => true,
                'mensagem' => 'Pagamento Atualizado Com Sucesso',
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
            PagamentosUsuarios::where('id', $id)->delete();
            return response()->json([
                'status' => true,
                'mensagem' => 'Pagamento Removido Com Sucesso'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'erro no servidor',
                'erro' => $e->getMessage()
            ], 500);
        }
    }
}
