<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="app_user")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Relative::class, mappedBy="createdBy")
     */
    private $relatives;

    /**
     * @ORM\OneToMany(targetEntity=Home::class, mappedBy="createdBy")
     */
    private $homes;

    public function __construct()
    {
        $this->relatives = new ArrayCollection();
        $this->homes = new ArrayCollection();
        $this->userHomes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Relative[]
     */
    public function getRelatives(): Collection
    {
        return $this->relatives;
    }

    public function addRelative(Relative $relative): self
    {
        if (!$this->relatives->contains($relative)) {
            $this->relatives[] = $relative;
            $relative->setCreatedBy($this);
        }

        return $this;
    }

    public function removeRelative(Relative $relative): self
    {
        if ($this->relatives->contains($relative)) {
            $this->relatives->removeElement($relative);
            // set the owning side to null (unless already changed)
            if ($relative->getCreatedBy() === $this) {
                $relative->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Home[]
     */
    public function getHomes(): Collection
    {
        return $this->homes;
    }

    public function addHome(Home $home): self
    {
        if (!$this->homes->contains($home)) {
            $this->homes[] = $home;
            $home->setCreatedBy($this);
        }

        return $this;
    }

    public function removeHome(Home $home): self
    {
        if ($this->homes->contains($home)) {
            $this->homes->removeElement($home);
            // set the owning side to null (unless already changed)
            if ($home->getCreatedBy() === $this) {
                $home->setCreatedBy(null);
            }
        }

        return $this;
    }
}
