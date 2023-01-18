<?php

namespace App\Entity;

use App\Repository\TipoContaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContaRepository::class)]
class Conta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column]
    private ?float $saldo = null;

    #[ORM\ManyToOne(inversedBy: 'contas')]
    private ?User $usuario = null;

    #[ORM\ManyToOne(inversedBy: 'contas')]
    private ?Agencia $agencia = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $situacao = null;

    #[ORM\ManyToOne(inversedBy: 'contas')]
    private ?TipoConta $tipo = null;

    #[ORM\OneToMany(mappedBy: 'Destino', targetEntity: Operacao::class, cascade: ['remove'])]

    private Collection $operacoes;

    public function __construct()
    {
        $this->operacoes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getSaldo(): ?float
    {
        return $this->saldo;
    }

    public function setSaldo(float $saldo): self
    {
        $this->saldo = $saldo;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getAgencia(): ?Agencia
    {
        return $this->agencia;
    }

    public function setAgencia(?Agencia $agencia): self
    {
        $this->agencia = $agencia;

        return $this;
    }

    public function getSituacao(): ?string
    {
        return $this->situacao;
    }

    public function setSituacao(?string $situacao): self
    {
        $this->situacao = $situacao;

        return $this;
    }

    public function getTipo(): ?TipoConta
    {
        return $this->tipo;
    }

    public function setTipo(?TipoConta $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }
}
