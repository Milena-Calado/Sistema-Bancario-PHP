<?php

namespace App\Entity;

use App\Repository\TipoContaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipoContaRepository::class)]
class TipoConta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo = null;

    #[ORM\OneToMany(mappedBy: 'tipoConta', targetEntity: conta::class)]
    private Collection $conta;

    public function __construct()
    {
        $this->conta = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * @return Collection<int, conta>
     */
    public function getConta(): Collection
    {
        return $this->conta;
    }

    public function addContum(conta $contum): self
    {
        if (!$this->conta->contains($contum)) {
            $this->conta->add($contum);
            $contum->setTipo($this);
        }

        return $this;
    }

    public function removeContum(conta $contum): self
    {
        if ($this->conta->removeElement($contum)) {
            // set the owning side to null (unless already changed)
            if ($contum->getTipo() === $this) {
                $contum->setTipo(null);
            }
        }

        return $this;
    }
}
