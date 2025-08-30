<?php

namespace App\Services;

class RotinaLicitacaoItemScraperService implements Contracts\RotinaInterface
{
    public const baseURL = 'http://comprasnet.gov.br/ConsultaLicitacoes/download/download_editais_detalhe.asp';

    protected LicitacaoItemScraperService $scraper;

    public function __construct(LicitacaoItemScraperService $scraper)
    {
        $this->scraper = $scraper;
    }

    public function executar(): void
    {

        /**
         * as licitacoes ja estarao salvas no banco de dados
         * e o que vamos fazer aqui é pegar os itens de cada licitação
         * e salvar no banco de dados
         */

        // as linhas estarão salvas já no formado da URL coduasg=90200&modprp=5&numprp=900282025

        $html = $this->scraper->getHtml(self::baseURL . '?coduasg=926119&modprp=5&numprp=901412025');
        $itens = $this->scraper->parseItens($html);

        dd($itens);
    }


}
