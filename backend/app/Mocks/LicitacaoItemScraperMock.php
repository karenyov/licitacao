<?php

namespace App\Mocks;

use App\Services\LicitacaoItemScraperService;

class LicitacaoItemScraperMock extends LicitacaoItemScraperService
{
    public function __construct()
    {
    }

    public function getHtml(string $url): string
    {
        if (str_contains($url, 'comprasnet.gov.br')) {
            return file_get_contents(base_path('tests/Mocks/licitacao_item.html'));
        }

        return '';
    }
}
