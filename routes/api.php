<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\AcervosController;
use App\Http\Controllers\Api\LocalizacoesObrasController;
use App\Http\Controllers\Api\MateriaisController;
use App\Http\Controllers\Api\ObrasController;
use App\Http\Controllers\Api\TecnicasController;
use App\Http\Controllers\Api\TesauroObrasController;

// Defina a rota de login usando a controladora sem o namespace completo
Route::post('/login', [LoginController::class, 'login']);
Route::get('/acervos', [AcervosController::class, 'index']);
Route::group(['middleware' => 'auth:api'], function () {
    
});
// Demais rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/acervos', [AcervosController::class, 'index']);
    Route::get('/acervos/criar', [AcervosController::class, 'criar']);
    Route::post('/acervos/criar/adicionar', [AcervosController::class, 'adicionar']);
    Route::get('/obras', [ObrasController::class, 'index']);
    Route::get('/obras/criar', [ObrasController::class, 'criar']);
    Route::get('/obras/criar/adicionar', [ObrasController::class, 'adicionar']);
    Route::post('/materiais/adicionar', [MateriaisController::class, 'adicionar']);
    Route::get('/materiais', [MateriaisController::class, 'listarTodos']);
    Route::post('/tecnicas/adicionar', [TecnicasController::class, 'adicionar']);
    Route::get('/tecnicas', [TecnicasController::class, 'listarTodos']);
    Route::get('/localizacoes', [LocalizacoesObrasController::class, 'listarTodos']);
    Route::post('/localizacoes/adincionar', [LocalizacoesObrasController::class, 'adicionar']);
    Route::get('/tesauros', [TesauroObrasController::class, 'listarTodos']);
    Route::post('/tesauros/adicionar', [TesauroObrasController::class, 'adicionar']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('/obras/busca', [ObrasController::class, 'busca']);
Route::post('/obras/busca', [ObrasController::class, 'busca']);
