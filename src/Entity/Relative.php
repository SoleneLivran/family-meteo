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

    public function getNextBirthday() : ?string
    {
        if ($this->birthdate === null) {
            return null;
        }

        // var_dump($this->birthdate);die;
        // get birthdate
        $birthday = new DateTime($this->birthdate->format('Y-m-d'));
        // 1993-02-18

        $currentYear = date('Y');
        // 2020

        // put date in current year
        $birthday->modify('+' . $currentYear - $birthday->format('Y') . ' years');
        // +2020-1993
        // +27 years
        // 2020-02-18

        // compare date with today's date
        if($birthday < new DateTime()) {
            $birthday->modify('+1 year');
        }

        return $birthday->format('Y-m-d');
    }
}
