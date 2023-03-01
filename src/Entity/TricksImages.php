<?php

namespace App\Entity;

use App\Repository\TricksImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TricksImagesRepository::class)
 */
class TricksImages
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="trickImages")
   * @ORM\JoinColumn(nullable=false)
   */
  private $trick;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $src;

  /**
   * @Assert\Image(
   *   mimeTypes= {"image/jpeg", "image/jpg", "image/png"},
   *   mimeTypesMessage= "Veuillez insérer une image en .jpg, .jpeg ou .png",
   *   minWidth= 300,
   *   minWidthMessage= "Image trop petite. Largeur minimal 300px",
   *   minHeight= 200,
   *   minHeightMessage="Image trop petite. Hauteur minimal 200px"
   * )
   */
  private $imageFile;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTrick(): ?Trick
  {
    return $this->trick;
  }

  public function setTrick(?Trick $trick): self
  {
    $this->trick = $trick;

    return $this;
  }

  public function getSrc(): ?string
  {
    return $this->src;
  }

  public function setSrc(string $src): self
  {
    $this->src = $src;

    return $this;
  }

  public function getImageFile()
  {
    return $this->imageFile;
  }

  /**
   * @param UploadedFile $file
   * @return TricksImages
   */
  public function setImageFile(UploadedFile $file): self
  {
    $this->imageFile = $file;
    return $this;
  }
}
