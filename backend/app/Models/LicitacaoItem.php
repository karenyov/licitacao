<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LicitacaoItem extends Model
{
    /** @use HasFactory<\Database\Factories\LicitacaoItemFactory> */
    use HasFactory;

    protected $table = 'licitacao_itens';

    protected $fillable = [
        'licitacao_id',
        'descricao',
        'tratamento_diferenciado',
        'tem_aplicabilidade_decreto_7174',
        'tem_aplicabilidade_margem_preferencial',
        'quantidade',
        'unidade_fornecimento',
    ];

    public function licitacao(): BelongsTo
    {
        return $this->belongsTo(Licitacao::class);
    }
}
