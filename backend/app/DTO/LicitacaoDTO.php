<?php

namespace App\DTO;

class LicitacaoDTO extends BaseDTO
{
    protected string $orgao;
    protected string $uasg;
    protected ?string $lei = null;
    protected string $pregao;
    protected string $objeto;
    protected string $edital;
    protected ?string $endereco = null;
    protected ?string $telefone = null;
    protected ?string $fax = null;
    protected string $entrega;
    protected string $linkHistEventos;

    public function getOrgao(): string
    {
        return $this->orgao;
    }

    public function setOrgao(string $orgao): self
    {
        $this->orgao = $orgao;
        return $this;
    }

    public function getLei(): ?string
    {
        return $this->lei;
    }

    public function setLei(?string $lei): self
    {
        $this->lei = $lei;
        return $this;
    }

    public function getUasg(): string
    {
        return $this->uasg;
    }

    public function setUasg(string $uasg): self
    {
        $this->uasg = $uasg;
        return $this;
    }

    public function getPregao(): string
    {
        return $this->pregao;
    }

    public function setPregao(string $pregao): self
    {
        $this->pregao = $pregao;
        return $this;
    }

    public function getObjeto(): string
    {
        return $this->objeto;
    }

    public function setObjeto(string $objeto): self
    {
        $this->objeto = $objeto;
        return $this;
    }

    public function getEdital(): string
    {
        return $this->edital;
    }

    public function setEdital(string $edital): self
    {
        $this->edital = $edital;
        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(?string $endereco): self
    {
        $this->endereco = $endereco;
        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(?string $telefone): self
    {
        $this->telefone = $telefone;
        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;
        return $this;
    }

    public function getEntrega(): string
    {
        return $this->entrega;
    }

    public function setEntrega(string $entrega): self
    {
        $this->entrega = $entrega;
        return $this;
    }

    public function getLinkHistEventos(): string
    {
        return $this->linkHistEventos;
    }

    public function setLinkHistEventos(string $linkHistEventos): self
    {
        $this->linkHistEventos = $linkHistEventos;
        return $this;
    }
}
