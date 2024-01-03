<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Emprestimos;
use App\Models\PagamentosClientes;
use Exception;
use Illuminate\Http\Request;

class PagamentosClientesController extends Controller
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

            $pagamentosClientes = PagamentosClientes::where('users_id', $this->users_id)
                ->with('clientes')
                ->get();
            return response()->json([
                'status' => true,
                'pagamentos_clientes' => $pagamentosClientes,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'mensagem' => 'Erro no servidor',
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
            $emprestimos_id = $request->emprestimos_id;
            $clientes_id = $request->clientes_id;
            $descricao = $request->descricao;
            $valor_pagamento = $request->valor_pagamento;
            $debito_total = $request->debito_total;
            $data_pagamento = $request->data_pagamento;
            $metodo_pagamento = $request->metodo_pagamento;

            $divida_cliente = Clientes::where('id', $clientes_id)
                ->pluck('divida');
            $calc_divida_cliente = $divida_cliente[0] - $valor_pagamento;

            if (
                PagamentosClientes::create([
                    'emprestimos_id' => $emprestimos_id,
                    'users_id' => $this->users_id,
                    'clientes_id' => $clientes_id,
                    'descricao' => $descricao,
                    'valor_pagamento' => $valor_pagamento,
                    'debito_total' => $debito_total,
                    'data_pagamento' => $data_pagamento,
                    'metodo_pagamento' => $metodo_pagamento,
                    'numero_parcela' => $request->numero_parcela,
                ])
            ) {
                Clientes::where('id', $clientes_id)
                    ->update([
                        'divida' => $calc_divida_cliente
                    ]);
            } else if (
                PagamentosClientes::create([
                    'emprestimos_id' => $emprestimos_id,
                    'users_id' => $this->users_id,
                    'clientes_id' => $clientes_id,
                    'descricao' => $descricao,
                    'valor_pagamento' => $valor_pagamento,
                    'debito_total' => $debito_total,
                    'data_pagamento' => $data_pagamento,
                    'metodo_pagamento' => $metodo_pagamento,
                    'numero_parcela' => $request->numero_parcela,
                ])
                && $debito_total == 1
            ) {
                Emprestimos::where('id', $emprestimos_id)
                    ->update([
                        "pago" => 1
                    ]);
                Clientes::where('id', $clientes_id)
                    ->update([
                        'divida' => $calc_divida_cliente
                    ]);
            }

            return response()->json([
                'status' => true,
                'mensagem' => 'Pagamento Registrado Com Sucesso',

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
    public function show(PagamentosClientes $pagamentosClientes)
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
            $emprestimos_id = $request->emprestimos_id;
            $descricao = $request->descricao;
            $clientes_id = $request->clientes_id;
            $valor_pagamento = $request->valor_pagamento;
            $debito_total = $request->debito_total;
            $data_pagamento = $request->data_pagamento;
            $metodo_pagamento = $request->metodo_pagamento;

            $pagamentos_clientes = new PagamentosClientes;

            $pagamentos_clientes->where('id', $id)
                ->update([
                    'emprestimos_id' => $emprestimos_id,
                    'users_id' => $this->users_id,
                    'clientes_id' => $clientes_id,
                    'descricao' => $descricao,
                    'valor_pagamento' => $valor_pagamento,
                    'debito_total' => $debito_total,
                    'data_pagamento' => $data_pagamento,
                    'metodo_pagamento' => $metodo_pagamento,
                    'numero_parcela' => $request->numero_parcela,
                ]);

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
            PagamentosClientes::where('id', $id)->delete();

            return response()->json([
                'status' => true,
                'mensagem' => 'Pagamento Excluído com Sucesso'
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
