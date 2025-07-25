<?php

namespace App\Console\Commands;

use App\Services\LicitacaoScraperService;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class ConsultarLicitacaoScraper extends Command
{
    protected $signature = 'app:consultar-licitacao-scraper';
    protected $description = 'Scraper de licitações - Testar ConsultarLicitacaoScraper';
    protected LicitacaoScraperService $scraper;
    public const baseURL = 'http://comprasnet.gov.br/ConsultaLicitacoes/ConsLicitacaoDia.asp';

    public function __construct()
    {
        parent::__construct();

        $client = HttpClient::create();
        $this->scraper = new LicitacaoScraperService($client);
    }

    public function handle()
    {
        $this->info('Iniciando scraping de consulta licitações...');
        try {
            $html = $this->scraper->getHtml(self::baseURL);
            $totalRegistros = $this->extrairTotalRegistros($html);
            $totalPaginas = (int) ceil($totalRegistros / 20);

            $this->info("Total de registros: {$totalRegistros}");
            $this->info("Total de páginas: {$totalPaginas}");

            $licitacoes = $this->scraper->parseLicitacoes($html);

            $todasLicitacoes = [];

            $totalPaginas = 2; //REMOVER ISSO AQUI DEIXEI APENAS PARA TESTE

            for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {
                $this->info("Capturando página $pagina / $totalPaginas");

                $urlPagina = self::baseURL . '?pagina=' . $pagina;

                $htmlPagina = $this->scraper->getHtml($urlPagina);

                $licitacoes = $this->scraper->parseLicitacoes($htmlPagina);

                $todasLicitacoes = array_merge($todasLicitacoes, $licitacoes);
            }

            var_dump($todasLicitacoes);

            $this->info('Scraping consulta licitações finalizado. Total capturado: ' . count($todasLicitacoes));

        } catch (\Throwable $th) {
            $this->error('Erro ao consultar licitações: ' . $th->getMessage());
            return;
        }
    }

    private function extrairTotalRegistros(string $html): int
    {
        $crawler = new Crawler($html);
        $texto = $crawler->filter('td.td center')->text();

        if (preg_match('/de\s+(\d+)/i', $texto, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }

}
