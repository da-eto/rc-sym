<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Сущность заведения в городе.
 *
 * @ORM\Entity(repositoryClass="App\Repository\PlaceRepository")
 * @ORM\Table(name="place")
 */
class Place
{
    /**
     * id заведения
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Название заведения
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Активно ли заведение
     *
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $active;

    /**
     * Закрыто ли заведение
     *
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $closed;

    /**
     * slug
     *
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private $slug;

    /**
     * Город, в котором находится заведение
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="places")
     * @ORM\JoinColumn(nullable=false)
     */
    private $city;

    /**
     * Время создания
     *
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): self
    {
        $this->closed = $closed;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
