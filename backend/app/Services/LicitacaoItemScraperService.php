<?php

namespace App\Services;

use App\DTO\LicitacaoItemDTO;
use Symfony\Component\DomCrawler\Crawler;

class LicitacaoItemScraperService extends ScraperBaseService
{
    public function __construct($client)
    {
        parent::__construct($client);
    }

    public function parseItens(string $html): array
    {

        $crawler = new Crawler($html);
        $itens = [];

        $crawler->filter('span.tex3b')->each(function (Crawler $span) use (&$itens) {
            if (trim($span->text()) === 'Itens de Material') {
                $tabela = $span->nextAll()->filter('table')->first();

                 $tabela->filter('tr')->each(function (Crawler $tr) use (&$itens) {
                    $tds = $tr->filter('td');

                    if ($tds->count() >= 2 && trim($tds->eq(1)->text()) !== '') {
                        $html = $tds->eq(1)->html();

                        $linha = $this->getTextFromHtml($html);

                        $dados = $this->extrairDados($linha);

                        $itens[] = $dados;
                    }
                });
            }
        });

        return $itens;
    }

    private function getTextFromHtml(string $html): array
    {
        $linha = preg_replace('/<br\s*\/?>/i', "\n", $html);
        $linha = strip_tags($linha);
        $linha = array_filter(array_map('trim', explode("\n", $linha)));

        $registro = array_map(function ($atributo, $index) {
            if ($index === 0) {
                return $atributo;
            }

            if (strpos($atributo, ':') !== false) {
                return trim(substr($atributo, strpos($atributo, ':') + 1));
            }

            return $atributo;
        }, $linha, array_keys($linha));

        return $registro;
    }

    private function extrairDados(array $linhas): LicitacaoItemDTO
    {
        $dto = (new LicitacaoItemDTO())
        ->setDescricao($linhas[0] ?? '')
            ->setTratamentoDiferenciado($linhas[1] ?? '')
            ->setTemAplicabilidadeDecreto7174(isset($linhas[2]) ? strtolower($linhas[2]) === 'sim' : false)
            ->setTemAplicabilidadeMargemPreferencial(isset($linhas[3]) ? strtolower($linhas[3]) === 'sim' : false)
            ->setQuantidade((int) ($linhas[4] ?? 0))
            ->setUnidadeFornecimento($linhas[5] ?? '');
        return $dto;
    }

}
