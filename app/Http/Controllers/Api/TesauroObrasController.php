<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tesauros;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TesauroObrasController extends Controller
{
    public function adicionar(Request $request)
    {
        $nome_tesauro = $request->cadatro_nome_tesauro;

        $existe = Tesauros::select('id', 'titulo_tesauro', 'descricao_tesauro')
            ->where('titulo_tesauro', $nome_tesauro)
            ->get();

        if (count($existe) > 0) {
            return response()->json(['error' => true, 'message' => 'Tesauro já existe'], 422);
        } elseif (empty($nome_tesauro)) {
            return response()->json(['error' => true, 'message' => 'Dados inválidos'], 422);
        } else {
            $tesauroObras = new Tesauros();
            $tesauroObras->titulo_tesauro = $request->cadatro_nome_tesauro;
            $tesauroObras->save();

            return response()->json(['success' => true, 'message' => 'Tesauro salvo com sucesso!'], 201);
        }
    }

    public function listarTodos()
    {
        $tesauros = Tesauros::all();
        return response()->json(['tesauros' => $tesauros]);
    }
}
