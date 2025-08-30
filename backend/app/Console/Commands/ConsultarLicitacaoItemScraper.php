<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConsultarLicitacaoItemScraper extends Command
{
    protected $signature = 'app:consultar-licitacao-item-scraper';
    protected $description = 'Scraper de itens de licitações - Testar ConsultarLicitacaoItemScraper';

    public function handle()
    {
        $this->info('Iniciando scraping de consulta items de licitações...');

        try {
            app(\App\Services\RotinaLicitacaoItemScraperService::class)->executar();
            $this->info('Scraping concluído com sucesso.');
        } catch (\Throwable $th) {
            $this->error('Erro ao consultar itens das licitações: ' . $th->getMessage());
            return;
        }
    }
}
