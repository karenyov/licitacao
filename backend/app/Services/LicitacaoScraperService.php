<?php
namespace App\Services;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LicitacaoScraperService
{
    protected HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getHtml(string $url): string
    {
        $response = $this->client->request('GET', $url);
        return $response->getContent();
    }

    public function parseLicitacoes(string $html): array
    {
        $crawler = new Crawler($html);

        $licitacoes = [];

        $crawler->filter('form')->each(function (Crawler $form) use (&$licitacoes) {
            $tds = $form->filterXPath('//table//tr[position() > 1]/td');

            $tds->each(function (Crawler $td) use (&$licitacoes)  {
                $html = $td->html();

                $linhas = $this->getTextFromHtml($html);
                $licitacoes[] = $this->extrairDados($linhas);
            });
        });
        return $licitacoes;
    }

    private function getTextFromHtml(string $html): array
    {
        $linhas = preg_split('/<br\s*\/?>/i', $html);
        $linhas = array_map(fn($l) => trim(strip_tags($l)), $linhas);
        $linhas = array_filter($linhas);
        return $linhas;
    }

    private function extrairDados(array $linhas): array
    {
        $dados = [];
        $orgao = [];

        foreach ($linhas as $linha) {
            if (str_contains($linha, 'Código da UASG:')) {
                $orgao[] = $linha;
                $dados['orgao'] = implode(' / ', $orgao);
                $dados['uasg'] = trim(str_replace('Código da UASG:', '', $linha));
            } elseif (!isset($dados['orgao'])) {
                $orgao[] = $linha;
            } elseif (str_starts_with($linha, 'Pregão Eletrônico')) {
                if (preg_match('/Nº\s*([\d\/]+)/', $linha, $matches)) {
                    $dados['pregao'] = $matches[1];
                } else {
                    $dados['pregao'] = trim($linha);
                }

                if (preg_match('/\(Lei (.+?)\)/', $linha, $m)) {
                    $dados['lei'] = $m[1];
                }
            } elseif (str_starts_with($linha, 'Objeto:')) {
                $dados['objeto'] = $this->trim_custom(str_replace('Objeto:', '', $linha));
            } elseif (str_starts_with($linha, 'Edital a partir de:')) {
                $dados['edital'] = $this->trim_custom(str_replace('Edital a partir de:', '', $linha));
            } elseif (str_starts_with($linha, 'Endereço:')) {
                $dados['endereco'] = $this->trim_custom($this->clean_spaces(str_replace('Endereço:', '', $linha)));
            } elseif (str_starts_with($linha, 'Telefone:')) {
                $dados['telefone'] = $this->trim_custom(str_replace('Telefone:', '', $linha));
            } elseif (str_starts_with($linha, 'Fax:')) {
                $dados['fax'] = $this->trim_custom(str_replace('Fax:', '', $linha));
            } elseif (str_starts_with($linha, 'Entrega da Proposta:')) {
                $dados['entrega'] = $this->parseDate($this->trim_custom(str_replace('Entrega da Proposta:', '', $linha)));
            }
        }

        return $dados;
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

    private function trim_custom(string $text): string {
        return preg_replace('/^[\s\x{00a0}]+|[\s\x{00a0}]+$/u', '', $text);
    }

    private function clean_spaces(string $text): string {
        $text = preg_replace('/[\s\x{00a0}]+/u', ' ', $text);
        return trim($text);
    }

    protected function mapLinhasToArray(array $linhas): array
    {
        var_dump($linhas);
        return [
            'orgao' => $linhas[0] ?? '',
            'entidade' => $linhas[1] ?? '',
            'unidade' => $linhas[2] ?? '',
            'uasg' => str_replace('Código da UASG:', '', $linhas[3] ?? ''),
            'numero_pregao' => preg_replace('/.*Pregão Eletrônico Nº\s*(.*?)\s*-.*$/', '$1', $linhas[4] ?? ''),
            'objeto' => preg_replace('/^Objeto:\s*/', '', $linhas[5] ?? ''),
            'data_edital' => str_replace('Edital a partir de:', '', $linhas[6] ?? ''),
            'endereco' => str_replace('Endereço:', '', $linhas[7] ?? ''),
            'telefone' => str_replace('Telefone:', '', $linhas[8] ?? ''),
            'fax' => str_replace('Fax:', '', $linhas[9] ?? ''),
            'entrega_proposta' => str_replace('Entrega da Proposta:', '', $linhas[10] ?? ''),
        ];
    }
}
