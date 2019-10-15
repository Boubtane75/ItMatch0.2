<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrajetRepository")
 * @ApiResource()
 */
class Trajet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LieuDepart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LieuArrived;

    /**
     * @ORM\Column(type="datetime")
     */
    private $HeureDepart;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="trajets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conducteur_id;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trajet", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", inversedBy="passager")
     */
    private $passager;



    public function __construct()
    {
        //$this->utilisateurs = new ArrayCollection();
        $this->passager = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieuDepart(): ?string
    {
        return $this->LieuDepart;
    }

    public function setLieuDepart(string $LieuDepart): self
    {
        $this->LieuDepart = $LieuDepart;

        return $this;
    }

    public function getLieuArrived(): ?string
    {
        return $this->LieuArrived;
    }

    public function setLieuArrived(string $LieuArrived): self
    {
        $this->LieuArrived = $LieuArrived;

        return $this;
    }

    public function getHeureDepart(): ?\DateTimeInterface
    {
        return $this->HeureDepart;
    }

    public function setHeureDepart(\DateTimeInterface $HeureDepart): self
    {
        $this->HeureDepart = $HeureDepart;

        return $this;
    }


    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->passager;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->passager->contains($utilisateur)) {
            $this->passager[] = $utilisateur;
            $utilisateur->addTrajet($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->passager->contains($utilisateur)) {
            $this->passager->removeElement($utilisateur);
            $utilisateur->removeTrajet($this);
        }

        return $this;
    }

    public function getConducteurId(): ?Utilisateur
    {
        return $this->conducteur_id;
    }

    public function setConducteurId(?Utilisateur $conducteur_id): self
    {
        $this->conducteur_id = $conducteur_id;

        return $this;
    }

    /**
     * @return Collection|passager[]
     */
    public function getPassager(): Collection
    {
        return $this->passager;
    }

    public function addPassager(Utilisateur $passager): self
    {
        if (!$this->passager->contains($passager)) {
            $this->passager[] = $passager;
        }

        return $this;
    }

    public function removePassager(Utilisateur $passager): self
    {
        if ($this->passager->contains($passager)) {
            $this->passager->removeElement($passager);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTrajet($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getTrajet() === $this) {
                $comment->setTrajet(null);
            }
        }

        return $this;
    }




}
