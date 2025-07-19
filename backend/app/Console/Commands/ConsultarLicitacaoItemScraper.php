<?php

namespace App\Console\Commands;

use App\Services\LicitacaoItemScraperService;
use Illuminate\Console\Command;
use Symfony\Component\HttpClient\HttpClient;

class ConsultarLicitacaoItemScraper extends Command
{
    protected $signature = 'app:consultar-licitacao-item-scraper';
    protected $description = 'Scraper de itens de licitações - Testar ConsultarLicitacaoItemScraper';

    public const baseURL = 'http://comprasnet.gov.br/ConsultaLicitacoes/download/download_editais_detalhe.asp';

    protected LicitacaoItemScraperService $scraper;

    public function __construct()
    {
        parent::__construct();

        $client = HttpClient::create();
        $this->scraper = new LicitacaoItemScraperService($client);
    }

    public function handle()
    {
        $this->info('Iniciando scraping de consulta items de licitações...');
        try {

            /**
             * as licitacoes ja estarao salvas no banco de dados
             * e o que vamos fazer aqui é pegar os itens de cada licitação
             * e salvar no banco de dados
             */

            // as linhas estarão salvas já no formado da URL coduasg=90200&modprp=5&numprp=900282025

            $html = $this->scraper->getHtml(self::baseURL . '?coduasg=926119&modprp=5&numprp=901412025');
            $itens = $this->scraper->parseItens($html);

            dd($itens);

            $this->info('Scraping consulta itens de licitações finalizado. Total capturado: ' . count($itens));

        } catch (\Throwable $th) {
            $this->error('Erro ao consultar itens das licitações: ' . $th->getMessage());
            return;
        }
    }
}
