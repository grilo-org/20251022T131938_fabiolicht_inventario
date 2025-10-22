<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Acervos;
use App\Models\Categorias;
use App\Models\CondicaoSegurancaObras;
use App\Models\EspecificacaoObras;
use App\Models\EspecificacaoSegurancaObras;
use App\Models\EstadoConservacaoObras;
use App\Models\LocalizacoesObras;
use App\Models\Materiais;
use App\Models\Obras;
use App\Models\Seculos;
use App\Models\Tecnicas;
use App\Models\Tesauros;
use App\Models\Tombamentos;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ObrasController extends Controller
{
    public function index(Request $request)
    {
        // Validação do Request (ajuste conforme necessário)
        $validator = Validator::make($request->all(), [
            // Adicione suas regras de validação aqui
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Seleciona os dados de obras para serem dispostas na listagem de obras
        $obras = Obras::select('obras.id', 'titulo_obra', 'tesauro_id', 'titulo_tesauro', 'acervo_id', 'nome_acervo', 'material_id_1', 'm1.titulo_material as titulo_material_1', 'material_id_2', 'm2.titulo_material as titulo_material_2', 'material_id_3', 'm3.titulo_material as titulo_material_3', 'foto_frontal_obra', 'obras.seculo_id', 'titulo_seculo', 'obra_provisoria');

        $user = auth()->user('id_cargo');

        // Descobre quais acervos que o usuário tem acesso
        $accesses = auth()->user('id')['acesso_acervos'];

        // Se o acesso não for nulo
        if (!is_null($accesses)) {
            // Faz o split do acesso usando vírgulas
            $accesses = explode(',', $accesses);

            // Se o acesso não for 0 (Acesso 0 é acesso a tudo)
            if (strval($accesses[0]) != '0') {
                // Para cada acesso
                foreach ($accesses as $access) {
                    // Faz o where com operador or para o id da obra
                    $obras->orWhere('acervo_id', '=', $access);
                }
            }
        } else {
            // Acesso nulo é sem acesso a nada
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
        }

        $obras = $obras->join('seculos as s', 's.id', '=', 'obras.seculo_id')
            ->join('tesauros as t', 't.id', '=', 'tesauro_id')
            ->join('acervos as a', 'a.id', '=', 'acervo_id')
            ->leftjoin('materiais as m1', 'm1.id', '=', 'material_id_1')
            ->leftjoin('materiais as m2', 'm2.id', '=', 'material_id_2')
            ->leftjoin('materiais as m3', 'm3.id', '=', 'material_id_3')
            ->orderBy('obras.id', 'ASC')
            ->paginate(200);

        // Retorna a resposta JSON com os dados de obras
        return response()->json(['data' => $obras, 'user' => $user], 200);
    }



    public function criar(Request $request)
    {
        // Revisores não podem criar, vistantes podem VER
        if (!in_array(strval(auth()->user('id')['id_cargo']), ['1', '2', '3', '5', '6'])) {
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
        }

        // Seleciona os dados necessários para o preenchimento dos dados do formulário de criação de obras (checkboxes, select, ...)
        $acervos = Acervos::select('id', 'nome_acervo');

        // Descobre quais acervos que o usuário tem acesso
        $accesses = auth()->user('id')['acesso_acervos'];

        // Se o acesso não for nulo
        if (!is_null($accesses)) {
            // Faz o split do acesso usando vírgulas
            $accesses = explode(',', $accesses);

            // Se o acesso não for 0 (Acesso 0 é acesso a tudo)
            if (strval($accesses[0]) != '0') {
                // Para cada acesso
                foreach ($accesses as $access) {
                    // Faz o where com operador or para o id da obra
                    $acervos->orWhere('id', '=', $access);
                }
            }
        } else {
            // Acesso nulo é sem acesso a nada
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
            // TODO: Trocar essa resposta para "usuário não tem acesso a nenhum acervo existente"
        }
        // Pega os dados
        $acervos = $acervos->get();

        // Se não houve nenhum resultado em acervo, o usuário não possui acesso a nenhum acervo cadastrado.
        if ($acervos === null) {
            // Se estiver vazio, o usuário não pode cadastrar nada (não deve existir esse erro).
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
            // TODO: Trocar essa resposta para "usuário não tem acesso a nenhum acervo existente"
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

        // Retorna a view de criação de obras contendo os dados coletados
        return response()->json([
            'acervos' => $acervos,
            'categorias' => $categorias,
            'especificacoes' => $especificacoes,
            'estados' => $estados,
            'localizacoes' => $localizacoes,
            'seculos' => $seculos,
            'tombamentos' => $tombamentos,
            'condicoes' => $condicoes,
            'especificacoesSeg' => $especificacoesSeg,
            'materiais' => $materiais,
            'tecnicas' => $tecnicas,
            'tesauros' => $tesauros
        ]);
    }

    public function adicionar(Request $request)
    {
        // Revisores e visitantes não podem criar
        if (!in_array(strval(auth()->user('id')['id_cargo']), ['1', '2', '3', '5'])) {
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
        }

        // Descobre os limites superior e inferior para os anos referentes ao século desejado
        $seculo = Seculos::select('ano_inicio_seculo', 'ano_fim_seculo')->where('id', $request->seculo_obra)->first();

        // Valida os campos
        $validator = Validator::make($request->all(), [
            'acervo_obra' => 'required|min:1|max:21',
            'categoria_obra' => 'required|min:1|max:21',
            'titulo_obra' => 'required|min:1|max:250',
            'tesauro_obra' => 'required|min:1|max:21',
            'localizacao_obra' => 'required|min:1|max:21',
            'condicao_seguranca_obra' => 'required|min:1|max:21',
            'tombamento_obra' => 'required|min:1|max:21',
            'estado_de_conservacao_obra' => 'required|min:1|max:21',
            'material_1_obra' => 'required|min:1|max:21',
            'tecnica_1_obra' => 'required|min:1|max:21',
            'seculo_obra' => 'required|min:1|max:21',
            'ano_obra' => 'nullable|max:5|gte:' . strval($seculo->ano_inicio_seculo) . '|lte:' . strval($seculo->ano_fim_seculo),
            // ... (outras validações)
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Descobre qual user fez a requisição
        $usuario = auth()->user('id');

        // Insere os dados em obras e retorna o id do elemento inserido
        $obraId = Obras::insertGetId([
            'id' => $request->id,
            'acervo_id' => $request->acervo_obra,
            'created_at' => new \DateTime(),
            'usuario_insercao_id' => $usuario->id,
            'categoria_id' => $request->categoria_obra,
            'titulo_obra' => $request->titulo_obra,
            'altura_obra' => $request->altura_obra,
            'largura_obra' => $request->largura_obra,
            'profundidade_obra' => $request->profundidade_obra,
            'comprimento_obra' => $request->comprimento_obra,
            'diametro_obra' => $request->diametro_obra,
            'tesauro_id' => $request->tesauro_obra,
            'localizacao_obra_id' => $request->localizacao_obra,
            'condicoes_de_seguranca_obra_id' => $request->condicao_seguranca_obra,
            'procedencia_obra' => $request->procedencia_obra,
            'tombamento_id' => $request->tombamento_obra,
            'seculo_id' => $request->seculo_obra,
            'ano_obra' => $request->ano_obra,
            'autoria_obra' => $request->autoria_obra,
            'estado_conservacao_obra_id' => $request->estado_de_conservacao_obra,
            'material_id_1' => $request->material_1_obra,
            'material_id_2' => $request->material_2_obra,
            'material_id_3' => $request->material_3_obra,
            'tecnica_id_1' => $request->tecnica_1_obra,
            'tecnica_id_2' => $request->tecnica_2_obra,
            'tecnica_id_3' => $request->tecnica_3_obra,
            'checkbox_especificacao_obra' => implode(',', $request->especificacao_obra),
            'checkbox_especificacao_seguranca_obra' => implode(',', $request->especificacao_seg_obra),
            'caracteristicas_est_icono_orna_obra' => $request->caracteristicas_estilisticas_obra,
            'observacoes_obra' => $request->observacoes_obra,
            'obra_provisoria' => isset($request->obra_provisoria) ? 1 : 0,
        ]);

        $repeat = [];

        if ($request->repete_obra == 1) { // ver checkbox
            $repeat['acervo_id'] = $request->acervo_obra;
            // ... (restante do código) ...
        }

        /* Parametrização do caminho onde as imagens ficam. */
        // Nome do primeiro folder
        $preBasePath =  'imagem';
        // Nome do segundo folder
        $basePath =  $preBasePath . '/obras';

        // Se o primeiro folder não existir
        if (!Storage::exists($preBasePath)) {
            // Ele será criado
            Storage::makeDirectory(public_path($preBasePath), 0755, true);
            // E o subfolder também (se o pré não existe, seus filhos também não existem)
            Storage::makeDirectory(public_path($basePath), 0755, true);
        } elseif (!is_dir($basePath)) {
            // Se não existir, cria ele
            mkdir(public_path($basePath));
        }

        /* Tratamento de dados para quando o folder de imagem do id a ser inserido já existe (não deve ser executado nunca, mas por precaução...) */
        // Parametrização do nome da pasta onde as imagens vão ficar
        $imagemaobra =  $basePath . '/' . $obraId;
        if (is_dir($imagemaobra)) {
            // Deleta tudo dentro dela
            array_map('unlink', glob(public_path($imagemaobra) . "/*.*"));
        } else {
            // Já que ela não existe, cria
            mkdir(public_path($imagemaobra));
        }

        /* Tratamento para inserção de fotos submetidas */
        // Se houver alguma foto submetida na requisição (útil para evitar processamento desnecessário)
        if (
            $request->hasFile('foto_frontal_obra') or
            $request->hasFile('foto_lateral_esquerda_obra') or
            $request->hasFile('foto_lateral_direita_obra') or
            $request->hasFile('foto_posterior_obra') or
            $request->hasFile('foto_superior_obra') or
            $request->hasFile('foto_inferior_obra')
        ) {

            // Descobre qual é a obra que acabou de ser inserida
            $insereObra = Obras::find($obraId);
            // Torna a inserção de timestamp como false (caso contrário, a coluna UpdatedAt ganha um valor)
            $insereObra->timestamps = false;

            // ... (restante do código)

            // Salva as alterações feitas (evitando o timestamp)
            $insereObra->save();
        }

        // Se houver um id, é sinal de que o cadastro foi feito com sucesso (não contempla as atualizações para inserção das imagens)
        if ($obraId) {
            // Seta a mensagem de sucesso e o tipo de resposta como sucesso (classe bootstrap)
            $response = [
                'message' => 'Obra cadastrada com sucesso!',
                'data' => [
                    'obra_id' => $obraId,
                    'repeat' => $repeat,  // Certifique-se de ajustar o tratamento do repeat conforme necessário
                ],
            ];
            return response()->json($response, 201);
        } else {
            // Seta a mensagem de falha e o tipo de resposta como perigo (classe bootstrap)
            $response = ['error' => 'Falha ao cadastrar a obra.'];
            return response()->json($response, 500);
        }
    }

    public function busca(Request $request)
    {
        $filtros = [];
    
        if (is_numeric($request->input('titulo_obra'))) {
            $obra_id1 = Obras::select('id')
                ->where('id', $request->input('titulo_obra'))
                ->first();
            if ($obra_id1) {
                $filtros[] = ['id', '=', $obra_id1->id];
            }
        } else {
            // Defina as variáveis para cada consulta antes de definir os filtros
            // e adicione cada filtro no array $filtros
            // Exemplo:
            $tesauro_id1 = Tesauros::select('id')
                ->where('titulo_tesauro', 'like', '%' . $request->input('titulo_obra') . '%')
                ->first();
            if ($tesauro_id1) {
                $filtros[] = ['tesauro_id', '=', $tesauro_id1->id];
            }
    
            // Repita o processo para os outros campos (estado_conservacao_id, acervoid, categoriaid, etc.)
    
            // Remova as verificações de campos múltiplos, pois não são necessárias na API
        }
    
        // Cria a query para buscar as obras
        $query = Obras::select('obras.*');
    
        foreach ($filtros as $filtro) {
            if (isset($filtro[2])) {
                $query->where($filtro[0], $filtro[1], $filtro[2]);
            }
        }
    
        $obras = $query->get();
    
        // Prepara a resposta JSON
        $resultado = [];
        foreach ($obras as $obra) {
            $resultado[] = [
                'id' => $obra->id,
                'titulo' => $obra->titulo_obra,
                'descrição' => $obra->observacoes_obra,
                'foto' => $obra->foto_frontal_obra,
                'criado' => $obra->created_at,
                'atualizado' => $obra->update_at,
            ];
        }
    
        return response()->json(['obras' => $resultado]);
    }
    
}
