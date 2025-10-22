<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Materiais;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MateriaisController extends Controller
{
    public function adicionar(Request $request)
    {

        $nome_material = $request->cadatro_nome_material;
        
        $existe = Materiais::select('id', 'titulo_material', 'descricao_material')
            ->where('titulo_material', $nome_material)
            ->get();



        if (count($existe) > 0) {
            return response()->json(['error' => true, 'message' => 'Material já existe'], 422);
        } elseif (empty($nome_material)) {
            return response()->json(['error' => true, 'message' => 'Dados inválidos'], 422);
        } else {
            $Material = new Materiais();
            $Material->titulo_material = $request->cadatro_nome_material;
            $Material->save();

            return response()->json(['success' => true, 'message' => 'Material salvo com sucesso!'],201);
        }
    }

    public function listarTodos()
{
    $materiais = Materiais::all();
    return response()->json(['materiais' => $materiais]);
}

}
