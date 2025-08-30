<?php

namespace App\Services\Contracts;

interface RotinaInterface
{
    /**
     * Executa a rotina.
     *
     * @return void
     */
    public function executar(): void;
}
