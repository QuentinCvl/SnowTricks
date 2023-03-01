<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=TrickRepository::class)
 */
class Trick
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=50)
   * @Assert\Length(min=5, max=50, minMessage="Le nom est trop court ! Il doit contenir au moins 5
    caractères !")
   */
  private $name;

  /**
   * @ORM\Column(type="string", length=60)
   */
  private $slug;

  /**
   * @ORM\Column(type="text")
   * @Assert\Length(min=10, minMessage="Le contenu est trop court ! Il doit contenir au moins 10
  caractères !")
   */
  private $content;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  private $mainPicture;

  /**
   * @Assert\Image(
   *   mimeTypes= {"image/jpeg", "image/jpg", "image/png"},
   *   mimeTypesMessage= "Veuillez insérer une image en .jpg, .jpeg ou .png",
   *   minWidth= 300,
   *   minWidthMessage= "Image trop petite. Largeur minimal 300px",
   *   minHeight= 200,
   *   minHeightMessage="Image trop petite. Hauteur minimal 200px",
   *   maxSize= "2M",
   *   maxSizeMessage="Image trop volumineuse. Taille maximal 2 Mo"
   * )
   */
  private $mainPictureFile;

  /**
   * @ORM\Column(type="string", nullable=true, options={"default": NULL})
   */
  private $video;

  /**
   * @Assert\File(
   *   mimeTypes={"video/mp4", "video/x-m4v", "video/*"},
   *   mimeTypesMessage="Veuillez insérer une video dans un format valide",
   *   maxSize= "150M",
   *   maxSizeMessage="Video trop volumineuse. Taille maximal 150 Mo"
   * )
   */
  private $videoFile;

  /**
   * @ORM\ManyToOne(targetEntity=TricksCategory::class)
   */
  private $category;


  /**
   * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
   */
  private $createdAt;

  /**
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $updatedAt;

  /**
   * @ORM\Column(type="datetime", nullable=true)
   */
  private $deletedAt;

  /**
   * @ORM\OneToMany(targetEntity=TricksImages::class, mappedBy="trick", orphanRemoval=true,
   *   cascade={"persist"})
   */
  private $tricksImages;

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
  private $images;


  /**
   * @ORM\OneToMany(targetEntity=TricksComment::class, mappedBy="trick", orphanRemoval=true)
   */
  private $trickComments;

  public function __construct()
  {
      $this->tricksImages = new ArrayCollection();
      $this->trickComments = new ArrayCollection();
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

  public function getSlug(): ?string
  {
    return $this->slug;
  }

  public function setSlug(string $slug): self
  {
    $this->slug = $slug;

    return $this;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(string $content): self
  {
    $this->content = $content;

    return $this;
  }

  public function getMainPicture(): ?string
  {
    return $this->mainPicture;
  }

  public function setMainPicture($mainPicture): self
  {
    $this->mainPicture = $mainPicture;

    return $this;
  }

  public function getMainPictureFile()
  {
    return $this->mainPictureFile;
  }

  public function setMainPictureFile(UploadedFile $mainPictureFile): self
  {
    $this->mainPictureFile = $mainPictureFile;

    return $this;
  }

  public function getVideo(): ?string
  {
    return $this->video;
  }

  public function setVideo(string $video): self
  {
    $this->video = $video;

    return $this;
  }

  public function getVideoFile()
  {
    return $this->videoFile;
  }

  public function setVideoFile(UploadedFile $videoFile): self
  {
    $this->videoFile = $videoFile;

    return $this;
  }

  public function getCategory(): ?TricksCategory
  {
    return $this->category;
  }

  public function setCategory(?TricksCategory $category): self
  {
    $this->category = $category;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeInterface
  {
    return $this->createdAt;
  }

  public function setCreatedAt(\DateTimeInterface $createdAt): self
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeInterface
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt(\DateTimeInterface $updatedAt): self
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  public function getDeletedAt(): ?\DateTimeInterface
  {
    return $this->deletedAt;
  }

  public function setDeletedAt(\DateTimeInterface $deletedAt): self
  {
    $this->deletedAt = $deletedAt;

    return $this;
  }

  /**
   * @return Collection<int, TricksImages>
   */
  public function getTricksImages(): Collection
  {
      return $this->tricksImages;
  }

  public function addTrickImage(TricksImages $trickImage): self
  {
      if (!$this->tricksImages->contains($trickImage)) {
          $this->tricksImages[] = $trickImage;
          $trickImage->setTrick($this);
      }

      return $this;
  }

  public function removeTrickImage(TricksImages $trickImage): self
  {
      if ($this->tricksImages->removeElement($trickImage)) {
          // set the owning side to null (unless already changed)
          if ($trickImage->getTrick() === $this) {
              $trickImage->setTrick(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, TricksComment>
   */
  public function getTrickComments(): Collection
  {
      return $this->trickComments;
  }

  public function addTrickComment(TricksComment $trickComment): self
  {
      if (!$this->trickComments->contains($trickComment)) {
          $this->trickComments[] = $trickComment;
          $trickComment->setTrick($this);
      }

      return $this;
  }

  public function removeTrickComment(TricksComment $trickComment): self
  {
      if ($this->trickComments->removeElement($trickComment)) {
          // set the owning side to null (unless already changed)
          if ($trickComment->getTrick() === $this) {
              $trickComment->setTrick(null);
          }
      }

      return $this;
  }
}
