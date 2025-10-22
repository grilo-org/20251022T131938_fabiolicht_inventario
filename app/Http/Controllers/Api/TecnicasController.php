<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tecnicas;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TecnicasController extends Controller
{
    public function adicionar(Request $request)
    {
        $nome_tecnica = $request->cadatro_nome_tecnica;

        $existe = Tecnicas::select('id', 'titulo_tecnica', 'descricao_tecnica')
            ->where('titulo_tecnica', $nome_tecnica)
            ->get();

        if (count($existe) > 0) {
            return response()->json(['error' => true, 'message' => 'Técnica já existe'], 422);
        } elseif (empty($nome_tecnica)) {
            return response()->json(['error' => true, 'message' => 'Dados inválidos'], 422);
        } else {
            $tecnica = new Tecnicas();
            $tecnica->titulo_tecnica = $nome_tecnica;
            $tecnica->save();

            return response()->json(['success' => true, 'message' => 'Técnica salva com sucesso!'], 201);
        }
    }

    public function listarTodos()
    {
        $tecnicas = Tecnicas::all();
        return response()->json(['tecnicas' => $tecnicas]);
    }
}
