<?php

namespace App\Services;

use App\Models\Licitacao;
use Illuminate\Support\Facades\DB;

class LicitacaoService
{
    public function salvarEmLote(array $licitacoes): void
    {
        if (empty($licitacoes)) {
            return;
        }

        DB::transaction(function () use ($licitacoes) {
            foreach ($licitacoes as $licitacao) {
                $this->salvar($licitacao->toArray());
            }
        });
    }

    public function salvar(array $dados): ?Licitacao
    {
        return Licitacao::create($dados);
    }
}
