<?php

namespace App\Entity;

use App\Repository\RelativeRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=RelativeRepository::class)
 */
class Relative
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\ManyToOne(targetEntity=Home::class, inversedBy="relatives")
     */
    private $home;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(?DateTime $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getHome(): ?Home
    {
        return $this->home;
    }

    public function setHome(?Home $home): self
    {
        $this->home = $home;

        return $this;
    }

    public function getNextBirthday(): ?DateTime
    {
        if ($this->birthdate === null) {
            return null;
        }

        // creates a new birthday object
        $birthday = new DateTime();

        // in this new birthay : day and month of birthdate and current year
        $birthday->setDate(
            date('Y'),
            $this->birthdate->format('m'),
            $this->birthdate->format('d')
        );
        $birthday->setTime(0, 0, 0);
        
        // if birthday is in the past (before today), set it to the next year
        if($birthday < new DateTime()) {
            $birthday->modify('+1 year');
        }

        return $birthday;
    }

    public function getAge(): ?int
    {
        if ($this->birthdate === null) {
            return null;
        }

        $today = new DateTime();

        $interval = $this->birthdate->diff($today);
        return $interval->y;

    }
}
