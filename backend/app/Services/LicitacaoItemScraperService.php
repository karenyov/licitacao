<?php

namespace App\Services;

class LicitacaoItemScraperService extends ScraperBaseService
{
    public function __construct($client)
    {
        parent::__construct($client);
    }

    public function parseItens(string $html): array
    {

    }
}
