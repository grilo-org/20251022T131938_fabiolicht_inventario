<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LocalizacoesObras;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LocalizacoesObrasController extends Controller
{
    public function adicionar(Request $request)
    {
        $nome_localicacao = $request->cadatro_nome_localicacao;

        $existe = LocalizacoesObras::select('id', 'nome_localizacao', 'descricao_localizacao')
            ->where('nome_localizacao', $nome_localicacao)
            ->get();

        if (count($existe) > 0) {
            return response()->json(['error' => true, 'message' => 'Localização já existe'], 422);
        } elseif (empty($nome_localicacao)) {
            return response()->json(['error' => true, 'message' => 'Dados inválidos'], 422);
        } else {
            $localicacaoObras = new LocalizacoesObras();
            $localicacaoObras->nome_localizacao = $request->cadatro_nome_localicacao;
            $localicacaoObras->save();

            return response()->json(['success' => true, 'message' => 'Localização salva com sucesso!'], 201);
        }
    }

    public function listarTodos()
    {
        $localizacoes = LocalizacoesObras::all();
        return response()->json(['localizacoes' => $localizacoes]);
    }
}
