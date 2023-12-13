<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EmprestimosController;
use App\Http\Controllers\InvestimentosController;
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

Route::apiResource('/clientes', ClientesController::class);
Route::apiResource('/emprestimos', EmprestimosController::class);
Route::apiResource('/investimentos', InvestimentosController::class);
Route::apiResource('/users', UsersController::class);


Route::get('/teste', function () {
    try {
        $teste = DB::table('teste')->get();

        return response()->json(['status' => true, 'teste' => $teste], 200);
    } catch (Exception $e) {
        return response()->json(['status' => false, 'Erro' => $e], 500);
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
