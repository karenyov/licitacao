<?php

namespace App\Services;

use App\DTO\LicitacaoDTO;
use Symfony\Component\DomCrawler\Crawler;

class LicitacaoScraperService extends ScraperBaseService
{
    public function __construct($client)
    {
        parent::__construct($client);
    }

    public function parseLicitacoes(string $html): array
    {
        $crawler = new Crawler($html);

        $licitacoes = [];

        $crawler->filter('form')->each(function (Crawler $form) use (&$licitacoes) {
            $tds = $form->filterXPath('//table//tr[position() > 1]/td');

            $tds->each(function (Crawler $td) use (&$licitacoes) {
                $html = $td->html();

                $linhas = $this->getTextFromHtml($html);

                $linkNode = $td->filter("a[name='hist_eventos']");
                $link = null;

                if ($linkNode->count() > 0) {
                    $link = $this->parseLink($linkNode->attr('onclick'));
                }

                $dados = $this->extrairDados($linhas);
                $dados->setLinkHistEventos($link);

                $licitacoes[] = $dados;
            });
        });
        return $licitacoes;
    }

    private function parseLink(string $link): ?string
    {
        if (preg_match('/\'(.*?)\'/', $link, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function getTextFromHtml(string $html): array
    {
        $linhas = preg_split('/<br\s*\/?>/i', $html);
        $linhas = array_map(fn ($l) => trim(strip_tags($l)), $linhas);
        $linhas = array_filter($linhas);
        return $linhas;
    }

    private function extrairDados(array $linhas): LicitacaoDTO
    {
        $dto = new LicitacaoDTO();

        foreach ($linhas as $key => $linha) {
            if ($key == 0) {
                $dto->setOrgao($linha);
            }
            if (str_contains($linha, 'Código da UASG:')) {
                $uasg = trim(str_replace('Código da UASG:', '', $linha));
                $dto->setUasg($uasg);
            } elseif (str_starts_with($linha, 'Pregão Eletrônico')) {
                if (preg_match('/Nº\s*([\d\/]+)/', $linha, $matches)) {
                    $pregao = $matches[1];
                } else {
                    $pregao = trim($linha);
                }
                $dto->setPregao($pregao);

                if (preg_match('/\(Lei (.+?)\)/', $linha, $m)) {
                    $dto->setLei($m[1]);
                }
            } elseif (str_starts_with($linha, 'Objeto:')) {
                $objeto = $this->trim_custom(str_replace('Objeto:', '', $linha));
                $dados['objeto'] = $objeto;
            } elseif (str_starts_with($linha, 'Edital a partir de:')) {
                $edital = $this->trim_custom(str_replace('Edital a partir de:', '', $linha));
                $dto->setEdital($edital);
            } elseif (str_starts_with($linha, 'Endereço:')) {
                $endereco = $this->trim_custom($this->clean_spaces(str_replace('Endereço:', '', $linha)));
                $dto->setEndereco($endereco);
            } elseif (str_starts_with($linha, 'Telefone:')) {
                $telefone = $this->trim_custom(str_replace('Telefone:', '', $linha));
                $dto->setTelefone($telefone);
            } elseif (str_starts_with($linha, 'Fax:')) {
                $fax = $this->trim_custom(str_replace('Fax:', '', $linha));
                $dto->setFax($fax);
            } elseif (str_starts_with($linha, 'Entrega da Proposta:')) {
                $entrega = $this->parseDate($this->trim_custom(str_replace('Entrega da Proposta:', '', $linha)));
                $dto->setEntrega($entrega);
            }
        }

        return $dto;
    }

    private function parseDate(string $data): ?string
    {
        $dataParsed = $this->clean_spaces(str_replace(['às', 'Hs'], '', $data));
        $dateTime = \DateTime::createFromFormat('d/m/Y H:i', $dataParsed);

        if (!$dateTime) {
            return null;
        }

        return $dateTime->format('Y-m-d H:i:s');
    }

    private function trim_custom(string $text): string
    {
        return preg_replace('/^[\s\x{00a0}]+|[\s\x{00a0}]+$/u', '', $text);
    }

    private function clean_spaces(string $text): string
    {
        $text = preg_replace('/[\s\x{00a0}]+/u', ' ', $text);
        return trim($text);
    }
}
