<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Licitacao extends Model
{
    /** @use HasFactory<\Database\Factories\LicitacaoFactory> */
    use HasFactory;
    protected $table = 'licitacoes';
    protected $fillable = [
        'orgao',
        'uasg',
        'lei',
        'pregao',
        'objeto',
        'edital',
        'endereco',
        'telefone',
        'fax',
        'entrega',
        'link_hist_eventos',
    ];

    public function itens(): HasMany
    {
        return $this->hasMany(LicitacaoItem::class);
    }
}
