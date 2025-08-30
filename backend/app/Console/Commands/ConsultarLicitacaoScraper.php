<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConsultarLicitacaoScraper extends Command
{
    protected $signature = 'app:consultar-licitacao-scraper';
    protected $description = 'Scraper de licitações - Testar ConsultarLicitacaoScraper';

    public function handle()
    {
        $this->info('Iniciando scraping de consulta licitações...');

        try {
            app(\App\Services\RotinaLicitacaoScraperService::class)->executar();
            $this->info('Scraping concluído com sucesso.');
        } catch (\Throwable $th) {
            $this->error('Erro ao consultar licitações: ' . $th->getMessage());
            return;
        }
    }

}
