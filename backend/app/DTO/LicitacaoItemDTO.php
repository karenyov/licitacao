<?php

namespace App\DTO;

class LicitacaoItemDTO extends BaseDTO
{
    protected string $descricao;
    protected string $tratamentoDiferenciado;
    protected bool $temAplicabilidadeDecreto7174 = false;
    protected bool $temAplicabilidadeMargemPreferencial = false;
    protected int $quantidade;
    protected string $unidadeFornecimento;

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getTratamentoDiferenciado(): string
    {
        return $this->tratamentoDiferenciado;
    }

    public function setTratamentoDiferenciado(string $tratamentoDiferenciado): self
    {
        $this->tratamentoDiferenciado = $tratamentoDiferenciado;
        return $this;
    }

    public function temAplicabilidadeDecreto7174(): bool
    {
        return $this->temAplicabilidadeDecreto7174;
    }

    public function setTemAplicabilidadeDecreto7174(bool $temAplicabilidadeDecreto7174): self
    {
        $this->temAplicabilidadeDecreto7174 = $temAplicabilidadeDecreto7174;
        return $this;
    }

    public function temAplicabilidadeMargemPreferencial(): bool
    {
        return $this->temAplicabilidadeMargemPreferencial;
    }

    public function setTemAplicabilidadeMargemPreferencial(bool $temAplicabilidadeMargemPreferencial): self
    {
        $this->temAplicabilidadeMargemPreferencial = $temAplicabilidadeMargemPreferencial;
        return $this;
    }

    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): self
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    public function getUnidadeFornecimento(): string
    {
        return $this->unidadeFornecimento;
    }

    public function setUnidadeFornecimento(string $unidadeFornecimento): self
    {
        $this->unidadeFornecimento = $unidadeFornecimento;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'descricao' => $this->getDescricao(),
            'tratamento_diferenciado' => $this->getTratamentoDiferenciado(),
            'tem_aplicabilidade_decreto_7174' => $this->temAplicabilidadeDecreto7174(),
            'tem_aplicabilidade_margem_preferencial' => $this->temAplicabilidadeMargemPreferencial(),
            'quantidade' => $this->getQuantidade(),
            'unidade_fornecimento' => $this->getUnidadeFornecimento(),
        ];
    }

}
