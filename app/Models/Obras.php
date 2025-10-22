<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obras extends Model
{
    use HasFactory;

    public $timestamps = true;

    // Relacionamento com a tabela de acervo
    public function acervo()
    {
        return $this->belongsTo(Acervos::class, 'acervo_id');
    }

    // Relacionamento com a tabela de categoria
    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'categoria_id');
    }

    // Relacionamento com a tabela de tesauro
    public function tesauro()
    {
        return $this->belongsTo(Tesauros::class, 'tesauro_id');
    }

    // Relacionamento com a tabela de materiais
    public function material1()
    {
        return $this->belongsTo(Materiais::class, 'material_id_1');
    }

    // Relacionamento com a tabela de materiais
    public function material2()
    {
        return $this->belongsTo(Materiais::class, 'material_id_2');
    }

    // Relacionamento com a tabela de materiais
    public function material3()
    {
        return $this->belongsTo(Materiais::class, 'material_id_3');
    }

    // Relacionamento com a tabela de tecnicas
    public function tecnica1()
    {
        return $this->belongsTo(Tecnicas::class, 'tecnica_id_1');
    }

    // Relacionamento com a tabela de tecnicas
    public function tecnica2()
    {
        return $this->belongsTo(Tecnicas::class, 'tecnica_id_2');
    }

    // Relacionamento com a tabela de tecnicas
    public function tecnica3()
    {
        return $this->belongsTo(Tecnicas::class, 'tecnica_id_3');
    }

    // Relacionamento com a tabela de seculo
    public function seculo()
    {
        return $this->belongsTo(Seculos::class, 'seculo_id');
    }

    // Relacionamento com a tabela de tombamento
    public function tombamento()
    {
        return $this->belongsTo(Tombamentos::class, 'tombamento_id');
    }

    // Relacionamento com a tabela de estado de conservação
    public function estadoConservacao()
    {
        return $this->belongsTo(EstadoConservacaoObras::class, 'estado_conservacao_obra_id');
    }

    // Relacionamento com a tabela de especificação da obra
    public function especificacaoObra()
    {
        return $this->belongsTo(EspecificacaoObras::class, 'especificacao_obra_id');
    }

    // Relacionamento com a tabela de condições de segurança
    public function condicaoSeguranca()
    {
        return $this->belongsTo(CondicaoSegurancaObras::class, 'condicoes_de_seguranca_obra_id');
    }

    // Relacionamento com a tabela de localização da obra
    public function localizacaoObra()
    {
        return $this->belongsTo(LocalizacoesObras::class, 'localizacao_obra_id');
    }

    // Relacionamento com a tabela de Usuario para inserção
    public function usuarioInsercao()
    {
        return $this->belongsTo(User::class, 'usuario_insercao_id');
    }

    // Relacionamento com a tabela de Usuario para atualizacao
    public function usuarioAtualizacao()
    {
        return $this->belongsTo(User::class, 'usuario_atualizacao_id');
    }
}
