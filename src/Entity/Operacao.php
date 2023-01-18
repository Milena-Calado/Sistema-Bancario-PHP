<?php

namespace App\Entity;

use App\Repository\OperacaoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperacaoRepository::class)]
class Operacao
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descricao = null;

    #[ORM\Column]
    private ?float $valor = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data = null;

    #[ORM\ManyToOne(inversedBy: 'operacaos')]
    private ?Conta $destino = null;

    #[ORM\ManyToOne(inversedBy: 'operacaos')]
    private ?Conta $envio = null;

    public function __construct()
    {
        $this->data = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getDestino(): ?Conta
    {
        return $this->destino;
    }

    public function setDestino(?Conta $destino): self
    {
        $this->destino = $destino;

        return $this;
    }

    public function getEnvio(): ?Conta
    {
        return $this->envio;
    }

    public function setEnvio(?Conta $envio): self
    {
        $this->envio = $envio;

        return $this;
    }
}
