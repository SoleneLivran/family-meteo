<?php

namespace App\Entity;

use App\Repository\HomeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HomeRepository::class)
 */
class Home
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $postCode;

    /**
     * @ORM\Column(type="float")
     */
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cityName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity=Relative::class, inversedBy="homes")
     */
    private $relatives;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="homes")
     */
    private $createdBy;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $isUserHome = false;

    // TODO : revoir cette syntaxe et ArrayCollection
    public function __construct()
    {
        $this->relatives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    // TODO : revoir self
    public function setPostCode(string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): self
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|Relative[]
     */
    public function getRelatives(): Collection
    // TODO : revoir collection
    {
        return $this->relatives;
    }

    public function addRelative(Relative $relative): self
    {
        if (!$this->relatives->contains($relative)) {
            $this->relatives[] = $relative;
            $relative->addHome($this);
        }

        return $this;
    }

    public function removeRelative(Relative $relative): self
    {
        if ($this->relatives->contains($relative)) {
            $this->relatives->removeElement($relative);
            $relative->removeHome($this);
        }

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function isUserHome(): ?bool
    {
        return $this->isUserHome;
    }

    public function setIsUserHome(bool $isUserHome): self
    {
        $this->isUserHome = $isUserHome;

        return $this;
    }
}
