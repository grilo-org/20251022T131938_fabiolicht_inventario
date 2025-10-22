<?php

namespace App\Http\Controllers;

use App\Models\Obras;
use App\Models\EspecificacaoObras;
use App\Models\EspecificacaoSegurancaObras;
use Illuminate\Http\Request;

use PDF;

class PdfController extends Controller
{
    private function safeImg($path, $maxH = 100, $maxW = 200) {
        // Se o path tiver o caractere ? remove ele e tudo que vem depois
        if(strpos($path, "?") !== false) {
            $path = substr($path, 0, strpos($path, "?"));
        }

        // Se a imagem não existir, retorna uma imagem padrão
        try{
            $path = asset($path);
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $size = getimagesize($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $logo = array("base64" => $base64, "width" => $size[0], "height" => $size[1]);
        }
        catch(\Exception $e){
            return array("base64" => "", "width" => $maxW, "height" => $maxH);
            $path = asset("assets/img/noimg_pdf.png");
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $size = getimagesize($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $logo = array("base64" => $base64, "width" => $size[0], "height" => $size[1]);
        }
    
        // Se a altura da imagem ultrapassa o máx aceito
        if ($logo["height"] > $maxH) {
            // Muda a altura
            $h = $maxH;
    
            // Descobre a proporção que mudou
            $proportion = $maxH / $logo["height"];
    
            // Alter a largura na mesma proporção
            $w = $logo["width"] * $proportion;
    
            // Agora checa a largura nova (que ainda não foi checada)
            if ($w > $maxW) {
                // Descobre a proporção que mudou
                $proportion = $maxW / $w;
    
                // Muda a largura
                $w = $maxW;
    
                // Altera a altura na mesma proporção
                $h = $h * $proportion;
            }
        } else {
            // Se a largura da imagem ultrapassa o máximo aceito
            if ($logo["width"] > $maxW) {
                // Muda a largura
                $w = $maxW;
    
                // Descobre a proporção que mudou
                $proportion = $maxW / $logo["width"];
    
                // Altera a altura na mesma proporção
                $h = $logo["height"] * $proportion;
            } else {
                // Mantém ambos dados, já que estão no padrão
                $w = $logo["width"];
                $h = $logo["height"];
            }
        }
    
        return array("base64" => $base64, "width" => $w, "height" => $h);
    }

    public function printObra(Request $request)
    {
        // Captura os dados de obra
        $obra = Obras::with([
            'acervo',
            'categoria',
            'tesauro',
            'material1',
            'material2',
            'material3',
            'tecnica1',
            'tecnica2',
            'tecnica3',
            'seculo',
            'tombamento',
            'estadoConservacao',
            'especificacaoObra',
            'condicaoSeguranca',
            'localizacaoObra',
            'usuarioInsercao',
            'usuarioAtualizacao',
        ])->find($request->id);

        $logo = $this->safeImg("assets/img/logo_cliente.png");

        $img1 = $this->safeImg($obra->foto_frontal_obra);
        $img2 = $this->safeImg($obra->foto_lateral_esquerda_obra);
        $img3 = $this->safeImg($obra->foto_lateral_direita_obra);

        $title = $obra->titulo_obra;
        $subtitle = "Peça " . $request->id;

        $filename = 'Ficha_Catalografica_' . $request->id . '.pdf';

        $instituicaoTitle = env('APP_NAME', '???');
        $instituicaoSubTitle = env('APP_SUBNAME', '');

        // Descobre as especificações de segurança da obra
        $secs = "";

        // Para cada especificação
        foreach(explode(",", $obra->checkbox_especificacao_seguranca_obra) as $sec) {
            // Checa se é uma especificação válida (pode ser convertida para inteiro)
            if(is_numeric($sec)) {
                // Busca o id da especificação com o modelo EspecificacaoObras
                $espec_data = EspecificacaoSegurancaObras::find($sec);
                // Checa se a especificação existe
                if($espec_data) {
                    // Se já existir alguma especificação, adiciona uma vírgula
                    if($secs != "") {
                        $secs .= ", ";
                    }
                    // Se existir, adiciona o nome dela
                    $secs .= $espec_data->titulo_especificacao_seguranca_obra;
                }
            }
        }

        // Descobre as especificações da obra
        $especs = "";

        // Para cada especificação
        foreach(explode(",", $obra->checkbox_especificacao_obra) as $espec) {
            // Checa se é uma especificação válida (pode ser convertida para inteiro)
            if(is_numeric($espec)) {
                // Busca o id da especificação com o modelo EspecificacaoObras
                $espec_data = EspecificacaoObras::find($espec);
                // Checa se a especificação existe
                if($espec_data) {
                    // Se já existir alguma especificação, adiciona uma vírgula
                    if($especs != "") {
                        $especs .= ", ";
                    }
                    // Se existir, adiciona o nome dela
                    $especs .= $espec_data->titulo_especificacao_obra;
                }
            }
        }

        // Composição do material
        $material = $obra->material1->titulo_material;
        // Se existir o material 2
        if($obra->material2) {
            // Adiciona o material 2
            $material .= ", " . $obra->material2->titulo_material;
        }
        // Se existir o material 3
        if($obra->material3) {
            // Adiciona o material 3
            $material .= ", " . $obra->material3->titulo_material;
        }

        // Composição da técnica
        $tecnica = $obra->tecnica1->titulo_tecnica;
        // Se existir a técnica 2
        if($obra->tecnica2) {
            // Adiciona a técnica 2
            $tecnica .= ", " . $obra->tecnica2->titulo_tecnica;
        }
        // Se existir a técnica 3
        if($obra->tecnica3) {
            // Adiciona a técnica 3
            $tecnica .= ", " . $obra->tecnica3->titulo_tecnica;
        }

        // Carrega a view /resources/views/admin/pdf/obra.blade.php para ser impressa em PDF
        $pdf = PDF::loadView('admin.pdf.obra', [
            'id' => $request->id,
            'titulo' => $title ?? null,
            'objeto' => $obra->tesauro->titulo_tesauro ?? null,
            'categoria' => $obra->categoria->titulo_categoria ?? null,
            'material' => $material ?? null,
            'tecnica' => $tecnica ?? null,
            'seculo' => $obra->seculo->titulo_seculo ?? null,
            'ano' => $obra->ano_obra ?? null,
            'autor' => $obra->autoria_obra ?? null,
            'procedencia' => $obra->procedencia_obra ?? null,
            'tombamento' => $obra->tombamento->titulo_tombamento ?? null,
            'estadoCons' => $obra->estadoConservacao->titulo_estado_conservacao_obra ?? null,
            'condSeg' => $obra->condicaoSeguranca->titulo_condicao_seguranca_obra ?? null,
            'altura' => $obra->altura_obra ? $obra->altura_obra . " cm" : null,
            'larg' => $obra->largura_obra ? $obra->largura_obra . " cm" : null,
            'comp' => $obra->comprimento_obra ? $obra->comprimento_obra . " cm" : null,
            'profundidade' => $obra->profundidade_obra ? $obra->profundidade_obra . " cm" : null,
            'diametro' => $obra->diametro_obra ? $obra->diametro_obra . " cm" : null,
            'acervo' => $obra->acervo->nome_acervo ?? null,
            'municipio' => $obra->acervo->cidade_acervo ?? null,
            'logradouro' => $obra->acervo->endereco_acervo ?? null,
            'locPred' => $obra->localizacaoObra->nome_localizacao ?? null,
            'resp' => env("APP_NAME". "-"),
            'especEstSeg' => $secs ?? null,
            'especEstCons' => $especs ?? null,
            'carac' => $obra->caracteristicas_est_icono_orna_obra ?? null,
            'obs' => $obra->observacoes_obra ?? null,
            'inventarista' => $obra->usuarioInsercao->name ?? null,
            'datainvent' => date("d/m/Y", strtotime($obra->created_at)) ?? null,
            'revisor' => $obra->usuarioAtualizacao->name ?? null, 
            'datarevis' => date("d/m/Y", strtotime($obra->updated_at)) ?? null,
            'img1' => $img1,
            'img2' => $img2,
            'img3' => $img3,
            'logo' => $logo,
            'instituicaoTitle' => $instituicaoTitle,
            'instituicaoSubTitle' => $instituicaoSubTitle,
        ]);

        $pdf->setPaper('A4', 'portrait');

        $pdf->add_info('Creator', 'Sistema de gerenciamento de bens culturais Procult - Licenciado para: ' .  env('APP_NAME'));
        $pdf->add_info('Author', 'Procult');
        $pdf->add_info('Title', $title);
        $pdf->add_info('Subject', $subtitle);
        $pdf->add_info('Keywords', 'Ficha catalográfica');

        return $pdf->stream($filename, array("Attachment" => false));
        //return $pdf->download('pdf.pdf');
    }
}
