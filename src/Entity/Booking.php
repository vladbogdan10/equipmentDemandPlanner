<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $campervan;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $startStation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $endStation;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $equipment = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampervan(): ?string
    {
        return $this->campervan;
    }

    public function setCampervan(string $campervan): self
    {
        $this->campervan = $campervan;

        return $this;
    }

    public function getStartStation(): ?string
    {
        return $this->startStation;
    }

    public function setStartStation(string $startStation): self
    {
        $this->startStation = $startStation;

        return $this;
    }

    public function getEndStation(): ?string
    {
        return $this->endStation;
    }

    public function setEndStation(string $endStation): self
    {
        $this->endStation = $endStation;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getEquipment(): ?array
    {
        return $this->equipment;
    }

    public function setEquipment(?array $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }
}
