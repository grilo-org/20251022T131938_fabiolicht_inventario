<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Acervos;
use App\Models\EspecificacaoAcervos;
use App\Models\EstadoConservacaoAcervos;
use App\Models\Seculos;
use App\Models\Tombamentos;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

class AcervosController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Acesso não autorizado. Por favor, faça login.'], 401);
        }

        $acervos = Acervos::select('acervos.id', 'nome_acervo', 'cidade_acervo', 'UF_acervo', 'foto_frontal_acervo', 'seculo_id', 'titulo_seculo', 'acervos.created_at', 'ano_construcao_acervo');
    
    
        $acervos = $acervos->join('seculos as s', 's.id', '=', 'seculo_id')
            ->orderBy('acervos.id', 'ASC')
            ->get();
    
        return response()->json($acervos);
    }


    public function criar(Request $request)
    {
        // Revisores não podem criar, visitantes podem VER
        if (!in_array(strval(auth()->user('id')['id_cargo']), ['1', '2', '3', '5', '6'])) {
            return response()->json(['error' => 'Acesso não autorizado.'], 403);
        }


        try {
            // Seleciona as especificações, estados, séculos e tombamentos para preencher os dados de uma ficha em branco (checkboxes, select, ...)
            $especificacoes = EspecificacaoAcervos::select('id', 'titulo_especificacao_acervo')->orderBy('titulo_especificacao_acervo', 'ASC')->get();
            $estados = EstadoConservacaoAcervos::select('id', 'titulo_estado_conservacao_acervo', 'is_default_estado_conservacao_acervo')->get();
            $seculos = Seculos::select('id', 'titulo_seculo', 'ano_inicio_seculo', 'ano_fim_seculo', 'is_default_seculo')->get();
            $tombamentos = Tombamentos::select('id', 'titulo_tombamento', 'is_default_tombamento')->get();

            // Retorna os dados como JSON
            return response()->json([
                'especificacoes' => $especificacoes,
                'estados' => $estados,
                'seculos' => $seculos,
                'tombamentos' => $tombamentos
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.'], 500);
        }
    }


    public function adicionar(Request $request)
    {
        // Revisores e visitantes não podem criar
        if(!in_array(strval(auth()->user()['id_cargo']), ['1', '2', '3', '5'])){
            return view('unauthorized');
        }
    
        // Descobre quais anos são os limites do século escolhido
        $seculo = Seculos::select('ano_inicio_seculo', 'ano_fim_seculo')->where('id', $request->seculo_acervo)->first();
    
        // Valida os dados
        $request->validate([
            'nome_acervo' => 'required|min:2|max:191',
            'cep_acervo' => 'required|min:1|max:9',
            'endereco_acervo' => 'required|min:1|max:250',
            'numero_endereco_acervo' => 'max:6',
            'bairro_acervo' => 'required|min:1|max:50',
            'cidade_acervo' => 'required|min:1|max:50',
            'UF_acervo' => 'required|min:2|max:2',
            'tombamento_acervo' => 'required|min:1|max:21',
            'seculo_acervo' => 'required|min:1|max:21',
            'ano_acervo' => 'nullable|max:5|gte:' . strval($seculo->ano_inicio_seculo) . '|lte:' . strval($seculo->ano_fim_seculo),
            'estado_conservacao_acervo' => 'required|min:1|max:21',
            'descricao_acervo' => 'required|max:10000',
        ]);
    
        // Descobre qual user que fez a requisição
        $usuario = auth()->user();
    
        // Se existe uma especificação de acervo e ela não está vazia
        if (isset($request->especificacao_acervo) and !empty($request->especificacao_acervo)) {
            // Concatena os elementos do array usando como separador uma ,
            $check = implode(',', $request->especificacao_acervo);
        } else {
            // Já que não existe dado para especificação de acervo, marca como uma string vazia
            $check = '';
        }
    
        try {
            // Insere os dados em acervos e retorna o id do elemento inserido
            $timestamp = now();
            $acervoId = Acervos::insertGetId([
                'nome_acervo' => $request->nome_acervo,
                'cep_acervo' => $request->cep_acervo,
                'endereco_acervo' => $request->endereco_acervo,
                'numero_endereco_acervo' => $request->numero_endereco_acervo,
                'bairro_acervo' => $request->bairro_acervo,
                'cidade_acervo' => $request->cidade_acervo,
                'UF_acervo' => $request->UF_acervo,
                'tombamento_id' => $request->tombamento_acervo,
                'seculo_id' => $request->seculo_acervo,
                'ano_construcao_acervo' => $request->ano_acervo,
                'estado_conservacao_acervo_id' => $request->estado_conservacao_acervo,
                'checkbox_especificacao_acervo' => $check,
                'descricao_fachada_planta_acervo' => $request->descricao_acervo,
                'usuario_insercao_id' => $usuario->id,
                'created_at' => $timestamp,
            ]);
    
            /* Parametrização do caminho onde as imagens ficam. */
            // Nome do primeiro folder
            $preBasePath =  'imagem';
            // Nome do segundo folder
            $basePath =  $preBasePath . '/acervos';
    
            // Se o primeiro folder não existir
            if (!Storage::exists($preBasePath)) {
                // Ele será criado
                Storage::makeDirectory(public_path($preBasePath), 0755, true);
                // E o subfolder também (se o pré não existe, seus filhos também não existem)
                Storage::makeDirectory(public_path($basePath), 0755, true);
            } elseif (!is_dir($basePath)) { // Caso o primeiro folder exista, checa se o segundo não existe
                // Se não existir, cria ele
                mkdir(public_path($basePath));
            }
    
            /* Tratamento de dados para quando o folder de imagem do id a ser inserido já existe (não deve ser executado nunca, mas por precaução...) */
            // Parametrização do nome da pasta onde as imagens vão ficar
            $imagemacervo =  $basePath . '/' . $acervoId;
    
            // Se a pasta já existir
            if (is_dir($imagemacervo)) {
                // Deleta tudo dentro dela
                array_map('unlink', glob(public_path($imagemacervo) . "/*.*"));
            } else {
                // Já que ela não existe, cria
                mkdir(public_path($imagemacervo));
            }
    
            /* Tratamento para inserção de fotos submetidas */
            // Se houver alguma foto submetida na requisição (útil pra evitar processamento desnecessário)
            if (
                $request->hasFile('foto_frontal_acervo') or
                $request->hasFile('foto_lateral_1_acervo') or
                $request->hasFile('foto_lateral_2_acervo') or
                $request->hasFile('foto_posterior_acervo') or
                $request->hasFile('foto_cobertura_acervo') or
                $request->hasFile('plantas_situacao_acervo')
            ) {
    
                // Descobre qual é o acervo que acabou de ser inserido
                $insereAcervo = Acervos::find($acervoId);
                // Torna a inserção de timestamp como false (caso contrário a coluna UpdatedAt ganha um valor)
                $insereAcervo->timestamps = false;
    
                // Se houver foto frontal
                if ($request->file('foto_frontal_acervo')) {
                    // Seta o nome da imagem como frontal
                    $imageName = 'Frontal_Acervo.webp';
                    // Cria um objeto de imagem com a imagem fornecida e marca a orientação
                    $img = Image::make($request->foto_frontal_acervo)->orientate();
                    // Redimensiona pra 450px x auto mantendo a proporção
                    $img->resize(450, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    // Salva a imagem com a codificação webp e dpi de 90
                    $img->save(public_path($imagemacervo) . '/' . $imageName)->encode('webp', 90);
    
                    // Seta a coluna foto_frontal_acervo como o caminho de onde a imagem está salva
                    $insereAcervo->foto_frontal_acervo = $imagemacervo . '/' . $imageName;
                }
    
                // Se houver foto lateral esquerda
                if ($request->file('foto_lateral_1_acervo')) {
                    // Seta o nome da imagem como lateral esquerda
                    $imageName = 'Lateral_Esquerda_Acervo.webp';
                    // Cria um objeto de imagem com a imagem fornecida e marca a orientação
                    $img = Image::make($request->foto_lateral_1_acervo)->orientate();
                    // Redimensiona pra 450px x auto mantendo a proporção
                    $img->resize(450, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    // Salva a imagem com a codificação webp e dpi de 90
                    $img->save(public_path($imagemacervo) . '/' . $imageName)->encode('webp', 90);
    
                    // Seta a coluna foto_lateral_1_acervo como o caminho de onde a imagem está salva
                    $insereAcervo->foto_lateral_1_acervo = $imagemacervo . '/' . $imageName;
                }
    
                // Se houver foto lateral direita
                if ($request->file('foto_lateral_2_acervo')) {
                    // Seta o nome da imagem como lateral direita
                    $imageName = 'Lateral_Direita_Acervo.webp';
                    // Cria um objeto de imagem com a imagem fornecida e marca a orientação
                    $img = Image::make($request->foto_lateral_2_acervo)->orientate();
                    // Redimensiona pra 450px x auto mantendo a proporção
                    $img->resize(450, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    // Salva a imagem com a codificação webp e dpi de 90
                    $img->save(public_path($imagemacervo) . '/' . $imageName)->encode('webp', 90);
                    // Seta a coluna foto_lateral_2_acervo como o caminho de onde a imagem está salva
                    $insereAcervo->foto_lateral_2_acervo = $imagemacervo . '/' . $imageName;
                }
    
                // Se houver foto posterior
                if ($request->file('foto_posterior_acervo')) {
                    // Seta o nome da imagem como posterior
                    $imageName = 'Posterior_Acervo.webp';
                    // Cria um objeto de imagem com a imagem fornecida e marca a orientação
                    $img = Image::make($request->foto_posterior_acervo)->orientate();
                    // Redimensiona pra 450px x auto mantendo a proporção
                    $img->resize(450, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    // Salva a imagem com a codificação webp e dpi de 90
                    $img->save(public_path($imagemacervo) . '/' . $imageName)->encode('webp', 90);
                    // Seta a coluna foto_posterior_acervo como o caminho de onde a imagem está salva
                    $insereAcervo->foto_posterior_acervo = $imagemacervo . '/' . $imageName;
                }
    
                // Se houver foto cobetura
                if ($request->file('foto_cobertura_acervo')) {
                    // Seta o nome da imagem como cobetura
                    $imageName = 'Cobertura_Acervo.webp';
                    // Cria um objeto de imagem com a imagem fornecida e marca a orientação
                    $img = Image::make($request->foto_cobertura_acervo)->orientate();
                    // Redimensiona pra 450px x auto mantendo a proporção
                    $img->resize(450, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    // Salva a imagem com a codificação webp e dpi de 90
                    $img->save(public_path($imagemacervo) . '/' . $imageName)->encode('webp', 90);
                    // Seta a coluna foto_cobertura_acervo como o caminho de onde a imagem está salva
                    $insereAcervo->foto_cobertura_acervo = $imagemacervo . '/' . $imageName;
                }
    
                // Se houver foto situação
                if ($request->file('plantas_situacao_acervo')) {
                    // Seta o nome da imagem como situação
                    $imageName = 'Plantas_Situacao_Acervo.webp';
                    // Cria um objeto de imagem com a imagem fornecida e marca a orientação
                    $img = Image::make($request->plantas_situacao_acervo)->orientate();
                    // Redimensiona pra 450px x auto mantendo a proporção
                    $img->resize(450, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    // Salva a imagem com a codificação webp e dpi de 90
                    $img->save(public_path($imagemacervo) . '/' . $imageName)->encode('webp', 90);
                    // Seta a coluna foto_cobertura_acervo como o caminho de onde a imagem está salva
                    $insereAcervo->plantas_situacao_acervo = $imagemacervo . '/' . $imageName;
                }
                // Salva as alterações feitas (evitando o timestamp)
                $insereAcervo->save();
            }
    
            // Se houver um id, é sinal de que o cadastro foi feito com sucesso (não contempla as atualizações para inserção das imagens)
            if ($acervoId) {
                // Seta a mensagem de sucesso e o tipo de resposta como sucesso (classe bootstrap)
                $alertMsg = 'Acervo cadastrado com sucesso!';
                $alertType = 'success';
            } else {
                // Seta a mensagem de falha e o tipo de resposta como perigo (classe bootstrap)
                $alertMsg = 'Falha ao cadastrar o acervo!';
                $alertType = 'danger';
            }
    
            // Redireciona para a url de criação de acervo passando o alerta de mensagem e o tipo de alerta
            return redirect('admin/acervo/criar')->with('alert_message', $alertMsg)->with('alert_type', $alertType);
        } catch (\Exception $e) {
            return redirect('admin/acervo/criar')->with('alert_message', 'Erro inesperado ao cadastrar o acervo.')->with('alert_type', 'danger');
        }
    }
    

    
}
