<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
   * @ORM\Column(type="string", length=255)
   */
  private $name;

  /**
   * @ORM\Column(type="string", length=255)
   */
  private $slug;

  /**
   * @ORM\Column(type="text")
   */
  private $content;

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
   * @ORM\OneToMany(targetEntity=TricksImages::class, mappedBy="trick", orphanRemoval=true)
   */
  private $trickImages;

  /**
   * @ORM\OneToMany(targetEntity=TricksVideos::class, mappedBy="trick", orphanRemoval=true)
   */
  private $trickVideos;

  /**
   * @ORM\OneToMany(targetEntity=TricksComment::class, mappedBy="trick", orphanRemoval=true)
   */
  private $trickComments;

  public function __construct()
  {
      $this->trickImages = new ArrayCollection();
      $this->trickVideos = new ArrayCollection();
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
  public function getTrickImages(): Collection
  {
      return $this->trickImages;
  }

  public function addTrickImage(TricksImages $trickImage): self
  {
      if (!$this->trickImages->contains($trickImage)) {
          $this->trickImages[] = $trickImage;
          $trickImage->setTrick($this);
      }

      return $this;
  }

  public function removeTrickImage(TricksImages $trickImage): self
  {
      if ($this->trickImages->removeElement($trickImage)) {
          // set the owning side to null (unless already changed)
          if ($trickImage->getTrick() === $this) {
              $trickImage->setTrick(null);
          }
      }

      return $this;
  }

  /**
   * @return Collection<int, TricksVideos>
   */
  public function getTrickVideos(): Collection
  {
      return $this->trickVideos;
  }

  public function addTrickVideo(TricksVideos $trickVideo): self
  {
      if (!$this->trickVideos->contains($trickVideo)) {
          $this->trickVideos[] = $trickVideo;
          $trickVideo->setTrick($this);
      }

      return $this;
  }

  public function removeTrickVideo(TricksVideos $trickVideo): self
  {
      if ($this->trickVideos->removeElement($trickVideo)) {
          // set the owning side to null (unless already changed)
          if ($trickVideo->getTrick() === $this) {
              $trickVideo->setTrick(null);
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
