<?php

namespace App\Http\Controllers;

use App\Models\Acervos;
use App\Models\Obras;
use App\Models\Categorias;
use App\Models\CondicaoSegurancaObras;
use App\Models\EspecificacaoObras;
use App\Models\EspecificacaoSegurancaObras;
use App\Models\EstadoConservacaoObras;
use App\Models\LocalizacoesObras;
use App\Models\Materiais;
use App\Models\Seculos;
use App\Models\Tecnicas;
use App\Models\Tesauros;
use App\Models\Tombamentos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Builder;

Builder::macro('whereLike', function (string $column, string $search) {
    return $this->orWhere($column, 'LIKE', '%' . $search . '%');
});

class BuscaObrasPublicoController2 extends Controller
{
    public function index()
    {
        // Seleciona os dados necessários para o preenchimento dos dados do formulário de criação de obras (checkboxes, select, ...)
        $acervos = Acervos::select('id', 'nome_acervo');


        // Pega os dados
        $acervos = $acervos->get();

        // Se não houve nenhum resultado em acervo, o usuário não possui acesso a nenum acervo cadastrado.
        if ($acervos === null) {
            // Se estiver vazio, o usuário não pode cadastrar nada (não deve existir esse erro).
            return view('unauthorized');
            // TODO: Trocar essa view para "usuario não tem acesso a nenhum acervo existente"
        }

        $categorias = Categorias::select('id', 'titulo_categoria')->get();
        $condicoes = CondicaoSegurancaObras::select('id', 'titulo_condicao_seguranca_obra', 'is_default_condicao_seguranca_obra')->get();
        $especificacoes = EspecificacaoObras::select('id', 'titulo_especificacao_obra')->orderBy('titulo_especificacao_obra', 'ASC')->get();
        $especificacoesSeg = EspecificacaoSegurancaObras::select('id', 'titulo_especificacao_seguranca_obra')->get();
        $estados = EstadoConservacaoObras::select('id', 'titulo_estado_conservacao_obra', 'is_default_estado_conservacao_obra')->get();
        $localizacoes = LocalizacoesObras::select('id', 'nome_localizacao')->orderBy('nome_localizacao', 'ASC')->get();
        $materiais = Materiais::select('id', 'titulo_material')->orderBy('titulo_material', 'ASC')->get();
        $seculos = Seculos::select('id', 'titulo_seculo', 'ano_inicio_seculo', 'ano_fim_seculo', 'is_default_seculo')->get();
        $tecnicas = Tecnicas::select('id', 'titulo_tecnica')->orderBy('titulo_tecnica', 'ASC')->get();
        $tesauros = Tesauros::select('id', 'titulo_tesauro')->orderBy('titulo_tesauro', 'ASC')->get();
        $tombamentos = Tombamentos::select('id', 'titulo_tombamento')->get();

        return view('web.busca_obra2', [
            'acervos' => $acervos,
            'categorias' => $categorias,
            'especificacoes' => $especificacoes,
            'estados' => $estados,
            'localizacoes' => $localizacoes,
            'seculos' => $seculos,
            'tombamentos' => $tombamentos,
            'especificacoesSeg' => $especificacoesSeg,
            'materiais' => $materiais,
            'tecnicas' => $tecnicas,
            'tesauros' => $tesauros,
            'condicoes' => $condicoes
        ]);
    }

    public function busca(Request $request)
    {
        // Cria uma lista de dados para serem aplicados nos filtros contendo os pares de coluna e valor
        /*$tesauro  = Tesauros::select('id');
        $tesauro->whereLike('titulo_tesauro', $request->input('titulo_obra'));
        $tesauro_id1 = $tesauro->first();
        */

        if (is_numeric($request->input('titulo_obra'))) {
            $obra_id1 = Obras::select('id')
                ->whereLike('id', $request->input('titulo_obra'))
                ->first();
            // var_dump( $obra_id1);die();
            $idobra = "";
            if (!$obra_id1) {
                $idobra = "";
                //var_dump($idobra); die();
            } else {
                $idobra = $obra_id1->id;

                //var_dump($idobra); die();
            }

            $filtros = [
                ['id', $idobra],
            ];
        } else {



            $tesauro_id1 = Tesauros::select('id')
                ->whereLike('titulo_tesauro', $request->input('titulo_obra'))
                ->first();
            $tes = "";
            if (!$tesauro_id1) {
                $tes = "";
                //var_dump($tes); die();
            } else {
                $tes = $tesauro_id1->id;
                //var_dump($tes); die();
            }

            $estado_conservacao_id = EstadoConservacaoObras::select('id')
                ->whereLike('titulo_estado_conservacao_obra', $request->input('titulo_obra'))
                ->first();
            $ecid = "";
            if (!$estado_conservacao_id) {
                $ecid = "";
                //var_dump($ecid); die();
            } else {
                $ecid = $estado_conservacao_id->id;
                //var_dump($ecid); die();
            }

            $acervoid = Acervos::select('acervos.id')
                ->whereLike('nome_acervo', $request->input('titulo_obra'))
                ->first();
            $aid = "";
            if (!$acervoid) {
                $aid = "";
                //var_dump($ecid); die();
            } else {
                $aid = $acervoid->id;
                //var_dump($aid); die();
            }

            $categoriaid = Categorias::select('id')
                ->whereLike('titulo_categoria', $request->input('titulo_obra'))
                ->first();
            $cid = "";
            if (!$categoriaid) {
                $cid = "";
                //var_dump($ecid); die();
            } else {
                $cid = $categoriaid->id;
                //var_dump($cid); die();
            }

            $localizacaoid = LocalizacoesObras::select('id')
                ->whereLike('nome_localizacao', $request->input('titulo_obra'))
                ->first();
            $lid = "";
            if (!$localizacaoid) {
                $lid = "";
                //var_dump($ecid); die();
            } else {
                $lid = $localizacaoid->id;
                //var_dump($lid); die();
            }

            $tombamentoid = Tombamentos::select('id')
                ->whereLike('titulo_tombamento', $request->input('titulo_obra'))
                ->first();
            $tid = "";
            if (!$tombamentoid) {
                $tid = "";
                //var_dump($ecid); die();
            } else {
                $tid = $tombamentoid->id;
                //var_dump($tid); die();
            }

            $seculoid = Seculos::select('id')
                ->whereLike('titulo_seculo', $request->input('titulo_obra'))
                ->first();
            $sid = "";
            if (!$seculoid) {
                $sid = "";
                //var_dump($ecid); die();
            } else {
                $sid = $seculoid->id;
                //var_dump($sid); die();
            }

            $condicoes_seguranca_id = EspecificacaoSegurancaObras::select('id')
                ->whereLike('titulo_especificacao_seguranca_obra', $request->input('titulo_obra'))
                ->first();
            $csid = "";
            if (!$condicoes_seguranca_id) {
                $csid = "";
                //var_dump($ecid); die();
            } else {
                $csid = $condicoes_seguranca_id->id;
                //var_dump($csid); die();
            }


            $filtros = array(
                ['categoria_id', $cid],
                ['acervo_id', $aid],
                ['titulo_obra', $request->input('titulo_obra')],
                ['tesauro_id', $tes],
                ['localizacao_obra_id', $lid],
                ['procedencia_obra', $request->input('titulo_obra')],
                ['tombamento_id', $tid],
                ['seculo_id', $sid],
                ['ano_obra', $request->input('titulo_obra')],
                ['estado_conservacao_obra_id', $ecid],
                ['autoria_obra', $request->input('titulo_obra')],
                ['material', $request->input('titulo_obra')],
                ['tecnica', $request->input('titulo_obra')],
                ['condicoes_de_seguranca_obra_id', $csid],
            );
        }
        // Inicializa a lista de campos múltiplos 
        $multiplos = ['material', 'tecnica'];
        $multiplosMateriais = ['material_id_1', 'material_id_2', 'material_id_3'];
        $multiplosTecnicas = ['tecnica_id_1', 'tecnica_id_2', 'tecnica_id_3'];

        // Cria a query para buscar as obras selecionando todas as obras
        $query = Obras::select('obras.*');

        // Percorre a lista de filtros e aplica os filtros que não são nulos

        foreach ($filtros as $filtro) {
            if ($filtro[1] != null) {
                # Checa se o campo está na lista de campos com múltiplas colunas (por exemplo: materiais e técnicas)
                if (in_array($filtro[0], $multiplos)) {
                    # Se estiver, aplica o filtro com and e or aninhados para ambas as colunas
                    $query = $query->orWhere(function ($query) use ($filtro, $multiplosMateriais) {
                        foreach ($multiplosMateriais as $material1) {
                            $query->whereLike($material1, $filtro[1]);
                        }
                    });

                    $query = $query->orWhere(function ($query) use ($filtro, $multiplosTecnicas) {
                        foreach ($multiplosTecnicas as $tecnica1) {
                            $query->whereLike($tecnica1, $filtro[1]);
                        }
                    });
                } else {
                    // Se não estiver, faz a comparação com where normalmente
                    $query->whereLike($filtro[0], $filtro[1]);
                }
            }
        }


        /*
        // Get all the records from the obras table
        //$query = Obras::all();
        $query = Obras::select('obras.*');
        // Get the column names for the obras table
        //$columns = Schema::getColumnListing('obras');
        
        $query->like('titulo_obra=', $filtros[0]);
        // Loop through each column and add an "orWhere" clause to the query for that column
        //foreach ($columns as $column) {
         //   $query->orWhere($column, '=', $titulo_obra);
        //}
        // Check if any obra matches the conditions
        //$hasMatch = $query->exists();
*/
        $obras = $query->get();



        // Inicializa a string de retorno
        $controles = "";

        // Temporário para o css, mas vai ser removido para por no .css
        $css = "background-color: #fff; border-radius: 10px; border: none; position: relative; margin-bottom: 30px; margin-left: 2px; margin-right: 2px; box-shadow: 0 0.46875rem 2.1875rem rgb(90 97 105 / 10%), 0 0.9375rem 1.40625rem rgb(90 97 105 / 10%), 0 0.25rem 0.53125rem rgb(90 97 105 / 12%), 0 0.125rem 0.1875rem rgb(90 97 105 / 10%); height: 350px;";

        // Ids de permissões TODO: mover para um local centralizado para evitar hardcoding
        $allowEdit = ['1', '2', '3', '5'];
        $canOnlyView = ['6'];
        $allowDelete = ['1', '2'];

        // Para cada elemento de obras
        foreach ($obras as $obra) {
            // Para cada elemento em obras monte um card
            $controles .= '<div class="col-lg-4 col-sm-4">' .
                '<img  class="img-thumbnail mb-3" src="' . asset($obra->foto_frontal_obra) . '" alt="' . $obra->titulo_obra . '">';

            // Checa se o usuário está logado e pode visualizar detalhes
            if (auth()->user('id') && in_array(strval(auth()->user('id')['id_cargo']), array_merge($allowEdit, $canOnlyView)) || $obra->obra_visibilidade == 1) {
                $controles .= '<a href="' . route('detalhar_obras_publico', ['id' => $obra->id]) . '"><h5> ' . $obra->titulo_obra . ' </h5></a>';
            } else {
                $controles .= '<a href="' . route('detalhar_obras_publico', ['id' => $obra->id]) . '"><h5> ' . $obra->titulo_obra . ' </h5></a>';
            }

            $controles .= '<div style="text-align: center; margin-top: 10px;">';

            // Checa se o usuário está logado
            if (auth()->user('id')) {

                // Checa se pode editar
                if (in_array(strval(auth()->user('id')['id_cargo']), $allowEdit)) {
                    $controles .= '<button class="btn btn-primary mr-1" onclick="location.href=\'' . route('editar_obra', ['id' => $obra->id]) . '\'")> Editar </button>';
                }

                // Checa se pode visualizar
                if (in_array(strval(auth()->user('id')['id_cargo']), array_merge($allowEdit, $canOnlyView))) {
                    $controles .=  '<button class="btn btn-success mr-1" onclick="location.href=\'' . route('detalhar_obra', ['id' => $obra->id]) . '\'")> Visualizar </button>';
                }

                // Checa se pode deletar
                if (in_array(strval(auth()->user('id')['id_cargo']), $allowDelete)) {
                    $controles .= '<button class="btn btn-danger mr-1 deletanovo" data-id="' . $obra->id . '"name="' . $obra->titulo_obra . '"> Deletar </button>';
                }
            }

            $controles .= '</div>' .
                '</div>';
        }

        // Retorna o json com os dados
        return response()->json([
            'controles' => $controles,
            'quantidade' => count($obras)
        ]);
    }


    public function detalhar(Request $request, $id)
    {
        // Seleciona os dados de obras para detalhamento (query completa com as devidas associações)
        $obra = Obras::select('obras.id', 'acervo_id', 'nome_acervo', 'obras.created_at', 'obras.updated_at', 'categoria_id', 'titulo_categoria', 'titulo_obra', 'foto_frontal_obra', 'foto_lateral_esquerda_obra', 'foto_lateral_direita_obra', 'foto_posterior_obra', 'foto_superior_obra', 'foto_inferior_obra', 'tesauro_id', 'titulo_tesauro', 'altura_obra', 'largura_obra', 'profundidade_obra', 'comprimento_obra', 'diametro_obra', 'material_id_1', 'm1.titulo_material as titulo_material_1', 'material_id_2', 'm2.titulo_material as titulo_material_2', 'material_id_3', 'm3.titulo_material as titulo_material_3', 'tecnica_id_1', 't1.titulo_tecnica as titulo_tecnica_1', 'tecnica_id_2', 't2.titulo_tecnica as titulo_tecnica_2', 'tecnica_id_3', 't3.titulo_tecnica as titulo_tecnica_3', 'obras.seculo_id', 'titulo_seculo', 'ano_obra', 'autoria_obra', 'procedencia_obra', 'estado_conservacao_obra_id', 'titulo_estado_conservacao_obra', 'checkbox_especificacao_obra', 'condicoes_de_seguranca_obra_id', 'titulo_condicao_seguranca_obra', 'checkbox_especificacao_seguranca_obra', 'caracteristicas_est_icono_orna_obra', 'observacoes_obra', 'localizacao_obra_id', 'nome_localizacao', 'obras.usuario_insercao_id', 'u1.name as usuario_cadastrante', 'obras.usuario_atualizacao_id', 'u2.name as usuario_revisor', 'obra_provisoria')
            ->where('obras.id', '=', intval($id))
            ->join('acervos as a', 'a.id', '=', 'acervo_id')
            ->join('categorias as c', 'c.id', '=', 'categoria_id')
            ->join('tesauros as te', 'te.id', '=', 'tesauro_id')
            ->leftjoin('materiais as m1', 'm1.id', '=', 'material_id_1')
            ->leftjoin('materiais as m2', 'm2.id', '=', 'material_id_2')
            ->leftjoin('materiais as m3', 'm3.id', '=', 'material_id_3')
            ->leftjoin('tecnicas as t1', 't1.id', '=', 'tecnica_id_1')
            ->leftjoin('tecnicas as t2', 't2.id', '=', 'tecnica_id_2')
            ->leftjoin('tecnicas as t3', 't3.id', '=', 'tecnica_id_3')
            ->join('seculos as s', 's.id', '=', 'obras.seculo_id')
            ->join('estado_conservacao_obras as ec', 'ec.id', '=', 'estado_conservacao_obra_id')
            ->join('condicao_seguranca_obras as cs', 'cs.id', '=', 'condicoes_de_seguranca_obra_id')
            ->join('localizacoes_obras as l', 'l.id', '=', 'localizacao_obra_id')
            ->join('users as u1', 'u1.id', '=', 'obras.usuario_insercao_id')
            ->leftJoin('users as u2', 'u2.id', '=', 'obras.usuario_atualizacao_id')
            ->first();


        // Como as especificações não são chave estrangeira perfeita, o split da string é feita utilizando como separador a ,
        $especificacoes_array = explode(',', $obra->checkbox_especificacao_obra);
        $especificacoes = EspecificacaoObras::find($especificacoes_array);

        // Como as especificações de segurança não são chave estrangeira perfeita, o split da string é feita utilizando como separador a ,
        $especificacoes_seg_array = explode(',', $obra->checkbox_especificacao_seguranca_obra);
        $especificacoesSeg = EspecificacaoSegurancaObras::find($especificacoes_seg_array);

        // var_dump($obra);die();

        // Retorna a visualização de detalhamento de obras com os dados coletados
        return view('web.detalhar_obras_publico2', [
            'obra' => $obra,
            'especificacoes' => $especificacoes,
            'especificacoesSeg' => $especificacoesSeg
        ]);
    }

    public function deletar(Request $request, $id){
        // Somente TI ou administradores podem deletar
        if(!in_array(strval(auth()->user('id')['id_cargo']), ['1', '2'])){
            return response()->json(['status' => 'error', 'msg' => 'Você não tem acesso para deletar esta obra.']);
        }

        try{
            // Descobre qual é a obra a ser deletada
            $acervoId = Obras::select('acervo_id')->where('id', '=', $id)->first()['acervo_id'];
        }catch(Exception $e){
            return response()->json(['status' => 'error', 'msg' => 'Registro inexistente. Talvez ele já tenha sido deletado.']);
        }

        // Descobre quais acervos que o usuário tem acesso
        $accesses = auth()->user('id')['acesso_acervos'];

        // Se o acesso não for nulo
        if(!is_null($accesses)){
            // Faz o split do acesso usando vírgulas
            $accesses = explode(',', $accesses);
        }else{
            // Acesso nulo é sem acesso a nada
            return response()->json(['status' => 'error', 'msg' => 'Você não tem acesso para deletar esta obra.']);
        }

        if(!in_array('0', $accesses) and !in_array(strval($acervoId) , $accesses)){
            // Se não estiver no array, o usuário não pode deletar essa obra porque não pertence ao acervo que ela tem acesso
            return response()->json(['status' => 'error', 'msg' => 'Você não tem acesso para deletar esta obra.']);
        }

        // Deleta a obra
        $obra = Obras::select()->where('id', '=', $id)->delete();
        //var_dump($obra);die;

        try{
            /* Parametrização do caminho onde as imagens ficam. */
            // Nome do primeiro folder
            $preBasePath =  'imagem';
            // Nome do segundo folder
            $basePath =  $preBasePath . '/obras';

            // Parametrização do nome da pasta onde as imagens estão
            $imagemaobra =  $basePath . '/' . $id;

            // Se a pasta existir
            if (is_dir($imagemaobra)) {
                // Delete o seu conteúdo
                array_map('unlink', glob(public_path($imagemaobra) . "/*.*"));
                // Apague a pasta
                rmdir(public_path($imagemaobra));
            }
            // Se existir um elemento obra (sinal de que foi deletada com sucesso)
            if ($obra) {
                // Retorne sucesso
                return response()->json(['status' => 'success', 'msg' => 'Obra deletada.']);
            } else { // caso contrário
                // Retorne falha
                return response()->json(['status' => 'error', 'msg' => 'Ops.. Não conseguimos deletar a obra.']);
            }
        }catch(Exception $e){ // Se houver qualquer falha
            // Retorne falha
            return response()->json(['status' => 'error', 'msg' => 'Ops.. Não conseguimos deletar a obra.']);
        }
        // Erro desconhecido (não é para acontecer)
        return response()->json(['status' => 'error', 'msg' => 'Ops.. Não conseguimos deletar a obra. Erro DESCONHECIDO']);;
    }
}
