<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @OA\Property(type="integer", description="The unique identifier of the product.")
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @OA\Property(type="string", description="The name of the product.", maxLength=255)
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @OA\Property(type="string", description="The brand of the product.", maxLength=255)
     * @ORM\Column(type="string", length=255)
     */
    private $brand;

    /**
     * @OA\Property(type="text", description="The description of the product.")
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @OA\Property(type="integer", description="The price of the product.")
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @OA\Property(type="date", description="The release date of the product.")
     * @ORM\Column(type="date")
     */
    private $releaseAt;

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReleaseAt(): ?\DateTimeInterface
    {
        return $this->releaseAt;
    }

    public function setReleaseAt(\DateTimeInterface $releaseAt): self
    {
        $this->releaseAt = $releaseAt;

        return $this;
    }
}
