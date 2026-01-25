<?php

namespace App\Entity;

use App\Repository\FabriquantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FabriquantRepository::class)]
class Fabriquant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Manekineko>
     */
    #[ORM\OneToMany(targetEntity: Manekineko::class, mappedBy: 'fabriquant')]
    private Collection $manekinekos;

    public function __construct()
    {
        $this->manekinekos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->nom;
    }


    /**
     * @return Collection<int, Manekineko>
     */
    public function getManekinekos(): Collection
    {
        return $this->manekinekos;
    }

    public function addManekineko(Manekineko $manekineko): static
    {
        if (!$this->manekinekos->contains($manekineko)) {
            $this->manekinekos->add($manekineko);
            $manekineko->setFabriquant($this);
        }

        return $this;
    }

    public function removeManekineko(Manekineko $manekineko): static
    {
        if ($this->manekinekos->removeElement($manekineko)) {
            // set the owning side to null (unless already changed)
            if ($manekineko->getFabriquant() === $this) {
                $manekineko->setFabriquant(null);
            }
        }

        return $this;
    }
}
