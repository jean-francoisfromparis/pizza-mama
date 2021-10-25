<?php

namespace App\Entity;

use App\Entity\Category;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use Gedmo\Mapping\Annotation\SoftDeleteable;
use Gedmo\Timestampable\Traits\Timestampable;
Use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 *
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable
 * @Gedmo\SoftDeleteable(hardDelete=false)
 */
class Product
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
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
     * 
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $photo;

    /**
     * @Vich\UploadableField(mapping="products_images", fileNameProperty="photo")
     * @var File|null
     */
    private $photoFile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function __toString()
    {
        return $this->getname();
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

    /**
     * Get the value of photoFile
     *
     * @return  File
     */

    public function getPhotoFile()
    {
        return $this->photoFile;
    }

    /**
     * Set the value of photoFile
     *
     * @param  File  $photoFile
     *
     * @return  self
     */

    public function setPhotoFile(File $photoFile = null)
    {
        $this->photoFile = $photoFile;

        if (null !== $photoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
}
