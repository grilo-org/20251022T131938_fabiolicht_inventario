<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Acervos;
use App\Models\EspecificacaoAcervos;
use App\Models\EstadoConservacaoAcervos;
use App\Models\Obras;
use App\Models\Seculos;
use App\Models\Tombamentos;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Image;

class AcervoPublicoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Somente usuários logados podem acessar esse controller
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Seleciona os dados de acervos para serem mostrados na listagem de acervos
        $acervos = Acervos::select('acervos.id', 'nome_acervo', 'cidade_acervo', 'UF_acervo', 'foto_frontal_acervo', 'seculo_id', 'titulo_seculo','acervos.created_at', 'ano_construcao_acervo');

       
        $acervos = $acervos->join('seculos as s', 's.id', '=', 'seculo_id')
            ->orderBy('acervos.id', 'ASC')
            ->get();

           // print_r( $acervos);die();
        return view('web.acervos', [
            'acervos' => $acervos
        ]);
    }


    public function detalhar(Request $request, $id)
    {
        // Seleciona os dados de acervos para detalhamento (query completa com as devidas associações)
        $acervo = Acervos::select('acervos.id', 'acervos.created_at','acervos.updated_at','nome_acervo', 'cep_acervo', 'endereco_acervo', 'numero_endereco_acervo', 'bairro_acervo', 'cidade_acervo', 'UF_acervo', 'descricao_fachada_planta_acervo', 'foto_frontal_acervo', 'titulo_estado_conservacao_acervo', 'ano_construcao_acervo', 'tombamento_id', 'titulo_tombamento', 'seculo_id', 'titulo_seculo', 'especificacao_acervo_id', 'titulo_especificacao_acervo', 'usuario_insercao_id', 'u1.name as usuario_cadastrante', 'usuario_atualizacao_id', 'u2.name as usuario_revisor', 'checkbox_especificacao_acervo',)
            ->where('acervos.id', '=', intval($id))
            ->join('estado_conservacao_acervos as ec', 'ec.id', '=', 'estado_conservacao_acervo_id')
            ->join('tombamentos as t', 't.id', '=', 'tombamento_id')
            ->join('seculos as s', 's.id', '=', 'seculo_id')
            ->leftJoin('especificacao_acervos as ea', 'ea.id', '=', 'especificacao_acervo_id')
            ->join('users as u1', 'u1.id', '=', 'usuario_insercao_id')
            ->leftJoin('users as u2', 'u2.id', '=', 'usuario_atualizacao_id')
            ->first();


        // Como as especificações não são chave estrangeira perfeita, o split da string é feita utilizando como separador a ,
        $especificacoes_array = explode(',', $acervo->checkbox_especificacao_acervo);

        // Busque todas as especificações que estão no array
        $especificacoes = EspecificacaoAcervos::find($especificacoes_array);

        // Chame a view de detalhamento de acervos
        return view('web.detalhaAcervo', [
            'acervo' => $acervo,
            'especificacoes' => $especificacoes
        ]);
    }

    public function listarObrasPorAcervo($acervoId)
    {

        // Seleciona as obras associadas ao acervo
        $obras = Obras::select('obras.id', 'titulo_obra', 'tesauro_id', 'titulo_tesauro', 'acervo_id', 'nome_acervo', 'material_id_1', 'm1.titulo_material as titulo_material_1', 'material_id_2', 'm2.titulo_material as titulo_material_2', 'material_id_3', 'm3.titulo_material as titulo_material_3', 'foto_frontal_obra', 'obras.seculo_id', 'titulo_seculo', 'obra_provisoria')
            ->where('acervo_id', '=', $acervoId)
            ->join('seculos as s', 's.id', '=', 'obras.seculo_id')
            ->join('tesauros as t', 't.id', '=', 'tesauro_id')
            ->join('acervos as a', 'a.id', '=', 'acervo_id')
            ->leftjoin('materiais as m1', 'm1.id', '=', 'material_id_1')
            ->leftjoin('materiais as m2', 'm2.id', '=', 'material_id_2')
            ->leftjoin('materiais as m3', 'm3.id', '=', 'material_id_3')
            ->orderBy('obras.id', 'ASC')
            ->get();

        return view('web.acervos-obras', [
            'obras' => $obras
        ]);
    }


}
