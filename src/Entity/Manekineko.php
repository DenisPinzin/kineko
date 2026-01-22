<?php

namespace App\Entity;

use App\Repository\ManekinekoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManekinekoRepository::class)]
class Manekineko
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateFabrication = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomFabriquant = null;

    #[ORM\Column(nullable: true)]
    private ?int $estimation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'manekinekos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'manekinekos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?fabriquant $fabriquant = null;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'manekineko')]
    private Collection $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDateFabrication(): ?\DateTime
    {
        return $this->dateFabrication;
    }

    public function setDateFabrication(?\DateTime $dateFabrication): static
    {
        $this->dateFabrication = $dateFabrication;

        return $this;
    }

    public function getNomFabriquant(): ?string
    {
        return $this->nomFabriquant;
    }

    public function setNomFabriquant(?string $nomFabriquant): static
    {
        $this->nomFabriquant = $nomFabriquant;

        return $this;
    }

    public function getEstimation(): ?int
    {
        return $this->estimation;
    }

    public function setEstimation(?int $estimation): static
    {
        $this->estimation = $estimation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getFabriquant(): ?fabriquant
    {
        return $this->fabriquant;
    }

    public function setFabriquant(?fabriquant $fabriquant): static
    {
        $this->fabriquant = $fabriquant;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setManekineko($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getManekineko() === $this) {
                $commentaire->setManekineko(null);
            }
        }

        return $this;
    }
}
