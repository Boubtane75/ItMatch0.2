<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\HobbyRepository")
 */
class Hobby
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
    private $nomHobby;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", inversedBy="hobbies")
     */
    private $hobbyUser;

    public function __construct()
    {
        $this->hobbyUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomHobby(): ?string
    {
        return $this->nomHobby;
    }

    public function setNomHobby(string $nomHobby): self
    {
        $this->nomHobby = $nomHobby;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getHobbyUser(): Collection
    {
        return $this->hobbyUser;
    }

    public function addHobbyUser(Utilisateur $hobbyUser): self
    {
        if (!$this->hobbyUser->contains($hobbyUser)) {
            $this->hobbyUser[] = $hobbyUser;
        }

        return $this;
    }

    public function removeHobbyUser(Utilisateur $hobbyUser): self
    {
        if ($this->hobbyUser->contains($hobbyUser)) {
            $this->hobbyUser->removeElement($hobbyUser);
        }

        return $this;
    }
}
