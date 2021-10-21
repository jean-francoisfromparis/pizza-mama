<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $deleteAt;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeleteAt(): ?\DateTimeImmutable
    {
        return $this->deleteAt;
    }

    public function setDeleteAt(?\DateTimeImmutable $deleteAt): self
    {
        $this->deleteAt = $deleteAt;

        return $this;
    }
}
