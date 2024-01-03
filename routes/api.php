<?php

use App\Http\Controllers\CategoriaGastosController;
use App\Http\Controllers\CategoriaInvestimentosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EmprestimosController;
use App\Http\Controllers\InvestimentosController;
use App\Http\Controllers\PagamentosClientesController;
use App\Http\Controllers\PagamentosUsuariosController;
use App\Http\Controllers\PendenciasController;
use App\Http\Controllers\RendimentosController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// CATEGORIA INVESTIMENTOS 
Route::apiResource('/categoria-investimentos', CategoriaInvestimentosController::class);
Route::apiResource('/categoria-gastos', CategoriaGastosController::class);
// CLIENTES 
Route::apiResource('/clientes', ClientesController::class);
// EMPRESTIMOS
Route::apiResource('/emprestimos', EmprestimosController::class);
Route::get('/emprestimos-abertos', [EmprestimosController::class, 'EmprestimosEmAberto']);
Route::get('/emprestimos-abertos/{cliente_id}', [EmprestimosController::class, 'EmprestimosEmAbertoEspecifico']);
// INVESTIMENTOS
Route::apiResource('/investimentos', InvestimentosController::class);
// PENDENCIAS 
Route::apiResource('/pendencias', PendenciasController::class);
Route::get('/pendencias-em-aberto', [PendenciasController::class, 'PendenciasEmAberto']);
// PAGAMENTO CLIENTES 
Route::apiResource('/pagamentos-clientes', PagamentosClientesController::class);
// MEUS PAGAMENTOS
Route::apiResource('/meus-pagamentos', PagamentosUsuariosController::class);
// RENDIMENTOS
Route::apiResource('/rendimentos', RendimentosController::class);
// USUARIOS
Route::apiResource('/users', UsersController::class);


Route::get('/teste', function () {
    try {
        $teste = DB::table('teste')->get();
        return response()->json(['status' => true, 'teste' => $teste], 200);
    } catch (Exception $e) {
        return response()->json(['status' => false, 'Erro' => $e], 500);
    }
});

Route::get('/me', function () {
    try {
        return response()->json(auth()->user());
    } catch (Exception $e) {
        return response()->json(['erro' => 'Usuário Não encontrado, por favor, faça login novamente.'], 500);
    }
});

Route::post('/logout', function () {
    try {
        auth()->logout();

        return response()->json([
            'status' => true,
            'mensagem' => 'Desautenticou Com Sucesso!'
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'status' => false,
            'mensagem' => 'erro no servidor',
            'erro' => $e->getMessage()
        ], 500);
    }
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only(['email', 'password']);
    // dd($credentials);
    if (!$token = auth()->attempt($credentials)) {
        abort(401, 'Credenciais Erradas, Cheque os Campos Novamente');
    }

    return response()->json([
        'user' => auth()->user(),
        'token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 120,
        'mensagem' => 'Autenticação Bem Sucedida'
    ], 200);
});

Route::post('/logout', function () {
    auth()->logout();
    response()->json(['message' => 'Usuário desautenticado com sucesso']);
});
