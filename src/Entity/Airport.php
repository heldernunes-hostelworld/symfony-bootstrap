<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity()
 * @ORM\Table(name="Airports")
 */
class Airport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("bestRoute")
     * @SerializedName("airportId")
     */
    private $id;

    /**
     * @ORM\Column(name="airportName", type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=City::class)
     * @ORM\JoinColumn(name="cityId", nullable=false)
     * @Groups("bestRoute")
     */
    private $city;

    /**
     * @ORM\ManyToMany(targetEntity=Airport::class)
     * @ORM\JoinTable(
     *     name="Routes",
     *     joinColumns={@ORM\JoinColumn(name="origin", referencedColumnName="airportName")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="destiny", referencedColumnName="airportName")}
     * )
     */
    private $routes;

    public function __construct()
    {
        $this->routes = new ArrayCollection();
    }

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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    public function addRoute(self $route): self
    {
        if (!$this->routes->contains($route)) {
            $this->routes[] = $route;
        }

        return $this;
    }

    public function removeRoute(self $route): self
    {
        $this->routes->removeElement($route);

        return $this;
    }
}
