<?php

namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class RotinaLicitacaoScraperService implements Contracts\RotinaInterface
{
    protected LicitacaoScraperService $scraper;
    protected LicitacaoService $licitacaoService;
    public const baseURL = 'http://comprasnet.gov.br/ConsultaLicitacoes/ConsLicitacaoDia.asp';

    public function __construct() {

        $client = HttpClient::create();
        $this->scraper = new LicitacaoScraperService($client);
        $this->licitacaoService = new LicitacaoService();
    }

    public function executar(): void
    {
        $todasLicitacoes = [];

        $html = $this->scraper->getHtml(self::baseURL);
        $totalRegistros = $this->extrairTotalRegistros($html);
        $totalPaginas = (int) ceil($totalRegistros / 20);

        $licitacoes = $this->scraper->parseLicitacoes($html);

        $totalPaginas = 2; //REMOVER ISSO AQUI DEIXEI APENAS PARA TESTE

        for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {
            $urlPagina = self::baseURL . '?pagina=' . $pagina;

            $htmlPagina = $this->scraper->getHtml($urlPagina);

            $licitacoes = $this->scraper->parseLicitacoes($htmlPagina);

            $todasLicitacoes = array_merge($todasLicitacoes, $licitacoes);
        }

        var_dump($todasLicitacoes);

        $this->licitacaoService->salvarEmLote($todasLicitacoes);
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
